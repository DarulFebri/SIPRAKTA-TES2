<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengajuan Sidang</title>
</head>

<body>

    <h2>Daftar Pengajuan Sidang</h2>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Mahasiswa</th>
                <th>Jenis Pengajuan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengajuans as $pengajuan)
                <tr>
                    <td>{{ $pengajuan->mahasiswa->nama_lengkap }} ({{ $pengajuan->mahasiswa->nim }})</td>
                    <td>{{ $pengajuan->jenis_pengajuan }}</td>
                    <td>{{ $pengajuan->status }}</td>
                    <td>
                        <a href="{{ route('dosen.pengajuan.show', $pengajuan->id) }}">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>