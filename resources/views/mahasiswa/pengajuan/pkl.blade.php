@extends('layouts.mahasiswa')

@section('page_title', 'Pengajuan Sidang PKL')

@push('styles')
    {{-- Inline styles from halamancontoh.html --}}
    <style>
        /* Variabel CSS sudah ada di mahasiswa.blade.php, tetapi bisa ditimpa jika perlu spesifik di sini */
        :root {
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        /* Override beberapa style agar konsisten dengan halamancontoh.html */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            animation: fadeIn 0.6s 0.3s both;
        }

        .alert-info {
            background-color: var(--primary-100);
            color: var(--primary-700);
            border-left: 4px solid var(--primary-500);
        }

        .alert i {
            margin-right: 15px;
            font-size: 20px;
        }

        .form-container {
            background-color: var(--white);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            animation: fadeIn 0.6s 0.4s both;
        }

        .form-title {
            color: var(--primary-700);
            margin-bottom: 20px;
            font-size: 22px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .form-title i {
            margin-right: 15px;
            color: var(--primary-500);
        }

        .student-info {
            margin-bottom: 30px;
            padding: 20px;
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            animation: fadeIn 0.6s 0.3s both;
        }

        .info-card {
            background: linear-gradient(135deg, var(--primary-100), var(--white));
            border-radius: 10px;
            padding: 15px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background-color: var(--primary-500);
            transition: var(--transition);
        }

        .info-card:hover::before {
            width: 8px;
        }

        .info-group {
            display: flex;
            flex-direction: column; /* Ubah menjadi column */
            gap: 5px; /* Kurangi gap */
        }

        .info-group i {
            color: var(--primary-500);
            font-size: 18px;
            width: 24px;
            text-align: center;
            margin-right: 5px; /* Tambahkan margin ke ikon */
        }

        .info-group label {
            font-size: 14px;
            color: var(--text-color);
            font-weight: 500;
            margin-bottom: 5px;
            display: flex; /* Tambahkan display flex untuk ikon */
            align-items: center;
        }

        .info-group input,
        .info-group select,
        .info-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 14px;
            background-color: var(--white);
            transition: var(--transition);
        }

        .info-group input:focus,
        .info-group select:focus,
        .info-group textarea:focus {
            outline: none;
            border-color: var(--primary-500);
            box-shadow: 0 0 5px rgba(26, 136, 255, 0.3);
        }

        .info-group input:disabled,
        .info-group textarea:disabled,
        .info-group select:disabled {
            background-color: #f1f5f9;
            cursor: not-allowed;
        }

        .info-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .info-group select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
        }

        .document-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            animation: fadeIn 0.6s 0.5s both;
        }

        .document-table thead tr {
            background-color: var(--primary-600);
            color: var(--white);
            text-align: left;
        }

        .document-table th,
        .document-table td {
            padding: 15px 20px;
        }

        .document-table tbody tr {
            border-bottom: 1px solid #eee;
        }

        .document-table tbody tr:nth-of-type(even) {
            background-color: var(--light-gray);
        }

        .document-table tbody tr:last-of-type {
            border-bottom: 2px solid var(--primary-600);
        }

        .document-table tbody tr:hover {
            background-color: var(--primary-100);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            display: inline-block;
        }

        .status-uploaded {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .status-not-uploaded {
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--warning-color);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-500);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-600);
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-500);
            color: var(--primary-500);
        }

        .btn-outline:hover {
            background-color: var(--primary-100);
            transform: translateY(-2px);
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: var(--white);
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        /* Footer Buttons */
        .footer-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s;
            overflow: auto; /* Agar bisa discroll jika konten terlalu banyak */
        }

        .modal-content {
            background-color: var(--white);
            margin: 5% auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            position: relative;
            animation: slideInLeft 0.3s;
            max-width: 90%;
            max-height: 90vh;
            width: 800px;
            display: flex;
            flex-direction: column;
        }

        .close-modal {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            color: var(--text-color);
        }

        .modal-title {
            color: var(--primary-700);
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 600;
        }

        .modal-body {
            flex: 1;
            margin-bottom: 25px;
            overflow: auto;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .pdf-viewer {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Modal untuk Upload, Confirmation, dan Success */
        #uploadModal .modal-content,
        #confirmationModal .modal-content,
        #successModal .modal-content {
            width: 400px;
            height: auto;
            max-height: 80vh;
            margin: 5% auto;
        }

        /* File Upload Styles */
        .file-upload-container {
            margin-bottom: 20px;
        }

        .file-upload-input {
            width: 100%;
            padding: 12px;
            border: 1px dashed #ccc;
            border-radius: 8px;
            background-color: var(--light-gray);
            cursor: pointer;
            transition: var(--transition);
        }

        .file-upload-input:hover {
            border-color: var(--primary-500);
            background-color: var(--primary-100);
        }

        /* Loading Modal */
        .loading-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 200;
            animation: fadeIn 0.3s ease;
        }

        .loading-content {
            background-color: var(--white);
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.4s 0.1s both;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--primary-100);
            border-top: 4px solid var(--primary-500);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        .loading-text {
            font-size: 16px;
            color: var(--primary-700);
            font-weight: 500;
        }

        /* Dosen Selector Modal */
        #dosenSelectorModal .modal-content {
            width: 600px;
            max-height: 90vh;
        }
        #dosenSelectorModal .modal-body {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        #dosenSelectorModal .dosen-search-filter {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        #dosenSelectorModal .dosen-search-filter input,
        #dosenSelectorModal .dosen-search-filter select {
            flex: 1;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        #dosenSelectorModal .dosen-list-container {
            flex: 1;
            overflow-y: auto;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 10px;
            background-color: var(--light-gray);
        }
        #dosenSelectorModal .dosen-item {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        #dosenSelectorModal .dosen-item:last-child {
            border-bottom: none;
        }
        #dosenSelectorModal .dosen-item:hover {
            background-color: var(--primary-100);
        }
        #dosenSelectorModal .dosen-item.selected {
            background-color: var(--primary-200);
            font-weight: 600;
        }
        #dosenSelectorModal .dosen-item span {
            font-size: 14px;
        }
        #dosenSelectorModal .dosen-item .dosen-name {
            color: var(--primary-700);
        }
        #dosenSelectorModal .dosen-item .dosen-prodi-jurusan {
            font-size: 12px;
            color: #666;
        }
        #dosenSelectorModal .no-dosen-found {
            text-align: center;
            padding: 20px;
            color: #888;
        }
        #dosenSelectorModal .pagination-controls {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }
        #dosenSelectorModal .pagination-controls button {
            padding: 8px 15px;
            border-radius: 5px;
            border: 1px solid var(--primary-500);
            background-color: var(--white);
            color: var(--primary-500);
            cursor: pointer;
        }
        #dosenSelectorModal .pagination-controls button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .student-info {
                grid-template-columns: 1fr;
            }
            #uploadModal .modal-content,
            #confirmationModal .modal-content,
            #successModal .modal-content,
            #dosenSelectorModal .modal-content {
                width: 95%;
                margin: 5% auto;
            }
            .document-table th,
            .document-table td {
                padding: 10px;
                font-size: 13px;
            }
            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }
            .btn-sm {
                width: 100%;
            }
            .footer-buttons {
                flex-direction: column;
            }
            .footer-buttons .btn {
                width: 100%;
            }
            .info-group label {
                flex-direction: row;
                align-items: center;
            }
        }
    </style>
