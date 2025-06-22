<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Persidangan</title>
</head>

<body>

    <h2>Detail Persidangan</h2>

    <p>Mahasiswa: {{ $sidang->pengajuan->mahasiswa->nama_lengkap }} ({{ $sidang->pengajuan->mahasiswa->nim }})</p>
    <p>Jenis Pengajuan: {{ $sidang->pengajuan->jenis_pengajuan }}</p>

    <p>Tanggal Sidang:
        @if ($sidang->tanggal_waktu_sidang)
            <strong>{{ \Carbon\Carbon::parse($sidang->tanggal_waktu_sidang)->format('d F Y') }}</strong>
        @else
            Belum Dijadwalkan
        @endif
    </p>
    <p>Waktu Sidang:
        @if ($sidang->tanggal_waktu_sidang)
            <strong>{{ \Carbon\Carbon::parse($sidang->tanggal_waktu_sidang)->format('H:i') }} WIB</strong>
        @else
            Belum Dijadwalkan
        @endif
    </p>
    <p>Tempat Sidang:
        @if ($sidang->ruangan_sidang)
            <strong>{{ $sidang->ruangan_sidang }}</strong>
        @else
            Belum Ditentukan
        @endif
    </p>

    ---

    <h3>Informasi Anggota Sidang</h3>
    {{-- Memastikan relasi anggota sidang sudah dimuat di controller --}}
    <p><strong>Ketua Sidang:</strong> {{ $sidang->ketuaSidang->nama ?? 'Belum Ditunjuk' }}</p>
    <p><strong>Sekretaris Sidang:</strong> {{ $sidang->sekretarisSidang->nama ?? 'Belum Ditunjuk' }}</p>
    <p><strong>Anggota Sidang 1:</strong> {{ $sidang->anggota1Sidang->nama ?? 'Belum Ditunjuk' }}</p>
    <p><strong>Anggota Sidang 2:</strong> {{ $sidang->anggota2Sidang->nama ?? 'Belum Ditunjuk' }}</p>

    <a href="{{ route('admin.sidang.index') }}">Kembali ke Daftar Persidangan</a>

</body>

</html>