@extends('layouts.mahasiswa')

@section('title', 'Form Pengajuan Tugas Akhir')
@section('page_title', 'Form Pengajuan Tugas Akhir')

@section('content')
    <div class="form-container">
        <h2 class="form-title">
            <i class="fas fa-file-alt"></i>
            Form Pengajuan Tugas Akhir
        </h2>

        <form action="{{ route('mahasiswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="jenis_pengajuan" value="ta">

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
                        <label><i class="fas fa-file-alt"></i> Judul Tugas Akhir</label>
                        <textarea id="reportTitle" name="judul_tugas_akhir" placeholder="Masukkan judul Tugas Akhir"></textarea>
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