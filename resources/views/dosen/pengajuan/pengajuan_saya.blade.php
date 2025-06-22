<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Saya - Dosen</title>
    <style>
        body { font-family: sans-serif; margin: 20px; background-color: #f4f7f6; }
        .container {
            max-width: 1400px; /* Lebarkan container untuk menampung lebih banyak kolom */
            width: 95%; /* Pastikan responsifitas untuk layar lebih kecil */
            margin: 30px auto;
            padding: 25px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            background-color: #fff;
        }
        h2 { text-align: center; margin-bottom: 25px; color: #333; }
        .back-link { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #007bff; font-weight: bold; }
        .back-link:hover { text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td {
            border: 1px solid #e9e9e9;
            padding: 12px 15px;
            text-align: left;
            font-size: 0.95em;
            /* white-space: nowrap; */ /* Dihapus untuk memungkinkan teks wrap jika dibutuhkan */
        }
        th { background-color: #f8f8f8; color: #555; text-transform: uppercase; }
        tr:nth-child(even) { background-color: #fcfcfc; }
        tr:hover { background-color: #f1f1f1; }
        .btn { padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; color: white; display: inline-block; font-size: 0.9em; margin-top: 5px; transition: background-color 0.3s ease; }
        .btn-info { background-color: #17a2b8; }
        .btn-info:hover { background-color: #138496; }
        .btn-warning { background-color: #ffc107; color: #333; }
        .btn-warning:hover { background-color: #e0a800; }
        .alert { padding: 12px; margin-bottom: 20px; border-radius: 5px; font-size: 0.95em; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .no-data { text-align: center; color: #777; padding: 30px; font-size: 1.1em; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Pengajuan yang Melibatkan Anda</h2>
        <a href="{{ route('dosen.dashboard') }}" class="back-link">&larr; Kembali ke Dashboard</a>

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

        @if ($pengajuansInvolved->isEmpty())
            <p class="no-data">Tidak ada pengajuan yang melibatkan Anda saat ini.</p>
        @else
            {{-- Wrapper table-responsive dihapus --}}
            <table>
                <thead>
                    <tr>
                        <th>ID Pengajuan</th>
                        <th>Mahasiswa</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Peran Anda</th>
                        {{-- Kolom Pembimbing, Penguji 1, Penguji 2 dihapus --}}
                        <th>Ketua Sidang</th>
                        <th>Sekretaris</th>
                        <th>Anggota 1</th>
                        <th>Anggota 2</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengajuansInvolved as $pengajuan)
                        <tr>
                            <td>{{ $pengajuan->id }}</td>
                            <td>{{ $pengajuan->mahasiswa->nama_lengkap }} ({{ $pengajuan->mahasiswa->nim }})</td>
                            <td>{{ strtoupper($pengajuan->jenis_pengajuan) }}</td>
                            <td>{{ str_replace('_', ' ', $pengajuan->status) }}</td>
                            <td>
                                @php
                                    $dosenId = Auth::user()->dosen->id;
                                    $roles = [];
                                    if ($pengajuan->sidang) {
                                        if ($pengajuan->sidang->dosen_pembimbing_id == $dosenId) $roles[] = 'Pembimbing';
                                        if ($pengajuan->sidang->dosen_penguji1_id == $dosenId) $roles[] = 'Penguji 1';
                                        if ($pengajuan->sidang->dosen_penguji2_id == $dosenId) $roles[] = 'Penguji 2';
                                        if ($pengajuan->sidang->ketua_sidang_dosen_id == $dosenId) $roles[] = 'Ketua Sidang';
                                        if ($pengajuan->sidang->sekretaris_sidang_dosen_id == $dosenId) $roles[] = 'Sekretaris Sidang';
                                        if ($pengajuan->sidang->anggota1_sidang_dosen_id == $dosenId) $roles[] = 'Anggota Sidang 1';
                                        if ($pengajuan->sidang->anggota2_sidang_dosen_id == $dosenId) $roles[] = 'Anggota Sidang 2';
                                    }
                                @endphp
                                {{ empty($roles) ? 'N/A' : implode(', ', $roles) }}
                            </td>
                            {{-- Data cell untuk Pembimbing, Penguji 1, Penguji 2 dihapus --}}
                            <td>{{ $pengajuan->sidang->ketuaSidang->nama ?? 'N/A' }}</td>
                            <td>{{ $pengajuan->sidang->sekretarisSidang->nama ?? 'N/A' }}</td>
                            <td>{{ $pengajuan->sidang->anggota1Sidang->nama ?? 'N/A' }}</td>
                            <td>{{ $pengajuan->sidang->anggota2Sidang->nama ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('dosen.pengajuan.show', $pengajuan->id) }}" class="btn btn-info">Detail</a>
                                {{-- Contoh Aksi Spesifik berdasarkan status dan peran --}}
                                @if ($pengajuan->status === 'dosen_ditunjuk' && $pengajuan->sidang)
                                    @if (in_array($dosenId, [$pengajuan->sidang->dosen_pembimbing_id, $pengajuan->sidang->dosen_penguji1_id, $pengajuan->sidang->dosen_penguji2_id]))
                                        {{-- Link ke form nilai jika dosen ini adalah pembimbing/penguji --}}
                                        <a href="{{ route('dosen.sidang.nilai.edit', $pengajuan->sidang->id) }}" class="btn btn-warning">Beri Nilai</a>
                                    @endif
                                    @if ($pengajuan->sidang->ketua_sidang_dosen_id == $dosenId && is_null($pengajuan->sidang->tanggal_waktu_sidang))
                                        {{-- Link ke form jadwal jika dosen ini ketua sidang dan jadwal belum ada --}}
                                        <a href="{{ route('dosen.jadwal.create', $pengajuan->id) }}" class="btn btn-info" style="background-color: #6c757d;">Jadwalkan</a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>