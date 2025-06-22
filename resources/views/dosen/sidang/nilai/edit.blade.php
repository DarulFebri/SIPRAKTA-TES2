<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai Sidang</title>
</head>

<body>

    <h2>Input Nilai Sidang</h2>

    <p>Mahasiswa: {{ $sidang->pengajuan->mahasiswa->nama_lengkap }} ({{ $sidang->pengajuan->mahasiswa->nim }})</p>

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

    <form method="POST" action="{{ route('dosen.sidang.nilai.store', $sidang->id) }}">
        @csrf

        <div>
            <label for="nilai_pembimbing">Nilai Pembimbing</label>
            <input type="number" name="nilai_pembimbing" id="nilai_pembimbing" value="{{ old('nilai_pembimbing', $sidang->nilai_pembimbing) }}" required>
        </div>

        <div>
            <label for="nilai_penguji_1">Nilai Penguji 1</label>
            <input type="number" name="nilai_penguji_1" id="nilai_penguji_1" value="{{ old('nilai_penguji_1', $sidang->nilai_penguji_1) }}" required>
        </div>

        <div>
            <label for="nilai_penguji_2">Nilai Penguji 2</label>
            <input type="number" name="nilai_penguji_2" id="nilai_penguji_2" value="{{ old('nilai_penguji_2', $sidang->nilai_penguji_2) }}" required>
        </div>

        <button type="submit">Simpan Nilai</button>
    </form>

    <a href="{{ route('dosen.pengajuan.show', $sidang->pengajuan_id) }}">Kembali ke Detail Pengajuan</a>

</body>

</html>