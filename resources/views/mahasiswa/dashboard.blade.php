@extends('layouts.mahasiswa')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    <div class="welcome-box" style="animation-delay: 0.1s;">
        <h2 class="welcome-title">
            <i class="fas fa-hands-helping" style="margin-right: 10px;"></i>
            Selamat Datang di SIPRAKTA
        </h2>
        <p>
            Sistem Informasi Praktek Kerja Lapangan dan Tugas Akhir - Politeknik Negeri Padang
        </p>
    </div>

    <div class="card-container">
        <a href="{{ route('mahasiswa.profile.edit') }}" class="card-link">
            <div class="card clickable-card medium">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="card-title">
                    Data Mahasiswa
                </h3>
            </div>
        </a>

        <a href="{{ route('mahasiswa.pengajuan.index') }}" class="card-link">
            <div class="card clickable-card medium">
                <div class="card-icon">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h3 class="card-title">
                    Sidang PKL
                </h3>
            </div>
        </a>

        <a href="#" class="card-link">
            <div class="card clickable-card medium">
                <div class="card-icon">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h3 class="card-title">
                    Sidang TA
                </h3>
            </div>
        </a>

        <a href="#" class="card-link">
            <div class="card clickable-card medium">
                <div class="card-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <h3 class="card-title">
                    Notifikasi
                </h3>
            </div>
        </a>
    </div>

    <div class="section-header">
        <div>
            <h2 class="section-title">
                <i class="fas fa-history"></i>
                Pengajuan Terbaru
            </h2>
            <p style="color: var(--text-color); opacity: 0.8; margin-top: 5px;">
                Ringkasan pengajuan PKL/TA terbaru Anda.
            </p>
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Jenis Pengajuan</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Assuming $pengajuanTerbaru is passed from your controller --}}
                @forelse($pengajuanTerbaru as $pengajuan)
                    <tr>
                        <td>{{ $pengajuan->jenis_pengajuan }}</td>
                        <td><span class="status-badge {{ $pengajuan->status == 'disetujui' ? 'status-active' : 'status-inactive' }}">{{ ucfirst($pengajuan->status) }}</span></td>
                        <td>{{ $pengajuan->created_at->format('d M Y') }}</td>
                        <td class="action-cell">
                            <a href="{{ route('mahasiswa.pengajuan.show', $pengajuan->id) }}" class="action-icon view-icon" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px;">Belum ada pengajuan terbaru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection