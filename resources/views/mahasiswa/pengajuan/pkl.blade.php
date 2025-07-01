@extends('layouts.mahasiswa') {{-- Pastikan ini mengacu pada layout mahasiswa Anda --}}

@section('title', 'Pengajuan Sidang PKL')
@section('page_title', 'Pengajuan Sidang PKL')

@section('content')
    {{-- Dynamic Status Alert --}}
    @if ($pengajuan->status === 'diajukan_mahasiswa')
        <div class="alert alert-info">
            <i class="fas fa-hourglass-half"></i>
            <strong>Menunggu Verifikasi Admin.</strong> Pengajuan Anda sedang dalam antrean untuk diverifikasi.
        </div>
    @elseif ($pengajuan->status === 'diverifikasi_admin')
        <div class="alert alert-info">
            <i class="fas fa-check-circle"></i>
            <strong>Diverifikasi Admin.</strong> Pengajuan Anda telah diverifikasi oleh Admin dan diteruskan ke Kaprodi untuk penjadwalan.
        </div>
    @elseif ($pengajuan->status === 'dosen_ditunjuk')
        <div class="alert alert-info">
            <i class="fas fa-user-tie"></i>
            <strong>Dosen Ditunjuk.</strong> Dosen untuk sidang Anda telah ditunjuk oleh Kaprodi. Menunggu persetujuan dosen terkait.
        </div>
    @elseif ($pengajuan->status === 'menunggu_persetujuan_dosen')
        <div class="alert alert-info">
            <i class="fas fa-clipboard-check"></i>
            <strong>Menunggu Persetujuan Dosen.</strong> Jadwal sidang Anda telah dibuat, menunggu persetujuan dari dosen-dosen yang ditunjuk.
        </div>
    @elseif ($pengajuan->status === 'sidang_dijadwalkan_final')
        <div class="alert alert-success">
            <i class="fas fa-calendar-check"></i>
            <strong>Jadwal Sidang Final.</strong> Jadwal sidang Anda telah difinalisasi oleh Kaprodi.
            Silakan periksa detail di bawah dan bersiap untuk sidang!
        </div>
    @elseif ($pengajuan->status === 'diverifikasi_kajur')
        <div class="alert alert-success">
            <i class="fas fa-graduation-cap"></i>
            <strong>Pengajuan Disetujui Kajur.</strong> Pengajuan sidang Anda telah disetujui oleh Ketua Jurusan. Sidang akan segera dilaksanakan.
        </div>
    @elseif ($pengajuan->status === 'selesai')
        <div class="alert alert-success">
            <i class="fas fa-clipboard-list"></i>
            <strong>Sidang Selesai.</strong> Pengajuan sidang Anda telah selesai.
        </div>
    @elseif (str_contains($pengajuan->status, 'ditolak')) {{-- Tangkap semua status ditolak --}}
        <div class="alert alert-danger">
            <i class="fas fa-times-circle"></i>
            <strong>Ditolak.</strong> Pengajuan Anda ditolak.
            @if ($pengajuan->catatan_admin)
                <p class="mt-2"><strong>Catatan dari Admin:</strong> {{ $pengajuan->catatan_admin }}</p>
            @endif
            @if ($pengajuan->catatan_kaprodi)
                <p class="mt-2"><strong>Catatan dari Kaprodi:</strong> {{ $pengajuan->catatan_kaprodi }}</p>
            @endif
            <p>Silakan perbaiki persyaratan yang salah dan ajukan ulang.</p>
        </div>
    @else {{-- Default: draft or initial view --}}
        <div class="alert alert-info">
            <i class="fas fa-pencil-alt"></i>
            <strong>Draft.</strong> Silakan lengkapi semua persyaratan dan lakukan finalisasi pengajuan.
            Perubahan pada judul dan dosen pembimbing akan disimpan otomatis.
        </div>
    @endif

    {{-- General success/error messages from controller actions --}}
    @if (session('success'))
        <div class="alert alert-success mt-4">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mt-4">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mt-4">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Terjadi Kesalahan Validasi:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <h2 class="form-title">
            <i class="fas fa-file-alt"></i>
            Detail Pengajuan Sidang PKL
        </h2>

        {{-- Mahasiswa Info (Read-only) --}}
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
                    <label><i class="fas fa-file-alt"></i> Judul Laporan PKL</label>
                    <textarea id="judul_pengajuan" name="judul_pengajuan" class="form-control"
                              placeholder="Masukkan Judul Laporan PKL"
                              {{ $pengajuan->isSubmitted() ? 'readonly' : '' }}
                              data-url="{{ route('mahasiswa.pengajuan.update', $pengajuan->id) }}"
                              data-field="judul_pengajuan">{{ old('judul_pengajuan', $pengajuan->judul_pengajuan) }}</textarea>
                    <small id="judul-save-status" class="form-text text-muted" style="display: none;">Menyimpan...</small>
                </div>
            </div>
            <div class="info-card">
                <div class="info-group">
                    <label><i class="fas fa-user-tie"></i> Dosen Pembimbing</label>
                    <select id="dosen_pembimbing_id" name="dosen_pembimbing_id" class="form-control"
                            {{ $pengajuan->isSubmitted() ? 'disabled' : '' }}
                            data-url="{{ route('mahasiswa.pengajuan.update', $pengajuan->id) }}"
                            data-field="dosen_pembimbing_id">
                        <option value="">Pilih Dosen Pembimbing</option>
                        @foreach($dosens as $dosen)
                            <option value="{{ $dosen->id }}" {{ old('dosen_pembimbing_id', optional($pengajuan->sidang)->dosen_pembimbing_id) == $dosen->id ? 'selected' : '' }}>
                                {{ $dosen->nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="dosen-save-status" class="form-text text-muted" style="display: none;">Menyimpan...</small>
                </div>
            </div>
        </div>

        {{-- Berkas Persyaratan Section --}}
        <h2 class="form-title mt-4">
            <i class="fas fa-upload"></i>
            Berkas Persyaratan Pengajuan PKL
        </h2>
        
        <div class="table-responsive mt-3">
            <table class="document-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Dokumen</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $allDocumentsUploaded = true;
                    @endphp
                    @foreach($dokumenSyarat as $key => $namaDokumen)
                        @php
                            $uploadedDoc = $dokumenTerupload->get($namaDokumen);
                            $isUploaded = !empty($uploadedDoc) && !empty($uploadedDoc->path_file);
                            // Cek dokumen opsional
                            $isOptional = ($namaDokumen === 'Kuisioner Kelulusan (jika ada)');

                            if (!$isUploaded && !$isOptional) {
                                $allDocumentsUploaded = false;
                            }
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $namaDokumen }}</td>
                            <td>
                                @if($isUploaded)
                                    <span class="status-badge status-uploaded">Sudah Diunggah</span>
                                @else
                                    <span class="status-badge status-pending">Belum Diunggah</span>
                                @endif
                            </td>
                            <td>
                                @if (!$pengajuan->isSubmitted() || str_contains($pengajuan->status, 'ditolak')) {{-- Izinkan upload/edit jika belum diserahkan atau ditolak --}}
                                    <div class="action-buttons">
                                        {{-- Hidden input for file upload. Perhatikan event listener di JavaScript. --}}
                                        <input type="file" id="dokumen_{{ $key }}" name="dokumen_{{ $key }}" class="d-none document-file-input" 
                                               accept=".pdf, .jpg, .jpeg, .png" 
                                               data-document-key="dokumen_{{ $key }}"
                                               data-pengajuan-id="{{ $pengajuan->id }}">
                                        
                                        @if($isUploaded)
                                            <a href="{{ asset('storage/' . $uploadedDoc->path_file) }}" target="_blank" class="action-btn btn-view">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                            <button type="button" class="action-btn btn-edit" onclick="document.getElementById('dokumen_{{ $key }}').click();">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        @else
                                            <button type="button" class="action-btn btn-submit" onclick="document.getElementById('dokumen_{{ $key }}').click();">
                                                <i class="fas fa-upload"></i> Unggah
                                            </button>
                                        @endif
                                    </div>
                                @else {{-- Jika sudah diserahkan (dan tidak ditolak), hanya izinkan melihat --}}
                                    @if($isUploaded)
                                        <a href="{{ asset('storage/' . $uploadedDoc->path_file) }}" target="_blank" class="action-btn btn-view">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    @else
                                        -
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Sidang Information (if scheduled) --}}
        @if($pengajuan->sidang && $pengajuan->sidang->tanggal_waktu_sidang)
            <h2 class="form-title mt-4">
                <i class="fas fa-calendar-check"></i>
                Jadwal Sidang & Tim Penguji
            </h2>
            <div class="student-info"> {{-- Gunakan kembali student-info untuk konsistensi styling card --}}
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-calendar-alt"></i> Tanggal Sidang</label>
                        <input type="text" value="{{ \Carbon\Carbon::parse($pengajuan->sidang->tanggal_waktu_sidang)->translatedFormat('l, d F Y') }}" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-clock"></i> Waktu Sidang</label>
                        <input type="text" value="{{ \Carbon\Carbon::parse($pengajuan->sidang->tanggal_waktu_sidang)->format('H:i') }} WIB" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-map-marker-alt"></i> Ruangan</label>
                        <input type="text" value="{{ $pengajuan->sidang->ruangan_sidang }}" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-user-tie"></i> Ketua Sidang</label>
                        <input type="text" value="{{ $pengajuan->sidang->ketuaSidang->nama ?? 'Belum Ditunjuk' }}" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-user-tag"></i> Sekretaris Sidang</label>
                        <input type="text" value="{{ $pengajuan->sidang->sekretarisSidang->nama ?? 'Belum Ditunjuk' }}" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-users"></i> Anggota Sidang 1</label>
                        <input type="text" value="{{ $pengajuan->sidang->anggota1Sidang->nama ?? 'Belum Ditunjuk' }}" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-users-cog"></i> Anggota Sidang 2</label>
                        <input type="text" value="{{ $pengajuan->sidang->anggota2Sidang->nama ?? 'Tidak Ada' }}" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-user-graduate"></i> Dosen Pembimbing 1</label>
                        <input type="text" value="{{ $pengajuan->sidang->dosenPembimbing->nama ?? 'Belum Ditunjuk' }}" disabled>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-group">
                        <label><i class="fas fa-user-graduate"></i> Dosen Pembimbing 2</label>
                        <input type="text" value="{{ $pengajuan->sidang->dosenPenguji1->nama ?? 'Belum Ditunjuk' }}" disabled>
                    </div>
                </div>
            </div>
        @elseif(!$pengajuan->isSubmitted() || str_contains($pengajuan->status, 'ditolak'))
            {{-- Pesan ini hanya muncul jika belum diserahkan atau ditolak --}}
            <div class="alert alert-info mt-4">
                <i class="fas fa-info-circle"></i>
                Jadwal sidang akan ditampilkan di sini setelah pengajuan Anda diverifikasi dan dijadwalkan oleh Kaprodi.
            </div>
        @endif

        {{-- Form untuk finalisasi --}}
        {{-- Tombol "Finalisasi Pengajuan" hanya akan muncul jika pengajuan belum diserahkan atau ditolak --}}
        @if (!$pengajuan->isSubmitted() || str_contains($pengajuan->status, 'ditolak'))
            <form id="finalizationForm" action="{{ route('mahasiswa.pengajuan.update', $pengajuan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="submit"> {{-- Menandakan pengiriman final --}}
                <input type="hidden" name="judul_pengajuan" id="hidden_judul_pengajuan">
                <input type="hidden" name="dosen_pembimbing_id" id="hidden_dosen_pembimbing_id">

                <div class="footer-buttons mt-4">
                    <button type="submit" id="finalisasiBtn" class="action-btn btn-submit" 
                            disabled {{-- Default disabled, akan diaktifkan oleh JS --}}
                            title="Lengkapi semua dokumen, judul, dan dosen pembimbing untuk memfinalisasi"
                            onclick="return confirm('Apakah Anda yakin ingin memfinalisasi pengajuan ini? Setelah difinalisasi, Anda tidak dapat mengubahnya lagi kecuali ditolak oleh admin.');">
                        <i class="fas fa-paper-plane"></i> Finalisasi Pengajuan
                    </button>
                    <a href="{{ route('mahasiswa.pengajuan.index') }}" class="action-btn btn-view">
                        <i class="fas fa-list-alt"></i> Daftar Pengajuan Saya
                    </a>
                    <a href="{{ route('mahasiswa.dashboard') }}" class="action-btn btn-view">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </form>
        @else {{-- Jika sudah diserahkan dan tidak ditolak, tampilkan tombol navigasi saja --}}
            <div class="footer-buttons mt-4" style="justify-content: flex-end;">
                <a href="{{ route('mahasiswa.pengajuan.index') }}" class="action-btn btn-view">
                    <i class="fas fa-list-alt"></i> Daftar Pengajuan Saya
                </a>
                <a href="{{ route('mahasiswa.dashboard') }}" class="action-btn btn-view">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> {{-- Pastikan jQuery sudah dimuat --}}
<script>
    $(document).ready(function() {
        const pengajuanStatus = "{{ $pengajuan->status }}";
        const isCurrentlySubmitted = isPengajuanSubmitted(pengajuanStatus); // Gunakan helper dari model

        // Disable/enable judul dan dosen_pembimbing jika sudah diserahkan
        if (isCurrentlySubmitted) {
            $('#judul_pengajuan').prop('readonly', true);
            $('#dosen_pembimbing_id').prop('disabled', true);
        } else {
            $('#judul_pengajuan').prop('readonly', false);
            $('#dosen_pembimbing_id').prop('disabled', false);
        }

        // Auto-save logic for judul and dosen_pembimbing
        const judulInput = $('#judul_pengajuan');
        const dosenSelect = $('#dosen_pembimbing_id');
        let autoSaveTimer;

        function showSaveStatus(element, message, isSuccess) {
            const statusElement = element.next('small');
            statusElement.text(message).css('color', isSuccess ? 'green' : 'red').fadeIn();
            setTimeout(() => statusElement.fadeOut(), 3000);
        }

        function triggerAutoSave(element, fieldName, value) {
            if (isCurrentlySubmitted) return; // Jangan auto-save jika sudah diserahkan

            const url = element.data('url');
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                element.next('small').text('Menyimpan...').css('color', 'orange').fadeIn();
                $.ajax({
                    url: url,
                    type: 'POST', 
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT', // Menggunakan PUT untuk hit route update
                        action: 'auto_save_field', // Aksi khusus untuk auto-save
                        field: fieldName,
                        value: value
                    },
                    success: function(response) {
                        showSaveStatus(element, response.message, response.success);
                        // Perbarui status tombol finalisasi setelah auto-save berhasil
                        checkAndSetFinalizationButtonStatus();
                    },
                    error: function(xhr) {
                        let errorMessage = 'Gagal menyimpan perubahan.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = 'Gagal: ' + xhr.responseJSON.message;
                        }
                        showSaveStatus(element, errorMessage, false);
                    }
                });
            }, 1000); // Delay 1 detik sebelum menyimpan
        }

        judulInput.on('keyup', function() {
            triggerAutoSave($(this), 'judul_pengajuan', $(this).val());
        });

        dosenSelect.on('change', function() {
            triggerAutoSave($(this), 'dosen_pembimbing_id', $(this).val());
        });

        // Document upload via AJAX
        $('.document-file-input').on('change', function() {
            if (isCurrentlySubmitted) return; // Jangan izinkan upload jika sudah diserahkan

            const fileInput = $(this);
            const documentKey = fileInput.data('document-key');
            const pengajuanId = fileInput.data('pengajuan-id');
            const file = fileInput[0].files[0];

            if (!file) return;

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PUT'); // Menggunakan PUT untuk update
            formData.append('action', 'upload_single_document');
            formData.append('document_name_key', documentKey);
            formData.append('document_file', file);

            // Tampilkan indikator loading
            const row = fileInput.closest('tr');
            const statusCell = row.find('td:nth-child(3)');
            const actionCell = row.find('td:nth-child(4)');

            statusCell.html('<span class="status-badge status-pending"><i class="fas fa-spinner fa-spin"></i> Mengunggah...</span>');
            actionCell.find('button, a').prop('disabled', true).addClass('disabled-btn'); // Nonaktifkan tombol selama upload

            $.ajax({
                url: "{{ route('mahasiswa.pengajuan.update', $pengajuan->id) }}",
                type: 'POST', // Dikirim sebagai POST, tetapi Laravel akan menginterpretasikan sebagai PUT
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        statusCell.html('<span class="status-badge status-uploaded">Sudah Diunggah</span>');
                        // Perbarui tombol aksi dengan link lihat dan tombol edit
                        actionCell.html(`
                            <a href="${response.file_url}" target="_blank" class="action-btn btn-view">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <button type="button" class="action-btn btn-edit" onclick="document.getElementById('${documentKey}').click();">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        `);
                        // Perbarui status tombol finalisasi
                        checkAndSetFinalizationButtonStatus();
                    } else {
                        statusCell.html('<span class="status-badge status-pending">Gagal Unggah</span>');
                        alert(response.message);
                    }
                    actionCell.find('button, a').prop('disabled', false).removeClass('disabled-btn'); // Aktifkan kembali tombol
                },
                error: function(xhr) {
                    statusCell.html('<span class="status-badge status-pending">Gagal Unggah</span>');
                    actionCell.find('button, a').prop('disabled', false).removeClass('disabled-btn'); // Aktifkan kembali tombol
                    let errorMessage = 'Terjadi kesalahan saat mengunggah.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert('Error: ' + errorMessage);
                }
            });
        });

        // Fungsi untuk memperbarui status tombol finalisasi
        function checkAndSetFinalizationButtonStatus() {
            const finalisasiBtn = $('#finalisasiBtn');
            const judulFilled = judulInput.val().trim() !== '';
            const dosenSelected = dosenSelect.val() !== '';
            
            let allRequiredDocumentsUploaded = true;
            $('.document-table tbody tr').each(function() {
                const statusBadge = $(this).find('.status-badge');
                const documentName = $(this).find('td:nth-child(2)').text().trim();
                const isOptional = (documentName === 'Kuisioner Kelulusan (jika ada)');

                if (!isOptional && statusBadge.text().trim() === 'Belum Diunggah') {
                    allRequiredDocumentsUploaded = false;
                    return false; // Break loop
                }
            });

            const canFinalize = judulFilled && dosenSelected && allRequiredDocumentsUploaded;

            if (canFinalize) {
                finalisasiBtn.prop('disabled', false).attr('title', 'Finalisasi pengajuan Anda');
            } else {
                finalisasiBtn.prop('disabled', true).attr('title', 'Lengkapi semua dokumen, judul, dan dosen pembimbing untuk memfinalisasi');
            }
        }

        // Update hidden fields in finalization form
        $('#finalizationForm').on('submit', function() {
            $('#hidden_judul_pengajuan').val(judulInput.val());
            $('#hidden_dosen_pembimbing_id').val(dosenSelect.val());
        });

        // Panggil saat halaman dimuat untuk set status awal tombol
        checkAndSetFinalizationButtonStatus();

        // Optional: Style for disabled buttons
        $(document).on('mouseover', '.disabled-btn', function() {
            $(this).css('cursor', 'not-allowed');
        }).on('mouseout', '.disabled-btn', function() {
            $(this).css('cursor', 'default');
        });
    });
</script>
@endpush
