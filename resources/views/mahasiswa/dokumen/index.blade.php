<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelengkapan Dokumen</title>
</head>

<body>

    <h2>Kelengkapan Dokumen {{ strtoupper($pengajuan->jenis_pengajuan) }}</h2>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nama Dokumen</th>
                <th>Status</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dokumenSyarat as $dokumen)
                <tr>
                    <td>{{ $dokumen }}</td>
                    <td>
                        @php
                            $dokumenTeruploadIni = $dokumenTerupload->where('nama_file', $dokumen)->first();
                        @endphp

                        @if ($dokumenTeruploadIni)
                            {{ $dokumenTeruploadIni->status }}
                        @else
                            Belum diupload
                        @endif
                    </td>
                    <td>
                        @if ($dokumenTeruploadIni)
                            <a href="{{ asset('storage/' . $dokumenTeruploadIni->path_file) }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($dokumenTeruploadIni)
                            <form method="POST" action="{{ route('mahasiswa.dokumen.update', $dokumenTeruploadIni->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="file" name="file" accept="application/pdf" required>
                                <button type="submit">Update</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('mahasiswa.dokumen.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="pengajuan_id" value="{{ $pengajuan->id }}">
                                <input type="hidden" name="nama_file" value="{{ $dokumen }}">
                                <input type="file" name="file" accept="application/pdf" required>
                                <button type="submit">Upload</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('mahasiswa.pengajuan.show', $pengajuan->id) }}">Kembali</a>

</body>

</html>