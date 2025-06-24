@extends('layouts.mahasiswa') {{-- Assuming your layout file is resources/views/layouts/mahasiswa.blade.php --}}

@section('title', 'Ubah Sandi') {{-- Sets the title for this page --}}

@section('page_title', 'Ubah Sandi') {{-- Sets the dynamic page title in the header --}}

@section('content')
    <div class="password-change-card">
        <div class="card-header">Ubah Sandi Anda</div>

        {{-- Pesan Sukses atau Error dari Laravel --}}
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="passwordForm" action="{{ route('mahasiswa.password.change') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="current_password">Sandi Saat Ini</label>
                <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
            </div>

            <div class="form-group">
                <label for="new_password">Sandi Baru</label>
                <input type="password" id="new_password" name="new_password" required autocomplete="new-password">
                <div class="password-strength-indicator">
                    <div class="strength-meter" id="strengthMeter"></div>
                </div>
                <div class="strength-text" id="strengthText"></div>
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Konfirmasi Sandi Baru</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required autocomplete="new-password">
                <div class="password-match-message" id="passwordMatchMessage"></div>
            </div>
            
            <div class="text-center" style="margin-top: 15px;">
                <a href="{{ route('mahasiswa.forgot.password.form') }}" class="forgot-password-link">Lupa kata sandi saat ini?</a>
            </div>

            <button type="submit" class="btn-primary">Ubah Sandi</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Password Strength and Match Logic
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('new_password_confirmation');
        const strengthMeter = document.getElementById('strengthMeter');
        const strengthText = document.getElementById('strengthText');
        const passwordMatchMessage = document.getElementById('passwordMatchMessage');

        if (newPasswordInput && confirmPasswordInput && strengthMeter && strengthText && passwordMatchMessage) {
            newPasswordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;

                // Length
                if (password.length >= 8) strength += 1;
                // Uppercase and lowercase
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 1;
                // Numbers
                if (/\d/.test(password)) strength += 1;
                // Special characters
                if (/[^A-Za-z0-9]/.test(password)) strength += 1;

                let meterColor = '';
                let meterWidth = 0;
                let text = '';

                if (password.length === 0) {
                    meterWidth = 0;
                    meterColor = 'transparent';
                    text = '';
                    strengthText.style.display = 'none';
                } else if (strength < 2) {
                    meterWidth = 30;
                    meterColor = '#dc3545'; /* Danger */
                    text = 'Sangat Lemah';
                    strengthText.style.color = '#dc3545';
                    strengthText.style.display = 'block';
                } else if (strength === 2) {
                    meterWidth = 60;
                    meterColor = '#ffc107'; /* Warning */
                    text = 'Cukup Kuat';
                    strengthText.style.color = '#ffc107';
                    strengthText.style.display = 'block';
                } else {
                    meterWidth = 100;
                    meterColor = '#198754'; /* Success */
                    text = 'Sangat Kuat';
                    strengthText.style.color = '#198754';
                    strengthText.style.display = 'block';
                }

                strengthMeter.style.width = meterWidth + '%';
                strengthMeter.style.backgroundColor = meterColor;
                strengthText.textContent = text;

                checkPasswordMatch();
            });

            confirmPasswordInput.addEventListener('input', checkPasswordMatch);

            function checkPasswordMatch() {
                const newPass = newPasswordInput.value;
                const confirmPass = confirmPasswordInput.value;

                if (confirmPass.length === 0) {
                    passwordMatchMessage.style.display = 'none';
                    return;
                }

                passwordMatchMessage.style.display = 'block';
                if (newPass === confirmPass) {
                    passwordMatchMessage.textContent = 'Kata sandi cocok';
                    passwordMatchMessage.style.color = '#38a169'; // Green color for match
                } else {
                    passwordMatchMessage.textContent = 'Kata sandi tidak cocok';
                    passwordMatchMessage.style.color = '#e53e3e'; // Red color for no match
                }
            }

            // Form submission client-side validation
            document.getElementById('passwordForm').addEventListener('submit', function(e) {
                const newPass = newPasswordInput.value;
                const confirmPass = confirmPasswordInput.value;

                if (newPass !== confirmPass) {
                    e.preventDefault();
                    alert('Konfirmasi kata sandi tidak cocok!');
                    return;
                }

                if (newPass.length < 8) {
                    e.preventDefault();
                    alert('Kata sandi baru harus minimal 8 karakter');
                    return;
                }
            });
        }
    </script>
@endpush