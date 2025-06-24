@extends('layouts.auth_layout') {{-- Menggunakan layout autentikasi baru --}}

@section('title', 'Login Mahasiswa - SIPRAKTA')

@section('content')
<div class="login-container"> {{-- Ini adalah div utama dari logincontoh.html --}}
    <div class="header">
        {{-- Pastikan path gambar benar, mungkin Anda perlu memindahkan gambar ke public/assets/images --}}
        <img src="{{ asset('assets/images/sipraktablue2.png') }}" alt="Logo SIPRAKTA" class="logo-img">
        <h2>Login Mahasiswa</h2>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('mahasiswa.login') }}">
        @csrf
        <div class="input-group"> {{-- Sesuaikan dengan class dari logincontoh.html --}}
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan alamat email" required autofocus>
            {{-- Pesan error Laravel, ubah kelasnya agar sesuai dengan CSS kita --}}
            @error('email')
                <span class="error-message">{{ $message }}</span> 
            @enderror
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        {{-- Tombol login, sesuaikan kelasnya --}}
        <button type="submit" class="login-button">Login</button> 
        <a href="{{ route('mahasiswa.forgot.password.form') }}" class="forgot-password">Lupa Sandi?</a>
    </form>
</div>
@endsection

{{-- Jika ada JavaScript yang SANGAT spesifik untuk halaman ini, letakkan di @push('scripts') --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logika JavaScript dari logincontoh.html yang relevan, seperti validasi sisi klien yang sederhana
        // Karena Laravel sudah menangani validasi sisi server, Anda bisa fokus pada efek UI saja.
        // Contoh: hilangkan pesan error saat mengetik (sudah di layout, tapi bisa override)
        
        // Contoh untuk menangani jika Anda ingin modal muncul setelah login
        // Misalnya, jika login berhasil secara AJAX (bukan redirect langsung Laravel)
        // if (someConditionForSuccess) {
        //    window.showSuccessModal("Login berhasil!", "{{ route('mahasiswa.dashboard') }}");
        // }
    });
</script>
@endpush