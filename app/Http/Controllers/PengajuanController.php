<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Validation\Rule;

class PengajuanController extends Controller
{
    private function getLoggedInMahasiswa()
    {
        return Mahasiswa::where('user_id', Auth::id())->firstOrFail();
    }

    public function pilihJenis()
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login sebagai mahasiswa untuk mengakses halaman ini.');
        }
        return view('mahasiswa.pengajuan.pilih-jenis');
    }

    public function create($jenis)
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        if (!in_array($jenis, ['ta', 'pkl'])) {
            abort(404, 'Jenis pengajuan tidak valid.');
        }
    
        $mahasiswa = $this->getLoggedInMahasiswa(); 
    
        $pengajuanAktif = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
                                    ->whereIn('status', ['diajukan_mahasiswa', 'diverifikasi_admin', 'dosen_ditunjuk', 'sedang_diproses'])
                                    ->first();
    
        if ($pengajuanAktif) {
            return redirect()->route('mahasiswa.pengajuan.index')
                             ->with('error', 'Anda sudah memiliki pengajuan yang sedang diproses. Anda tidak dapat membuat pengajuan baru sampai pengajuan sebelumnya selesai atau dibatalkan.');
        }
    
        $dokumenSyarat = $this->getDokumenSyarat($jenis);
        $dosens = Dosen::orderBy('nama')->get(); 
        return view('mahasiswa.pengajuan.form', compact('jenis', 'dokumenSyarat', 'dosens'));
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') { 
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $mahasiswa = $this->getLoggedInMahasiswa();

        $pengajuanAktif = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
                                    ->whereIn('status', ['diajukan_mahasiswa', 'diverifikasi_admin', 'dosen_ditunjuk', 'sedang_diproses'])
                                    ->first();

        if ($pengajuanAktif) {
            return redirect()->route('mahasiswa.pengajuan.index')
                             ->with('error', 'Anda sudah memiliki pengajuan yang sedang diproses. Anda tidak dapat membuat pengajuan baru sampai pengajuan sebelumnya selesai atau dibatalkan.');
        }

        $status = $request->input('action') === 'draft' ? 'draft' : 'diajukan_mahasiswa';

        $validationRules = [
            'jenis_pengajuan' => 'required|in:pkl,ta',
            'dosen_pembimbing1_id' => $status === 'diajukan_mahasiswa' ? 'required|exists:dosens,id' : 'nullable|exists:dosens,id',
            'dosen_pembimbing2_id' => 'nullable|exists:dosens,id|different:dosen_pembimbing1_id', 
            // Tidak ada validasi untuk ketua_sidang_dosen_id di sini karena mahasiswa tidak boleh mengaturnya saat membuat baru atau mengedit
            // Ini akan diatur oleh admin
        ];

        $dokumenSyaratList = $this->getDokumenSyarat($request->jenis_pengajuan);

        foreach ($dokumenSyaratList as $key => $namaDokumen) {
            $validationRules["dokumen.{$key}"] = ($status === 'diajukan_mahasiswa') ? 'required|file|mimes:pdf,jpg,jpeg,png|max:2048' : 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pengajuan = Pengajuan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'jenis_pengajuan' => $request->jenis_pengajuan,
            'status' => $status,
        ]);

        // Buat entri sidang dengan dosen pembimbing yang dipilih mahasiswa
        $pengajuan->sidang()->create([
            'dosen_pembimbing_id' => $request->dosen_pembimbing1_id,
            'dosen_penguji1_id' => $request->dosen_pembimbing2_id, // Ini adalah Dosen Pembimbing 2
            'status' => 'belum_dijadwalkan', 
            // Ketua sidang, sekretaris, anggota, tanggal_waktu_sidang, ruangan_sidang
            // tidak diisi oleh mahasiswa saat membuat/mengedit, diisi oleh admin/proses lain.
        ]);

        // Upload dan simpan dokumen
        if ($request->has('dokumen')) {
            foreach ($request->file('dokumen') as $nama_dokumen_key => $file) {
                if (array_key_exists($nama_dokumen_key, $dokumenSyaratList)) {
                    $originalFileName = Str::slug($dokumenSyaratList[$nama_dokumen_key]) . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('dokumen_pengajuan/' . $pengajuan->id, $originalFileName, 'public');

                    Dokumen::create([
                        'pengajuan_id' => $pengajuan->id,
                        'nama_file' => $dokumenSyaratList[$nama_dokumen_key],
                        'path_file' => $path,
                        'status' => 'diajukan_mahasiswa',
                    ]);
                }
            }
        }

        if ($status === 'draft') {
            return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->id)->with('success', 'Pengajuan berhasil disimpan sebagai draft.');
        } else {
            return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->id)->with('success', 'Pengajuan berhasil diajukan_mahasiswa dan akan segera diverifikasi!');
        }
    }

    public function show(Pengajuan $pengajuan)
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $mahasiswa = $this->getLoggedInMahasiswa();

        if ($mahasiswa->id != $pengajuan->mahasiswa_id) {
            abort(403, 'Anda tidak diizinkan mengakses pengajuan ini.');
        }

        $pengajuan->load([
            'dokumens',
            'sidang.ketuaSidang',
            'sidang.sekretarisSidang',
            'sidang.anggota1Sidang',
            'sidang.anggota2Sidang',
            'sidang.dosenPembimbing', // Load dosen pembimbing 1
            'sidang.dosenPenguji1',   // Load dosen pembimbing 2 (yang disimpan di dosen_penguji1_id)
        ]);

        return view('mahasiswa.pengajuan.show', compact('pengajuan'));
    }

    public function simpanSebagaiDraft(Request $request, Pengajuan $pengajuan)
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $mahasiswa = $this->getLoggedInMahasiswa();

        if ($mahasiswa->id != $pengajuan->mahasiswa_id) {
            abort(403, 'Unauthorized');
        }

        $pengajuan->update(['status' => 'draft']);

        return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->id)->with('success', 'Pengajuan berhasil diperbarui sebagai draft.');
    }

    public function edit(Pengajuan $pengajuan)
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $mahasiswa = $this->getLoggedInMahasiswa();

        if ($mahasiswa->id != $pengajuan->mahasiswa_id) {
            abort(403, 'Unauthorized');
        }

        if ($pengajuan->status !== 'draft' && !in_array($pengajuan->status, ['ditolak_admin', 'ditolak_kaprodi'])) {
            return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->id)
                             ->with('error', 'Pengajuan sudah diajukan_mahasiswa dan tidak bisa diedit.');
        }

        $jenis = $pengajuan->jenis_pengajuan;
        $dokumenSyarat = $this->getDokumenSyarat($jenis);
        $dokumenTerupload = $pengajuan->dokumens->keyBy('nama_file');
        $dosens = Dosen::orderBy('nama')->get();

        return view('mahasiswa.pengajuan.edit', compact('pengajuan', 'jenis', 'dokumenSyarat', 'dokumenTerupload', 'dosens'));
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $mahasiswa = $this->getLoggedInMahasiswa();
    
        if ($mahasiswa->id != $pengajuan->mahasiswa_id) {
            abort(403, 'Unauthorized');
        }
    
        if ($pengajuan->status !== 'draft' && !in_array($pengajuan->status, ['ditolak_admin', 'ditolak_kaprodi'])) {
            return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->id)
                             ->with('error', 'Pengajuan ini tidak dapat diupdate karena sudah dalam proses verifikasi.');
        }
    
        $status = $request->input('action') === 'submit' ? 'diajukan_mahasiswa' : 'draft';
    
        $validationRules = [
            'action' => 'required|in:draft,submit',
            'dosen_pembimbing_id' => $status === 'diajukan_mahasiswa' ? 'required|exists:dosens,id' : 'nullable|exists:dosens,id',
            'dosen_penguji1_id' => 'nullable|exists:dosens,id|different:dosen_pembimbing_id', // Ini Pembimbing 2
            // Hapus 'ketua_sidang_dosen_id' dari validation rules karena mahasiswa tidak mengaturnya
        ];
    
        $dokumenSyaratList = $this->getDokumenSyarat($pengajuan->jenis_pengajuan);
    
        foreach ($dokumenSyaratList as $key => $namaDokumen) {
            $fieldName = 'dokumen_' . $key;
            $uploadedDoc = $pengajuan->dokumens->where('nama_file', $namaDokumen)->first();
        
            $rulesForThisDoc = [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ];
        
            if ($status === 'diajukan_mahasiswa' && !$uploadedDoc) {
                $rulesForThisDoc[] = 'required';
            }
        
            $validationRules[$fieldName] = $rulesForThisDoc;
        }
    
        $validator = Validator::make($request->all(), $validationRules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $pengajuan->update([
            'status' => $status,
        ]);
    
        // Update entri sidang
        if ($pengajuan->sidang) {
            $pengajuan->sidang->update([
                'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
                'dosen_penguji1_id' => $request->dosen_penguji1_id, // Update Dosen Pembimbing 2
                // Jangan update ketua_sidang_dosen_id di sini, karena itu diurus oleh admin/sistem
                'status' => $status === 'diajukan_mahasiswa' ? 'belum_dijadwalkan' : $pengajuan->sidang->status,
            ]);
        } else {
            // Ini seharusnya tidak terjadi di update, tapi sebagai fallback
            $pengajuan->sidang()->create([
                'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
                'dosen_penguji1_id' => $request->dosen_penguji1_id,
                'status' => 'belum_dijadwalkan',
            ]);
        }
    
        // Proses dokumen
        foreach ($dokumenSyaratList as $key => $namaDokumen) {
            $fieldName = 'dokumen_' . $key;
            if ($request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                $namaFileSyarat = $namaDokumen;
            
                $existingDokumen = Dokumen::where('pengajuan_id', $pengajuan->id)
                                          ->where('nama_file', $namaFileSyarat)
                                          ->first();
            
                $originalFileName = Str::slug($namaFileSyarat) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('dokumen_pengajuan/' . $pengajuan->id, $originalFileName, 'public');
            
                if ($existingDokumen) {
                    Storage::disk('public')->delete($existingDokumen->path_file);
                    $existingDokumen->update(['path_file' => $path, 'status' => 'diajukan_mahasiswa']);
                } else {
                    Dokumen::create([
                        'pengajuan_id' => $pengajuan->id,
                        'nama_file' => $namaFileSyarat,
                        'path_file' => $path,
                        'status' => 'diajukan_mahasiswa',
                    ]);
                }
            }
        }
    
        if ($status === 'draft') {
            return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->id)->with('success', 'Pengajuan draft berhasil diperbarui.');
        } else {
            return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->id)->with('success', 'Pengajuan berhasil difinalisasi dan diajukan!');
        }
    }

    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $mahasiswa = $this->getLoggedInMahasiswa();

        $pengajuans = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
                                ->with('mahasiswa', 'sidang')
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('mahasiswa.pengajuan.index', compact('pengajuans'));
    }

    private function getDokumenSyarat($jenisPengajuan)
    {
        if ($jenisPengajuan == 'pkl') {
            return [
                'laporan_pkl' => 'Laporan PKL sebanyak 2 rangkap',
                'buku_pkl' => 'Buku PKL',
                'kuisioner_survey_pkl' => 'Kuisioner survey PKL yang telah diisi dan ditandatangani serta distempel perusahaan',
                'kuisioner_kelulusan' => 'Kuisioner Kelulusan (jika ada)',
                'kuisioner_balikan_pkl' => 'Kuisioner balikan PKL',
                'lembaran_rekomendasi_penguji' => 'Lembaran Rekomendasi Penguji',
                'surat_permohonan_sidang_pkl' => 'Surat Permohonan Sidang PKL',
                'lembar_penilaian_sidang_pkl' => 'Lembar Penilaian Sidang PKL (Penguji)',
                'surat_keterangan_pelaksanaan_pkl' => 'Surat keterangan pelaksanaan PKL (Asli, distempel dan ditandatangani pihak perusahaan)',
                'fotocopy_cover_laporan_pkl' => 'Fotocopy cover laporan PKL yang ada tanda tangan persetujuan sidang dari dosen pembimbing PKL',
                'fotocopy_lembar_penilaian_industri' => 'Fotocopy lembar penilaian dari pembimbing di industri (ditandatangani pembimbing industri)',
                'fotocopy_lembar_penilaian_dosen_pembimbing_pkl' => 'Fotocopy lembar penilaian dari dosen pembimbing PKL (ditandantangani pembimbing kampus)',
                'fotocopy_lembar_konsultasi_bimbingan_pkl' => 'Fotocopy lembar konsultasi bimbingan PKL (diisi dan ditandatangani pembimbing kampus)',
            ];
        } elseif ($jenisPengajuan == 'ta') {
            return [
                'surat_permohonan_sidang' => 'Surat Permohonan Sidang',
                'surat_keterangan_bebas_kompensasi_ganjil_genap' => 'Surat Keterangan bebas Kompensasi Semester Ganjil & Genap',
                'ipk_terakhir' => 'IPK Terakhir (Lampiran Rapor Semester 1 s.d 5 (D3) dan 1 s.d 7 (D4))',
                'bukti_menyerahkan_laporan_pkl' => 'Bukti menyerahkan laporan PKL',
                'nilai_toeic' => 'Nilai TOEIC minimal 450 (D3) dan 550 (D4) (Lampirkan kartu TOEIC)',
                'tugas_akhir_rangkap_4' => 'Tugas Akhir Rangkap 4 yang disetujui pembimbing',
                'kartu_bimbingan_konsultasi_ta_9x' => 'Kartu Bimbingan/Konsultasi Tugas Akhir 9x',
                'fotocopy_ijazah_sma_ma_smk' => 'Fotokopi Ijazah SMA/MA/SMK',
                'fotocopy_sertifikat_diksarlin' => 'Fotokopi Sertifikat Diksarlin',
                'sertifikat_responsi' => 'Sertifikat Responsi',
                'nilai_satuan_kredit_ekstrakurikuler' => 'Nilai Satuan Kredit Ekstrakurikuler (SKE) (Lampirkan kartu SKE)',
            ];
        }
        return [];
    }

    public function destroy(Pengajuan $pengajuan)
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $mahasiswa = $this->getLoggedInMahasiswa();

        if ($mahasiswa->id != $pengajuan->mahasiswa_id) {
            abort(403, 'Unauthorized access.');
        }

        if ($pengajuan->status === 'diverifikasi_admin' ||
            $pengajuan->status === 'dosen_ditunjuk' ||
            $pengajuan->status === 'ditolak_admin' ||
            $pengajuan->status === 'ditolak_kaprodi' ||
            $pengajuan->status === 'selesai'
        ) {
            return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->id)
                             ->with('error', 'Pengajuan ini tidak dapat dihapus karena sudah dalam proses verifikasi atau telah diproses.');
        }

        if ($pengajuan->sidang) {
            $pengajuan->sidang->delete();
        }

        foreach ($pengajuan->dokumens as $dokumen) {
            Storage::disk('public')->delete($dokumen->path_file);
            $dokumen->delete();
        }

        $pengajuan->delete();

        return redirect()->route('mahasiswa.pengajuan.index')
                         ->with('success', 'Pengajuan berhasil dihapus.');
    }
}