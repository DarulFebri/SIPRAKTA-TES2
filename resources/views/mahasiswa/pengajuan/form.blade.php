@extends('layouts.mahasiswa')

@section('title', 'Pengajuan Sidang PKL')
@section('page_title', ' Pengajuan Sidang PKL ')

@section('content')
    <div class="alertpkl alert-infopkl">
        <i class="fas fa-info-circle"></i>
        <div>
            <strong>Informasi Penting!</strong> Semua dokumen persyaratan untuk mengajukan sidang PKL sudah lengkap. 
            Anda dapat melanjutkan ke proses finalisasi pengajuan.
        </div>
    </div>

    <div class="form-container">
        <h2 class="form-title">
            <i class="fas fa-user"></i>
            Informasi Mahasiswa
        </h2>
        <div class="student-info">
            <div class="info-card">
                <div class="info-group">
                    <label><i class="fas fa-user"></i> Nama</label>
                    <input type="text" value="Mahasiswa" disabled>
                </div>
            </div>
            <div class="info-card">
                <div class="info-group">
                    <label><i class="fas fa-id-card"></i> NIM</label>
                    <input type="text" value="1234567890" disabled>
                </div>
            </div>
            <div class="info-card">
                <div class="info-group">
                    <label><i class="fas fa-graduation-cap"></i> Program Studi</label>
                    <input type="text" value="Teknik Informatika" disabled>
                </div>
            </div>
            <div class="info-card">
                <div class="info-group">
                    <label><i class="fas fa-file-alt"></i> Judul Laporan PKL</label>
                    <textarea id="reportTitle" placeholder="Masukkan judul laporan PKL"></textarea>
                </div>
            </div>
            <div class="info-card">
                <div class="info-group">
                    <label><i class="fas fa-user-tie"></i> Dosen Pembimbing</label>
                    <select id="dosenPembimbing">
                        <option value="">Pilih Dosen Pembimbing</option>
                        <option value="Dr. John Doe, M.T.">Dr. John Doe, M.T.</option>
                        <option value="Prof. Jane Smith, M.Kom.">Prof. Jane Smith, M.Kom.</option>
                        <option value="Dr. Ahmad Yani, M.T.">Dr. Ahmad Yani, M.T.</option>
                    </select>
                </div>
            </div>
        </div>

        <h2 class="form-title">
            <i class="fas fa-file-upload"></i>
            Berkas Persyaratan Pengajuan PKL
        </h2>
        
        <table class="document-table">
            <thead>
                <tr>
                    <th>Berkas Dokumen</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Laporan PKL sebanyak 2 rangkap</strong></td>
                    <td><span class="status-badge status-uploaded">Sudah Diunggah</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewFile('Laporan PKL sebanyak 2 rangkap')">Lihat</button>
                            <button class="btn btn-primary btn-sm" onclick="showUploadModal('Laporan PKL sebanyak 2 rangkap')">Ubah</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Buku PKL</strong></td>
                    <td><span class="status-badge status-uploaded">Sudah Diunggah</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewFile('Buku PKL')">Lihat</button>
                            <button class="btn btn-primary btn-sm" onclick="showUploadModal('Buku PKL')">Ubah</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Kuisioner survey PKL yang telah diisi dan ditandatangani serta distempel perusahaan</strong></td>
                    <td><span class="status-badge status-uploaded">Sudah Diunggah</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewFile('Kuisioner survey PKL yang telah diisi dan ditandatangani serta distempel perusahaan')">Lihat</button>
                            <button class="btn btn-primary btn-sm" onclick="showUploadModal('Kuisioner survey PKL yang telah diisi dan ditandatangani serta distempel perusahaan')">Ubah</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Kuisioner Kelulusan (jika ada)</strong></td>
                    <td><span class="status-badge status-uploaded">Sudah Diunggah</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewFile('Kuisioner Kelulusan (jika ada)')">Lihat</button>
                            <button class="btn btn-primary btn-sm" onclick="showUploadModal('Kuisioner Kelulusan (jika ada)')">Ubah</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Kuisioner balikan PKL</strong></td>
                    <td><span class="status-badge status-uploaded">Sudah Diunggah</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewFile('Kuisioner balikan PKL')">Lihat</button>
                            <button class="btn btn-primary btn-sm" onclick="showUploadModal('Kuisioner balikan PKL')">Ubah</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Lembaran Rekomendasi Penguji</strong></td>
                    <td><span class="status-badge status-uploaded">Sudah Diunggah</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewFile('Lembaran Rekomendasi Penguji')">Lihat</button>
                            <button class="btn btn-primary btn-sm" onclick="showUploadModal('Lembaran Rekomendasi Penguji')">Ubah</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Surat Permohonan Sidang PKL</strong></td>
                    <td><span class="status-badge status-uploaded">Sudah Diunggah</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewFile('Surat Permohonan Sidang PKL')">Lihat</button>
                            <button class="btn btn-primary btn-sm" onclick="showUploadModal('Surat Permohonan Sidang PKL')">Ubah</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Lembar Penilaian Sidang PKL (Penguji)</strong></td>
                    <td><span class="status-badge status-uploaded">Sudah Diunggah</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewFile('Lembar Penilaian Sidang PKL (Penguji)')">Lihat</button>
                            <button class="btn btn-primary btn-sm" onclick="showUploadModal('Lembar Penilaian Sidang PKL (Penguji)')">Ubah</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Surat keterangan pelaksanaan PKL (Asli, distempel dan ditandatangani pihak perusahaan)</strong></td>
                    <td><span class="status-badge status-uploaded">Sudah Diunggah</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewFile('Surat keterangan pelaksanaan PKL (Asli, distempel dan ditandatangani pihak perusahaan)')">Lihat</button>
                            <button class="btn btn-primary btn-sm" onclick="showUploadModal('Surat keterangan pelaksanaan PKL (Asli, distempel dan ditandatangani pihak perusahaan)')">Ubah</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Fotocopy cover laporan PKL yang ada tanda tangan persetujuan sidang dari dosen pembimbing PKL</strong></td>
                    <td><span class="status-badge status-uploaded">Sudah Diunggah</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewFile('Fotocopy cover laporan PKL yang ada tanda tangan persetujuan sidang dari dosen pembimbing PKL')">Lihat</button>
                            <button class="btn btn-primary btn-sm" onclick="showUploadModal('Fotocopy cover laporan PKL yang ada tanda tangan persetujuan sidang dari dosen pembimbing PKL')">Ubah</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Fotocopy lembar penilaian dari pembimbing di industri (ditandatangani pembimbing industri)</strong></td>
                    <td><span class="status-badge status-uploaded">Sudah Diunggah</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewFile('Fotocopy lembar penilaian dari pembimbing di industri (ditandatangani pembimbing industri)')">Lihat</button>
                            <button class="btn btn-primary btn-sm" onclick="showUploadModal('Fotocopy lembar penilaian dari pembimbing di industri (ditandatangani pembimbing industri)')">Ubah</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Fotocopy lembar penilaian dari dosen pembimbing PKL (ditandatangani pembimbing kampus)</strong></td>
                    <td><span class="status-badge status-uploaded">Sudah Diunggah</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewFile('Fotocopy lembar penilaian dari dosen pembimbing PKL (ditandatangani pembimbing kampus)')">Lihat</button>
                            <button class="btn btn-primary btn-sm" onclick="showUploadModal('Fotocopy lembar penilaian dari dosen pembimbing PKL (ditandatangani pembimbing kampus)')">Ubah</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Fotocopy lembar konsultasi bimbingan PKL (diisi dan ditandatangani pembimbing kampus)</strong></td>
                    <td><span class="status-badge status-uploaded">Sudah Diunggah</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewFile('Fotocopy lembar konsultasi bimbingan PKL (diisi dan ditandatangani pembimbing kampus)')">Lihat</button>
                            <button class="btn btn-primary btn-sm" onclick="showUploadModal('Fotocopy lembar konsultasi bimbingan PKL (diisi dan ditandatangani pembimbing kampus)')">Ubah</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div class="footer-buttons">
            <button class="btn btn-outline" onclick="window.history.back()">Kembali</button>
            <button class="btn btn-primary" id="finalizeBtn" onclick="showConfirmationModal()">Finalisasi Pengajuan</button>
        </div>
    </div>

    <div class="main-card custom-form-card"> {{-- Tambahkan class custom-form-card di sini --}}
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

@push('scripts')
    <script>
        // Any specific scripts for edit_profile can go here.
    </script>
@endpush