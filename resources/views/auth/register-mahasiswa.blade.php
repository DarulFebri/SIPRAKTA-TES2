<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Mahasiswa</title>
</head>
<body>

    <h2>Registrasi Mahasiswa</h2>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.mahasiswa') }}">
        @csrf

        <div>
            <label for="nim">NIM</label>
            <input type="text" name="nim" id="nim" value="{{ old('nim') }}" required>
        </div>

        <div>
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
        </div>

        <div>
            <label for="jurusan">Jurusan</label>
            <input type="text" name="jurusan" id="jurusan" value="{{ old('jurusan') }}" required>
        </div>

        <div>
            <label for="prodi">Program Studi</label>
            <input type="text" name="prodi" id="prodi" value="{{ old('prodi') }}" required>
        </div>

        <div>
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" required>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>

        <div>
            <label for="kelas">Kelas</label>
            <input type="text" name="kelas" id="kelas" value="{{ old('kelas') }}" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div>
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <button type="submit">Daftar</button>
    </form>

</body>
</html>