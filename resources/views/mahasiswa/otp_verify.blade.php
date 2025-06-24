{{-- resources/views/auth/otp_verify_project.blade.php --}}

@extends('layouts.auth_layout') {{-- Menggunakan layout autentikasi baru --}}

@section('title', 'Verifikasi OTP Mahasiswa - SIPRAKTA')

@section('content')
<div class="otp-container"> {{-- Ini adalah div utama dari otp-verification_contoh.html --}}
    <div class="header">
        <h2>Verifikasi Kode OTP</h2>
        <p>Kami telah mengirimkan kode OTP ke email Anda (<strong>{{ $email ?? 'Tidak diketahui' }}</strong>). Silakan masukkan kode tersebut di bawah ini.</p>
    </div>

    {{-- Menampilkan pesan session dari Laravel --}}
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

    <form method="POST" action="{{ route('mahasiswa.otp.verify') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="input-group otp-input-group"> {{-- Menggunakan otp-input-group untuk layout OTP --}}
            {{-- Buat 6 input terpisah jika Anda ingin efek input per digit --}}
            {{-- Atau satu input tunggal jika hanya butuh 1 field --}}
            {{-- Contoh dengan satu input: --}}
            <input type="text" id="otp" name="otp" class="otp-input" required maxlength="6" value="{{ old('otp') }}" placeholder="______">
            @error('otp')
                <span class="error-message">{{ $message }}</span>
            @enderror
            {{-- Jika Anda ingin input per digit, ubah menjadi seperti ini: --}}
            {{--
            <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" onkeyup="moveToNext(this, 'otp2')">
            <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" id="otp2" onkeyup="moveToNext(this, 'otp3')">
            ...dst
            --}}
        </div>
        
        {{-- Timer --}}
        <div class="timer">Kode akan kedaluwarsa dalam <span id="countdown">02:00</span></div>

        {{-- Tombol submit, menggunakan kelas dari otp-verification_contoh.html --}}
        <button type="submit" class="action-button">Verifikasi OTP</button>
    </form>

    <div class="resend-otp">
        <p>Tidak menerima kode?</p>
        <form method="POST" action="{{ route('mahasiswa.otp.resend') }}" style="display:inline;">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="resend-button" id="resendOtpButton">Kirim Ulang OTP</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countdownElement = document.getElementById('countdown');
        const resendOtpButton = document.getElementById('resendOtpButton');
        let timeLeft = 120; // 2 minutes

        function updateCountdown() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            countdownElement.textContent = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                resendOtpButton.disabled = false; // Aktifkan tombol resend
                resendOtpButton.style.opacity = '1';
                resendOtpButton.style.cursor = 'pointer';
            } else {
                timeLeft--;
            }
        }

        let timerInterval = setInterval(updateCountdown, 1000);
        updateCountdown(); // Call once immediately to display initial time

        resendOtpButton.disabled = true; // Non-aktifkan tombol saat pertama kali load
        resendOtpButton.style.opacity = '0.5';
        resendOtpButton.style.cursor = 'not-allowed';

        resendOtpButton.addEventListener('click', function(e) {
            // Mencegah form submit default jika tombol masih disabled
            if (this.disabled) {
                e.preventDefault();
                return;
            }

            e.preventDefault(); // Mencegah submit form untuk sementara
            
            // Tampilkan loader modal (jika Anda ingin ada popup saat resend)
            // window.showSuccessModal('Mengirim ulang kode OTP...', null); // Pesan akan diganti oleh server response

            // Kirim ulang OTP menggunakan AJAX atau form submit biasa
            const resendForm = this.closest('form');
            if (resendForm) {
                resendForm.submit(); // Biarkan Laravel menangani resend dan redirect/flash message
            }

            // Setelah resend, reset timer dan nonaktifkan tombol lagi
            // Ini akan dieksekusi setelah halaman refresh atau jika AJAX berhasil
            // Jika Anda menggunakan AJAX untuk resend, uncomment ini:
            /*
            timeLeft = 120;
            resendOtpButton.disabled = true;
            resendOtpButton.style.opacity = '0.5';
            resendOtpButton.style.cursor = 'not-allowed';
            clearInterval(timerInterval);
            timerInterval = setInterval(updateCountdown, 1000);
            updateCountdown();
            */
        });

        // Contoh bagaimana memicu modal jika ada pesan sukses/error dari session Laravel
        @if (session('success'))
            window.showSuccessModal("{{ session('success') }}");
        @endif
        @if (session('error'))
            window.showErrorModal("{{ session('error') }}");
        @endif
    });
</script>
@endpush