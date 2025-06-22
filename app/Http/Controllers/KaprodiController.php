<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Dosen;
use App\Models\Sidang; // Pastikan model Sidang di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; // Untuk validasi unique
use App\Notifications\DosenSidangInvitation; // Pastikan ini di-import
use Illuminate\Support\Facades\DB;

class KaprodiController extends Controller
{

    public function storeUpdateJadwalSidang(Request $request, Pengajuan $pengajuan)
    {
        // Pastikan relasi sidang sudah di-load. Jika belum ada, buat baru
        if (!$pengajuan->sidang) {
            $sidang = new Sidang();
            $sidang->pengajuan_id = $pengajuan->id;
            $sidang->dosen_pembimbing_id = $pengajuan->mahasiswa->pembimbing1_id;
            $sidang->dosen_penguji1_id = $pengajuan->mahasiswa->pembimbing2_id;
            $sidang->persetujuan_dosen_pembimbing = $sidang->persetujuan_dosen_pembimbing ?? 'pending';
            $sidang->persetujuan_dosen_penguji1 = $sidang->persetujuan_dosen_penguji1 ?? 'pending';
            $sidang->save();
            $pengajuan->load('sidang'); // Reload pengajuan untuk mendapatkan relasi sidang yang baru
        }
        
        $sidang = $pengajuan->sidang; // Ambil objek sidang setelah dipastikan ada

        // Tentukan apakah ada pembimbing yang sudah menyetujui
        $pembimbing1Setuju = $sidang->dosenPembimbing && $sidang->persetujuan_dosen_pembimbing === 'setuju';
        $pembimbing2Setuju = $sidang->dosenPenguji1 && $sidang->persetujuan_dosen_penguji1 === 'setuju';
        
        $ketuaSidangRules = ['nullable', 'exists:dosens,id'];

        if ($pembimbing1Setuju || $pembimbing2Setuju) {
            $allowedKetuaIds = [];
            if ($pembimbing1Setuju) {
                $allowedKetuaIds[] = $sidang->dosenPembimbing->id;
            }
            if ($pembimbing2Setuju) {
                $allowedKetuaIds[] = $sidang->dosenPenguji1->id;
            }
            
            $ketuaSidangRules = [
                'nullable',
                function ($attribute, $value, $fail) use ($allowedKetuaIds) {
                    if ($value !== null && $value !== '' && !in_array($value, $allowedKetuaIds)) {
                        $fail('Ketua Sidang yang dipilih harus merupakan Dosen Pembimbing atau Penguji yang sudah menyetujui.');
                    }
                },
            ];
        }

        // --- VALIDASI DATA ---
        $validator = Validator::make($request->all(), [
            'ketua_sidang_id' => $ketuaSidangRules,
            'sekretaris_sidang_id' => 'required|exists:dosens,id',
            'anggota_1_sidang_id' => 'required|exists:dosens,id',
            'anggota_2_sidang_id' => 'nullable|exists:dosens,id',
            'tanggal_waktu_sidang' => 'required|date|after_or_equal:now',
            'ruangan_sidang' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $validatedData = $validator->validated();

        // Cek duplikasi dosen
        $assignedDosenIds = array_filter([
            'ketua_sidang'    => $validatedData['ketua_sidang_id'],
            'sekretaris_sidang' => $validatedData['sekretaris_sidang_id'],
            'anggota1_sidang' => $validatedData['anggota_1_sidang_id'],
            'anggota2_sidang' => $validatedData['anggota_2_sidang_id'],
            'dosen_pembimbing' => $sidang->dosen_pembimbing_id,
            'dosen_penguji1'   => $sidang->dosen_penguji1_id,
        ]);
    
        $dosenNames = Dosen::whereIn('id', $assignedDosenIds)->pluck('nama', 'id')->toArray();
    
        $conflictingDosen = [];
        $roleAssignments = [];
    
        foreach ($assignedDosenIds as $role => $dosenId) {
            if (!isset($roleAssignments[$dosenId])) {
                $roleAssignments[$dosenId] = [];
            }
            $roleAssignments[$dosenId][] = $role;
        }
    
        foreach ($roleAssignments as $dosenId => $roles) {
            if (count($roles) > 1) {
                $isChairmanAlsoPembimbing = (in_array('ketua_sidang', $roles) && in_array('dosen_pembimbing', $roles));
                $isChairmanAlsoPenguji1   = (in_array('ketua_sidang', $roles) && in_array('dosen_penguji1', $roles));
    
                if (!$isChairmanAlsoPembimbing && !$isChairmanAlsoPenguji1) {
                    $conflictingDosen[] = $dosenNames[$dosenId] . ' (peran: ' . implode(', ', $roles) . ')';
                }
            }
        }
    
        if (!empty($conflictingDosen)) {
            return back()->withErrors(['dosen_duplikat' => 
                'Dosen yang ditunjuk tidak boleh memiliki peran ganda yang tidak diizinkan: ' . implode('; ', $conflictingDosen) . '. Pastikan setiap peran unik diisi oleh dosen yang berbeda (kecuali Ketua Sidang boleh merangkap pembimbing/penguji).'])
                ->withInput();
        }
    
        DB::beginTransaction();
        try {
            // $sidang sudah diambil di awal method
        
            $sidang->ketua_sidang_dosen_id = empty($validatedData['ketua_sidang_id']) ? null : $validatedData['ketua_sidang_id'];

            if ($sidang->ketua_sidang_dosen_id !== null) {
                 $sidang->persetujuan_ketua_sidang = 'setuju';
            } else {
                 $sidang->persetujuan_ketua_sidang = 'pending';
            }
            
            $sidang->sekretaris_sidang_dosen_id = $validatedData['sekretaris_sidang_id'];
            $sidang->anggota1_sidang_dosen_id = $validatedData['anggota_1_sidang_id'];
            $sidang->anggota2_sidang_dosen_id = empty($validatedData['anggota_2_sidang_id']) ? null : $validatedData['anggota_2_sidang_id'];
        
            $sidang->tanggal_waktu_sidang = $validatedData['tanggal_waktu_sidang'];
            $sidang->ruangan_sidang = $validatedData['ruangan_sidang'];
        
            $sidang->save();
        
            // Notifikasi ke dosen yang baru ditunjuk
            $dosenToNotify = [];
            // Map dosen IDs to their roles to avoid duplicate notifications and pass correct role
            $rolesForNotification = [];

            // Ketua Sidang (jika baru ditunjuk dan belum ada persetujuan)
            // Namun, karena ketua sidang otomatis 'setuju' saat dipilih,
            // notifikasi ke Ketua Sidang sebagai Ketua tidak terlalu diperlukan di sini
            // karena dia sudah menerima notifikasi sebagai Pembimbing/Penguji.
            // Jika Anda ingin notifikasi terpisah untuk peran Ketua Sidang,
            // Anda perlu menyesuaikan logic dan DosenSidangInvitation notification.

            // Sekretaris
            if ($sidang->sekretaris_sidang_dosen_id && $sidang->persetujuan_sekretaris_sidang === 'pending') {
                $dosenToNotify[] = $sidang->sekretaris_sidang_dosen_id;
                $rolesForNotification[$sidang->sekretaris_sidang_dosen_id] = 'sekretaris_sidang';
            }
            // Anggota 1
            if ($sidang->anggota1_sidang_dosen_id && $sidang->persetujuan_anggota1_sidang === 'pending') {
                $dosenToNotify[] = $sidang->anggota1_sidang_dosen_id;
                $rolesForNotification[$sidang->anggota1_sidang_dosen_id] = 'anggota1_sidang';
            }
            // Anggota 2 (opsional)
            if ($sidang->anggota2_sidang_dosen_id !== null && $sidang->persetujuan_anggota2_sidang === 'pending') {
                $dosenToNotify[] = $sidang->anggota2_sidang_dosen_id;
                $rolesForNotification[$sidang->anggota2_sidang_dosen_id] = 'anggota2_sidang';
            }
    
            // Ambil objek Dosen berdasarkan ID yang akan dinotifikasi
            $uniqueDosenIdsToNotify = array_unique($dosenToNotify);
            $newlyAssignedDosen = Dosen::whereIn('id', $uniqueDosenIdsToNotify)->get();
    
            foreach ($newlyAssignedDosen as $dosen) {
                // Pastikan kita melewatkan $sidang, $pengajuan, dan peran yang benar
                $role = $rolesForNotification[$dosen->id] ?? 'Unknown Role'; // Default jika somehow tidak ditemukan
                $dosen->notify(new DosenSidangInvitation($sidang, $pengajuan, $role));
            }
        
            // Perbarui status pengajuan
            if ($pengajuan->status === 'diverifikasi_admin' || $pengajuan->status === 'disetujui_kaprodi') {
                $pengajuan->status = 'menunggu_persetujuan_dosen'; 
            }
            $pengajuan->save();
        
            DB::commit();
        
            return redirect()->route('kaprodi.pengajuan.show', $pengajuan->id)
                             ->with('success', 'Jadwal sidang berhasil ' . ($sidang->wasRecentlyCreated ? 'ditentukan' : 'diperbarui') . '. Menunggu persetujuan dosen terkait (jika ada).');
        
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menentukan jadwal sidang: ' . $e->getMessage())->withInput();
        }
    }

    // Method untuk memfinalkan jadwal sidang setelah semua dosen menyetujui
    public function finalkanJadwal(Pengajuan $pengajuan)
    {
        $sidang = $pengajuan->sidang;

        // Pastikan sidang ada
        if (!$sidang) {
            return back()->with('error', 'Jadwal sidang belum ditentukan.');
        }

        // Cek apakah semua peran wajib sudah diisi
        if (
            !$sidang->sekretaris_sidang_dosen_id ||
            !$sidang->anggota1_sidang_dosen_id ||
            !$sidang->tanggal_waktu_sidang ||
            !$sidang->ruangan_sidang ||
            !$sidang->dosen_pembimbing_id || 
            !$sidang->dosen_penguji1_id    
        ) {
            return back()->with('error', 'Semua peran dosen wajib (Pembimbing, Penguji 1, Sekretaris, Anggota 1) dan detail jadwal (Tanggal, Ruangan) harus ditentukan sebelum finalisasi.');
        }

        // Logika untuk memeriksa apakah Ketua Sidang sudah ditentukan (jika opsinya ada)
        // DAN semua dosen WAJIB sudah menyetujui
        $allDosenAgreed = true;
        $missingApprovals = [];

        // Cek Pembimbing
        if ($sidang->dosen_pembimbing_id && $sidang->persetujuan_dosen_pembimbing !== 'setuju') {
            $allDosenAgreed = false;
            $missingApprovals[] = $sidang->dosenPembimbing->nama . ' (Pembimbing)';
        }
        // Cek Penguji 1
        if ($sidang->dosen_penguji1_id && $sidang->persetujuan_dosen_penguji1 !== 'setuju') {
            $allDosenAgreed = false;
            $missingApprovals[] = $sidang->dosenPenguji1->nama . ' (Penguji 1)';
        }

        // Cek Ketua Sidang (jika ada) - sudah di setuju otomatis saat dipilih di storeUpdateJadwalSidang
        // Jika Ketua Sidang tidak dipilih, maka persetujuannya 'pending'.
        // Maka finalisasi tidak bisa dilakukan jika ketua_sidang_dosen_id NULL
        if (!$sidang->ketua_sidang_dosen_id) {
             $allDosenAgreed = false;
             $missingApprovals[] = 'Ketua Sidang belum ditentukan atau belum disetujui.';
        }


        // Cek Sekretaris
        if ($sidang->sekretaris_sidang_dosen_id && $sidang->persetujuan_sekretaris_sidang !== 'setuju') {
            $allDosenAgreed = false;
            $missingApprovals[] = $sidang->sekretarisSidang->nama . ' (Sekretaris)';
        }
        // Cek Anggota 1
        if ($sidang->anggota1_sidang_dosen_id && $sidang->persetujuan_anggota1_sidang !== 'setuju') {
            $allDosenAgreed = false;
            $missingApprovals[] = $sidang->anggota1Sidang->nama . ' (Anggota 1)';
        }
        // Anggota 2 opsional, hanya cek persetujuan jika IDnya tidak null
        if ($sidang->anggota2_sidang_dosen_id !== null && $sidang->persetujuan_anggota2_sidang !== 'setuju') { 
            $allDosenAgreed = false;
            $missingApprovals[] = $sidang->anggota2Sidang->nama . ' (Anggota 2)';
        }
        
        if ($allDosenAgreed) {
            $pengajuan->update(['status' => 'sidang_dijadwalkan_final']);
            // TODO: Kirim notifikasi ke Kajur (jika ada) atau Mahasiswa
            return redirect()->route('kaprodi.pengajuan.show', $pengajuan->id)->with('success', 'Jadwal sidang berhasil difinalisasi dan siap diverifikasi Ketua Jurusan.');
        } else {
            $errorMessage = 'Belum semua dosen yang terlibat menyetujui jadwal sidang yang diajukan. Daftar yang belum menyetujui: ' . implode(', ', $missingApprovals) . '.';
            return back()->with('finalisasi_error', $errorMessage)->withInput();
        }
    }

    // Method untuk menampilkan form login Kaprodi
    public function loginForm()
    {
        return view('kaprodi.auth.login'); // Asumsi view login ada di kaprodi/auth/login.blade.php
    }

    // Method untuk memproses login Kaprodi
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'kaprodi') {
                $request->session()->regenerate();
                return redirect()->intended(route('kaprodi.dashboard'));
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Anda tidak memiliki akses sebagai Kaprodi.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Kombinasi email dan password salah.',
        ]);
    }

    // Method untuk logout Kaprodi
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('kaprodi.login')->with('success', 'Anda telah berhasil logout.');
    }

    // Method untuk dashboard Kaprodi
    public function dashboard()
    {
        // 1. Ambil Jumlah Dosen
        $jumlahDosen = Dosen::count();

        // 2. Ambil Jumlah Pengajuan Baru (misalnya yang statusnya 'diverifikasi_admin')
        // Sesuaikan status ini berdasarkan alur kerja Anda.
        // Asumsi 'diverifikasi_admin' adalah status ketika pengajuan sudah diverifikasi admin dan siap untuk kaprodi.
        $jumlahPengajuan = Pengajuan::where('status', 'diverifikasi_admin')->count();

        // 3. Ambil Pengajuan Terbaru (misalnya 5 pengajuan terbaru dengan status 'diverifikasi_admin')
        // Eager load relasi 'mahasiswa' jika Anda ingin menampilkan nama mahasiswa di view
        $pengajuanBaru = Pengajuan::where('status', 'diverifikasi_admin')
                                ->with('mahasiswa')
                                ->latest() // Mengurutkan berdasarkan created_at secara descending
                                ->take(5) // Mengambil 5 data terbaru
                                ->get();


        // Kirim semua data ini ke view
        return view('kaprodi.dashboard', compact('jumlahDosen', 'jumlahPengajuan', 'pengajuanBaru'));
    }

    // Method untuk menampilkan daftar dosen
    public function daftarDosen()
    {
        $dosens = Dosen::orderBy('nama')->get();
        return view('kaprodi.dosen.index', compact('dosens'));
    }

    // --- Pengajuan-related methods ---

    // Menampilkan daftar pengajuan yang perlu ditinjau Kaprodi
    public function indexPengajuan()
    {
        // 1. Ambil pengajuan yang sedang menunggu aksi Kaprodi
        $pengajuansKaprodi = Pengajuan::where('status', 'diverifikasi_admin')
                                    ->orWhere('status', 'menunggu_persetujuan_dosen')
                                    ->with('mahasiswa')
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(10); // Atau gunakan get() jika tidak ada pagination di bagian ini

        // 2. Ambil pengajuan yang telah selesai ditangani oleh Kaprodi
        // Status 'sidang_dijadwalkan_final' berarti sudah difinalisasi Kaprodi.
        // Status 'ditolak_kaprodi' berarti sudah ditolak Kaprodi.
        $pengajuansSelesaiKaprodi = Pengajuan::whereIn('status', ['sidang_dijadwalkan_final', 'ditolak_kaprodi'])
                                            ->with('mahasiswa') // Eager load relasi mahasiswa
                                            ->orderBy('updated_at', 'desc') // Urutkan berdasarkan update terakhir
                                            ->get(); // Atau gunakan paginate(10) jika Anda ingin pagination di bagian ini juga


        // Kirim kedua set data ke view
        return view('kaprodi.pengajuan.index', compact('pengajuansKaprodi', 'pengajuansSelesaiKaprodi'));
    }

    // Menampilkan detail pengajuan
    public function showPengajuan(Pengajuan $pengajuan)
    {
        // Eager load relasi yang diperlukan untuk detail
        $pengajuan->load([
            'mahasiswa',
            'dokumens',
            'sidang.ketuaSidang',
            'sidang.sekretarisSidang',
            'sidang.anggota1Sidang',
            'sidang.anggota2Sidang',
            'sidang.dosenPembimbing',
            'sidang.dosenPenguji1'
        ]);
    
        // Ambil daftar dosen untuk dropdown di form penjadwalan
        $dosens = Dosen::orderBy('nama')->get(); 
    
        return view('kaprodi.pengajuan.show', compact('pengajuan', 'dosens'));
    }

    public function showAksiKaprodi(Pengajuan $pengajuan)
    {
        // Pastikan relasi sidang sudah ada atau buat jika belum
        // Ini memastikan $pengajuan->sidang selalu tersedia
        if (!$pengajuan->sidang) {
            $sidang = new Sidang();
            $sidang->pengajuan_id = $pengajuan->id;
            $sidang->save();
            $pengajuan->load('sidang'); // Reload pengajuan untuk mendapatkan relasi sidang yang baru
        }

        // Eager load relasi yang diperlukan untuk form aksi
        $pengajuan->load([
            'mahasiswa',
            'sidang.ketuaSidang',
            'sidang.sekretarisSidang',
            'sidang.anggota1Sidang',
            'sidang.anggota2Sidang',
            'sidang.dosenPembimbing',
            'sidang.dosenPenguji1'
        ]);

        // Ambil daftar dosen untuk dropdown di form penjadwalan
        $dosens = Dosen::orderBy('nama')->get();

        return view('kaprodi.pengajuan.aksi', compact('pengajuan', 'dosens'));
    }

    // Menampilkan form untuk menjadwalkan/mengedit jadwal sidang
    public function jadwalkanSidangForm(Pengajuan $pengajuan)
    {
        // Kaprodi dapat menjadwalkan jika statusnya 'diverifikasi_admin' (setelah admin memverifikasi dokumen),
        // atau jika statusnya 'siap_dijadwalkan_kaprodi' (setelah kaprodi menyetujui),
        // atau jika statusnya 'dosen_ditunjuk' (untuk edit jadwal yang sudah ada).
        if (!in_array($pengajuan->status, ['diverifikasi_admin', 'siap_dijadwalkan_kaprodi', 'dosen_ditunjuk'])) {
            return redirect()->route('kaprodi.pengajuan.index')->with('error', 'Pengajuan ini tidak dapat dijadwalkan pada tahap ini.');
        }

        $dosens = Dosen::orderBy('nama')->get();
        $sidang = $pengajuan->sidang; 

        // View yang cocok adalah 'jadwal_sidang_form.blade.php'
        return view('kaprodi.pengajuan.jadwal_sidang_form', compact('pengajuan', 'dosens', 'sidang'));
    }

    // Method untuk menyetujui pengajuan (setelah admin memverifikasi dokumen)
    public function setujuiPengajuan(Pengajuan $pengajuan)
    {
        if ($pengajuan->status !== 'diverifikasi_admin') {
            return back()->with('error', 'Pengajuan ini tidak dapat disetujui pada tahap ini.');
        }

        $pengajuan->update(['status' => 'siap_dijadwalkan_kaprodi']); // Status baru: siap dijadwalkan oleh Kaprodi
        // TODO: Kirim notifikasi ke admin atau pihak terkait jika diperlukan
        return redirect()->route('kaprodi.pengajuan.index')->with('success', 'Pengajuan berhasil disetujui untuk dijadwalkan.');
    }

    // Method untuk menolak pengajuan (setelah admin memverifikasi dokumen)
    public function tolakPengajuan(Request $request, Pengajuan $pengajuan)
    {
        if ($pengajuan->status !== 'diverifikasi_admin') {
            return back()->with('error', 'Pengajuan ini tidak dapat ditolak pada tahap ini.');
        }

        $request->validate([
            'alasan_penolakan' => 'required|string|max:500',
        ]);

        $pengajuan->update([
            'status' => 'ditolak_kaprodi',
            'alasan_penolakan_kaprodi' => $request->alasan_penolakan,
        ]);

        // TODO: Kirim notifikasi ke mahasiswa bahwa pengajuannya ditolak Kaprodi
        return redirect()->route('kaprodi.pengajuan.index')->with('success', 'Pengajuan berhasil ditolak.');
    }

}