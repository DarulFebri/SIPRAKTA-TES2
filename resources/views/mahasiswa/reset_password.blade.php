{{-- resources/views/auth/atur_katasandi_project.blade.php --}}

@extends('layouts.auth_layout') {{-- Menggunakan layout autentikasi baru --}}

@section('title', 'Atur Ulang Sandi Mahasiswa - SIPRAKTA')

@section('content')
<div class="reset-container"> {{-- Ini adalah div utama dari atur-ulang-sandi_contoh.html --}}
    <div class="header">
        {{-- Jika Anda ingin logo di sini seperti di reset-success_contoh.html --}}
        {{-- <img src="{{ asset('assets/images/sipraktablue2.png') }}" alt="Logo SIPRAKTA" class="logo-img"> --}}
        <h2>Atur Ulang Sandi Anda</h2>
    </div>

    {{-- Menampilkan pesan session dari Laravel --}}
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

    <form method="POST" action="{{ route('mahasiswa.password.reset') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="input-group"> {{-- Kelas dari atur-ulang-sandi_contoh.html --}}
            <label for="password">Password Baru</label>
            <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required autocomplete="new-password">
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ketik ulang password baru" required autocomplete="new-password">
            {{-- Laravel akan menangani validasi konfirmasi, pesan error di sini akan muncul jika tidak cocok --}}
            @error('password_confirmation')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        {{-- Tombol submit, menggunakan kelas dari atur-ulang-sandi_contoh.html --}}
        <button type="submit" class="action-button" id="resetPasswordButton">Ubah Sandi</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const newPassword = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const form = document.querySelector('.reset-container form');

        form.addEventListener('submit', function(e) {
            // Client-side validation seperti di atur-ulang-sandi_contoh.html
            // Laravel akan melakukan validasi server-side juga
            if (newPassword.value.length < 8) {
                e.preventDefault(); // Mencegah submit
                window.showErrorModal('Sandi baru harus minimal 8 karakter.');
                newPassword.focus();
                return;
            }
            if (newPassword.value !== confirmPassword.value) {
                e.preventDefault(); // Mencegah submit
                window.showErrorModal('Password baru dan konfirmasi password tidak cocok.');
                confirmPassword.focus();
                return;
            }
        });

        // Trigger success modal if Laravel returns success session
        @if (session('status'))
            // Langsung arahkan ke halaman sukses setelah modal muncul
            window.showSuccessModal("{{ session('status') }}", "{{ route('mahasiswa.password.reset.success') }}");
        @endif
        // Trigger error modal if Laravel returns error session (selain validasi form)
        @if (session('error'))
            window.showErrorModal("{{ session('error') }}");
        @endif
    });
</script>
@endpush