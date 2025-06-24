{{-- resources/views/auth/forgot_password_project.blade.php --}}

@extends('layouts.auth_layout') {{-- Menggunakan layout autentikasi baru --}}

@section('title', 'Lupa Sandi Mahasiswa - SIPRAKTA')

@section('content')
<div class="login-container"> {{-- Menggunakan kelas kontainer yang sama dengan logincontoh.html --}}
    <div class="header">
        {{-- Anda bisa menambahkan logo di sini jika ingin konsisten dengan halaman login --}}
        {{-- <img src="{{ asset('assets/images/sipraktablue2.png') }}" alt="Logo SIPRAKTA" class="logo-img"> --}}
        <h2>Lupa Sandi Mahasiswa</h2>
        {{-- Anda bisa menambahkan paragraf deskripsi seperti di otp_verify_project.blade.php jika diperlukan --}}
        {{-- <p>Masukkan alamat email Anda untuk mengirimkan kode OTP verifikasi.</p> --}}
    </div>

    {{-- Menampilkan pesan session dari Laravel --}}
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('mahasiswa.send.reset.otp') }}">
        @csrf
        <div class="input-group"> {{-- Menggunakan kelas dari auth_styles.css --}}
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan alamat email Anda" required autofocus>
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        {{-- Tombol submit, menggunakan kelas dari auth_styles.css --}}
        <button type="submit" class="action-button">Kirim Kode OTP</button>
    </form>
    <div class="back-to-login">
        {{-- Menggunakan kelas yang mirip dengan forgot-password atau bisa dibuat kelas baru jika stylingnya berbeda --}}
        <a href="{{ route('mahasiswa.login') }}" class="forgot-password">Kembali ke halaman login</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Implementasi untuk memicu modal jika ada pesan sukses dari session Laravel
        @if (session('status'))
            // Jika Anda ingin modal muncul saat request OTP berhasil
            window.showSuccessModal("{{ session('status') }}", "{{ route('mahasiswa.otp.form', ['email' => $email ?? '']) }}");
            // Atau cukup tampilkan alert seperti saat ini, tanpa modal
        @endif
        @if (session('success'))
            // Jika ada pesan sukses umum yang ingin ditampilkan dengan modal
            window.showSuccessModal("{{ session('success') }}");
        @endif
        @if (session('error'))
            // Jika ada pesan error umum yang ingin ditampilkan dengan modal
            window.showErrorModal("{{ session('error') }}");
        @endif
    });
</script>
@endpush