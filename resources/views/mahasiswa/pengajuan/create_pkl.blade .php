<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Praktek Kerja Lapangan</title>
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
        <h2>Form Pengajuan Praktek Kerja Lapangan</h2>

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
            <input type="hidden" name="jenis_pengajuan" value="pkl">

            <div class="form-group">
                <label for="laporan_pkl">1. Laporan PKL (2 rangkap):</label>
                <input type="file" name="dokumen[laporan_pkl]" id="laporan_pkl" accept=".pdf" required>
                @error('dokumen.laporan_pkl')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="buku_pkl">2. Buku PKL:</label>
                <input type="file" name="dokumen[buku_pkl]" id="buku_pkl" accept=".pdf" required>
                @error('dokumen.buku_pkl')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="kuisioner_survey_pkl">3. Kuisioner Survey PKL (telah diisi, ditandatangani, dan distempel perusahaan):</label>
                <input type="file" name="dokumen[kuisioner_survey_pkl]" id="kuisioner_survey_pkl" accept=".pdf" required>
                @error('dokumen.kuisioner_survey_pkl')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="kuisioner_kelulusan">4. Kuisioner Kelulusan (jika ada):</label>
                <input type="file" name="dokumen[kuisioner_kelulusan]" id="kuisioner_kelulusan" accept=".pdf">
                <small>Opsional jika tidak ada</small>
                @error('dokumen.kuisioner_kelulusan')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="kuisioner_balikan_pkl">5. Kuisioner Balikan PKL:</label>
                <input type="file" name="dokumen[kuisioner_balikan_pkl]" id="kuisioner_balikan_pkl" accept=".pdf" required>
                @error('dokumen.kuisioner_balikan_pkl')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="lembaran_rekomendasi_penguji">6. Lembaran Rekomendasi Penguji:</label>
                <input type="file" name="dokumen[lembaran_rekomendasi_penguji]" id="lembaran_rekomendasi_penguji" accept=".pdf" required>
                @error('dokumen.lembaran_rekomendasi_penguji')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="surat_permohonan_sidang_pkl">7. Surat Permohonan Sidang PKL:</label>
                <input type="file" name="dokumen[surat_permohonan_sidang_pkl]" id="surat_permohonan_sidang_pkl" accept=".pdf" required>
                @error('dokumen.surat_permohonan_sidang_pkl')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="lembar_penilaian_sidang_pkl">8. Lembar Penilaian Sidang PKL (Penguji):</label>
                <input type="file" name="dokumen[lembar_penilaian_sidang_pkl]" id="lembar_penilaian_sidang_pkl" accept=".pdf" required>
                @error('dokumen.lembar_penilaian_sidang_pkl')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="surat_keterangan_pelaksanaan_pkl">9. Surat Keterangan Pelaksanaan PKL (Asli, distempel dan ditandatangani pihak perusahaan):</label>
                <input type="file" name="dokumen[surat_keterangan_pelaksanaan_pkl]" id="surat_keterangan_pelaksanaan_pkl" accept=".pdf" required>
                @error('dokumen.surat_keterangan_pelaksanaan_pkl')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="fotocopy_cover_laporan_pkl">10. Fotokopi Cover Laporan PKL (ada tanda tangan persetujuan sidang dari dosen pembimbing PKL):</label>
                <input type="file" name="dokumen[fotocopy_cover_laporan_pkl]" id="fotocopy_cover_laporan_pkl" accept=".pdf,.jpg,.jpeg,.png" required>
                @error('dokumen.fotocopy_cover_laporan_pkl')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="fotocopy_lembar_penilaian_industri">11. Fotokopi Lembar Penilaian dari Pembimbing di Industri (ditandatangani pembimbing industri):</label>
                <input type="file" name="dokumen[fotocopy_lembar_penilaian_industri]" id="fotocopy_lembar_penilaian_industri" accept=".pdf,.jpg,.jpeg,.png" required>
                @error('dokumen.fotocopy_lembar_penilaian_industri')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="fotocopy_lembar_penilaian_dosen_pembimbing_pkl">12. Fotokopi Lembar Penilaian dari Dosen Pembimbing PKL (ditandatangani pembimbing kampus):</label>
                <input type="file" name="dokumen[fotocopy_lembar_penilaian_dosen_pembimbing_pkl]" id="fotocopy_lembar_penilaian_dosen_pembimbing_pkl" accept=".pdf,.jpg,.jpeg,.png" required>
                @error('dokumen.fotocopy_lembar_penilaian_dosen_pembimbing_pkl')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="fotocopy_lembar_konsultasi_bimbingan_pkl">13. Fotokopi Lembar Konsultasi Bimbingan PKL (diisi dan ditandatangani pembimbing kampus):</label>
                <input type="file" name="dokumen[fotocopy_lembar_konsultasi_bimbingan_pkl]" id="fotocopy_lembar_konsultasi_bimbingan_pkl" accept=".pdf,.jpg,.jpeg,.png" required>
                @error('dokumen.fotocopy_lembar_konsultasi_bimbingan_pkl')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit">Ajukan PKL</button>
        </form>

        <a href="{{ route('mahasiswa.dashboard') }}" class="back-link">Kembali ke Dashboard</a>
    </div>

</body>
</html>