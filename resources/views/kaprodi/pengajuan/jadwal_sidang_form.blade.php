<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($sidang->id) ? 'Edit' : 'Jadwalkan' }} Sidang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .info-group {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 5px solid #007bff;
            border-radius: 4px;
        }
        .info-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .info-group p {
            margin: 0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .form-group select,
        .form-group input[type="datetime-local"],
        .form-group input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .buttons {
            text-align: right;
            margin-top: 30px;
        }
        .buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            margin-left: 10px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
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
        .error-message {
            color: #dc3545;
            font-size: 0.8em;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>{{ isset($sidang->id) ? 'Edit' : 'Jadwalkan' }} Sidang untuk Pengajuan {{ strtoupper($pengajuan->jenis_pengajuan) }}</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="info-group">
            <label>Mahasiswa:</label>
            <p>{{ $pengajuan->mahasiswa->nama_lengkap }} (NIM: {{ $pengajuan->mahasiswa->nim }})</p>
        </div>
        <div class="info-group">
            <label>Dosen Pembimbing 1:</label>
            <p>{{ $pengajuan->sidang->dosenPembimbing->nama ?? '-' }}</p>
        </div>
        <div class="info-group">
            <label>Dosen Pembimbing 2:</label>
            <p>{{ $pengajuan->sidang->dosenPenguji1->nama ?? '-' }}</p>
        </div>

        <hr>

        <form action="{{ route('kaprodi.pengajuan.jadwalkan.storeUpdate', $pengajuan->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Karena ini bisa update juga --}}

            <div class="form-group">
                <label for="ketua_sidang_dosen_id">Ketua Sidang:</label>
                <select name="ketua_sidang_dosen_id" id="ketua_sidang_dosen_id" required>
                    <option value="">-- Pilih Dosen --</option>
                    @foreach ($dosens as $dosen)
                        <option value="{{ $dosen->id }}" 
                            {{ (isset($sidang) && $sidang->ketua_sidang_dosen_id == $dosen->id) ? 'selected' : (old('ketua_sidang_dosen_id') == $dosen->id ? 'selected' : '') }}>
                            {{ $dosen->nama }}
                        </option>
                    @endforeach
                </select>
                @error('ketua_sidang_dosen_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="sekretaris_sidang_dosen_id">Sekretaris Sidang:</label>
                <select name="sekretaris_sidang_dosen_id" id="sekretaris_sidang_dosen_id" required>
                    <option value="">-- Pilih Dosen --</option>
                    @foreach ($dosens as $dosen)
                        <option value="{{ $dosen->id }}" 
                            {{ (isset($sidang) && $sidang->sekretaris_sidang_dosen_id == $dosen->id) ? 'selected' : (old('sekretaris_sidang_dosen_id') == $dosen->id ? 'selected' : '') }}>
                            {{ $dosen->nama }}
                        </option>
                    @endforeach
                </select>
                @error('sekretaris_sidang_dosen_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="anggota1_sidang_dosen_id">Anggota Sidang 1 (Penguji):</label>
                <select name="anggota1_sidang_dosen_id" id="anggota1_sidang_dosen_id" required>
                    <option value="">-- Pilih Dosen --</option>
                    @foreach ($dosens as $dosen)
                        <option value="{{ $dosen->id }}" 
                            {{ (isset($sidang) && $sidang->anggota1_sidang_dosen_id == $dosen->id) ? 'selected' : (old('anggota1_sidang_dosen_id') == $dosen->id ? 'selected' : '') }}>
                            {{ $dosen->nama }}
                        </option>
                    @endforeach
                </select>
                @error('anggota1_sidang_dosen_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="anggota2_sidang_dosen_id">Anggota Sidang 2 (Penguji): (Opsional)</label>
                <select name="anggota2_sidang_dosen_id" id="anggota2_sidang_dosen_id">
                    <option value="">-- Tidak Ada --</option>
                    @foreach ($dosens as $dosen)
                        <option value="{{ $dosen->id }}" 
                            {{ (isset($sidang) && $sidang->anggota2_sidang_dosen_id == $dosen->id) ? 'selected' : (old('anggota2_sidang_dosen_id') == $dosen->id ? 'selected' : '') }}>
                            {{ $dosen->nama }}
                        </option>
                    @endforeach
                </select>
                @error('anggota2_sidang_dosen_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_waktu_sidang">Tanggal & Waktu Sidang:</label>
                <input type="datetime-local" name="tanggal_waktu_sidang" id="tanggal_waktu_sidang" 
                       value="{{ old('tanggal_waktu_sidang', isset($sidang) && $sidang->tanggal_waktu_sidang ? \Carbon\Carbon::parse($sidang->tanggal_waktu_sidang)->format('Y-m-d\TH:i') : '') }}" required>
                @error('tanggal_waktu_sidang')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="ruangan_sidang">Ruangan Sidang:</label>
                <input type="text" name="ruangan_sidang" id="ruangan_sidang" 
                       value="{{ old('ruangan_sidang', $sidang->ruangan_sidang ?? '') }}" placeholder="Contoh: Ruang Sidang 1" required>
                @error('ruangan_sidang')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="buttons">
                <button type="submit">Simpan Jadwal Sidang</button>
            </div>
        </form>
    </div>
</body>
</html>