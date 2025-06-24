@extends('layouts.mahasiswa')

@section('title', 'Form Pengajuan Praktek Kerja Lapangan')
@section('page_title', 'Form Pengajuan Praktek Kerja Lapangan')

@section('content')
    <div class="form-container">
        <h2 class="form-title">
            <i class="fas fa-file-alt"></i>
            Form Pengajuan Praktek Kerja Lapangan
        </h2>

        <form action="{{ route('mahasiswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="jenis_pengajuan" value="pkl">

            <div class="student-info">
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-user"></i> Nama</label>
                        <input type="text" value="{{ Auth::user()->name }}" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-id-card"></i> NIM</label>
                        <input type="text" value="{{ Auth::user()->nim }}" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-graduation-cap"></i> Program Studi</label>
                        <input type="text" value="{{ Auth::user()->program_studi }}" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-file-alt"></i> Judul Laporan PKL</label>
                        <textarea id="reportTitle" name="judul_laporan_pkl" placeholder="Masukkan judul laporan PKL"></textarea>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-user-tie"></i> Dosen Pembimbing</label>
                        <select id="dosenPembimbing" name="dosen_pembimbing">
                            <option value="">Pilih Dosen Pembimbing</option>
                            <option value="Dr. John Doe, M.T.">Dr. John Doe, M.T.</option>
                            <option value="Prof. Jane Smith, M.Kom.">Prof. Jane Smith, M.Kom.</option>
                            <option value="Dr. Ahmad Yani, M.T.">Dr. Ahmad Yani, M.T.</option>
                        </select>
                    </div>
                </div>
            </div>

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

        <div class="footer-buttons" style="margin-top: 20px; text-align: center;">
            <button class="btn btn-outline" onclick="window.history.back()">Kembali</button>
        </div>
    </div>

    {{-- Pesan Sukses dan Error diletakkan di luar form-container agar konsisten dengan form.blade.php --}}
    <div class="main-card custom-form-card">
        @if (session('success'))
            <div class="alert alert-success success-animation">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger error-animation">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection