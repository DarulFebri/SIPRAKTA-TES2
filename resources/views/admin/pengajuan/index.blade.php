<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengajuan Mahasiswa (Admin)</title>
    <style>
        /* General Body Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f7f6;
            color: #333;
        }

        /* Container Styling */
        .container {
            max-width: 1000px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* Heading Styles */
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 2em;
            position: relative;
            padding-bottom: 10px;
        }

        h2::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: #3498db;
            border-radius: 2px;
        }

        /* Alert Messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden; /* Ensures rounded corners on table */
        }

        table thead {
            background-color: #3498db;
            color: #fff;
        }

        table th,
        table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        table tbody tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        table tbody tr:hover {
            background-color: #eef;
            transition: background-color 0.2s ease;
        }

        /* Status Badges */
        .status-pending,
        .status-success,
        .status-danger {
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: bold;
            color: #fff;
        }

        .status-pending {
            background-color: #f39c12; /* Orange */
        }

        .status-success {
            background-color: #28a745; /* Green */
        }

        .status-danger {
            background-color: #dc3545; /* Red */
        }

        /* Action Link */
        table td a {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        table td a:hover {
            color: #2980b9;
            text-decoration: underline;
        }

        /* Empty State Message */
        table td[colspan="6"] {
            text-align: center;
            font-style: italic;
            color: #777;
            padding: 20px;
        }

        /* Pagination */
        .pagination {
            margin-top: 30px;
            text-align: center;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 8px 12px;
            margin: 0 4px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #3498db;
            transition: all 0.2s ease;
        }

        .pagination a:hover {
            background-color: #3498db;
            color: #fff;
            border-color: #3498db;
        }

        .pagination .active span {
            background-color: #3498db;
            color: #fff;
            border-color: #3498db;
            font-weight: bold;
        }

        /* Back to Dashboard Link */
        .back-to-dashboard {
            text-align: center;
            margin-top: 30px;
        }

        .back-to-dashboard a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.2s ease;
            font-weight: 500;
        }

        .back-to-dashboard a:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Pengajuan Mahasiswa</h2>

        @if (session('success'))
            <div class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jenis Pengajuan</th>
                    <th>Status</th>
                    <th>Tanggal Diajukan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengajuans as $pengajuan)
                <tr>
                    <td>{{ $pengajuan->mahasiswa->nim }}</td>
                    <td>{{ $pengajuan->mahasiswa->nama_lengkap }}</td>
                    <td>{{ strtoupper(str_replace('_', ' ', $pengajuan->jenis_pengajuan)) }}</td> {{-- Improved formatting for jenis_pengajuan --}}
                    <td>
                        @if ($pengajuan->status == 'diajukan_mahasiswa')
                            <span class="status-pending">Menunggu Verifikasi Admin</span>
                        @elseif ($pengajuan->status == 'diverifikasi_admin')
                            <span class="status-success">Diverifikasi Admin</span>
                        @elseif ($pengajuan->status == 'ditolak_admin')
                            <span class="status-danger">Ditolak Admin</span>
                        @else
                            <span class="status-unknown">{{ ucfirst(str_replace('_', ' ', $pengajuan->status)) }}</span> {{-- Handle other statuses gracefully --}}
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($pengajuan->created_at)->translatedFormat('d F Y') }}</td>
                    <td>
                        <a href="{{ route('admin.pengajuan.verifikasi.show', $pengajuan->id) }}">Lihat Detail & Verifikasi</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">Tidak ada pengajuan yang perlu diverifikasi saat ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $pengajuans->links() }}
        </div>
    </div>
    <div class="back-to-dashboard">
        <a href="{{ route('admin.dashboard') }}">Kembali Ke Dashboard</a>
    </div>
</body>
</html>