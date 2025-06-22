<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pengajuan - Kajur</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        .header { background-color: #f2f2f2; padding: 15px; border-bottom: 1px solid #eee; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .nav-links a { margin-right: 15px; text-decoration: none; color: #007bff; }
        .card { border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin-bottom: 15px; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card-header { font-weight: bold; margin-bottom: 10px; color: #333; }
        .card-body p { margin-bottom: 8px; }
        .btn { padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .alert-success { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        .logout-form button { background-color: #dc3545; color: white; padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verifikasi Pengajuan Sidang</h1>
            <div class="nav-links">
                <a href="{{ route('kajur.dashboard') }}">Dashboard</a>
                <a href="{{ route('kajur.pengajuan.perlu_verifikasi') }}">Pengajuan Perlu Verifikasi</a>
                <a href="{{ route('kajur.pengajuan.sudah_verifikasi') }}">Pengajuan Terverifikasi</a>
                {{-- Tambahkan link navigasi lainnya sesuai kebutuhan --}}
                <form action="{{ route('kajur.logout') }}" method="POST" class="logout-form" style="display: inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <p>Anda akan memverifikasi pengajuan sidang ini:</p>

        <div class="card mb-4">
            <div class="card-header">Detail Pengajuan</div>
            <div class="card-body">
                <p><strong>ID Pengajuan:</strong> {{ $pengajuan->id }}</p>
                <p><strong>Nama Mahasiswa:</strong> {{ $pengajuan->mahasiswa->nama }}</p>
                <p><strong>NIM:</strong> {{ $pengajuan->mahasiswa->nim }}</p>
                <p><strong>Judul Tugas Akhir:</strong> {{ $pengajuan->judul_tugas_akhir }}</p>
                <p><strong>Status Saat Ini:</strong> {{ Str::replace('_', ' ', Str::title($pengajuan->status)) }}</p>
            </div>
        </div>

        <form action="{{ route('kajur.verifikasi.store', $pengajuan->id) }}" method="POST">
            @csrf
            <p>Apakah Anda yakin ingin memverifikasi pengajuan sidang ini?</p>
            <button type="submit" class="btn btn-success">Verifikasi Sekarang</button>
            <a href="{{ route('kajur.pengajuan.perlu_verifikasi') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>