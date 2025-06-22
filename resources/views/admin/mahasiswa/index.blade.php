<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
</head>
<body>

    <h2>Daftar Mahasiswa</h2>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.mahasiswa.create') }}">Tambah Mahasiswa</a>
    <a href="{{ route('admin.mahasiswa.import.form') }}">Import Mahasiswa</a>
    <a href="{{ route('mahasiswas.export') }}" class="btn btn-success"><i class="fas fa-file-excel"></i> Export Mahasiswa</a> 
    <a href="{{ route('admin.dashboard') }}">Kembali Ke Dashboard</a>
        <table>
        <thead>
            <tr>
                <th>NIM</th> 
                <th>Nama Lengkap</th>
                <th>Jurusan</th>
                <th>Prodi</th>
                <th>Jenis Kelamin</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswas as $mahasiswa)
                <tr>
                    <td>{{ $mahasiswa->nim }}</td>
                    <td>{{ $mahasiswa->nama_lengkap }}</td>
                    <td>{{ $mahasiswa->jurusan }}</td>
                    <td>{{ $mahasiswa->prodi }}</td>
                    <td>{{ $mahasiswa->jenis_kelamin }}</td>
                    <td>{{ $mahasiswa->kelas }}</td>
                    <td>
                        <a href="{{ route('admin.mahasiswa.show', $mahasiswa->id) }}">Detail</a>
                        <a href="{{ route('admin.mahasiswa.edit', $mahasiswa->id) }}">Edit</a>
                        <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>