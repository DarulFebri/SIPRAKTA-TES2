<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respon Undangan Sidang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
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
        }
        .info-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .info-group p {
            margin: 0;
            padding: 8px 12px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .form-group input[type="radio"] {
            margin-right: 10px;
        }
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
            min-height: 80px;
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
            margin-left: 10px;
        }
        .buttons button[type="submit"] {
            background-color: #007bff;
            color: white;
        }
        .buttons .btn-tolak {
            background-color: #dc3545;
            color: white;
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
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
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
        <h2>Respon Undangan Sidang</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
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
            <p>{{ $sidang->pengajuan->mahasiswa->nama_lengkap }} (NIM: {{ $sidang->pengajuan->mahasiswa->nim }})</p>
        </div>
        <div class="info-group">
            <label>Jenis Pengajuan:</label>
            <p>{{ strtoupper($sidang->pengajuan->jenis_pengajuan) }}</p>
        </div>
        @if ($sidang->tanggal_waktu_sidang)
            <div class="info-group">
                <label>Tanggal & Waktu Sidang:</label>
                <p>{{ \Carbon\Carbon::parse($sidang->tanggal_waktu_sidang)->translatedFormat('l, d F Y H:i') }} WIB</p>
            </div>
        @endif
        @if ($sidang->ruangan_sidang)
            <div class="info-group">
                <label>Ruangan Sidang:</label>
                <p>{{ $sidang->ruangan_sidang }}</p>
            </div>
        @endif
        <div class="info-group">
            <label>Peran Anda:</label>
            <p>
                @if ($peran == 'ketua_sidang') Ketua Sidang
                @elseif ($peran == 'sekretaris_sidang') Sekretaris Sidang
                @elseif ($peran == 'anggota1_sidang') Anggota Sidang 1 (Penguji)
                @elseif ($peran == 'anggota2_sidang') Anggota Sidang 2 (Penguji)
                @elseif ($peran == 'dosen_pembimbing') Dosen Pembimbing 1
                @elseif ($peran == 'dosen_penguji1') Dosen Pembimbing 2
                @endif
            </p>
        </div>

        <hr>

        <h3>Tim Sidang:</h3>
        <div class="info-group">
            <label>Dosen Pembimbing 1:</label>
            <p>{{ $sidang->dosenPembimbing->nama ?? '-' }}</p>
        </div>
        <div class="info-group">
            <label>Dosen Pembimbing 2:</label>
            <p>{{ $sidang->dosenPenguji1->nama ?? '-' }}</p>
        </div>
        <div class="info-group">
            <label>Ketua Sidang:</label>
            <p>{{ $sidang->ketuaSidang->nama ?? '-' }}</p>
        </div>
        <div class="info-group">
            <label>Sekretaris Sidang:</label>
            <p>{{ $sidang->sekretarisSidang->nama ?? '-' }}</p>
        </div>
        <div class="info-group">
            <label>Anggota Sidang 1 (Penguji):</label>
            <p>{{ $sidang->anggota1Sidang->nama ?? '-' }}</p>
        </div>
        <div class="info-group">
            <label>Anggota Sidang 2 (Penguji):</label>
            <p>{{ $sidang->anggota2Sidang->nama ?? '-' }}</p>
        </div>
        
        <hr>

        <form action="{{ route('dosen.sidang.respon.submit', $sidang->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Respon Anda:</label>
                <input type="radio" name="response" id="response_setuju" value="setuju" {{ old('response') == 'setuju' ? 'checked' : '' }} required>
                <label for="response_setuju">Setuju</label>
                
                <input type="radio" name="response" id="response_tolak" value="tolak" {{ old('response') == 'tolak' ? 'checked' : '' }} required>
                <label for="response_tolak">Tolak</label>
                @error('response')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" id="alasan_tolak_group" style="display: {{ old('response') == 'tolak' ? 'block' : 'none' }};">
                <label for="alasan">Alasan (Wajib jika Menolak):</label>
                <textarea name="alasan" id="alasan" placeholder="Sebutkan alasan Anda menolak undangan sidang ini...">{{ old('alasan') }}</textarea>
                @error('alasan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="buttons">
                <button type="submit" name="action" value="submit_response">Kirim Respon</button>
            </div>
        </form>

        <a href="{{ route('dosen.dashboard') }}" class="back-link">Kembali ke Dashboard Dosen</a>
    </div>

    <script>
        const responseSetuju = document.getElementById('response_setuju');
        const responseTolak = document.getElementById('response_tolak');
        const alasanTolakGroup = document.getElementById('alasan_tolak_group');
        const alasanTextarea = document.getElementById('alasan');

        function toggleAlasanField() {
            if (responseTolak.checked) {
                alasanTolakGroup.style.display = 'block';
                alasanTextarea.setAttribute('required', 'required'); // Wajib jika menolak
            } else {
                alasanTolakGroup.style.display = 'none';
                alasanTextarea.removeAttribute('required');
                alasanTextarea.value = ''; // Kosongkan jika tidak menolak
            }
        }

        responseSetuju.addEventListener('change', toggleAlasanField);
        responseTolak.addEventListener('change', toggleAlasanField);

        // Panggil saat halaman dimuat jika ada old input
        toggleAlasanField();
    </script>
</body>
</html>