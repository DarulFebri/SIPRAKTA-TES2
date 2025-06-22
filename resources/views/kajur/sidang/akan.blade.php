<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidang Akan Dilaksanakan</title>
</head>

<body>

    <h2>Sidang Akan Dilaksanakan</h2>

    <table>
        <thead>
            <tr>
                <th>Mahasiswa</th>
                <th>Jenis Sidang</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Tempat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sidangs as $sidang)
                <tr>
                    <td>{{ $sidang->pengajuan->mahasiswa->nama_lengkap }}</td>
                    <td>{{ $sidang->pengajuan->jenis_pengajuan }}</td>
                    <td>{{ $sidang->tanggal_sidang }}</td>
                    <td>{{ $sidang->waktu_sidang }}</td>
                    <td>{{ $sidang->tempat_sidang }}</td>
                    <td><a href="{{ route('kajur.sidang.show', $sidang->id) }}">Detail</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>