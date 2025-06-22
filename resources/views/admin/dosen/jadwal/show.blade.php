<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jadwal Sidang</title>
</head>

<body>

    <h2>Detail Jadwal Sidang</h2>

    <p>Mahasiswa: {{ $sidang->pengajuan->mahasiswa->nama_lengkap }} ({{ $sidang->pengajuan->mahasiswa->nim }})</p>
    <p>Tanggal Sidang: {{ $sidang->tanggal_sidang }}</p>
    <p>Waktu Sidang: {{ $sidang->waktu_sidang }}</p>
    <p>Tempat Sidang: {{ $sidang->tempat_sidang }}</p>

    <a href="{{ route('dosen.pengajuan.show', $sidang->pengajuan_id) }}">Kembali ke Detail Pengajuan</a>

</body>

</html>