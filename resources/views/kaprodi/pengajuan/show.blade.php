<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan Sidang - Kaprodi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 900px;
            width: 95%;
            margin: 30px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.08);
        }
        h2 {
            font-size: 2em;
            color: #2c3e50;
            margin-bottom: 25px;
            text-align: center;
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
            height: 3px;
            background-color: #3498db;
            border-radius: 5px;
        }
        h3 {
            font-size: 1.5em;
            color: #34495e;
            margin-bottom: 15px;
            border-bottom: 2px solid #eee;
            padding-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 25px;
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .back-link:hover {
            color: #2980b9;
        }
        .alert {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 8px;
            font-size: 0.98em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success {
            background-color: #e6ffed;
            color: #1a7e3d;
            border: 1px solid #b3e6c3;
        }
        .alert-danger {
            background-color: #ffe6e6;
            color: #c0392b;
            border: 1px solid #e6b3b3;
        }
        .alert-info {
            background-color: #e0f7fa;
            color: #007bb2;
            border: 1px solid #b2ebf2;
        }
        .card-section {
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .card-section p {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }
        .card-section strong {
            color: #555;
            min-width: 150px;
            display: inline-block;
        }
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 700;
            text-transform: capitalize;
            display: inline-block;
            margin-left: 8px; /* Added for spacing */
        }
        .status-badge.menunggu { background-color: #fff3cd; color: #856404; } /* warning */
        .status-badge.setuju { background-color: #d4edda; color: #155724; } /* success */
        .status-badge.tolak { background-color: #f8d7da; color: #721c24; } /* danger */
        .status-badge.default { background-color: #e2e3e5; color: #495057; } /* secondary */

        .info-message {
            background-color: #e0f7fa;
            border-left: 5px solid #00bcd4;
            padding: 15px;
            margin-top: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            color: #007bb2;
            font-style: italic;
            text-align: center;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        .error-message {
            color: #e74c3c;
            font-size: 0.85em;
            margin-top: 5px;
            display: block;
        }
        .buttons {
            display: flex;
            justify-content: flex-start;
            gap: 15px;
            margin-top: 25px;
        }
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary {
            background-color: #3498db;
            color: white;
        }
        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            .card-section {
                padding: 15px;
            }
            .card-section p {
                flex-direction: column;
                align-items: flex-start;
            }
            .card-section strong {
                min-width: unset;
                margin-bottom: 5px;
            }
            .buttons {
                flex-direction: column;
                gap: 10px;
            }
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detail Pengajuan Sidang</h2>
        <a href="{{ route('kaprodi.pengajuan.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Daftar Pengajuan
        </a>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-times-circle"></i>
                {{ session('error') }}
            </div>
        @endif
        @if (session('finalisasi_error'))
            <div class="alert alert-danger" style="margin-top: 15px;">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('finalisasi_error') }}
            </div>
        @endif

        <div class="card-section">
            <h3><i class="fas fa-user-graduate"></i> Detail Mahasiswa & Pengajuan</h3>
            <p><strong>Mahasiswa:</strong> {{ $pengajuan->mahasiswa->nama_lengkap }} ({{ $pengajuan->mahasiswa->nim }})</p>
            <p><strong>Jenis Pengajuan:</strong> {{ strtoupper(str_replace('_', ' ', $pengajuan->jenis_pengajuan)) }}</p>
            <p>
                <strong>Status Pengajuan:</strong>
                <span class="status-badge {{
                    $pengajuan->status == 'diajukan_mahasiswa' ? 'menunggu' :
                    ($pengajuan->status == 'diverifikasi_admin' ? 'menunggu' :
                    ($pengajuan->status == 'menunggu_persetujuan_dosen' ? 'menunggu' :
                    ($pengajuan->status == 'disetujui_kaprodi' ? 'setuju' :
                    ($pengajuan->status == 'sidang_selesai' ? 'setuju' :
                    ($pengajuan->status == 'ditolak_admin' || $pengajuan->status == 'ditolak_kaprodi' ? 'tolak' : 'default')))))
                }}">
                    {{ ucfirst(str_replace('_', ' ', $pengajuan->status)) }}
                </span>
            </p>
            <p><strong>Tanggal Diajukan:</strong> {{ \Carbon\Carbon::parse($pengajuan->created_at)->translatedFormat('d F Y H:i') }}</p>
        </div>

        <div class="card-section">
            <h3><i class="fas fa-calendar-alt"></i> Informasi Sidang</h3>
            @if ($pengajuan->sidang)
                <p>
                    <strong>Dosen Pembimbing:</strong>
                    {{ $pengajuan->sidang->dosenPembimbing->nama ?? 'Belum Terpilih' }}
                    @if ($pengajuan->sidang->dosenPembimbing)
                        (<span class="status-badge {{
                            $pengajuan->sidang->persetujuan_dosen_pembimbing == 'setuju' ? 'setuju' :
                            ($pengajuan->sidang->persetujuan_dosen_pembimbing == 'tolak' ? 'tolak' : 'menunggu')
                        }}">
                            {{ ucfirst(str_replace('_', ' ', $pengajuan->sidang->persetujuan_dosen_pembimbing)) }}
                        </span>)
                    @endif
                </p>
                <p>
                    <strong>Dosen Penguji 1:</strong>
                    {{ $pengajuan->sidang->dosenPenguji1->nama ?? 'Belum Terpilih' }}
                    @if ($pengajuan->sidang->dosenPenguji1)
                        (<span class="status-badge {{
                            $pengajuan->sidang->persetujuan_dosen_penguji1 == 'setuju' ? 'setuju' :
                            ($pengajuan->sidang->persetujuan_dosen_penguji1 == 'tolak' ? 'tolak' : 'menunggu')
                        }}">
                            {{ ucfirst(str_replace('_', ' ', $pengajuan->sidang->persetujuan_dosen_penguji1)) }}
                        </span>)
                    @endif
                </p>

                <p><strong>Tanggal & Waktu Sidang:</strong> {{ $pengajuan->sidang->tanggal_waktu_sidang ? \Carbon\Carbon::parse($pengajuan->sidang->tanggal_waktu_sidang)->translatedFormat('d F Y H:i') : 'Belum Dijadwalkan' }}</p>
                <p><strong>Ruangan Sidang:</strong> {{ $pengajuan->sidang->ruangan_sidang ?? 'Belum Ditentukan' }}</p>
                <p>
                    <strong>Ketua Sidang:</strong>
                    {{ $pengajuan->sidang->ketuaSidang->nama ?? 'Belum Terpilih' }}
                    @if ($pengajuan->sidang->ketuaSidang)
                        (<span class="status-badge {{
                            $pengajuan->sidang->persetujuan_ketua_sidang == 'setuju' ? 'setuju' :
                            ($pengajuan->sidang->persetujuan_ketua_sidang == 'tolak' ? 'tolak' : 'menunggu')
                        }}">
                            {{ ucfirst(str_replace('_', ' ', $pengajuan->sidang->persetujuan_ketua_sidang)) }}
                        </span>)
                    @endif
                </p>
                <p>
                    <strong>Sekretaris Sidang:</strong>
                    {{ $pengajuan->sidang->sekretarisSidang->nama ?? 'Belum Terpilih' }}
                    @if ($pengajuan->sidang->sekretarisSidang)
                        (<span class="status-badge {{
                            $pengajuan->sidang->persetujuan_sekretaris_sidang == 'setuju' ? 'setuju' :
                            ($pengajuan->sidang->persetujuan_sekretaris_sidang == 'tolak' ? 'tolak' : 'menunggu')
                        }}">
                            {{ ucfirst(str_replace('_', ' ', $pengajuan->sidang->persetujuan_sekretaris_sidang)) }}
                        </span>)
                    @endif
                </p>
                <p>
                    <strong>Anggota Sidang 1:</strong>
                    {{ $pengajuan->sidang->anggota1Sidang->nama ?? 'Belum Terpilih' }}
                    @if ($pengajuan->sidang->anggota1Sidang)
                        (<span class="status-badge {{
                            $pengajuan->sidang->persetujuan_anggota1_sidang == 'setuju' ? 'setuju' :
                            ($pengajuan->sidang->persetujuan_anggota1_sidang == 'tolak' ? 'tolak' : 'menunggu')
                        }}">
                            {{ ucfirst(str_replace('_', ' ', $pengajuan->sidang->persetujuan_anggota1_sidang)) }}
                        </span>)
                    @endif
                </p>
                <p>
                    <strong>Anggota Sidang 2:</strong>
                    {{ $pengajuan->sidang->anggota2Sidang->nama ?? 'Belum Terpilih' }}
                    @if ($pengajuan->sidang->anggota2Sidang)
                        (<span class="status-badge {{
                            $pengajuan->sidang->persetujuan_anggota2_sidang == 'setuju' ? 'setuju' :
                            ($pengajuan->sidang->persetujuan_anggota2_sidang == 'tolak' ? 'tolak' : 'menunggu')
                        }}">
                            {{ ucfirst(str_replace('_', ' ', $pengajuan->sidang->persetujuan_anggota2_sidang)) }}
                        </span>)
                    @endif
                </p>
            @else
                <p class="info-message">Detail sidang belum tersedia untuk pengajuan ini. Kaprodi perlu menjadwalkan dosen dan informasi sidang.</p>
            @endif
        </div>

        <div class="card-section">
            <h3><i class="fas fa-cogs"></i> Aksi Kaprodi</h3>

            @if (in_array($pengajuan->status, ['diverifikasi_admin', 'menunggu_persetujuan_dosen', 'disetujui_kaprodi']))
                <h4>Form Penjadwalan Sidang</h4>
                <form action="{{ route('kaprodi.pengajuan.jadwalkan.storeUpdate', $pengajuan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="ketua_sidang_id">Ketua Sidang:</label>
                        <select name="ketua_sidang_id" id="ketua_sidang_id" class="form-control">
                            <option value="">Pilih Ketua Sidang</option>
                            @php
                                $pembimbing1Setuju = $pengajuan->sidang && $pengajuan->sidang->dosenPembimbing && $pengajuan->sidang->persetujuan_dosen_pembimbing === 'setuju';
                                $pembimbing2Setuju = $pengajuan->sidang && $pengajuan->sidang->dosenPenguji1 && $pengajuan->sidang->persetujuan_dosen_penguji1 === 'setuju';
                            @endphp

                            @if ($pembimbing1Setuju)
                                <option value="{{ $pengajuan->sidang->dosenPembimbing->id }}"
                                    {{ old('ketua_sidang_id', $pengajuan->sidang->ketua_sidang_dosen_id ?? '') == $pengajuan->sidang->dosenPembimbing->id ? 'selected' : '' }}>
                                    {{ $pengajuan->sidang->dosenPembimbing->nama }} (Pembimbing)
                                </option>
                            @endif

                            @if ($pembimbing2Setuju)
                                <option value="{{ $pengajuan->sidang->dosenPenguji1->id }}"
                                    {{ old('ketua_sidang_id', $pengajuan->sidang->ketua_sidang_dosen_id ?? '') == $pengajuan->sidang->dosenPenguji1->id ? 'selected' : '' }}>
                                    {{ $pengajuan->sidang->dosenPenguji1->nama }} (Penguji 1)
                                </option>
                            @endif

                            {{-- Jika tidak ada pembimbing yang disetujui, Kaprodi tidak bisa memilih Ketua Sidang dari daftar pembimbing. --}}
                            {{-- Tetapi Kaprodi bisa tetap menyimpan jadwal tanpa Ketua Sidang. --}}
                            @if (!$pembimbing1Setuju && !$pembimbing2Setuju)
                                <option value="" disabled>Dosen Pembimbing/Penguji belum menyetujui</option>
                            @endif
                        </select>
                        @error('ketua_sidang_id') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="sekretaris_sidang_id">Sekretaris Sidang:</label>
                        <select name="sekretaris_sidang_id" id="sekretaris_sidang_id" class="form-control" required>
                            <option value="">Pilih Sekretaris</option>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}" {{ old('sekretaris_sidang_id', $pengajuan->sidang->sekretaris_sidang_dosen_id ?? '') == $dosen->id ? 'selected' : '' }}>
                                    {{ $dosen->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('sekretaris_sidang_id') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="anggota_1_sidang_id">Anggota 1 Sidang:</label>
                        <select name="anggota_1_sidang_id" id="anggota_1_sidang_id" class="form-control" required>
                            <option value="">Pilih Anggota 1</option>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}" {{ old('anggota_1_sidang_id', $pengajuan->sidang->anggota1_sidang_dosen_id ?? '') == $dosen->id ? 'selected' : '' }}>
                                    {{ $dosen->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('anggota_1_sidang_id') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="anggota_2_sidang_id">Anggota 2 Sidang:</label>
                        <select name="anggota_2_sidang_id" id="anggota_2_sidang_id" class="form-control">
                            <option value="">Pilih Anggota 2 (Opsional)</option>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}" {{ old('anggota_2_sidang_id', $pengajuan->sidang->anggota2_sidang_dosen_id ?? '') == $dosen->id ? 'selected' : '' }}>
                                    {{ $dosen->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('anggota_2_sidang_id') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="tanggal_waktu_sidang">Tanggal dan Waktu Sidang:</label>
                        <input type="datetime-local" name="tanggal_waktu_sidang" id="tanggal_waktu_sidang" class="form-control"
                                     value="{{ old('tanggal_waktu_sidang', $pengajuan->sidang->tanggal_waktu_sidang ? \Carbon\Carbon::parse($pengajuan->sidang->tanggal_waktu_sidang)->format('Y-m-d\TH:i') : '') }}" required>
                        @error('tanggal_waktu_sidang') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="ruangan_sidang">Ruangan Sidang:</label>
                        <input type="text" name="ruangan_sidang" id="ruangan_sidang" class="form-control" placeholder="Contoh: Ruang Sidang A"
                                     value="{{ old('ruangan_sidang', $pengajuan->sidang->ruangan_sidang ?? '') }}" required>
                        @error('ruangan_sidang') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="buttons">
                        @php
                            // Check if essential fields for a basic schedule are filled
                            $isBasicScheduled = $pengajuan->sidang &&
                                $pengajuan->sidang->sekretaris_sidang_dosen_id &&
                                $pengajuan->sidang->anggota1_sidang_dosen_id &&
                                $pengajuan->sidang->tanggal_waktu_sidang &&
                                $pengajuan->sidang->ruangan_sidang;
                        @endphp
                        <button type="submit" class="btn btn-primary">
                            @if ($isBasicScheduled)
                                Update Jadwal
                            @else
                                Jadwalkan Sidang
                            @endif
                        </button>
                    </div>
                </form>

                {{-- Tombol Finalisasi Jadwal --}}
                @if ($pengajuan->sidang && $pengajuan->sidang->exists && $isBasicScheduled)
                    <form action="{{ route('kaprodi.pengajuan.finalkan.jadwal', $pengajuan->id) }}" method="POST" style="margin-top: 20px;">
                        @csrf
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Finalisasi Pengajuan Sidang</button>
                    </form>
                @endif
            @else
                <p class="info-message">Tidak ada aksi penjadwalan yang tersedia untuk status pengajuan ini ({{ ucfirst(str_replace('_', ' ', $pengajuan->status)) }}).</p>
            @endif
        </div>

    </div>
</body>
</html>