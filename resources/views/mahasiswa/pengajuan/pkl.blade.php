@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pengajuan Sidang PKL</h4>
                    <p class="card-subtitle">
                        Halaman ini adalah pusat untuk pengajuan sidang PKL Anda. Silakan lengkapi semua persyaratan di bawah ini.
                        Perubahan pada judul dan dosen pembimbing akan disimpan secara otomatis.
                    </p>

                    {{-- Bagian Status Pengajuan dan Catatan --}}
                    <div class="mt-4 mb-4">
                        <h5>Status Pengajuan Anda</h5>
                        @if($pengajuan->status == 'disetujui')
                            <div class="alert alert-success">
                                <strong>Disetujui.</strong> Jadwal sidang Anda telah ditetapkan. Silakan cek di halaman jadwal.
                            </div>
                        @elseif($pengajuan->status == 'ditolak')
                            <div class="alert alert-danger">
                                <strong>Ditolak.</strong> Pengajuan Anda ditolak.
                                <p class="font-weight-bold mt-2">Catatan dari Admin/Kaprodi:</p>
                                <p>{{ $pengajuan->catatan ?? 'Tidak ada catatan.' }}</p>
                                <p>Silakan perbaiki persyaratan yang ditolak dan lakukan finalisasi ulang.</p>
                            </div>
                        @elseif($pengajuan->status == 'pending')
                             <div class="alert alert-warning">
                                <strong>Menunggu Verifikasi.</strong> Pengajuan Anda sedang diverifikasi oleh admin.
                            </div>
                        @else
                            <div class="alert alert-info">
                                <strong>Draft.</strong> Silakan lengkapi semua persyaratan dan lakukan finalisasi.
                            </div>
                        @endif
                    </div>


                    <form id="pengajuanForm" action="{{ route('mahasiswa.pengajuan.pkl.finalisasi', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            {{-- Judul dan Dosen Pembimbing --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="judul_laporan_pkl">Judul Laporan PKL</label>
                                        <input type="text" id="judul_laporan_pkl" name="judul_laporan_pkl" class="form-control"
                                               placeholder="Masukkan Judul Laporan PKL"
                                               value="{{ $pengajuan->judul_laporan_pkl }}"
                                               data-url="{{ route('mahasiswa.pengajuan.pkl.update', $pengajuan->id) }}">
                                        <small id="judul-save-status" class="form-text text-muted" style="display: none;"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dosen_pembimbing_id">Dosen Pembimbing</label>
                                        <select id="dosen_pembimbing_id" name="dosen_pembimbing_id" class="form-control"
                                                data-url="{{ route('mahasiswa.pengajuan.pkl.update', $pengajuan->id) }}">
                                            <option value="">Pilih Dosen Pembimbing</option>
                                            @foreach($dosen_pembimbings as $dosen)
                                                <option value="{{ $dosen->id }}" {{ $pengajuan->dosen_pembimbing_id == $dosen->id ? 'selected' : '' }}>
                                                    {{ $dosen->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small id="dosen-save-status" class="form-text text-muted" style="display: none;"></small>
                                    </div>
                                </div>
                            </div>

                            {{-- Berkas Persyaratan --}}
                            <h5 class="mt-4">Berkas Persyaratan Pengajuan PKL</h5>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered">
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
                                            $berkas_list = [
                                                'laporan_pkl_1' => 'Laporan PKL (Rangkap 1)',
                                                'laporan_pkl_2' => 'Laporan PKL (Rangkap 2)',
                                                'buku_pkl' => 'Buku PKL',
                                                'kuisioner_survey' => 'Kuisioner Survey PKL (diisi, ttd, stempel)',
                                                'kuisioner_kelulusan' => 'Kuisioner Kelulusan (jika ada)',
                                                'kuisioner_balikan' => 'Kuisioner Balikan PKL',
                                                'rekomendasi_penguji' => 'Lembaran Rekomendasi Penguji',
                                                'surat_permohonan_sidang' => 'Surat Permohonan Sidang PKL',
                                                'lembar_penilaian_sidang' => 'Lembar Penilaian Sidang PKL (Penguji)',
                                                'surat_keterangan_pelaksanaan' => 'Surat Keterangan Pelaksanaan PKL (Asli)',
                                                'cover_laporan_pkl' => 'Fotocopy Cover Laporan (ttd dospem)',
                                                'lembar_penilaian_industri' => 'Fotocopy Lembar Penilaian Industri (ttd pembimbing industri)',
                                                'lembar_penilaian_dospem' => 'Fotocopy Lembar Penilaian Dospem (ttd dospem)',
                                                'lembar_konsultasi' => 'Fotocopy Lembar Konsultasi Bimbingan (diisi dan ttd dospem)',
                                            ];
                                            $all_uploaded = $pengajuan->judul_laporan_pkl && $pengajuan->dosen_pembimbing_id;
                                        @endphp

                                        @foreach($berkas_list as $key => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $value }}</td>
                                            <td>
                                                @if($pengajuan->{$key})
                                                    <span class="badge badge-success">Sudah Diunggah</span>
                                                @else
                                                    <span class="badge badge-danger">Belum Diunggah</span>
                                                    @php $all_uploaded = false; @endphp
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                     <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('{{ $key }}').click();">
                                                        {{ $pengajuan->{$key} ? 'Edit' : 'Unggah' }}
                                                    </button>
                                                    <input type="file" name="{{ $key }}" id="{{ $key }}" class="d-none" onchange="this.form.submit()">
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-actions mt-4">
                            <div class="text-right">
                                <button type="submit" id="finalisasiBtn" class="btn btn-info" {{ !$all_uploaded ? 'disabled' : '' }}>
                                    Finalisasi Pengajuan
                                </button>
                                <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-dark">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    const judulInput = $('#judul_laporan_pkl');
    const dosenSelect = $('#dosen_pembimbing_id');
    let timer;

    function showSaveStatus(element, message, isSuccess) {
        const statusElement = element.next('small');
        statusElement.text(message).css('color', isSuccess ? 'green' : 'red').fadeIn();
        setTimeout(() => statusElement.fadeOut(), 3000);
    }

    function autoSave(element, fieldName, value) {
        const url = element.data('url');
        clearTimeout(timer);
        timer = setTimeout(() => {
            element.next('small').text('Menyimpan...').css('color', 'orange').fadeIn();
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PATCH', // Menggunakan PATCH untuk update
                    field: fieldName,
                    value: value
                },
                success: function(response) {
                    showSaveStatus(element, 'Perubahan berhasil disimpan!', true);
                },
                error: function() {
                    showSaveStatus(element, 'Gagal menyimpan perubahan.', false);
                }
            });
        }, 1000); // Delay 1 detik sebelum menyimpan
    }

    judulInput.on('keyup', function() {
        autoSave($(this), 'judul_laporan_pkl', $(this).val());
    });

    dosenSelect.on('change', function() {
        autoSave($(this), 'dosen_pembimbing_id', $(this).val());
    });

    // Cek kondisi tombol finalisasi saat halaman dimuat
    const allUploaded = {{ $all_uploaded ? 'true' : 'false' }};
    if (allUploaded) {
        $('#finalisasiBtn').prop('disabled', false).attr('title', 'Anda dapat memfinalisasi pengajuan');
    } else {
        $('#finalisasiBtn').prop('disabled', true).attr('title', 'Harap lengkapi semua judul, dosen, dan dokumen terlebih dahulu');
    }
});
</script>
@endpush
@endsection