@endpush

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        <div>
            <strong>Informasi Penting!</strong> Lengkapi semua dokumen persyaratan dan informasi pengajuan sebelum melakukan finalisasi.
        </div>
    </div>

    <div class="form-container">
        <h2 class="form-title">
            <i class="fas fa-user"></i>
            Informasi Mahasiswa dan Pengajuan
        </h2>
        <form id="pengajuanForm" action="{{ $pengajuan->exists ? route('mahasiswa.pengajuan.update', $pengajuan->id) : route('mahasiswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($pengajuan->exists)
                @method('PUT')
            @endif
            <input type="hidden" name="jenis_pengajuan" value="{{ $pengajuan->jenis_pengajuan ?? $jenis }}">
            <input type="hidden" name="action" id="formAction">

            <div class="student-info">
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-user"></i> Nama</label>
                        <input type="text" value="{{ $mahasiswa->nama_lengkap }}" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-id-card"></i> NIM</label>
                        <input type="text" value="{{ $mahasiswa->nim }}" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-graduation-cap"></i> Program Studi</label>
                        <input type="text" value="{{ $mahasiswa->prodi }}" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label for="judul_pengajuan"><i class="fas fa-file-alt"></i> Judul Laporan PKL</label>
                        <textarea id="judul_pengajuan" name="judul_pengajuan" placeholder="Masukkan judul laporan PKL" {{ ($pengajuan->exists && $pengajuan->status !== 'draft' && !in_array($pengajuan->status, ['ditolak_admin', 'ditolak_kaprodi'])) ? 'disabled' : '' }}>{{ old('judul_pengajuan', $pengajuan->judul_pengajuan ?? '') }}</textarea>
                        @error('judul_pengajuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label for="dosen_pembimbing_id"><i class="fas fa-user-tie"></i> Dosen Pembimbing</label>
                        <input type="text" id="selectedDosenName" value="{{ old('dosen_pembimbing_id', optional($pengajuan->sidang)->dosenPembimbing->nama ?? 'Pilih Dosen Pembimbing') }}" disabled>
                        <input type="hidden" id="dosenPembimbingId" name="dosen_pembimbing_id" value="{{ old('dosen_pembimbing_id', optional($pengajuan->sidang)->dosen_pembimbing_id) }}">
                        <button type="button" class="btn btn-outline btn-sm" onclick="showDosenSelectorModal()" {{ ($pengajuan->exists && $pengajuan->status !== 'draft' && !in_array($pengajuan->status, ['ditolak_admin', 'ditolak_kaprodi'])) ? 'disabled' : '' }}>Pilih Dosen</button>
                        @error('dosen_pembimbing_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- Dosen Pembimbing 2 (Penguji 1) is not needed for PKL --}}
                @if(($pengajuan->jenis_pengajuan ?? $jenis) === 'ta')
                <div class="info-card">
                    <div class="info-group">
                        <label for="dosen_penguji1_id"><i class="fas fa-user-tie"></i> Dosen Pembimbing 2 (Penguji 1)</label>
                        <input type="text" id="selectedDosenPenguji1Name" value="{{ old('dosen_penguji1_id', optional($pengajuan->sidang)->dosenPenguji1->nama ?? 'Pilih Dosen Pembimbing 2') }}" disabled>
                        <input type="hidden" id="dosenPenguji1Id" name="dosen_penguji1_id" value="{{ old('dosen_penguji1_id', optional($pengajuan->sidang)->dosen_penguji1_id) }}">
                        <button type="button" class="btn btn-outline btn-sm" onclick="showDosenSelectorModal('dosenPenguji1')" {{ ($pengajuan->exists && $pengajuan->status !== 'draft' && !in_array($pengajuan->status, ['ditolak_admin', 'ditolak_kaprodi'])) ? 'disabled' : '' }}>Pilih Dosen</button>
                        @error('dosen_penguji1_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @else
                    {{-- Hidden input to ensure dosen_penguji1_id is sent as null if not applicable --}}
                    <input type="hidden" id="dosenPenguji1Id" name="dosen_penguji1_id" value="">
                @endif
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
                    @foreach($dokumenSyarat as $key => $namaDokumen)
                        @php
                            // Gunakan $dokumenTerupload yang sudah di-keyBy di controller
                            $uploadedDocument = $dokumenTerupload->get($namaDokumen);
                            $statusClass = $uploadedDocument ? 'status-uploaded' : 'status-not-uploaded';
                            $statusText = $uploadedDocument ? 'Sudah Diunggah' : 'Belum Diunggah';
                            $buttonText = $uploadedDocument ? 'Ubah' : 'Unggah'; // Logika untuk teks tombol
                        @endphp
                        <tr>
                            <td><strong>{{ $namaDokumen }}</strong></td>
                            <td><span class="status-badge {{ $statusClass }}">{{ $statusText }}</span></td>
                            <td>
                                <div class="action-buttons">
                                    @if($uploadedDocument)
                                        {{-- Mengubah onclick agar membuka di tab baru --}}
                                        <button type="button" class="btn btn-outline btn-sm" onclick="viewFileInNewTab('{{ Storage::url($uploadedDocument->path_file) }}')">Lihat</button>
                                    @else
                                        <button type="button" class="btn btn-outline btn-sm" disabled>Lihat</button>
                                    @endif
                                    <button type="button" class="btn btn-primary btn-sm" onclick="showUploadModal('{{ $namaDokumen }}', 'dokumen_{{ $key }}', '{{ $buttonText }}')"
                                        {{ ($pengajuan->exists && $pengajuan->status !== 'draft' && !in_array($pengajuan->status, ['ditolak_admin', 'ditolak_kaprodi'])) ? 'disabled' : '' }}>{{ $buttonText }}</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="footer-buttons">
                <button type="button" class="btn btn-outline" onclick="window.history.back()">Kembali</button>
                @if(!$pengajuan->exists || $pengajuan->status === 'draft' || in_array($pengajuan->status, ['ditolak_admin', 'ditolak_kaprodi']))
                    <button type="submit" name="action" value="draft" class="btn btn-secondary">Simpan Draft</button>
                    <button type="button" class="btn btn-primary" id="finalizeBtn" onclick="showConfirmationModal()">Finalisasi Pengajuan</button>
                @else
                    <button type="button" class="btn btn-primary" id="finalizeBtn" disabled>Telah Difinalisasi</button>
                @endif
            </div>
        </form>
    </div>

    <!-- Upload Modal -->
    <div class="modal" id="uploadModal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('uploadModal')">×</span>
            <h3 class="modal-title" id="uploadModalTitle">Unggah Dokumen</h3>
            <div class="modal-body">
                {{-- Form action will be dynamically set by JS when the modal is opened --}}
                <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- _method will be dynamically added by JS if it's an existing pengajuan --}}
                    <input type="hidden" name="action" value="upload_single_document">
                    <input type="hidden" name="document_name_key" id="documentNameKeyInput"> {{-- Will store e.g., 'dokumen_laporan_pkl' --}}
                    <div class="file-upload-container">
                        <label class="file-upload-label">Pilih file untuk diunggah:</label>
                        <input type="file" class="file-upload-input" id="fileInput" name="document_file">
                    </div>
                    <div style="margin-top: 15px; font-size: 13px; color: #666;">
                        <i class="fas fa-info-circle"></i> Format file yang diterima: PDF, JPG, PNG (Maks. 2MB)
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" onclick="closeModal('uploadModal')">Batal</button>
                        <button type="submit" class="btn btn-primary" id="uploadModalSubmitBtn">Unggah</button> {{-- Tambahkan ID di sini --}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal" id="confirmationModal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('confirmationModal')">×</span>
            <h3 class="modal-title">Konfirmasi Finalisasi</h3>
            <div class="modal-body">
                <p>Anda yakin ingin melakukan finalisasi pengajuan sidang PKL?</p>
                <p><strong>Semua dokumen dan informasi mahasiswa sudah lengkap dan siap untuk diproses.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('confirmationModal')">Kembali</button>
                <button type="button" class="btn btn-primary" onclick="finalizeSubmission()">Finalisasi</button>
            </div>
        </div>
    </div>

    <!-- Success Notification Modal -->
    <div class="modal" id="successModal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('successModal')">×</span>
            <h3 class="modal-title" style="color: var(--success-color);">
                <i class="fas fa-check-circle"></i> Pengajuan Berhasil
            </h3>
            <div class="modal-body">
                <p>Pengajuan sidang PKL Anda telah berhasil difinalisasi.</p>
                <p>Silakan tunggu konfirmasi lebih lanjut dari admin melalui notifikasi.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="closeModal('successModal')">Tutup</button>
            </div>
        </div>
    </div>

    {{-- PDF Viewer Modal ini dihapus karena tidak lagi digunakan --}}
    {{--
    <div class="modal" id="pdfModal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('pdfModal')">×</span>
            <h3 class="modal-title" id="pdfModalTitle">Lihat Dokumen</h3>
            <div class="modal-body">
                <iframe class="pdf-viewer" id="pdfViewer" src="" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="closeModal('pdfModal')">Tutup</button>
            </div>
        </div>
    </div>
    --}}

    <!-- Loading Modal -->
    <div class="loading-modal" id="loadingModal">
        <div class="loading-content">
            <div class="spinner"></div>
            <div class="loading-text">Memproses Finalisasi...</div>
        </div>
    </div>

    <!-- Dosen Selector Modal -->
    <div class="modal" id="dosenSelectorModal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('dosenSelectorModal')">×</span>
            <h3 class="modal-title">Pilih Dosen Pembimbing</h3>
            <div class="modal-body">
                <div class="dosen-search-filter">
                    <input type="text" id="dosenSearchInput" onkeyup="filterDosenList()" placeholder="Cari dosen...">
                    <select id="dosenJurusanFilter" onchange="filterDosenList()">
                        <option value="">Semua Jurusan</option>
                        {{-- Options will be populated by JS from `dosens` data --}}
                    </select>
                    <select id="dosenProdiFilter" onchange="filterDosenList()">
                        <option value="">Semua Prodi</option>
                        {{-- Options will be populated by JS from `dosens` data --}}
                    </select>
                </div>
                <div class="dosen-list-container">
                    <ul id="dosenList" style="list-style: none; padding: 0;">
                        {{-- Dosen items will be rendered here by JavaScript --}}
                    </ul>
                    <div id="noDosenFound" class="no-dosen-found" style="display: none;">Tidak ada dosen yang ditemukan.</div>
                </div>
                <div class="pagination-controls">
                    <button id="prevDosenPage" onclick="changeDosenPage(-1)" disabled>Sebelumnya</button>
                    <span id="dosenPageInfo">Halaman 1 dari 1</span>
                    <button id="nextDosenPage" onclick="changeDosenPage(1)" disabled>Berikutnya</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('dosenSelectorModal')">Batal</button>
                <button type="button" class="btn btn-primary" id="selectDosenBtn" onclick="selectDosen()">Pilih</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Data dosen dari controller
        const allDosens = @json($dosens);
        let currentSelectedDosenId = null;
        let currentSelectedDosenNameTarget = null; // To differentiate between pembimbing and penguji1
        const dosenPerPage = 10;
        let currentDosenPage = 1;
        let filteredDosens = [];

        document.addEventListener('DOMContentLoaded', function() {
            // Set judul halaman pada layout utama
            document.querySelector('.main-content .header h1').innerHTML = `
                <i class="fas fa-briefcase" style="margin-right: 15px;"></i>
                Pengajuan Sidang PKL
            `;

            // Initialize dosen list in the selector modal
            populateDosenFilters();
            filterDosenList(); // Initial render of dosen list

            // Finalisasi button state on load
            updateFinalizeButtonState();

            // Set active menu based on current page
            const pklMenu = document.querySelector('.menu-item .fa-briefcase').closest('.menu-item');
            if (pklMenu) {
                pklMenu.classList.add('active');
                const pklSubmenu = document.getElementById('pkl-submenu');
                if (pklSubmenu) pklSubmenu.classList.add('show');
            }
            const pendaftaranItem = document.querySelector('a[href="{{ route('mahasiswa.pengajuan.detail', ['jenis' => 'pkl']) }}"] .submenu-item');
            if (pendaftaranItem) {
                pendaftaranItem.classList.add('active');
            }
        });

        // Function to update the state of the Finalisasi button
        function updateFinalizeButtonState() {
            const reportTitle = document.getElementById('judul_pengajuan').value.trim();
            const dosenPembimbingId = document.getElementById('dosenPembimbingId').value;
            // Removed check for dosenPenguji1Id as it's not required for PKL
            const finalizeBtn = document.getElementById('finalizeBtn');
            const documentRows = document.querySelectorAll('.document-table tbody tr');
            let allDocumentsUploaded = true;

            documentRows.forEach(row => {
                const statusBadge = row.querySelector('.status-badge');
                if (statusBadge && statusBadge.textContent.trim() === 'Belum Diunggah') {
                    allDocumentsUploaded = false;
                }
            });

            const isNewPengajuan = {{ $pengajuan->exists ? 'false' : 'true' }}; // Check if $pengajuan is an existing model
            const currentPengajuanStatus = '{{ $pengajuan->status ?? 'draft' }}'; // Use 'draft' as default for new pengajuan
            const disableAll = (currentPengajuanStatus !== 'draft' && currentPengajuanStatus !== 'ditolak_admin' && currentPengajuanStatus !== 'ditolak_kaprodi');

            // Log status to console for debugging
            console.log('--- updateFinalizeButtonState Debug ---');
            console.log('isNewPengajuan:', isNewPengajuan);
            console.log('currentPengajuanStatus:', currentPengajuanStatus);
            console.log('disableAll (should disable most inputs/buttons):', disableAll);
            console.log('reportTitle filled:', !!reportTitle);
            console.log('dosenPembimbingId selected:', !!dosenPembimbingId);
            console.log('allDocumentsUploaded:', allDocumentsUploaded);


            if (!isNewPengajuan && disableAll) {
                // Existing pengajuan and already processed: Disable all form elements
                document.getElementById('judul_pengajuan').disabled = true;
                document.getElementById('selectedDosenName').disabled = true;
                document.getElementById('dosenPembimbingId').disabled = true;
                // document.getElementById('selectedDosenPenguji1Name').disabled = true; // Removed
                // document.getElementById('dosenPenguji1Id').disabled = true; // Removed

                document.querySelectorAll('.btn-primary.btn-sm').forEach(btn => btn.disabled = true);
                document.querySelectorAll('.btn-outline.btn-sm').forEach(btn => {
                    if (!btn.textContent.includes('Lihat')) { // "Ubah" button
                        btn.disabled = true;
                    }
                });

                finalizeBtn.disabled = true;
                finalizeBtn.textContent = 'Telah Difinalisasi';
                finalizeBtn.classList.remove('btn-primary');
                finalizeBtn.classList.add('btn-outline');
                console.log('Finalize button: DISABLED (Pengajuan already processed)');
                return; // Exit function if disabled
            }

            // Common logic for both new and editable existing pengajuan
            // Removed dosenPenguji1Id from the condition
            if (reportTitle && dosenPembimbingId && allDocumentsUploaded) {
                finalizeBtn.disabled = false;
                finalizeBtn.textContent = 'Finalisasi Pengajuan';
                finalizeBtn.classList.remove('btn-outline');
                finalizeBtn.classList.add('btn-primary');
                console.log('Finalize button: ENABLED (All conditions met)');
            } else {
                finalizeBtn.disabled = true;
                finalizeBtn.textContent = 'Finalisasi Pengajuan';
                finalizeBtn.classList.remove('btn-primary');
                finalizeBtn.classList.add('btn-outline');
                console.log('Finalize button: DISABLED (Conditions not met)');
            }
        }


        // Modal functions
        // Menambahkan parameter buttonText
        function showUploadModal(documentName, documentNameKey, buttonText) {
            console.log('showUploadModal called for:', documentName, 'Key:', documentNameKey, 'Button Text:', buttonText);
            const pengajuanExists = {{ $pengajuan->exists ? 'true' : 'false' }};
            let pengajuanId = null;

            if(pengajuanExists) {
                 pengajuanId = {{ $pengajuan->id ?? 'null' }};
            }

            // Set the form action dynamically
            const uploadForm = document.getElementById('uploadForm');
            // Clear any existing _method input from previous modal opens
            const existingMethodInput = uploadForm.querySelector('input[name="_method"]');
            if (existingMethodInput) {
                existingMethodInput.remove();
            }

            if (pengajuanId) {
                uploadForm.action = `{{ route('mahasiswa.pengajuan.update', ':id') }}`.replace(':id', pengajuanId);
                // For existing pengajuan, use PUT method for single document upload via AJAX
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                uploadForm.appendChild(methodInput); // Append _method for PUT request
            } else {
                uploadForm.action = `{{ route('mahasiswa.pengajuan.store') }}`;
                // For new pengajuan, method will be POST (default)
            }

            // Set the document title in the modal
            document.getElementById('uploadModalTitle').textContent = `Unggah ${documentName}`;
            // Set the hidden input to the document key (e.g., 'dokumen_laporan_pkl')
            document.getElementById('documentNameKeyInput').value = documentNameKey;
            // Clear previous file selection
            document.getElementById('fileInput').value = '';
            // Set the submit button text in the modal
            document.getElementById('uploadModalSubmitBtn').textContent = buttonText; // Set teks tombol
            // Display the modal
            document.getElementById('uploadModal').style.display = 'block';
        }

        function showConfirmationModal() {
            console.log('showConfirmationModal called.');
            const reportTitle = document.getElementById('judul_pengajuan').value.trim();
            const dosenPembimbingId = document.getElementById('dosenPembimbingId').value;
            // Removed check for dosenPenguji1Id as it's not required for PKL
            const documentRows = document.querySelectorAll('.document-table tbody tr');
            let allDocumentsUploaded = true;

            documentRows.forEach(row => {
                const statusBadge = row.querySelector('.status-badge');
                if (statusBadge && statusBadge.textContent.trim() === 'Belum Diunggah') {
                    allDocumentsUploaded = false;
                }
            });

            if (!reportTitle) {
                console.log('Validation failed: Judul Laporan PKL is empty.');
                showTemporaryMessage('Judul Laporan PKL wajib diisi.', 'danger');
                return;
            }
            if (!dosenPembimbingId) {
                console.log('Validation failed: Dosen Pembimbing is not selected.');
                showTemporaryMessage('Dosen Pembimbing wajib dipilih.', 'danger');
                return;
            }
            // Removed check for dosenPenguji1Id
            if (!allDocumentsUploaded) {
                console.log('Validation failed: Not all documents are uploaded.');
                showTemporaryMessage('Harap unggah semua dokumen persyaratan sebelum finalisasi.', 'danger');
                return;
            }

            console.log('All validations passed. Showing confirmation modal.');
            document.getElementById('confirmationModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Fungsi baru untuk membuka file di tab baru
        function viewFileInNewTab(url) {
            console.log('Opening file in new tab:', url);
            window.open(url, '_blank');
        }

        function finalizeSubmission() {
            console.log('finalizeSubmission called. Initiating form submission...');
            const loadingModal = document.getElementById('loadingModal');
            loadingModal.style.display = 'flex';
            closeModal('confirmationModal');

            document.getElementById('formAction').value = 'submit';
            document.getElementById('pengajuanForm').submit();
        }

        // --- Dosen Selector Modal Logic ---
        function showDosenSelectorModal(targetInput = 'dosenPembimbing') {
            currentSelectedDosenNameTarget = targetInput; // Set which input field to update

            // Reset search and filters
            document.getElementById('dosenSearchInput').value = '';
            document.getElementById('dosenJurusanFilter').value = '';
            document.getElementById('dosenProdiFilter').value = '';

            // Set title based on which role is being selected
            const modalTitle = document.querySelector('#dosenSelectorModal .modal-title');
            if (targetInput === 'dosenPembimbing') {
                modalTitle.textContent = 'Pilih Dosen Pembimbing';
                currentSelectedDosenId = document.getElementById('dosenPembimbingId').value;
            } else if (targetInput === 'dosenPenguji1') {
                modalTitle.textContent = 'Pilih Dosen Pembimbing 2 (Penguji 1)';
                currentSelectedDosenId = document.getElementById('dosenPenguji1Id').value;
            }


            filterDosenList(); // Re-filter and render

            document.getElementById('dosenSelectorModal').style.display = 'block';
        }

        function populateDosenFilters() {
            const jurusanFilter = document.getElementById('dosenJurusanFilter');
            const prodiFilter = document.getElementById('dosenProdiFilter');

            const uniqueJurusan = [...new Set(allDosens.map(dosen => dosen.jurusan))].sort();
            const uniqueProdi = [...new Set(allDosens.map(dosen => dosen.prodi))].sort();

            jurusanFilter.innerHTML = '<option value="">Semua Jurusan</option>';
            uniqueJurusan.forEach(jurusan => {
                jurusanFilter.innerHTML += `<option value="${jurusan}">${jurusan}</option>`;
            });

            prodiFilter.innerHTML = '<option value="">Semua Prodi</option>';
            uniqueProdi.forEach(prodi => {
                prodiFilter.innerHTML += `<option value="${prodi}">${prodi}</option>`;
            });
        }

        function filterDosenList() {
            const searchTerm = document.getElementById('dosenSearchInput').value.toLowerCase();
            const selectedJurusan = document.getElementById('dosenJurusanFilter').value;
            const selectedProdi = document.getElementById('dosenProdiFilter').value;

            filteredDosens = allDosens.filter(dosen => {
                const matchesSearch = dosen.nama.toLowerCase().includes(searchTerm) ||
                                      dosen.nidn.toLowerCase().includes(searchTerm);
                const matchesJurusan = selectedJurusan === '' || dosen.jurusan === selectedJurusan;
                const matchesProdi = selectedProdi === '' || dosen.prodi === selectedProdi;
                return matchesSearch && matchesJurusan && matchesProdi;
            }).sort((a, b) => a.nama.localeCompare(b.nama)); // Sort alphabetically by name

            currentDosenPage = 1; // Reset to first page after filtering
            renderDosenList();
        }

        function renderDosenList() {
            const dosenListDiv = document.getElementById('dosenList');
            dosenListDiv.innerHTML = '';
            document.getElementById('noDosenFound').style.display = 'none';

            const start = (currentDosenPage - 1) * dosenPerPage;
            const end = start + dosenPerPage;
            const paginatedDosens = filteredDosens.slice(start, end);

            if (paginatedDosens.length === 0) {
                document.getElementById('noDosenFound').style.display = 'block';
                document.getElementById('selectDosenBtn').disabled = true;
            } else {
                document.getElementById('selectDosenBtn').disabled = false;
                paginatedDosens.forEach(dosen => {
                    const dosenItem = document.createElement('li');
                    dosenItem.className = 'dosen-item';
                    if (dosen.id == currentSelectedDosenId) {
                        dosenItem.classList.add('selected');
                    }
                    dosenItem.dataset.dosenId = dosen.id;
                    dosenItem.dataset.dosenName = dosen.nama;
                    dosenItem.innerHTML = `
                        <span class="dosen-name">${dosen.nama} (${dosen.nidn})</span>
                        <span class="dosen-prodi-jurusan">${dosen.prodi}, ${dosen.jurusan}</span>
                    `;
                    dosenItem.onclick = function() {
                        document.querySelectorAll('.dosen-item').forEach(item => item.classList.remove('selected'));
                        this.classList.add('selected');
                        currentSelectedDosenId = this.dataset.dosenId;
                    };
                    dosenListDiv.appendChild(dosenItem);
                });
            }

            updatePaginationControls();
        }

        function updatePaginationControls() {
            const totalPages = Math.ceil(filteredDosens.length / dosenPerPage);
            document.getElementById('dosenPageInfo').textContent = `Halaman ${currentDosenPage} dari ${totalPages || 1}`;
            document.getElementById('prevDosenPage').disabled = currentDosenPage === 1;
            document.getElementById('nextDosenPage').disabled = currentDosenPage === totalPages || totalPages === 0;
        }

        function changeDosenPage(direction) {
            currentDosenPage += direction;
            renderDosenList();
        }

        function selectDosen() {
            const selectedDosenItem = document.querySelector('.dosen-item.selected');
            if (selectedDosenItem) {
                const dosenId = selectedDosenItem.dataset.dosenId;
                const dosenName = selectedDosenItem.dataset.dosenName;

                if (currentSelectedDosenNameTarget === 'dosenPembimbing') {
                    document.getElementById('dosenPembimbingId').value = dosenId;
                    document.getElementById('selectedDosenName').value = dosenName;
                } else if (currentSelectedDosenNameTarget === 'dosenPenguji1') {
                    // For PKL, this block will likely not be reached as the element is hidden
                    document.getElementById('dosenPenguji1Id').value = dosenId;
                    document.getElementById('selectedDosenPenguji1Name').value = dosenName;
                }
                updateFinalizeButtonState(); // Update status after selecting a Dosen
                closeModal('dosenSelectorModal');
            } else {
                showTemporaryMessage('Pilih dosen terlebih dahulu.', 'warning');
            }
        }

        // Function to show temporary messages (like alerts but styled)
        function showTemporaryMessage(message, type = 'info') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} fade-in`; // Use fade-in animation
            alertDiv.style.position = 'fixed';
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '9999';
            alertDiv.style.maxWidth = '350px';
            alertDiv.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
            alertDiv.innerHTML = `
                <i class="fas fa-info-circle" style="margin-right: 10px;"></i>
                <div>${message}</div>
            `;
            document.body.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.style.opacity = '0';
                alertDiv.style.transform = 'translateY(-20px)';
                alertDiv.addEventListener('transitionend', () => alertDiv.remove());
            }, 3000); // Message disappears after 3 seconds
        }

        // Add event listener for form submission (for both draft and finalization)
        document.getElementById('pengajuanForm').addEventListener('submit', function(event) {
            // This event listener specifically handles the full form submission
            // For single file upload from modal, a separate form is used.
            const action = document.getElementById('formAction').value;
            if (action === 'submit') {
                // If it's a final submission, the validation is done in showConfirmationModal()
                // If this is reached, it means validation passed for finalization
                showLoadingModal('Memproses Finalisasi...');
            } else if (action === 'draft') {
                // For draft, no need for full document validation
                showLoadingModal('Menyimpan Draft...');
            }
        });

        // Event listener for single document upload form
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            const formData = new FormData(); // Create a new FormData for this specific submission
            const fileInput = document.getElementById('fileInput');
            const documentNameKey = document.getElementById('documentNameKeyInput').value;

            const pengajuanExists = {{ $pengajuan->exists ? 'true' : 'false' }};
            let pengajuanId = null;
            let fetchUrl;
            let httpMethod = 'POST'; // Default for store

            if(pengajuanExists) {
                 pengajuanId = {{ $pengajuan->id ?? 'null' }};
                 fetchUrl = `{{ route('mahasiswa.pengajuan.update', ':id') }}`.replace(':id', pengajuanId);
                 httpMethod = 'POST'; // Laravel's update route often expects PUT, but FormData with file often works with POST, or you can add a _method: PUT hidden field
                 // If updating an existing record, Laravel's update route handles _method=PUT via POST
                 formData.append('_method', 'PUT'); // Explicitly set method for Laravel
            } else {
                // For new pengajuan, we need to send ALL main form data to create the draft first
                fetchUrl = `{{ route('mahasiswa.pengajuan.store') }}`;
                // Collect main form data
                formData.append('judul_pengajuan', document.getElementById('judul_pengajuan').value);
                formData.append('dosen_pembimbing_id', document.getElementById('dosenPembimbingId').value);
                // Only append dosen_penguji1_id if the element exists (i.e., for TA)
                const dosenPenguji1Input = document.getElementById('dosenPenguji1Id');
                if (dosenPenguji1Input) {
                    formData.append('dosen_penguji1_id', dosenPenguji1Input.value);
                } else {
                    formData.append('dosen_penguji1_id', ''); // Send empty if not applicable
                }

                formData.append('jenis_pengajuan', document.querySelector('input[name="jenis_pengajuan"]').value);
                formData.append('action', 'draft_and_upload'); // New action to signify auto-drafting for the backend
                httpMethod = 'POST';
            }


            // Append the file input's selected file
            if (fileInput.files.length > 0) {
                formData.append('document_file', fileInput.files[0]);
                formData.append('document_name_key', documentNameKey);
            } else {
                showTemporaryMessage('Pilih file untuk diunggah.', 'danger');
                return;
            }

            // Set action for backend - this is for single document upload
            // It will be 'upload_single_document' for existing, or 'draft_and_upload' for new
            if (!pengajuanExists) {
                 formData.set('action', 'draft_and_upload'); // Overwrite the action if it's a new pengajuan
            } else {
                formData.set('action', 'upload_single_document');
            }


            // Show loading modal
            showLoadingModal('Mengunggah dokumen...');

            fetch(fetchUrl, {
                method: httpMethod,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData
            })
            .then(response => {
                // Check if the response is JSON before parsing
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json();
                } else {
                    // If not JSON, it might be an HTML error page. Read as text.
                    return response.text().then(text => {
                        console.error("Server responded with non-JSON:", text);
                        throw new Error("Server responded with non-JSON. Check server logs for details.");
                    });
                }
            })
            .then(data => {
                hideLoadingModal();
                if (data.success) {
                    showTemporaryMessage(data.message, 'success');
                    closeModal('uploadModal');
                    // Reload the page to reflect changes or update UI dynamically
                    // If it was a new pengajuan, the reload will take it to the edit page of the newly created draft.
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        window.location.reload();
                    }
                } else {
                    showTemporaryMessage(data.message || 'Gagal mengunggah dokumen.', 'danger');
                }
            })
            .catch(error => {
                hideLoadingModal();
                console.error('Error:', error);
                showTemporaryMessage('Terjadi kesalahan saat mengunggah dokumen: ' + error.message, 'danger');
            });
        });


        function showLoadingModal(message) {
            document.getElementById('loadingModal').style.display = 'flex';
            document.querySelector('#loadingModal .loading-text').textContent = message;
        }

        function hideLoadingModal() {
            document.getElementById('loadingModal').style.display = 'none';
        }

        // Update finalize button state when judul_pengajuan changes
        document.getElementById('judul_pengajuan').addEventListener('input', updateFinalizeButtonState);

    </script>
@endpush
