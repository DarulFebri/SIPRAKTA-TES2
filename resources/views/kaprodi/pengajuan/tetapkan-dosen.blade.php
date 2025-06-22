<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetapkan Dosen</title>
</head>

<body>

    <h2>Tetapkan Dosen</h2>

    <p>Mahasiswa: {{ $pengajuan->mahasiswa->nama_lengkap }}</p>
    <p>Judul: {{ $pengajuan->judul }}</p>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('kaprodi.pengajuan.tetapkan-dosen.store', $pengajuan->id) }}">
        @csrf

        <div>
            <label for="pembimbing_id">Dosen Pembimbing</label>
            <select name="pembimbing_id" id="pembimbing_id" required>
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="penguji_1_id">Dosen Penguji 1</label>
            <select name="penguji_1_id" id="penguji_1_id" required>
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="penguji_2_id">Dosen Penguji 2</label>
            <select name="penguji_2_id" id="penguji_2_id" required>
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit">Simpan</button>
    </form>

</body>

</html>