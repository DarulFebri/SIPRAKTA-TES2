<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPRAKTA - Autentikasi')</title>

    {{-- Link CSS umum untuk tampilan otentikasi --}}
    {{-- PASTIKAN TIDAK ADA LINK BOOTSTRAP DI SINI JIKA INGIN MENGGUNAKAN GAYA DARI _CONTOH --}}
    <link rel="stylesheet" href="{{ asset('css/auth_styles.css') }}">
    
    @stack('styles')
</head>
<body>
    {{-- Animated book particles --}}
    <div class="book-particle"></div>
    <div class="book-particle"></div>
    <div class="book-particle"></div>
    <div class="book-particle"></div>
    <div class="book-particle"></div>
    <div class="book-particle"></div>
    <div class="book-particle"></div> {{-- Partikel tambahan --}}
    <div class="book-particle"></div> {{-- Partikel tambahan --}}
    <div class="book-particle"></div> {{-- Partikel tambahan --}}
    <div class="book-particle"></div> {{-- Partikel tambahan --}}

    @yield('content')

    {{-- Modal Popups (Success/Error) - Ini bisa dipindahkan ke sini jika ingin seragam --}}
    <div id="modal" class="modal-overlay">
        <div class="modal-content">
            {{-- <div class="modal-header"> --}}
                {{-- <span class="modal-close-button" id="successModalClose">&times;</span> --}}
            {{-- </div> --}}
            <div class="modal-body">
                <div id="loader" class="loader"></div>
                {{-- Pastikan path icon benar --}}
                <img src="{{ asset('assets/icons/success-icon.png') }}" alt="Success" class="icon" id="success-icon" style="display: none;">
                <p id="modal-message"></p>
            </div>
        </div>
    </div>

    <div id="errorModal" class="modal-overlay">
        <div class="modal-content">
            {{-- <div class="modal-header"> --}}
                {{-- <span class="modal-close-button" id="errorModalClose">&times;</span> --}}
            {{-- </div> --}}
            <div class="modal-body">
                {{-- Pastikan path icon benar --}}
                <img src="{{ asset('assets/icons/error-icon.png') }}" alt="Error" class="icon" id="error-icon" style="display: none;">
                <p id="error-modal-message"></p>
            </div>
        </div>
    </div>

    {{-- Script JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global function to hide error messages on input
            document.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', function() {
                    const errorSpan = this.closest('.input-group') ? this.closest('.input-group').querySelector('.error-message') : null;
                    if (errorSpan) {
                        errorSpan.style.display = 'none';
                    }
                    // Juga untuk pesan error Laravel yang pakai is-invalid
                    this.classList.remove('is-invalid');
                    const invalidFeedback = this.nextElementSibling;
                    if (invalidFeedback && invalidFeedback.classList.contains('invalid-feedback')) {
                        invalidFeedback.style.display = 'none';
                    }
                });
            });

            // Handle session status/error messages from Laravel
            const alertSuccess = document.querySelector('.alert-success');
            const alertDanger = document.querySelector('.alert-danger');

            if (alertSuccess) {
                setTimeout(() => {
                    alertSuccess.style.display = 'none';
                }, 5000); // Hide success alert after 5 seconds
            }
            if (alertDanger) {
                setTimeout(() => {
                    alertDanger.style.display = 'none';
                }, 5000); // Hide danger alert after 5 seconds
            }

            // Implementasi untuk Modal (pop-up)
            const modal = document.getElementById('modal');
            const errorModal = document.getElementById('errorModal');
            const loader = document.getElementById('loader');
            const successIcon = document.getElementById('success-icon');
            const errorIcon = document.getElementById('error-icon');
            const modalMessage = document.getElementById('modal-message');
            const errorModalMessage = document.getElementById('error-modal-message');

            // Global function to show success modal
            window.showSuccessModal = function(message, redirectUrl = null) {
                modalMessage.textContent = message;
                loader.style.display = 'block';
                successIcon.style.display = 'none';
                modal.style.display = 'flex';

                setTimeout(() => {
                    loader.style.display = 'none';
                    successIcon.style.display = 'block';
                    if (redirectUrl) {
                        setTimeout(() => {
                            window.location.href = redirectUrl;
                        }, 1000); // Redirect after icon shows
                    } else {
                        // If no redirect, just show success for a bit and then hide
                        setTimeout(() => {
                            modal.style.display = 'none';
                        }, 2000);
                    }
                }, 1500); // Loader visible for 1.5 seconds
            };

            // Global function to show error modal
            window.showErrorModal = function(message) {
                errorModalMessage.textContent = message;
                errorIcon.style.display = 'block';
                errorModal.style.display = 'flex';
                setTimeout(() => {
                    errorModal.style.display = 'none';
                }, 3000); // Hide error modal after 3 seconds
            };

            // Event listener for modal close buttons (if you decide to have them)
            // const successModalClose = document.getElementById('successModalClose');
            // if (successModalClose) {
            //     successModalClose.addEventListener('click', () => modal.style.display = 'none');
            // }
            // const errorModalClose = document.getElementById('errorModalClose');
            // if (errorModalClose) {
            //     errorModalClose.addEventListener('click', () => errorModal.style.display = 'none');
            // }
        });
    </script>
    @stack('scripts')
</body>
</html>