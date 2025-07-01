<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Pengajuan;
use App\Models\Sidang; // Tambahkan ini
use App\Models\Dokumen;
use App\Models\User; //
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DosenImport;
use App\Imports\MahasiswaImport; // Tambahkan ini
use App\Exports\MahasiswaExport; // Tambahkan ini
use App\Exports\DosenExport; // Tambahkan ini
use App\Exports\SidangExport; // Tambahkan ini
use Carbon\Carbon; // Tambahkan ini
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 

class AdminController extends Controller
{

    public function daftarDosen(Request $request)
{
    $query = Dosen::query();
    
    // Search functionality
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('nidn', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }
    
    // Sorting functionality
    switch ($request->sort) {
        case 'nama_asc':
            $query->orderBy('nama', 'asc');
            break;
        case 'nama_desc':
            $query->orderBy('nama', 'desc');
            break;
        case 'nidn_asc':
            $query->orderBy('nidn', 'asc');
            break;
        case 'nidn_desc':
            $query->orderBy('nidn', 'desc');
            break;
        default:
            $query->orderBy('created_at', 'desc');
    }
    
    $dosens = $query->paginate(10);
    
    return view('admin.dosen.index', compact('dosens'));
}


    public function importForm()
    {
        return view('admin.dosen.import');
    }

