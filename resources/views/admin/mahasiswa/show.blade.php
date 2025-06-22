<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mahasiswa</title>
</head>
<body>

    <h2>Detail Mahasiswa</h2>

    <p>NIM: {{ $mahasiswa->nim }}</p>
    <p>Nama Lengkap: {{ $mahasiswa->nama_lengkap }}</p>
    <p>Jurusan: {{ $mahasiswa->jurusan }}</p>
    <p>Prodi: {{ $mahasiswa->prodi }}</p>
    <p>Jenis Kelamin: {{ $mahasiswa->jenis_kelamin }}</p>
    <p>Kelas: {{ $mahasiswa->kelas }}</p>

    <a href="{{ route('admin.mahasiswa.index') }}">Kembali ke Daftar Mahasiswa</a>

</body>

</html>