<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Mahasiswa; // Tambahkan ini

class DokumenController extends Controller
{
    // Helper untuk mendapatkan objek Mahasiswa dari user yang login
    private function getLoggedInMahasiswa()
    {
        return Mahasiswa::where('user_id', Auth::id())->firstOrFail();
    }

    public function index(Pengajuan $pengajuan)
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $mahasiswa = $this->getLoggedInMahasiswa();

        // Pastikan mahasiswa yang melihat adalah pemilik pengajuan
        if ($mahasiswa->id != $pengajuan->mahasiswa_id) {
            abort(403, 'Anda tidak diizinkan mengakses dokumen ini.');
        }

        $dokumenTerupload = Dokumen::where('pengajuan_id', $pengajuan->id)->get();

        return view('mahasiswa.dokumen.index', compact('pengajuan', 'dokumenTerupload'));
    }

    // Metode store dan update di DokumenController dapat dihapus atau disesuaikan
    // jika Anda ingin memungkinkan update/hapus dokumen individual secara terpisah dari pengajuan.
    // Namun, untuk alur pengajuan dokumen persyaratan, PengajuanController sudah cukup.

    // Contoh: Jika Anda ingin mahasiswa bisa menghapus dokumen satu per satu
    public function destroy(Dokumen $dokumen)
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $mahasiswa = $this->getLoggedInMahasiswa();

        // Pastikan dokumen milik mahasiswa yang login dan pengajuan masih dalam status draft/ditolak
        if ($dokumen->pengajuan->mahasiswa_id !== $mahasiswa->id ||
            !in_array($dokumen->pengajuan->status, ['draft', 'ditolak_admin', 'ditolak_kaprodi'])) {
            abort(403, 'Anda tidak diizinkan menghapus dokumen ini.');
        }

        Storage::disk('public')->delete($dokumen->path_file);
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}