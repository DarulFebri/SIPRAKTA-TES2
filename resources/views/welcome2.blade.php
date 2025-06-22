<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 13 - Selamat Datang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1f2937 0%, #111827 50%, #0f172a 100%);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            transition: all 0.3s ease;
        }
        .animate-pulse-slow {
            animation: pulse 3s infinite;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        .dark-card {
            background: linear-gradient(145deg, #374151, #1f2937);
            border: 1px solid #4b5563;
        }
        .glow-effect {
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
        }
    </style>
</head>
<body class="h-full bg-gray-900 text-white">
    <!-- Navigation -->
    <nav class="bg-gray-800 shadow-xl fixed w-full z-50 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-code text-2xl text-red-500 mr-2"></i>
                        <span class="text-xl font-bold text-white">Laravel 13</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#dokumentasi" class="text-gray-300 hover:text-red-400 px-3 py-2 rounded-md text-sm font-medium transition">Dokumentasi</a>
                    <a href="#fitur" class="text-gray-300 hover:text-red-400 px-3 py-2 rounded-md text-sm font-medium transition">Fitur</a>
                    <a href="#komunitas" class="text-gray-300 hover:text-red-400 px-3 py-2 rounded-md text-sm font-medium transition">Komunitas</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="gradient-bg min-h-screen flex items-center justify-center pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="fade-in-up">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Selamat Datang di
                    <span class="text-red-400 animate-pulse-slow">Laravel 13</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto">
                    Framework PHP yang elegan dengan sintaks ekspresif. Mari kita buat sesuatu yang luar biasa bersama-sama!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition transform hover:scale-105 glow-effect">
                        <i class="fas fa-rocket mr-2"></i>
                        Mulai Sekarang
                    </button>
                    <button class="bg-transparent border-2 border-gray-400 text-gray-300 hover:bg-gray-700 hover:border-red-400 hover:text-white font-bold py-3 px-8 rounded-lg text-lg transition">
                        <i class="fas fa-book mr-2"></i>
                        Pelajari Lebih Lanjut
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="py-16 bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div class="fade-in-up">
                    <div class="text-4xl font-bold text-red-400 mb-2">10M+</div>
                    <div class="text-gray-400">Developer Aktif</div>
                </div>
                <div class="fade-in-up">
                    <div class="text-4xl font-bold text-red-400 mb-2">500K+</div>
                    <div class="text-gray-400">Proyek Laravel</div>
                </div>
                <div class="fade-in-up">
                    <div class="text-4xl font-bold text-red-400 mb-2">99.9%</div>
                    <div class="text-gray-400">Uptime</div>
                </div>
                <div class="fade-in-up">
                    <div class="text-4xl font-bold text-red-400 mb-2">24/7</div>
                    <div class="text-gray-400">Dukungan Komunitas</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="fitur" class="py-16 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Mengapa Laravel 13?</h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">Fitur-fitur powerful yang membuat pengembangan web menjadi lebih mudah dan menyenangkan</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="dark-card p-6 rounded-xl shadow-2xl card-hover">
                    <div class="bg-red-900 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-bolt text-red-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Performa Tinggi</h3>
                    <p class="text-gray-400">Optimasi terbaru dengan cache yang cerdas dan query builder yang efisien</p>
                </div>
                
                <div class="dark-card p-6 rounded-xl shadow-2xl card-hover">
                    <div class="bg-blue-900 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-blue-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Keamanan Terdepan</h3>
                    <p class="text-gray-400">Built-in security features untuk melindungi aplikasi dari berbagai ancaman</p>
                </div>
                
                <div class="dark-card p-6 rounded-xl shadow-2xl card-hover">
                    <div class="bg-green-900 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-code text-green-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Sintaks Elegan</h3>
                    <p class="text-gray-400">Kode yang bersih dan mudah dibaca dengan sintaks yang ekspresif</p>
                </div>
                
                <div class="dark-card p-6 rounded-xl shadow-2xl card-hover">
                    <div class="bg-purple-900 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-database text-purple-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Eloquent ORM</h3>
                    <p class="text-gray-400">Object-Relational Mapping yang powerful dan mudah digunakan</p>
                </div>
                
                <div class="dark-card p-6 rounded-xl shadow-2xl card-hover">
                    <div class="bg-yellow-900 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-tools text-yellow-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Artisan CLI</h3>
                    <p class="text-gray-400">Command line interface yang powerful untuk mempercepat development</p>
                </div>
                
                <div class="dark-card p-6 rounded-xl shadow-2xl card-hover">
                    <div class="bg-indigo-900 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-users text-indigo-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Komunitas Besar</h3>
                    <p class="text-gray-400">Dukungan komunitas global dengan ribuan package dan tutorial</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Start Section -->
    <div id="dokumentasi" class="py-16 bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Mulai dalam 3 Langkah</h2>
                <p class="text-xl text-gray-400">Setup Laravel 13 hanya dalam beberapa menit</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-red-900 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-2xl font-bold text-red-400">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Install Laravel</h3>
                    <div class="bg-gray-900 border border-gray-600 p-4 rounded-lg text-left">
                        <code class="text-sm text-green-400">composer create-project laravel/laravel my-app</code>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="bg-blue-900 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-2xl font-bold text-blue-400">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Konfigurasi</h3>
                    <div class="bg-gray-900 border border-gray-600 p-4 rounded-lg text-left">
                        <code class="text-sm text-green-400">cp .env.example .env<br>php artisan key:generate</code>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-900 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-2xl font-bold text-green-400">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Jalankan Server</h3>
                    <div class="bg-gray-900 border border-gray-600 p-4 rounded-lg text-left">
                        <code class="text-sm text-green-400">php artisan serve</code>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Community Section -->
    <div id="komunitas" class="py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Bergabung dengan Komunitas</h2>
            <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
                Terhubung dengan developer Laravel dari seluruh dunia
            </p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <a href="#" class="bg-gray-800 hover:bg-gray-700 border border-gray-600 p-6 rounded-lg transition hover:border-red-500">
                    <i class="fab fa-github text-3xl text-white mb-2 hover:text-red-400"></i>
                    <div class="text-white font-semibold">GitHub</div>
                </a>
                <a href="#" class="bg-gray-800 hover:bg-gray-700 border border-gray-600 p-6 rounded-lg transition hover:border-red-500">
                    <i class="fab fa-discord text-3xl text-white mb-2 hover:text-red-400"></i>
                    <div class="text-white font-semibold">Discord</div>
                </a>
                <a href="#" class="bg-gray-800 hover:bg-gray-700 border border-gray-600 p-6 rounded-lg transition hover:border-red-500">
                    <i class="fab fa-twitter text-3xl text-white mb-2 hover:text-red-400"></i>
                    <div class="text-white font-semibold">Twitter</div>
                </a>
                <a href="#" class="bg-gray-800 hover:bg-gray-700 border border-gray-600 p-6 rounded-lg transition hover:border-red-500">
                    <i class="fas fa-comments text-3xl text-white mb-2 hover:text-red-400"></i>
                    <div class="text-white font-semibold">Forum</div>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-700 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <i class="fas fa-code text-2xl text-red-500 mr-2"></i>
                    <span class="text-xl font-bold text-white">Laravel 13</span>
                </div>
                <div class="text-gray-400 text-center md:text-right">
                    <p>&copy; 2025 Laravel. Made with <i class="fas fa-heart text-red-500"></i> for developers worldwide.</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                }
            });
        }, observerOptions);

        // Observe all cards and sections
        document.querySelectorAll('.card-hover, .fade-in-up').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>