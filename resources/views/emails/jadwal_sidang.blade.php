<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Sidang Mahasiswa</title>
</head>

<body>

    <h2>Jadwal Sidang Mahasiswa</h2>

    <p>Yth. Bapak/Ibu Dosen,</p>

    <p>
        Dengan hormat, kami memberitahukan bahwa telah dijadwalkan sidang untuk mahasiswa:
        <b>{{ $sidang->pengajuan->mahasiswa->nama_lengkap }} ({{ $sidang->pengajuan->mahasiswa->nim }})</b>
    </p>

    <p>
        <b>Detail Sidang:</b><br>
        Tanggal: {{ $sidang->tanggal_sidang }}<br>
        Waktu: {{ $sidang->waktu_sidang }}<br>
        Tempat: {{ $sidang->tempat_sidang }}
    </p>

    <p>
        Demikian informasi ini kami sampaikan. Terima kasih atas perhatiannya.
    </p>

</body>

</html>