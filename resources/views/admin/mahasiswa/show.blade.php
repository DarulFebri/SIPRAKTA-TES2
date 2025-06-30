@extends('layouts.admin')

@section('title', 'Detail Mahasiswa')

@section('header_title', 'Detail Mahasiswa')

@section('content')
<div class="welcome-box" style="margin-top: 0;"> {{-- Re-using welcome-box for a card-like appearance --}}
    <h2 class="welcome-title" style="margin-bottom: 20px; text-align: center;">Detail Data Mahasiswa</h2>

    <div class="card-body"> {{-- Adding a div for card-like body content --}}
        <p class="detail-item"><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
        <p class="detail-item"><strong>Nama Lengkap:</strong> {{ $mahasiswa->nama_lengkap }}</p>
        <p class="detail-item"><strong>Jurusan:</strong> {{ $mahasiswa->jurusan }}</p>
        <p class="detail-item"><strong>Prodi:</strong> {{ $mahasiswa->prodi }}</p>
        <p class="detail-item"><strong>Jenis Kelamin:</strong> {{ $mahasiswa->jenis_kelamin }}</p>
        <p class="detail-item"><strong>Kelas:</strong> {{ $mahasiswa->kelas }}</p>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Mahasiswa
        </a>
    </div>
</div>
@endsection

@section('styles')
<style>
    .detail-item {
        font-size: 1.1rem;
        margin-bottom: 12px;
        padding-bottom: 5px;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
    }

    .detail-item strong {
        color: var(--primary-600);
        margin-right: 8px;
        min-width: 150px; /* Adjust as needed for alignment */
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        background-color: var(--primary-500);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(26, 136, 255, 0.2);
    }

    .btn-primary:hover {
        background-color: var(--primary-600);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(26, 136, 255, 0.3);
    }

    .btn-primary i {
        margin-right: 8px;
    }

    /* Adjusting welcome-box for direct content */
    .welcome-box {
        padding: 40px; /* More padding for a better look */
        max-width: 800px; /* Limit width for better readability */
        margin: 30px auto !important; /* Center the box and override default margin-top */
    }

    .card-body {
        padding: 20px;
        background-color: var(--light-gray);
        border-radius: 8px;
        border: 1px solid rgba(0,0,0,0.05);
    }
</style>
@endsection