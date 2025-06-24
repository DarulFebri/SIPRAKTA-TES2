<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Peran Login - SIPRAKTA</title>
    {{-- Menggunakan auth_styles.css untuk body background, font, dan partikel --}}
    <link rel="stylesheet" href="{{ asset('css/auth_styles.css') }}">
    {{-- Font Awesome (jika diperlukan untuk ikon kartu di masa depan) --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> --}}

    {{-- Gaya khusus untuk halaman Pilih Peran Login, diletakkan setelah auth_styles.css --}}
    <style>
        /* Variabel CSS bisa dipertahankan jika ingin spesifik di sini */
        :root {
            --primary-blue: #007bff;
            --dark-blue: #0056b3;
            /* Menggunakan warna ini sebagai referensi, bisa juga langsung nilai hex */
            --light-blue-bg-custom: #E0F2F7; /* Biru muda kustom untuk container */ 
            --white: #ffffff;
            --light-grey: #f8f9fa;
            --medium-grey: #dee2e6;
            --dark-grey: #495057;
            --text-color: #343a40;
            --border-color: #e9ecef; /* disesuaikan dari user's original */
            --error-color: #dc3545;
            --shadow-medium: 0 5px 15px rgba(0,0,0,0.05); /* disesuaikan dari user's original */
            --border-radius: 10px; /* disesuaikan dari user's original */
        }

        .container {
            max-width: 900px;
            padding: 40px;
            text-align: center;
            position: relative; /* Penting untuk z-index di atas partikel */
            z-index: 1; /* Pastikan konten di atas partikel */
            
            /* ---- PERUBAHAN DI SINI ---- */
            background-color: var(--light-blue-bg-custom); /* Warna biru muda untuk container */
            border-radius: var(--border-radius); /* Menggunakan border-radius dari root */
            box-shadow: var(--shadow-medium); /* Menggunakan shadow dari root */
            /* --------------------------- */
        }
        h1 {
            color: #212529;
            margin-bottom: 50px;
            font-size: 2.8em;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .role-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px; /* Space between cards */
        }
        .role-card {
            background-color: var(--white);
            border: 1px solid var(--border-color); /* Light border */
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-medium);
            padding: 30px;
            width: 200px; /* Fixed width for cards */
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            position: relative;
            overflow: hidden; /* For accent line */
        }
        .role-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-blue); /* Highlight border on hover */
        }
        .role-card .icon-wrapper {
            font-size: 3.5em;
            margin-bottom: 20px;
            color: var(--primary-blue); /* Default icon color */
            transition: color 0.3s ease;
        }
        .role-card:hover .icon-wrapper {
            color: var(--dark-blue); /* Darker blue on hover */
        }
        .role-card h2 {
            font-size: 1.5em;
            margin: 0;
            color: var(--text-color);
            font-weight: 500;
        }

        /* Specific accent colors for each role card */
        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px; /* Thin line at the top */
            background-color: transparent; /* Default transparent */
            transition: background-color 0.3s ease;
        }

        .role-card.admin::before { background-color: #dc3545; }
        .role-card.mahasiswa::before { background-color: #28a745; }
        .role-card.kaprodi::before { background-color: #ffc107; }
        .role-card.kajur::before { background-color: #6f42c1; }
        .role-card.dosen::before { background-color: #17a2b8; }

        /* Specific icon colors if desired */
        .role-card.admin .icon-wrapper { color: #dc3545; }
        .role-card.mahasiswa .icon-wrapper { color: #28a745; }
        .role-card.kaprodi .icon-wrapper { color: #ffc107; }
        .role-card.kajur .icon-wrapper { color: #6f42c1; }
        .role-card.dosen .icon-wrapper { color: #17a2b8; }
    </style>
</head>
<body>
    {{-- Animated book particles (sesuai dari auth_layout.blade.php) --}}
    <div class="book-particle"></div>
    <div class="book-particle"></div>
    <div class="book-particle"></div>
    <div class="book-particle"></div>
    <div class="book-particle"></div>
    <div class="book-particle"></div>
    <div class="book-particle"></div> 
    <div class="book-particle"></div> 
    <div class="book-particle"></div> 
    <div class="book-particle"></div> 

    <div class="container">
        <h1>Login Sebagai</h1>

        <div class="role-cards">
            <a href="{{ route('admin.login') }}" class="role-card admin">
                <div class="icon-wrapper">
                    &#128081; </div>
                <h2>Admin</h2>
            </a>

            <a href="{{ route('mahasiswa.login') }}" class="role-card mahasiswa">
                <div class="icon-wrapper">
                    &#127891; </div>
                <h2>Mahasiswa</h2>
            </a>

            <a href="{{ route('kaprodi.login') }}" class="role-card kaprodi">
                <div class="icon-wrapper">
                    &#128104;&#8205;&#127891; </div>
                <h2>Kaprodi</h2>
            </a>

            <a href="{{ route('kajur.login') }}" class="role-card kajur">
                <div class="icon-wrapper">
                    &#128188; </div>
                <h2>Kajur</h2>
            </a>

            <a href="{{ route('dosen.login') }}" class="role-card dosen">
                <div class="icon-wrapper">
                    &#128104;&#8205;&#128187; </div>
                <h2>Dosen</h2>
            </a>
        </div>
    </div>
</body>
</html>