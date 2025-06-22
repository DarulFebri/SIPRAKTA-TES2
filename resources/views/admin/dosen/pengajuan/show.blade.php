<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan Sidang</title>
</head>

<body>

    <h2>Detail Pengajuan Sidang</h2>

    <p>Mahasiswa: {{ $pengajuan->mahasiswa->nama_lengkap }} ({{ $pengajuan->mahasiswa->nim }})</p>
    <p>Jenis Pengajuan: {{ $pengajuan->jenis_pengajuan }}</p>
    <p>Status: {{ $pengajuan->status }}</p>

    <h3>Dokumen Pengajuan</h3>
    @if (count($dokumens) > 0)
        <ul>
            @foreach ($dokumens as $dokumen)
                <li>
                    <a href="{{ asset('storage/' . $dokumen->path_file) }}" target="_blank">{{ $dokumen->nama_file }}</a>
                    - Status: {{ $dokumen->status }}
                    @if ($dokumen->status == 'diajukan')
                        <form action="{{ route('dosen.dokumen.setujui', $dokumen->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menyetujui dokumen ini?')">Setujui</button>
                        </form>
                        <form action="{{ route('dosen.dokumen.tolak', $dokumen->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menolak dokumen ini?')">Tolak</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>Tidak ada dokumen yang diupload.</p>
    @endif

    <a href="{{ route('dosen.pengajuan.index') }}">Kembali ke Daftar Pengajuan</a>

</body>

</html>