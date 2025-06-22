<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengajuan Menunggu Pengesahan (Kajur)</title>
    </head>
<body>
    <div class="container">
        <h2>Daftar Pengajuan Menunggu Pengesahan Kajur</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jenis Pengajuan</th>
                    <th>Tanggal Sidang</th>
                    <th>Ruangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengajuans as $pengajuan)
                <tr>
                    <td>{{ $pengajuan->mahasiswa->nim }}</td>
                    <td>{{ $pengajuan->mahasiswa->nama_lengkap }}</td>
                    <td>{{ strtoupper($pengajuan->jenis_pengajuan) }}</td>
                    <td>{{ $pengajuan->sidang->tanggal_waktu_sidang ? \Carbon\Carbon::parse($pengajuan->sidang->tanggal_waktu_sidang)->translatedFormat('d F Y H:i') : '-' }}</td>
                    <td>{{ $pengajuan->sidang->ruangan_sidang ?? '-' }}</td>
                    <td>
                        @if ($pengajuan->status == 'siap_sidang_kajur')
                            <span class="status-warning">Menunggu Pengesahan Kajur</span>
                        @else
                            {{ $pengajuan->status }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('kajur.pengajuan.show', $pengajuan->id) }}">Lihat Detail & Sahkan</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">Tidak ada pengajuan yang menunggu pengesahan Kajur.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $pengajuans->links() }}
    </div>
</body>
</html>