<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Dosen</title>
</head>

<body>

    <h2>Daftar Dosen</h2>

    <table>
        <thead>
            <tr>
                <th>Nama Dosen</th>
                <th>NIP</th>
                <th>Jurusan</th>
                <th>Program Studi</th>
                </tr>
        </thead>
        <tbody>
            @foreach ($dosens as $dosen)
                <tr>
                    <td>{{ $dosen->nama }}</td>
                    <td>{{ $dosen->nip }}</td>
                    <td>{{ $dosen->jurusan }}</td>
                    <td>{{ $dosen->prodi }}</td>
                    </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>