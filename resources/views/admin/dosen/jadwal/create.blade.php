<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Jadwal Sidang</title>
</head>

<body>

    <h2>Buat Jadwal Sidang</h2>

    <p>Mahasiswa: {{ $pengajuan->mahasiswa->nama_lengkap }} ({{ $pengajuan->mahasiswa->nim }})</p>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('dosen.jadwal.store', $pengajuan->id) }}">
        @csrf

        <div>
            <label for="tanggal_sidang">Tanggal Sidang</label>
            <input type="date" name="tanggal_sidang" id="tanggal_sidang" value="{{ old('tanggal_sidang') }}" required>
        </div>

        <div>
            <label for="waktu_sidang">Waktu Sidang</label>
            <input type="time" name="waktu_sidang" id="waktu_sidang" value="{{ old('waktu_sidang') }}" required>
        </div>

        <div>
            <label for="tempat_sidang">Tempat Sidang</label>
            <input type="text" name="tempat_sidang" id="tempat_sidang" value="{{ old('tempat_sidang') }}" required>
        </div>

        <button type="submit">Simpan Jadwal</button>
    </form>

</body>

</html>