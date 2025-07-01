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
use App\Models\Sidang;
use Illuminate\Validation\Rule;
use Throwable; // Import Throwable untuk menangkap semua jenis error/exception

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

        // Cek apakah mahasiswa sudah punya pengajuan jenis ini yang sedang aktif
        $existingPengajuan = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
                                    ->where('jenis_pengajuan', $jenis)
                                    ->whereNotIn('status', ['ditolak_admin', 'ditolak_kaprodi', 'selesai']) // Izinkan edit/buat jika ditolak atau selesai
                                    ->first();

        if ($existingPengajuan && $existingPengajuan->status !== 'draft_auto_saved') {
            // Jika ada pengajuan aktif (selain draft_auto_saved), arahkan ke halaman detail/edit pengajuan tersebut
            return redirect()->route('mahasiswa.pengajuan.show', $existingPengajuan->id)
                             ->with('info', 'Anda sudah memiliki pengajuan ' . strtoupper($jenis) . ' yang sedang diproses. Silakan lanjutkan di sini.');
        } elseif ($existingPengajuan && $existingPengajuan->status === 'draft_auto_saved') {
            // Jika ada draft_auto_saved, gunakan itu
            $pengajuan = $existingPengajuan;
        } else {
            // Buat instance Pengajuan baru dengan status 'draft_auto_saved' jika tidak ada pengajuan aktif
            $pengajuan = Pengajuan::create([
                'mahasiswa_id' => $mahasiswa->id,
                'jenis_pengajuan' => $jenis,
                'status' => 'draft_auto_saved',
                'judul_pengajuan' => null // Inisialisasi judul
            ]);
        }
        
        // Pastikan record sidang juga ada (bisa kosong dulu)
        if (!$pengajuan->sidang) {
            $pengajuan->sidang()->create(['status' => 'belum_dijadwalkan']);
        }

        $dokumenSyarat = $this->getDokumenSyarat($jenis);
        $dokumenTerupload = $pengajuan->dokumens->keyBy('nama_file'); // Key by nama_file for easy lookup
        $dosens = Dosen::orderBy('nama')->get();

        return view('mahasiswa.pengajuan.pkl', compact('pengajuan', 'mahasiswa', 'jenis', 'dokumenSyarat', 'dokumenTerupload', 'dosens'));
    }

    public function store(Request $request)
    {
        // Metode ini akan dipanggil saat mahasiswa mencoba membuat pengajuan baru.
        // Namun, karena logika 'create' sudah menangani pembuatan draft otomatis,
        // metode ini bisa langsung mengarahkan ke halaman update/edit.
        // Atau, jika Anda ingin menggunakan ini untuk finalisasi awal dari halaman kosong,
        // Anda bisa membiarkannya, namun pastikan logikanya tidak tumpang tindih.

        // Dalam implementasi ini, kita akan delegasikan ke metode 'update'
        // untuk menangani pengiriman data dari form.
        $mahasiswa = $this->getLoggedInMahasiswa();

        // Temukan pengajuan draft yang ada atau buat baru (jika entah bagaimana belum ada)
        $pengajuan = Pengajuan::firstOrCreate(
            ['mahasiswa_id' => $mahasiswa->id, 'jenis_pengajuan' => $request->jenis_pengajuan],
            ['status' => 'draft_auto_saved', 'judul_pengajuan' => null]
        );

        // Langsung panggil metode update untuk memproses data
        return $this->update($request, $pengajuan);
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
            'sidang.dosenPembimbing',
            'sidang.dosenPenguji1',
        ]);

        $jenis = $pengajuan->jenis_pengajuan;
        $dokumenSyarat = $this->getDokumenSyarat($jenis);
        $dokumenTerupload = $pengajuan->dokumens->keyBy('nama_file');
        $dosens = Dosen::orderBy('nama')->get();

        // Arahkan semua tampilan PKL ke pkl.blade.php
        return view('mahasiswa.pengajuan.pkl', compact('pengajuan', 'mahasiswa', 'jenis', 'dokumenSyarat', 'dokumenTerupload', 'dosens'));
    }

    public function edit(Pengajuan $pengajuan)
    {
        // Metode ini sekarang hanya akan mengarahkan ke `show` untuk memastikan logika terpusat di satu tempat.
        // Jika status pengajuan tidak mengizinkan edit, `show` akan memberikan pesan error/redirect.
        return $this->show($pengajuan);
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

        // Cek apakah pengajuan sudah diserahkan dan tidak bisa di-update lagi (kecuali ditolak)
        if ($pengajuan->isSubmitted() && !in_array($pengajuan->status, ['ditolak_admin', 'ditolak_kaprodi'])) {
            return back()->with('error', 'Pengajuan ini tidak dapat diupdate karena sudah dalam proses verifikasi atau telah selesai.');
        }
        
        // Handle single document upload via AJAX (if action is 'upload_single_document')
        if ($request->input('action') === 'upload_single_document') {
            return $this->uploadSingleDocument($request, $pengajuan);
        }

        // Handle auto-save of judul and dosen_pembimbing (from auto-save JavaScript)
        if ($request->input('action') === 'auto_save_field') {
             return $this->autoSaveField($request, $pengajuan);
        }

        // From here, assume it's a finalization attempt
        // Validasi untuk final submission
        $validationRules = [
            'judul_pengajuan' => 'required|string|max:255',
            'dosen_pembimbing_id' => 'required|exists:dosens,id',
        ];

        // Memastikan semua dokumen yang wajib sudah diunggah
        $dokumenSyaratList = $this->getDokumenSyarat($pengajuan->jenis_pengajuan);
        $allDocumentsUploaded = true;
        foreach ($dokumenSyaratList as $key => $namaDokumen) {
            // Periksa apakah dokumen wajib ada di dokumenTerupload
            if (!in_array($namaDokumen, ['Kuisioner Kelulusan (jika ada)'])) { // Dokumen opsional tidak perlu dicek
                $uploadedDoc = $pengajuan->dokumens->where('nama_file', $namaDokumen)->first();
                if (!$uploadedDoc || empty($uploadedDoc->path_file)) {
                    $allDocumentsUploaded = false;
                    break;
                }
            }
        }

        if (!$allDocumentsUploaded) {
            return back()->with('error', 'Semua dokumen persyaratan wajib diunggah sebelum finalisasi pengajuan.')->withInput();
        }

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $pengajuan->update([
                'judul_pengajuan' => $request->judul_pengajuan,
                'status' => 'diajukan_mahasiswa', // Ganti status menjadi diajukan
                'alasan_penolakan_admin' => null, // Hapus alasan penolakan pada pengajuan ulang
                'alasan_penolakan_kaprodi' => null, // Hapus alasan penolakan pada pengajuan ulang
            ]);

            // Update atau buat record Sidang untuk dosen_pembimbing
            Sidang::updateOrCreate(
                ['pengajuan_id' => $pengajuan->id],
                [
                    'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
                    'status' => 'belum_dijadwalkan', // Reset ke status sidang default
                ]
            );

            return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->id)->with('success', 'Pengajuan berhasil difinalisasi dan diajukan!');
        } catch (Throwable $e) {
            \Log::error('Error in PengajuanController@update (finalization): ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return back()->with('error', 'Terjadi kesalahan server saat memfinalisasi pengajuan: ' . $e->getMessage())->withInput();
        }
    }

    protected function uploadSingleDocument(Request $request, Pengajuan $pengajuan)
    {
        try {
            $request->validate([
                'document_name_key' => 'required|string',
                'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            $actualDocumentKey = Str::after($request->input('document_name_key'), 'dokumen_');
            $dokumenSyaratList = $this->getDokumenSyarat($pengajuan->jenis_pengajuan);
            $namaDokumenFull = $dokumenSyaratList[$actualDocumentKey] ?? null;

            if (!$namaDokumenFull) {
                return response()->json(['success' => false, 'message' => 'Nama dokumen tidak valid.'], 400);
            }

            $file = $request->file('document_file');
            $originalFileName = Str::slug($namaDokumenFull) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('dokumen_pengajuan/' . $pengajuan->id, $originalFileName, 'public');

            $existingDokumen = Dokumen::where('pengajuan_id', $pengajuan->id)
                                      ->where('nama_file', $namaDokumenFull)
                                      ->first();

            if ($existingDokumen) {
                Storage::disk('public')->delete($existingDokumen->path_file);
                $existingDokumen->update(['path_file' => $path, 'status' => 'uploaded']);
            } else {
                Dokumen::create([
                    'pengajuan_id' => $pengajuan->id,
                    'nama_file' => $namaDokumenFull,
                    'path_file' => $path,
                    'status' => 'uploaded',
                ]);
            }

            // Setelah upload dokumen, pastikan status pengajuan adalah 'draft_auto_saved'
            // kecuali jika pengajuan sudah berada dalam status yang sedang diproses.
            if (!in_array($pengajuan->status, ['diajukan_mahasiswa', 'diverifikasi_admin', 'dosen_ditunjuk', 'menunggu_persetujuan_dosen', 'sidang_dijadwalkan_final', 'diverifikasi_kajur', 'selesai'])) {
                 $pengajuan->update(['status' => 'draft_auto_saved']);
            }
            
            // Hitung ulang status kelengkapan dokumen setelah upload
            $allDocumentsPresent = true;
            foreach ($dokumenSyaratList as $docKey => $docName) {
                if (!in_array($docName, ['Kuisioner Kelulusan (jika ada)'])) { // Abaikan dokumen opsional
                    if (!$pengajuan->dokumens->where('nama_file', $docName)->first()) {
                        $allDocumentsPresent = false;
                        break;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diunggah.',
                'file_url' => Storage::url($path),
                'file_name_display' => $namaDokumenFull,
                'all_uploaded' => $allDocumentsPresent
            ]);
        } catch (Throwable $e) {
            \Log::error('Error in PengajuanController@uploadSingleDocument: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengunggah dokumen: ' . $e->getMessage()], 500);
        }
    }

    protected function autoSaveField(Request $request, Pengajuan $pengajuan)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        // Validasi field yang sedang di-auto-save
        $rules = [
            'judul_pengajuan' => 'nullable|string|max:255',
            'dosen_pembimbing_id' => 'nullable|exists:dosens,id',
        ];

        // Pastikan hanya field yang diizinkan yang bisa di-auto-save
        if (!isset($rules[$field])) {
             return response()->json(['success' => false, 'message' => 'Field tidak valid untuk auto-save.'], 400);
        }

        $validator = Validator::make([$field => $value], [$field => $rules[$field]]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $pengajuan->{$field} = $value;
        $pengajuan->save();

        // Pastikan status pengajuan adalah 'draft_auto_saved' jika belum diserahkan
        if (!in_array($pengajuan->status, ['diajukan_mahasiswa', 'diverifikasi_admin', 'dosen_ditunjuk', 'menunggu_persetujuan_dosen', 'sidang_dijadwalkan_final', 'diverifikasi_kajur', 'selesai'])) {
             $pengajuan->update(['status' => 'draft_auto_saved']);
        }
        
        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan.']);
    }

    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $mahasiswa = $this->getLoggedInMahasiswa();

        $pengajuans = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
                                ->with('mahasiswa', 'sidang')
                                ->orderBy('updated_at', 'desc') // Urutkan berdasarkan update terakhir
                                ->get();

        return view('mahasiswa.pengajuan.index', compact('pengajuans'));
    }

    private function getDokumenSyarat($jenisPengajuan)
    {
        if ($jenisPengajuan == 'pkl') {
            return [
                'laporan_pkl_rangkap_2' => 'Laporan PKL sebanyak 2 rangkap',
                'buku_pkl' => 'Buku PKL',
                'kuisioner_survey_pkl' => 'Kuisioner survey PKL yang telah diisi dan ditandatangani serta distempel perusahaan',
                'kuisioner_kelulusan' => 'Kuisioner Kelulusan (jika ada)', // Ini opsional
                'kuisioner_balikan_pkl' => 'Kuisioner balikan PKL',
                'lembaran_rekomendasi_penguji' => 'Lembaran Rekomendasi Penguji',
                'surat_permohonan_sidang_pkl' => 'Surat Permohonan Sidang PKL',
                'lembar_penilaian_sidang_pkl' => 'Lembar Penilaian Sidang PKL (Penguji)',
                'surat_keterangan_pelaksanaan_pkl' => 'Surat keterangan pelaksanaan PKL (Asli, distempel dan ditandatangani pihak perusahaan)',
                'fotocopy_cover_laporan_pkl_ttd' => 'Fotocopy cover laporan PKL yang ada tanda tangan persetujuan sidang dari dosen pembimbing PKL',
                'fotocopy_lembar_penilaian_industri_ttd' => 'Fotocopy lembar penilaian dari pembimbing di industri (ditandatangani pembimbing industri)',
                'fotocopy_lembar_penilaian_dospem_ttd' => 'Fotocopy lembar penilaian dari dosen pembimbing PKL (ditandantangani pembimbing kampus)',
                'fotocopy_lembar_konsultasi_bimbingan_pkl_ttd' => 'Fotocopy lembar konsultasi bimbingan PKL (diisi dan ditandatangani pembimbing kampus)',
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

        // Hanya izinkan hapus jika statusnya 'draft_auto_saved', 'ditolak_admin', atau 'ditolak_kaprodi'
        if ($pengajuan->isSubmitted() && !in_array($pengajuan->status, ['ditolak_admin', 'ditolak_kaprodi'])) {
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
    

     public function pklDetail()
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $mahasiswa = Auth::user()->mahasiswa;
        
        $pengajuan = Pengajuan::firstOrCreate(
            ['mahasiswa_id' => $mahasiswa->id, 'jenis_pengajuan' => 'pkl'],
            ['status' => 'draft', 'judul_pengajuan' => null]
        );
        
        $dosens = Dosen::all(); // <-- Ambil semua dosen dan gunakan nama variabel $dosens

        // PERBAIKAN: Pastikan 'dosens' ada di compact()
        return view('mahasiswa.pengajuan.pkl', compact('pengajuan', 'mahasiswa', 'dosens'));
    }

    /**
     * Mengunggah atau memperbarui dokumen persyaratan.
     */
    public function pklStore(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            // Tambahkan validasi file jika perlu, contoh:
            // 'laporan_pkl_1' => 'mimes:pdf|max:2048',
        ]);

        foreach ($request->files as $key => $file) {
            // Hapus file lama jika ada
            if ($pengajuan->{$key}) {
                Storage::disk('public')->delete($pengajuan->{$key});
            }

            // Simpan file baru
            $path = $file->store('berkas_pkl', 'public');
            $pengajuan->{$key} = $path;
        }

        $pengajuan->save();

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah/diperbarui.');
    }


    /**
     * Memperbarui field secara spesifik (untuk auto-save).
     */
    public function pklUpdate(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'field' => 'required|string|in:judul_laporan_pkl,dosen_pembimbing_id',
            'value' => 'required',
        ]);

        $field = $request->input('field');
        $value = $request->input('value');

        $pengajuan->{$field} = $value;
        $pengajuan->save();

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
    }

    /**
     * Finalisasi pengajuan oleh mahasiswa.
     */
    public function pklFinalisasi(Pengajuan $pengajuan)
    {
        // Logika untuk memastikan semua sudah lengkap bisa ditambahkan di sini
        // sebagai double-check sebelum mengubah status.

        $pengajuan->status = 'pending'; // Status menjadi menunggu verifikasi
        $pengajuan->catatan = null; // Hapus catatan penolakan sebelumnya
        $pengajuan->save();

        return redirect()->back()->with('success', 'Pengajuan berhasil difinalisasi dan dikirim untuk verifikasi.');
    }


    public function jadwalSidangPkl()
    {
        // Eager load related data: pengajuan and all associated dosens
        $sidangsPkl = Sidang::with([
            'pengajuan',
            'ketuaSidangDosen',
            'sekretarisSidangDosen',
            'anggota1SidangDosen',
            'anggota2SidangDosen',
            'dosenPembimbing',
            'dosenPenguji1',
            'dosenPenguji2'
        ])
        ->whereHas('pengajuan', function ($query) {
            $query->where('jenis_pengajuan', 'Sidang PKL'); // Assuming 'jenis_pengajuan' exists in 'pengajuans' table
        })
        ->orderBy('tanggal_waktu_sidang', 'desc')
        ->get();

        return view('mahasiswa.jadwal_pkl', compact('sidangsPkl'));
    }

    /**
     * Display a listing of Sidang TA schedules.
     *
     * @return \Illuminate\View\View
     */
    public function jadwalSidangTa()
    {
        // Eager load related data: pengajuan and all associated dosens
        $sidangsTa = Sidang::with([
            'pengajuan',
            'ketuaSidangDosen',
            'sekretarisSidangDosen',
            'anggota1SidangDosen',
            'anggota2SidangDosen',
            'dosenPembimbing',
            'dosenPenguji1',
            'dosenPenguji2'
        ])
        ->whereHas('pengajuan', function ($query) {
            $query->where('jenis_pengajuan', 'Sidang TA'); // Assuming 'jenis_pengajuan' exists in 'pengajuans' table
        })
        ->orderBy('tanggal_waktu_sidang', 'desc')
        ->get();

        return view('mahasiswa.jadwal_ta', compact('sidangsTa'));
    }

    // You might also want a method to view a single sidang detail
    public function showSidang($id)
    {
        $sidang = Sidang::with([
            'pengajuan',
            'ketuaSidangDosen',
            'sekretarisSidangDosen',
            'anggota1SidangDosen',
            'anggota2SidangDosen',
            'dosenPembimbing',
            'dosenPenguji1',
            'dosenPenguji2'
        ])->findOrFail($id);

        return view('mahasiswa.show', compact('sidang'));
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

        return redirect()->route('mahasiswa.pengajuan.edit', $pengajuan->id)->with('success', 'Pengajuan berhasil diperbarui sebagai draft.');
    }


}
