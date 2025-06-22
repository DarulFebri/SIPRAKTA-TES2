<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Tugas Akhir</title>
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

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-grey);
        }

        input[type="file"] {
            border: 1px solid var(--medium-grey);
            padding: 10px 12px;
            border-radius: 6px;
            width: calc(100% - 24px); /* Account for padding */
            background-color: var(--light-blue-bg);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="file"]:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
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
            width: auto;
            display: block;
            margin: 25px auto 0;
        }

        button:hover {
            background-color: var(--dark-blue);
            transform: translateY(-2px);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
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
    </style>
</head>
<body>

    <div class="container">
        <h2>Form Pengajuan Tugas Akhir</h2>

        @if (session('success'))
            <div class="message message-success">
                {{ session('success') }}
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

        <form action="{{ route('mahasiswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="jenis_pengajuan" value="ta">

            <div class="form-group">
                <label for="surat_permohonan_sidang">1. Surat Permohonan Sidang:</label>
                <input type="file" name="dokumen[surat_permohonan_sidang]" id="surat_permohonan_sidang" accept=".pdf" required>
                @error('dokumen.surat_permohonan_sidang')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="bebas_kompensasi">2. Surat Keterangan Bebas Kompensasi Semester Ganjil & Genap:</label>
                <input type="file" name="dokumen[surat_keterangan_bebas_kompensasi]" id="bebas_kompensasi" accept=".pdf" required>
                @error('dokumen.surat_keterangan_bebas_kompensasi')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="ipk_terakhir">3. IPK Terakhir (Lampiran Rapor Semester 1 s.d 5 (D3) dan 1 s.d 7 (D4)):</label>
                <input type="file" name="dokumen[ipk_terakhir]" id="ipk_terakhir" accept=".pdf" required>
                @error('dokumen.ipk_terakhir')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="bukti_laporan_pkl">4. Bukti Menyerahkan Laporan PKL:</label>
                <input type="file" name="dokumen[bukti_menyerahkan_laporan_pkl]" id="bukti_laporan_pkl" accept=".pdf" required>
                @error('dokumen.bukti_menyerahkan_laporan_pkl')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="nilai_toeic">5. Nilai TOEIC (minimal 450 (D3) / 550 (D4) - Lampirkan kartu TOEIC. Jika belum mencukupi, fotokopi kartu nilai TOEIC terakhir dan bukti pendaftaran tes TOEIC berikutnya):</label>
                <input type="file" name="dokumen[nilai_toeic]" id="nilai_toeic" accept=".pdf,.jpg,.jpeg,.png" required>
                @error('dokumen.nilai_toeic')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="tugas_akhir_rangkap">6. Tugas Akhir Rangkap 4 yang Disetujui Pembimbing:</label>
                <input type="file" name="dokumen[tugas_akhir_rangkap]" id="tugas_akhir_rangkap" accept=".pdf" required>
                @error('dokumen.tugas_akhir_rangkap')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="kartu_bimbingan">7. Kartu Bimbingan/Konsultasi Tugas Akhir 9x:</label>
                <input type="file" name="dokumen[kartu_bimbingan_ta]" id="kartu_bimbingan" accept=".pdf" required>
                @error('dokumen.kartu_bimbingan_ta')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="fotokopi_ijazah_sma">8. Fotokopi Ijazah SMA/MA/SMK:</label>
                <input type="file" name="dokumen[fotokopi_ijazah_sma]" id="fotokopi_ijazah_sma" accept=".pdf,.jpg,.jpeg,.png" required>
                @error('dokumen.fotokopi_ijazah_sma')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="fotokopi_sertifikat_diksarlin">10. Fotokopi Sertifikat Diksarlin:</label>
                <input type="file" name="dokumen[fotokopi_sertifikat_diksarlin]" id="fotokopi_sertifikat_diksarlin" accept=".pdf,.jpg,.jpeg,.png" required>
                @error('dokumen.fotokopi_sertifikat_diksarlin')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="sertifikat_responsi">11. Sertifikat Responsi:</label>
                <input type="file" name="dokumen[sertifikat_responsi]" id="sertifikat_responsi" accept=".pdf" required>
                @error('dokumen.sertifikat_responsi')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="nilai_ske">12. Nilai Satuan Kredit Ekstrakurikuler (SKE) (Lampirkan kartu SKE):</label>
                <input type="file" name="dokumen[nilai_ske]" id="nilai_ske" accept=".pdf,.jpg,.jpeg,.png" required>
                @error('dokumen.nilai_ske')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <p style="font-size: 0.9em; color: var(--dark-grey); margin-top: 20px;">Catatan: Untuk 'Map Plastik', akan diurus secara fisik.</p>

            <button type="submit">Ajukan Tugas Akhir</button>
        </form>

        <a href="{{ route('mahasiswa.dashboard') }}" class="back-link">Kembali ke Dashboard</a>
    </div>

</body>
</html>