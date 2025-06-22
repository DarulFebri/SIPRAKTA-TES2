<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Persidangan</title>
</head>

<body>

    <h2>Daftar Persidangan</h2>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.sidang.kalender') }}">Lihat Kalender Sidang</a>

    <table>
        <thead>
            <tr>
                <th>Mahasiswa</th>
                <th>Tanggal Sidang</th>
                <th>Waktu Sidang</th> <th>Tempat Sidang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sidangs as $sidang)
                <tr>
                    <td>{{ $sidang->pengajuan->mahasiswa->nama_lengkap }} ({{ $sidang->pengajuan->mahasiswa->nim }})</td>
                    {{-- Menggunakan properti dari model Sidang yang benar --}}
                    <td>{{ $sidang->tanggal_waktu_sidang ? \Carbon\Carbon::parse($sidang->tanggal_waktu_sidang)->format('d F Y') : 'Belum Dijadwalkan' }}</td>
                    <td>{{ $sidang->tanggal_waktu_sidang ? \Carbon\Carbon::parse($sidang->tanggal_waktu_sidang)->format('H:i') . ' WIB' : 'Belum Dijadwalkan' }}</td>
                    <td>{{ $sidang->ruangan_sidang ? $sidang->ruangan_sidang : 'Belum Ditentukan' }}</td>
                    <td>
                        <a href="{{ route('admin.sidang.show', $sidang->id) }}">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>