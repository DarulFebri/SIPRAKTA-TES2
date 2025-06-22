<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPRAKTA - Daftar Pengajuan Sidang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #007bff;
            --dark-blue: #0056b3;
            --light-blue-bg: #e6f2ff;
            --white: #ffffff;
            --light-grey: #f8f9fa;
            --medium-grey: #dee2e6;
            --dark-grey: #495057;
            --text-color: #343a40;
            --border-color: #ced4da;
            --success-color: #28a745;
            --error-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --shadow-light: 0 2px 8px rgba(0,0,0,0.05);
            --shadow-medium: 0 4px 15px rgba(0,0,0,0.1);
            --border-radius: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-grey);
            color: var(--text-color);
            line-height: 1.6;
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            max-width: 1100px;
            width: 100%;
            background-color: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-medium);
            padding: 30px;
        }

        h2 {
            color: var(--primary-blue);
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-blue-bg);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: var(--border-radius);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
            border: 1px solid var(--success-color);
        }

        .alert-error {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--error-color);
            border: 1px solid var(--error-color);
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: var(--dark-grey);
            background-color: var(--light-blue-bg);
            border-radius: var(--border-radius);
            margin-top: 30px;
            box-shadow: var(--shadow-light);
        }

        .empty-state i {
            font-size: 60px;
            color: var(--primary-blue);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: var(--dark-blue);
            font-weight: 600;
        }

        .empty-state p {
            font-size: 16px;
            color: var(--dark-grey);
        }

        table {
            width: 100%;
            border-collapse: separate; /* Use separate to allow border-radius on cells */
            border-spacing: 0;
            margin-bottom: 30px;
            background-color: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden; /* Ensures border-radius is applied to the table */
            box-shadow: var(--shadow-light);
        }

        th, td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid var(--medium-grey);
            font-size: 15px;
        }

        th {
            background-color: var(--primary-blue);
            color: var(--white);
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Round first/last cells for aesthetic */
        th:first-child { border-top-left-radius: var(--border-radius); }
        th:last-child { border-top-right-radius: var(--border-radius); }

        tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background-color: var(--light-blue-bg);
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-draft { background-color: #f0f0f0; color: #666; border: 1px solid #ccc; }
        .status-ditolak, .status-ditolak_admin, .status-ditolak_kaprodi { background-color: #ffe0e0; color: var(--error-color); border: 1px solid var(--error-color); }
        .status-diproses { background-color: #fff9e6; color: var(--warning-color); border: 1px solid var(--warning-color); }
        .status-diterima, .status-sidang_dijadwalkan_final { background-color: #e6ffe6; color: var(--success-color); border: 1px solid var(--success-color); }
        .status-dosen_ditunjuk { background-color: #e0f2f7; color: var(--info-color); border: 1px solid var(--info-color); }
        .status-diajukan { background-color: #e0f7fa; color: #007bff; border: 1px solid #007bff;} /* New status for submitted */


        .action-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap; /* Allow wrapping on smaller screens */
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9em;
            font-weight: 500;
            transition: all 0.3s ease;
            white-space: nowrap; /* Prevent text from wrapping */
        }

        .action-btn i {
            margin-right: 5px;
        }

        .btn-view {
            background-color: var(--light-blue-bg);
            color: var(--primary-blue);
            border: 1px solid var(--primary-blue);
        }
        .btn-view:hover {
            background-color: var(--primary-blue);
            color: var(--white);
            transform: translateY(-2px);
        }

        .btn-edit {
            background-color: var(--warning-color);
            color: var(--white);
            border: 1px solid var(--warning-color);
        }
        .btn-edit:hover {
            background-color: #e0a800;
            transform: translateY(-2px);
        }

        .btn-delete {
            background-color: var(--error-color);
            color: var(--white);
            border: 1px solid var(--error-color);
            cursor: pointer;
        }
        .btn-delete:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        .btn-submit {
            background-color: var(--primary-blue);
            color: var(--white);
            border: 1px solid var(--primary-blue);
        }
        .btn-submit:hover {
            background-color: var(--dark-blue);
            transform: translateY(-2px);
        }
        
        .info-text {
            color: var(--info-color);
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .footer-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--medium-grey);
        }

        .footer-actions .action-btn {
            margin-right: 0; /* Remove extra margin */
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
            .container {
                padding: 20px;
            }
            h2 {
                font-size: 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            h2 i {
                font-size: 25px;
            }
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr {
                border: 1px solid var(--medium-grey);
                margin-bottom: 15px;
                border-radius: var(--border-radius);
                overflow: hidden;
            }
            td {
                border: none;
                position: relative;
                padding-left: 50%;
                text-align: right;
                word-wrap: break-word;
            }
            td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: 600;
                color: var(--dark-blue);
            }
            td:last-child {
                border-bottom: none;
            }
            .action-group {
                justify-content: flex-end;
            }
            .footer-actions {
                flex-direction: column;
                gap: 15px;
            }
            .footer-actions .action-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-list-alt"></i> Daftar Pengajuan Sidang Saya</h2>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if ($pengajuans->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jenis Pengajuan</th>
                        <th>Status</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengajuans as $pengajuan)
                        <tr>
                            <td data-label="ID">#{{ $pengajuan->id }}</td>
                            <td data-label="Jenis Pengajuan">{{ ucfirst($pengajuan->jenis_pengajuan) }}</td>
                            <td data-label="Status">
                                @php
                                    $statusClass = '';
                                    if ($pengajuan->status === 'draft') {
                                        $statusClass = 'status-draft';
                                    } elseif (str_contains($pengajuan->status, 'ditolak')) {
                                        $statusClass = 'status-ditolak';
                                    } elseif ($pengajuan->status === 'diproses') {
                                        $statusClass = 'status-diproses';
                                    } elseif ($pengajuan->status === 'diterima') {
                                        $statusClass = 'status-diterima';
                                    } elseif ($pengajuan->status === 'dosen_ditunjuk') {
                                        $statusClass = 'status-dosen_ditunjuk';
                                    } elseif ($pengajuan->status === 'diajukan') { // Added for explicit 'diajukan' status
                                        $statusClass = 'status-diajukan';
                                    }
                                @endphp
                                <span class="status {{ $statusClass }}">
                                    {{ str_replace('_', ' ', ucfirst($pengajuan->status)) }}
                                </span>
                            </td>
                            <td data-label="Tanggal Pengajuan">{{ $pengajuan->created_at->format('d M Y H:i') }}</td>
                            <td data-label="Aksi">
                                <div class="action-group">
                                    <a href="{{ route('mahasiswa.pengajuan.show', $pengajuan->id) }}" class="action-btn btn-view">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>

                                    @if ($pengajuan->status === 'draft')
                                        <a href="{{ route('mahasiswa.pengajuan.edit', $pengajuan->id) }}" class="action-btn btn-edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('mahasiswa.pengajuan.destroy', $pengajuan->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')" class="action-btn btn-delete">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @elseif ($pengajuan->status === 'dosen_ditunjuk')
                                        <span class="info-text">
                                            <i class="fas fa-user-tie"></i> Dosen Ditunjuk
                                        </span>
                                    @elseif ($pengajuan->status === 'ditolak_admin' || $pengajuan->status === 'ditolak_kaprodi')
                                        <a href="{{ route('mahasiswa.pengajuan.edit', $pengajuan->id) }}" class="action-btn btn-edit">
                                            <i class="fas fa-redo"></i> Ajukan Ulang
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-file-alt"></i>
                <h3>Anda belum memiliki pengajuan</h3>
                <p>Silakan buat pengajuan baru untuk memulai proses.</p>
            </div>
        @endif

        <div class="footer-actions">
            <a href="{{ route('mahasiswa.dashboard') }}" class="action-btn btn-view">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            
            {{-- Check if there are no applications or if an option to create new is always desired --}}
            <a href="{{ route('mahasiswa.pengajuan.pilih') }}" class="action-btn btn-submit">
                <i class="fas fa-plus"></i> Buat Pengajuan Baru
            </a>
        </div>
    </div>
</body>
</html>