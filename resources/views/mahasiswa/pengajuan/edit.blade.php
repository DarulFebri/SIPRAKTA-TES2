<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengajuan Sidang {{ strtoupper($jenis) }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #007bff;
            --dark-blue: #0056b3;
            --light-blue-bg: #e6f2ff;
            --white: #ffffff;
            --light-grey: #f8f9fa;
            --medium-grey: #ced4da;
            --dark-grey: #495057;
            --text-color: #343a40;
            --border-color: #dee2e6;
            --success-color: #28a745;
            --error-color: #dc3545;
            --draft-button-bg: #6c757d;
            --draft-button-hover: #5a6268;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--light-grey);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            width: 100%;
            background-color: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
        }

        h2 {
            text-align: center;
            color: var(--primary-blue);
            margin-bottom: 30px;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: var(--primary-blue);
            border-radius: 2px;
        }

        h3 {
            color: var(--dark-blue);
            margin-top: 30px;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-grey);
        }

        input[type="file"],
        select {
            border: 1px solid var(--medium-grey);
            padding: 10px 12px;
            border-radius: 6px;
            width: calc(100% - 24px); /* Account for padding */
            background-color: var(--light-blue-bg);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="file"]:focus,
        select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        p {
            margin-top: 5px;
            margin-bottom: 10px;
            color: var(--dark-grey);
            font-size: 0.9em;
        }

        p a {
            color: var(--primary-blue);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        p a:hover {
            color: var(--dark-blue);
            text-decoration: underline;
        }

        button {
            background-color: var(--primary-blue);
            color: var(--white);
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-right: 15px;
            margin-top: 20px;
        }

        button:hover {
            background-color: var(--dark-blue);
            transform: translateY(-2px);
        }

        .button-draft {
            background-color: var(--draft-button-bg);
        }

        .button-draft:hover {
            background-color: var(--draft-button-hover);
        }

        .back-link {
            display: inline-block;
            text-align: center;
            margin-top: 30px;
            margin-right: 15px;
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            text-decoration: underline;
            color: var(--dark-blue);
        }

        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }

        .message-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
            border: 1px solid var(--success-color);
        }

        .message-error {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--error-color);
            border: 1px solid var(--error-color);
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.85em;
            margin-top: 5px;
            display: block;
        }

        small {
            color: var(--dark-grey);
            font-size: 0.8em;
            margin-top: 5px;
            display: block;
        }

        hr {
            border: 0;
            height: 1px;
            background: var(--border-color);
            margin: 25px 0;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Pengajuan Sidang {{ strtoupper($jenis) }}</h2>

        @if (session('success'))
            <div class="message message-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="message message-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="message message-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('mahasiswa.pengajuan.update', $pengajuan->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        
            <input type="hidden" name="jenis_pengajuan" value="{{ $jenis }}">
        
            {{-- Bagian untuk Ketua Sidang Dihapus atau Dibuat Read-only --}}
            {{-- Jika Anda ingin menampilkannya tapi tidak bisa diubah: --}}
            {{--<div class="form-group">
                <label for="ketua_sidang_dosen_id">Ketua Sidang:</label>
                <input type="text" value="{{ $pengajuan->sidang->ketuaSidang->nama ?? 'Belum Ditentukan' }}" readonly disabled>
                {{-- Atau, jika Anda benar-benar tidak ingin menampilkannya sama sekali, hapus div ini
            </div>--}}

            {{-- Tambahkan input untuk Dosen Pembimbing 1 --}}
            <div class="form-group">
                <label for="dosen_pembimbing_id">Dosen Pembimbing 1:</label>
                <select name="dosen_pembimbing_id" id="dosen_pembimbing_id" required>
                    <option value="">-- Pilih Dosen Pembimbing 1 --</option>
                    @foreach ($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ old('dosen_pembimbing_id', $pengajuan->sidang->dosen_pembimbing_id ?? null) == $dosen->id ? 'selected' : '' }}>
                            {{ $dosen->nama }}
                        </option>
                    @endforeach
                </select>
                @error('dosen_pembimbing_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tambahkan input untuk Dosen Pembimbing 2 (dosen_penguji1_id) --}}
            <div class="form-group">
                <label for="dosen_penguji1_id">Dosen Pembimbing 2:</label>
                <select name="dosen_penguji1_id" id="dosen_penguji1_id"> {{-- Tidak required, opsional --}}
                    <option value="">-- Pilih Dosen Pembimbing 2 (Opsional) --</option>
                    @foreach ($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ old('dosen_penguji1_id', $pengajuan->sidang->dosen_penguji1_id ?? null) == $dosen->id ? 'selected' : '' }}>
                            {{ $dosen->nama }}
                        </option>
                    @endforeach
                </select>
                @error('dosen_penguji1_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <h3>Dokumen Persyaratan:</h3>
            @foreach ($dokumenSyarat as $key => $namaDokumen)
                <div class="form-group">
                    <label for="dokumen_file_{{ $key }}">{{ $loop->iteration }}. {{ $namaDokumen }}:</label>
                    @php
                        $uploadedDoc = $pengajuan->dokumens->where('nama_file', $namaDokumen)->first();
                    @endphp
                    @if ($uploadedDoc)
                        <p>File saat ini: <a href="{{ asset('storage/' . $uploadedDoc->path_file) }}" target="_blank">Lihat File</a></p>
                    @else
                        <p>Belum ada file terupload.</p>
                    @endif
                    <input type="file" name="dokumen_{{ $key }}" id="dokumen_file_{{ $key }}" accept="application/pdf"> {{-- Perbaiki name attribute --}}
                    <small>(Upload file baru untuk mengganti yang lama atau mengisi yang kosong. Format: PDF)</small>
                    @error("dokumen_{{ $key }}") {{-- Perbaiki error message --}}
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                @if (!$loop->last)
                    <hr>
                @endif
            @endforeach
        
            <button type="submit" name="action" value="submit" onclick="return confirm('Apakah Anda yakin ingin memfinalisasi pengajuan ini? Setelah difinalisasi, Anda tidak dapat mengubahnya lagi.');">Finalisasi dan Ajukan</button>
            <button type="submit" name="action" value="draft" class="button-draft">Simpan Perubahan Draft</button>
        </form>

        <div style="text-align: center;">
            <a href="{{ route('mahasiswa.dashboard') }}" class="back-link">Kembali ke Dashboard</a>
            <a href="{{ route('mahasiswa.pengajuan.show', $pengajuan->id) }}" class="back-link">Kembali ke Detail Pengajuan</a>
        </div>
    </div>

</body>
</html>