    // Method untuk memproses file Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv', // Validasi file Excel
        ]);

        try {
            Excel::import(new DosenImport, $request->file('file')); // Proses impor
            return redirect()->back()->with('success', 'Data dosen berhasil diimpor!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->with('error', 'Gagal mengimpor data dosen. Ada kesalahan validasi: ' . implode('; ', $errors));
        } catch (\Exception $e) {
            // Tangani error umum lainnya
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data dosen: ' . $e->getMessage());
        }
    }


    public function pilihJenisPengajuanSidang()
    {
        return view('admin.pengajuan.sidang.pilih-jenis');
    }

    // New method to list TA submissions
    public function daftarPengajuanTa()
    {
        $pengajuans = Pengajuan::with('mahasiswa')
                      ->where('jenis_pengajuan', 'ta')
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);
        return view('admin.pengajuan.sidang.ta', compact('pengajuans'));
    }

    // New method to list PKL submissions
    public function daftarPengajuanPkl()
    {
        $pengajuans = Pengajuan::with('mahasiswa')
                      ->where('jenis_pengajuan', 'pkl')
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);
        return view('admin.pengajuan.sidang.pkl', compact('pengajuans'));
    }

    // ... existing Pengajuan Methods (setujuiPengajuan, tolakPengajuan, detailPengajuan)
    // You might want to adjust detailPengajuan to be more generic if it's used for both types,
    // or create specific detail methods if the logic differs significantly.
    public function detailPengajuan(Pengajuan $pengajuan)
    {
        $dokumens = Dokumen::where('pengajuan_id', $pengajuan->id)->get();
        return view('admin.pengajuan.show', compact('pengajuan', 'dokumens'));
    }

    public function setujuiPengajuan(Pengajuan $pengajuan)
    {
        $pengajuan->update(['status' => 'diverifikasi_admin']); // Changed status to 'diverifikasi_admin' as per your existing code 
        return back()->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function tolakPengajuan(Pengajuan $pengajuan)
    {
        $pengajuan->update(['status' => 'ditolak_admin']); // Changed status to 'ditolak_admin' as per your existing code 
        return back()->with('error', 'Pengajuan berhasil ditolak.');
    }

    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'admin'; // Tambahkan role ke credentials

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/'); // Redirect ke halaman utama atau halaman lain setelah logout
    }

    // Dibawah ini untuk CRUD mahasiswa
    public function daftarMahasiswa(Request $request){
        $mahasiswas = Mahasiswa::query(); // Start with a query builder

        // Sorting
        if ($request->has('sort_by') && $request->has('sort_order')) {
            $sortBy = $request->input('sort_by');
            $sortOrder = $request->input('sort_order');

            if (in_array($sortBy, ['kelas', 'jenis_kelamin'])) {
                $mahasiswas->orderBy($sortBy, $sortOrder);
            }
        }

        $mahasiswas = $mahasiswas->get(); // Get the results

        return view('admin.mahasiswa.index', compact('mahasiswas'));
    }

    public function detailMahasiswa(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    public function createMahasiswa()
    {
        return view('admin.mahasiswa.create');
    }

    /*public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas',
            'nama_lengkap' => 'required',
            'jurusan' => 'required',
            'prodi' => 'required',
            'jenis_kelamin' => 'required',
            'kelas' => 'required',
        ]);

        Mahasiswa::create($request->all());

        logActivity('Membuat mahasiswa baru: ' . $request->nama_lengkap, 'Mahasiswa');

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }>*/

    public function storeMahasiswa(Request $request)
    {
        // Pastikan Anda memiliki Validator facade di-import: use Illuminate\Support\Facades\Validator;
        $validator = Validator::make($request->all(), [
            'nim' => 'required|unique:mahasiswas',
            'nama_lengkap' => 'required',
            'jurusan' => 'required',
            'prodi' => 'required',
            'jenis_kelamin' => 'required',
            'kelas' => 'required',
            'email' => 'required|email|unique:users', // Validasi email untuk user
            'password' => 'required|min:8', // Validasi password untuk user
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Buat user baru terlebih dahulu
        $user = User::create([
            'name' => $request->nama_lengkap, // Gunakan nama lengkap mahasiswa sebagai nama user
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa', // Tetapkan role 'mahasiswa'
        ]);

        // Buat data mahasiswa dan kaitkan dengan user_id yang baru dibuat
        Mahasiswa::create([
            'user_id' => $user->id, // Penting: kaitkan dengan ID user yang baru dibuat
            'nim' => $request->nim,
            'nama_lengkap' => $request->nama_lengkap,
            'jurusan' => $request->jurusan,
            'prodi' => $request->prodi,
            'email' =>$request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas' => $request->kelas,
        ]);

        logActivity('Membuat mahasiswa baru: ' . $request->nama_lengkap, 'Mahasiswa');

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    public function editMahasiswa(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function updateMahasiswa(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim,' . $mahasiswa->id,
            'nama_lengkap' => 'required',
            'jurusan' => 'required',
            'prodi' => 'required',
            'jenis_kelamin' => 'required',
            'kelas' => 'required',
        ]);

        $mahasiswa->update($request->all());

        logActivity('Mengupdate mahasiswa: ' . $mahasiswa->nama_lengkap, 'Mahasiswa');

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil diupdate.');
    }

    public function destroyMahasiswa(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        logActivity('Menghapus mahasiswa: ' . $mahasiswa->nama_lengkap, 'Mahasiswa');

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }

    public function detailDosen(Dosen $dosen)
    {
        return view('admin.dosen.show', compact('dosen'));
    }

    public function createDosen() 
    {
        return view('admin.dosen.create');
    }

    public function storeDosen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nidn' => 'required|unique:dosens',
            'nama' => 'required',
            'jurusan' => 'required',
            'prodi' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen',
        ]);

        Dosen::create([
            'user_id' => $user->id,
            'nidn' => $request->nidn,
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
            'email' => $request->email,
            'prodi' => $request->prodi,
            'jenis_kelamin' => $request->jenis_kelamin,
            'password' => $request->password,

        ]);

        // logActivity('Membuat dosen baru: ' . $request->nama, 'Dosen'); // Jika Anda menggunakan logActivity
        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil ditambahkan!');
    }

    public function editDosen(Dosen $dosen)
    {
        return view('admin.dosen.edit', compact('dosen'));
    }

    public function updateDosen(Request $request, Dosen $dosen)
    {
        $request->validate([
            'nidn' => 'required|unique:dosens,nidn,' . $dosen->id,
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        $dosen->update($request->all());

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil diupdate.');
    }

    public function destroyDosen(Dosen $dosen)
    {
        $dosen->delete();

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil dihapus.');
    }

    public function importDosenForm()
    {
        return view('admin.dosen.import');
    }

    public function importDosen(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new DosenImport, $request->file('file'));

        return redirect()->route('admin.dosen.index')->with('success', 'Data dosen berhasil diimport.');
    }

    // Dibawah ini Pengajuan Sidang Methods
    public function daftarPengajuan()
    {
        //$pengajuans = Pengajuan::with('mahasiswa')->get(); // Eager load data mahasiswa
        $pengajuans = Pengajuan::with('mahasiswa') // Eager load relasi mahasiswa jika digunakan di view
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
            ->paginate(10); // Ambil 10 pengajuan per halaman. Sesuaikan jumlah ini.

        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    // Dibawah ini Persidangan Methods
    public function daftarSidang()
    {
        $sidangs = Sidang::with('pengajuan.mahasiswa')->get(); // Eager load data
        return view('admin.sidang.index', compact('sidangs'));
    }

    public function kalenderSidang()
    {
        $sidangs = Sidang::with('pengajuan.mahasiswa')->get();
        $events = [];

        foreach ($sidangs as $sidang) {
            if ($sidang->tanggal_sidang) {
                $events[] = [
                    'title' => 'Sidang ' . $sidang->pengajuan->mahasiswa->nama_lengkap,
                    'start' => $sidang->tanggal_sidang,
                    // Tambahkan data lain yang ingin ditampilkan di kalender
                ];
            }
        }

        return view('admin.sidang.kalender', compact('events'));
    }

    public function detailSidang(Sidang $sidang)
    {
        return view('admin.sidang.show', compact('sidang'));
    }

    // Method untuk menampilkan nilai dan hasil (jika diperlukan terpisah)
    // public function nilaiSidang(Sidang $sidang) { ... }
    // public function hasilSidang(Sidang $sidang) { ... }

    // Dibawah ini import mahasiswa method
    public function importMahasiswaForm()
    {
        return view('admin.mahasiswa.import');
    }

    public function importMahasiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new MahasiswaImport, $request->file('file'));

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil diimport.');
    }

    // Dibawah ini export (mahasiswa, Dosen, Sidang) method
    public function exportMahasiswa()
    {
        return Excel::download(new MahasiswasExport, 'data_mahasiswa.xlsx');
    }

    public function exportDosen()
    {
        return Excel::download(new DosensExport, 'data_dosen.xlsx');
    }

    public function exportSidang()
    {
        return Excel::download(new SidangsExport, 'data_persidangan.xlsx');
    }

    // Dibawah ini Untuk Log aktivitas
    public function showActivities()
    {
        $activities = Activity::with('user')->latest()->paginate(10); // Ambil log, urutkan terbaru, paginasi
        return view('admin.activities.index', compact('activities'));
    }
}