{{-- resources/views/auth/password_reset_success_project.blade.php --}}

@extends('layouts.auth_layout') {{-- Menggunakan layout autentikasi baru --}}

@section('title', 'Sandi Berhasil Diubah - SIPRAKTA')

@section('content')
<div class="success-container"> {{-- Ini adalah div utama dari reset-success_contoh.html --}}
    <div class="logo-container">
        {{-- Pastikan path gambar benar: public/assets/images/sipraktablue2.png --}}
        <img src="{{ asset('assets/images/sipraktablue2.png') }}" alt="Logo SIPRAKTA" class="logo-img">
    </div>
    
    {{-- Pastikan path icon benar: public/assets/icons/success-icon.png --}}
    <img src="{{ asset('assets/icons/success-icon.png') }}" alt="Success" class="success-icon">
    <h2>Sandi Berhasil Diubah!</h2>

    <p>Password akun Anda telah berhasil diubah. Sekarang Anda bisa login menggunakan password baru Anda.</p>
    
    {{-- Tombol kembali ke login, menggunakan kelas dari reset-success_contoh.html --}}
    <a href="{{ route('mahasiswa.login') }}" class="back-button">Kembali ke Halaman Login</a>

    <div class="footer">
        <p>Copyright &copy; 2024 Tim SIPRAKTA</p>
        <p>Politeknik Negeri Padang</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Jika Anda ingin modal muncul saat halaman ini dimuat (misal dari redirect setelah reset)
        @if (session('success_message'))
            // Tampilkan modal sukses, lalu redirect ke halaman login
            window.showSuccessModal("{{ session('success_message') }}", "{{ route('mahasiswa.login.form') }}");
        @endif
    });
</script>
@endpush