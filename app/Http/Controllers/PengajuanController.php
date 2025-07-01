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

     public function pklDetail()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $pengajuan = Pengajuan::firstOrCreate(
            ['mahasiswa_id' => $mahasiswa->id, 'jenis_sidang' => 'pkl'],
            ['status' => 'draft']
        );
        $dosen_pembimbings = Dosen::all(); // Ambil semua dosen

        return view('mahasiswa.pengajuan.pkl', compact('pengajuan', 'dosen_pembimbings'));
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
        $dosens = Dosen::orderBy('nama')->get(); // Mengambil semua dosen yang diurutkan berdasarkan nama

        // Buat instance Pengajuan baru (kosong)
        $pengajuan = new Pengajuan(['jenis_pengajuan' => $jenis, 'mahasiswa_id' => $mahasiswa->id]);

        // Karena ini pengajuan baru, tidak ada dokumen terupload sebelumnya
        $dokumenTerupload = collect();

        return view('mahasiswa.pengajuan.pkl', compact('pengajuan', 'mahasiswa', 'jenis', 'dokumenSyarat', 'dosens', 'dokumenTerupload'));
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
            if ($request->input('action') === 'draft_and_upload') {
                 return response()->json(['success' => false, 'message' => 'Anda sudah memiliki pengajuan yang sedang diproses. Dokumen tidak dapat diunggah.'], 409);
            }
            return redirect()->route('mahasiswa.pengajuan.index')
                             ->with('error', 'Anda sudah memiliki pengajuan yang sedang diproses. Anda tidak dapat membuat pengajuan baru sampai pengajuan sebelumnya selesai atau dibatalkan.');
        }

        $status = $request->input('action') === 'draft' ? 'draft' : 'diajukan_mahasiswa';

        // Base validation rules
        $validationRules = [
            'jenis_pengajuan' => 'required|in:pkl,ta',
            'judul_pengajuan' => 'nullable|string|max:255',
            'dosen_pembimbing_id' => $status === 'diajukan_mahasiswa' ? 'required|exists:dosens,id' : 'nullable|exists:dosens,id',
        ];

        // Specific rules for TA or PKL
        if ($request->jenis_pengajuan === 'ta') {
            $validationRules['dosen_penguji1_id'] = ($status === 'diajukan_mahasiswa' ? 'required' : 'nullable') . '|exists:dosens,id|different:dosen_pembimbing_id';
        } elseif ($request->jenis_pengajuan === 'pkl') {
            // Dosen Penguji 1 (Dosen Pembimbing 2) is not required for PKL
            $validationRules['dosen_penguji1_id'] = 'nullable|exists:dosens,id|different:dosen_pembimbing_id';
        }


        // Handle the new 'draft_and_upload' action
        if ($request->input('action') === 'draft_and_upload') {
            $status = 'draft'; // Force status to draft for auto-drafting
            $validationRules['document_file'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
            $validationRules['document_name_key'] = 'required|string';
            // For draft_and_upload, dosen_pembimbing_id is required from the start
            $validationRules['dosen_pembimbing_id'] = 'required|exists:dosens,id';
            // Re-apply dosen_penguji1_id rule based on jenis_pengajuan for draft_and_upload
            if ($request->jenis_pengajuan === 'ta') {
                $validationRules['dosen_penguji1_id'] = 'required|exists:dosens,id|different:dosen_pembimbing_id';
            } elseif ($request->jenis_pengajuan === 'pkl') {
                $validationRules['dosen_penguji1_id'] = 'nullable|exists:dosens,id|different:dosen_pembimbing_id';
            }
        } else { // Existing logic for regular form submission with multiple files
            $dokumenSyaratList = $this->getDokumenSyarat($request->jenis_pengajuan);
            foreach ($dokumenSyaratList as $key => $namaDokumen) {
                $validationRules["dokumen_{$key}"] = ($status === 'diajukan_mahasiswa') ? 'required|file|mimes:pdf,jpg,jpeg,png|max:2048' : 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
            }
        }

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            if ($request->input('action') === 'draft_and_upload') {
                return response()->json(['success' => false, 'message' => 'Validasi gagal: ' . $validator->errors()->first()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            $pengajuan = Pengajuan::create([
                'mahasiswa_id' => $mahasiswa->id,
                'jenis_pengajuan' => $request->jenis_pengajuan,
                'judul_pengajuan' => $request->judul_pengajuan,
                'status' => $status,
            ]);

            $pengajuan->sidang()->create([
                'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
                // If dosen_penguji1_id is not present (e.g., PKL), it will be null, which is allowed by nullable in fillable
                'dosen_penguji1_id' => $request->dosen_penguji1_id,
                'status' => 'belum_dijadwalkan',
            ]);

            // Handle document upload for 'draft_and_upload' action
            if ($request->input('action') === 'draft_and_upload') {
                // Ambil key yang sebenarnya dari document_name_key
                $actualDocumentKey = Str::after($request->input('document_name_key'), 'dokumen_');
                $dokumenSyaratList = $this->getDokumenSyarat($pengajuan->jenis_pengajuan);
                $namaDokumen = $dokumenSyaratList[$actualDocumentKey] ?? null; // Gunakan actualDocumentKey di sini

                if ($namaDokumen && $request->hasFile('document_file')) {
                    $file = $request->file('document_file');
                    $originalFileName = Str::slug($namaDokumen) . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('dokumen_pengajuan/' . $pengajuan->id, $originalFileName, 'public');

                    Dokumen::create([
                        'pengajuan_id' => $pengajuan->id,
                        'nama_file' => $namaDokumen,
                        'path_file' => $path,
                        'status' => 'diajukan_mahasiswa', // Status dokumen diatur sebagai diajukan_mahasiswa
                    ]);
                }
                return response()->json(['success' => true, 'message' => 'Pengajuan draft berhasil dibuat dan dokumen diunggah.', 'redirect_url' => route('mahasiswa.pengajuan.edit', $pengajuan->id)]);

            } else { // Existing logic for regular form submission with multiple files
                $dokumenSyaratList = $this->getDokumenSyarat($request->jenis_pengajuan); // Ensure dokumenSyaratList is defined
                foreach ($dokumenSyaratList as $key => $namaDokumen) {
                    $fieldName = 'dokumen_' . $key;
                    if ($request->hasFile($fieldName)) {
                        $file = $request->file($fieldName);
                        $namaFileSyarat = $namaDokumen;

                        $existingDokumen = Dokumen::where('pengajuan_id', $pengajuan->id)
                                                  ->where('nama_file', $namaFileSyarat)
                                                  ->first();

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
                    return redirect()->route('mahasiswa.pengajuan.edit', $pengajuan->id)->with('success', 'Pengajuan berhasil disimpan sebagai draft.');
                } else {
                    return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->id)->with('success', 'Pengajuan berhasil diajukan dan akan segera diverifikasi!');
                }
            }
        } catch (Throwable $e) {
            // Log the error for debugging
            \Log::error('Error in PengajuanController@store: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            if ($request->input('action') === 'draft_and_upload') {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan server saat memproses pengajuan: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Terjadi kesalahan server saat memproses pengajuan: ' . $e->getMessage())->withInput();
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

        $dokumenSyarat = $this->getDokumenSyarat($pengajuan->jenis_pengajuan);
        $dokumenTerupload = $pengajuan->dokumens->keyBy('nama_file');
        $dosens = Dosen::orderBy('nama')->get(); // Mengambil semua dosen

        // Menentukan view berdasarkan jenis pengajuan
        if ($pengajuan->jenis_pengajuan === 'ta') {
            return view('mahasiswa.pengajuan.show_ta', compact('pengajuan', 'mahasiswa', 'dokumenSyarat', 'dokumenTerupload', 'dosens'));
        } elseif ($pengajuan->jenis_pengajuan === 'pkl') {
            return view('mahasiswa.pengajuan.pkl', compact('pengajuan', 'mahasiswa', 'dokumenSyarat', 'dokumenTerupload', 'dosens'));
        }

        return view('mahasiswa.pengajuan.show', compact('pengajuan', 'mahasiswa', 'dokumenSyarat', 'dokumenTerupload', 'dosens'));
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
                             ->with('error', 'Pengajuan sudah diajukan dan tidak bisa diedit.');
        }

        $jenis = $pengajuan->jenis_pengajuan;
        $dokumenSyarat = $this->getDokumenSyarat($jenis);
        $dokumenTerupload = $pengajuan->dokumens->keyBy('nama_file');
        $dosens = Dosen::orderBy('nama')->get();

        // Menentukan view berdasarkan jenis pengajuan
        if ($jenis === 'ta') {
            return view('mahasiswa.pengajuan.edit_ta', compact('pengajuan', 'jenis', 'dokumenSyarat', 'dokumenTerupload', 'dosens', 'mahasiswa'));
        } elseif ($jenis === 'pkl') {
            return view('mahasiswa.pengajuan.pkl', compact('pengajuan', 'jenis', 'dokumenSyarat', 'dokumenTerupload', 'dosens', 'mahasiswa'));
        }
        return view('mahasiswa.pengajuan.edit', compact('pengajuan', 'jenis', 'dokumenSyarat', 'dokumenTerupload', 'dosens', 'mahasiswa'));
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

        // Cek apakah update dilakukan untuk single document upload atau form utama
        if ($request->input('action') === 'upload_single_document') {
            return $this->uploadSingleDocument($request, $pengajuan);
        }

        if ($pengajuan->status !== 'draft' && !in_array($pengajuan->status, ['ditolak_admin', 'ditolak_kaprodi'])) {
            return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->id)
                             ->with('error', 'Pengajuan ini tidak dapat diupdate karena sudah dalam proses verifikasi.');
        }

        $status = $request->input('action') === 'submit' ? 'diajukan_mahasiswa' : 'draft';

        // Base validation rules
        $validationRules = [
            'action' => 'required|in:draft,submit',
            'judul_pengajuan' => 'nullable|string|max:255',
            'dosen_pembimbing_id' => $status === 'diajukan_mahasiswa' ? 'required|exists:dosens,id' : 'nullable|exists:dosens,id',
        ];

        // Specific rules for TA or PKL
        if ($pengajuan->jenis_pengajuan === 'ta') {
            $validationRules['dosen_penguji1_id'] = ($status === 'diajukan_mahasiswa' ? 'required' : 'nullable') . '|exists:dosens,id|different:dosen_pembimbing_id';
        } elseif ($pengajuan->jenis_pengajuan === 'pkl') {
            // Dosen Penguji 1 (Dosen Pembimbing 2) is not required for PKL
            $validationRules['dosen_penguji1_id'] = 'nullable|exists:dosens,id|different:dosen_pembimbing_id';
        }

        $dokumenSyaratList = $this->getDokumenSyarat($pengajuan->jenis_pengajuan);

        // Validasi untuk semua dokumen persyaratan
        foreach ($dokumenSyaratList as $key => $namaDokumen) {
            $fieldName = 'dokumen_' . $key;
            $uploadedDoc = $pengajuan->dokumens->where('nama_file', $namaDokumen)->first();

            $rulesForThisDoc = [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ];

            // Jika status adalah submit dan dokumen belum ada, maka required
            if ($status === 'diajukan_mahasiswa' && !$uploadedDoc && !$request->hasFile($fieldName)) {
                $rulesForThisDoc[] = 'required';
            }

            $validationRules[$fieldName] = $rulesForThisDoc;
        }

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $pengajuan->update([
                'judul_pengajuan' => $request->judul_pengajuan, // Update judul pengajuan
                'status' => $status,
            ]);

            // Update entri sidang
            if ($pengajuan->sidang) {
                $pengajuan->sidang->update([
                    'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
                    // Only update dosen_penguji1_id if it's present in the request (e.g., for TA) or set to null if PKL
                    'dosen_penguji1_id' => $request->dosen_penguji1_id,
                    'status' => $status === 'diajukan_mahasiswa' ? 'belum_dijadwalkan' : $pengajuan->sidang->status,
                ]);
            } else {
                // Ini seharusnya tidak terjadi di update, tapi sebagai fallback jika sidang belum ada
                $pengajuan->sidang()->create([
                    'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
                    'dosen_penguji1_id' => $request->dosen_penguji1_id,
                    'status' => 'belum_dijadwalkan',
                ]);
            }

            // Proses dokumen upload dari form utama (jika ada)
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
                return redirect()->route('mahasiswa.pengajuan.edit', $pengajuan->id)->with('success', 'Pengajuan draft berhasil diperbarui.');
            } else {
                return redirect()->route('mahasiswa.pengajuan.show', $pengajuan->id)->with('success', 'Pengajuan berhasil difinalisasi dan diajukan!');
            }
        } catch (Throwable $e) {
            \Log::error('Error in PengajuanController@update: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return back()->with('error', 'Terjadi kesalahan server saat memperbarui pengajuan: ' . $e->getMessage())->withInput();
        }
    }

    protected function uploadSingleDocument(Request $request, Pengajuan $pengajuan)
    {
        try {
            $request->validate([
                'document_name_key' => 'required|string',
                'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            // Ambil key yang sebenarnya dari document_name_key (misal: 'dokumen_laporan_pkl' menjadi 'laporan_pkl')
            $actualDocumentKey = Str::after($request->input('document_name_key'), 'dokumen_');
            $dokumenSyaratList = $this->getDokumenSyarat($pengajuan->jenis_pengajuan);
            $namaDokumen = $dokumenSyaratList[$actualDocumentKey] ?? null; // Gunakan actualDocumentKey di sini

            if (!$namaDokumen) {
                return response()->json(['success' => false, 'message' => 'Nama dokumen tidak valid.'], 400);
            }

            $file = $request->file('document_file');
            $originalFileName = Str::slug($namaDokumen) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('dokumen_pengajuan/' . $pengajuan->id, $originalFileName, 'public');

            $existingDokumen = Dokumen::where('pengajuan_id', $pengajuan->id)
                                      ->where('nama_file', $namaDokumen)
                                      ->first();

            if ($existingDokumen) {
                Storage::disk('public')->delete($existingDokumen->path_file);
                $existingDokumen->update(['path_file' => $path, 'status' => 'diajukan_mahasiswa']);
            } else {
                Dokumen::create([
                    'pengajuan_id' => $pengajuan->id,
                    'nama_file' => $namaDokumen,
                    'path_file' => $path,
                    'status' => 'diajukan_mahasiswa',
                ]);
            }

            // Ensure the pengajuan status is 'draft' after document upload if it wasn't already submitted
            // This handles cases where a rejected pengajuan has its document updated.
            if ($pengajuan->status !== 'diajukan_mahasiswa' && $pengajuan->status !== 'diverifikasi_admin' && $pengajuan->status !== 'dosen_ditunjuk' && $pengajuan->status !== 'sedang_diproses' && $pengajuan->status !== 'selesai') {
                $pengajuan->update(['status' => 'draft']);
            }


            return response()->json(['success' => true, 'message' => 'Dokumen berhasil diunggah.']);
        } catch (Throwable $e) {
            \Log::error('Error in PengajuanController@uploadSingleDocument: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengunggah dokumen: ' . $e->getMessage()], 500);
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
