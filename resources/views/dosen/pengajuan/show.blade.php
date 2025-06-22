<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan - Dosen</title>
    <style>
        body { font-family: sans-serif; margin: 20px; background-color: #f4f7f6; }
        .container { max-width: 900px; margin: 30px auto; padding: 25px; border: 1px solid #e0e0e0; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); background-color: #fff; }
        h2 { text-align: center; margin-bottom: 25px; color: #333; }
        .detail-group { margin-bottom: 15px; }
        .detail-group label { font-weight: bold; display: block; margin-bottom: 5px; color: #555; }
        .detail-group p { margin: 0; padding: 8px 12px; background-color: #f9f9f9; border: 1px solid #eee; border-radius: 5px; }
        .dokumen-list { list-style-type: none; padding: 0; }
        .dokumen-list li { background-color: #f0f8ff; border: 1px solid #e0efff; padding: 10px; margin-bottom: 8px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; }
        .dokumen-list li a { text-decoration: none; color: #007bff; font-weight: bold; }
        .dokumen-list li a:hover { text-decoration: underline; }
        .btn-primary:hover { background-color: #0056b3; }
        .btn-success { background-color: #28a745; }
        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }
        .btn-info { background-color: #17a2b8; }
        .btn-info:hover { background-color: #138496; }
    
        .btn {
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        color: white; /* Pastikan ini ada dan efektif untuk semua tombol */
        display: inline-block;
        font-size: 0.9em;
        margin-right: 10px;
        margin-top: 20px;
        transition: background-color 0.3s ease;
        }
        .btn-primary {
            background-color: #007bff;
            color: white; /* Tambahkan atau pastikan ini ada untuk .btn-primary */
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        /* ... gaya CSS lainnya ... */
    
        /* Spesifik untuk tautan di daftar dokumen jika Anda ingin lebih presisi */
        .dokumen-list li a.btn-primary {
            color: white; /* Pastikan ini ada khusus untuk tombol 'Lihat' */
        }
    </style>
    
</head>
<body>
    <div class="container">
        <h2>Detail Pengajuan - {{ strtoupper($pengajuan->jenis_pengajuan) }}</h2>

        <div class="detail-group">
            <label>Mahasiswa:</label>
            <p>{{ $pengajuan->mahasiswa->nama_lengkap }} ({{ $pengajuan->mahasiswa->nim }})</p>
        </div>

        <div class="detail-group">
            <label>Jenis Pengajuan:</label>
            <p>{{ strtoupper($pengajuan->jenis_pengajuan) }}</p>
        </div>

        @if ($pengajuan->judul_pengajuan)
            <div class="detail-group">
                <label>Judul Pengajuan:</label>
                <p>{{ $pengajuan->judul_pengajuan }}</p>
            </div>
        @endif

        <div class="detail-group">
            <label>Status Pengajuan:</label>
            <p>{{ str_replace('_', ' ', $pengajuan->status) }}</p>
        </div>

        @if ($pengajuan->catatan_admin)
            <div class="detail-group">
                <label>Catatan Admin:</label>
                <p>{{ $pengajuan->catatan_admin }}</p>
            </div>
        @endif

        @if ($pengajuan->catatan_kaprodi)
            <div class="detail-group">
                <label>Catatan Kaprodi:</label>
                <p>{{ $pengajuan->catatan_kaprodi }}</p>
            </div>
        @endif

        <h3>Informasi Sidang:</h3>
        @if ($pengajuan->sidang)
            <div class="detail-group">
                <label>Tanggal & Waktu Sidang:</label>
                <p>{{ $pengajuan->sidang->tanggal_waktu_sidang ? \Carbon\Carbon::parse($pengajuan->sidang->tanggal_waktu_sidang)->format('d F Y H:i') : 'Belum Dijadwalkan' }}</p>
            </div>
            <div class="detail-group">
                <label>Ruangan Sidang:</label>
                <p>{{ $pengajuan->sidang->ruangan_sidang ?? 'Belum Ditentukan' }}</p>
            </div>

            <div class="detail-group">
                <label>Ketua Sidang:</label>
                <p>{{ $pengajuan->sidang->ketuaSidang->nama ?? 'Belum Terpilih' }}</p>
            </div>
            <div class="detail-group">
                <label>Sekretaris Sidang:</label>
                <p>{{ $pengajuan->sidang->sekretarisSidang->nama ?? 'Belum Terpilih' }}</p>
            </div>
            <div class="detail-group">
                <label>Anggota Sidang 1:</label>
                <p>{{ $pengajuan->sidang->anggota1Sidang->nama ?? 'Belum Terpilih' }}</p>
            </div>
            <div class="detail-group">
                <label>Anggota Sidang 2:</label>
                <p>{{ $pengajuan->sidang->anggota2Sidang->nama ?? 'Belum Terpilih' }}</p>
            </div>
            @else
            <p>Informasi sidang belum tersedia.</p>
        @endif

        <a href="{{ route('dosen.pengajuan.saya') }}" class="btn btn-info">Kembali ke Daftar Pengajuan Saya</a>
    </div>
</body>
</html>

