<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen - SIPRAKTA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-100: #e6f2ff;
            --primary-200: #b3d7ff;
            --primary-300: #80bdff;
            --primary-400: #4da3ff;
            --primary-500: #1a88ff;
            --primary-600: #0066cc;
            --primary-700: #004d99;
            --sidebar-color: #1e3a8a;
            --text-color: #2d3748;
            --light-gray: #f8fafc;
            --white: #ffffff;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: var(--light-gray);
            color: var(--text-color);
            transition: var(--transition);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInLeft {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.03); }
            100% { transform: scale(1); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .loading-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .loading-spinner {
            border: 5px solid var(--primary-100);
            border-top: 5px solid var(--primary-600);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        /* Notification popup */
        .notification-popup {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            z-index: 2000;
            transform: translateX(120%);
            transition: transform 0.4s ease;
        }

        .notification-popup.show {
            transform: translateX(0);
        }

        .notification-popup.success {
            border-left: 4px solid #10b981;
        }

        .notification-popup.error {
            border-left: 4px solid #ef4444;
        }

        .notification-popup.info {
            border-left: 4px solid var(--primary-500);
        }

        .notification-icon {
            font-size: 22px;
            margin-right: 12px;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .notification-message {
            font-size: 14px;
            color: var(--text-color);
        }

        .notification-close {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
            margin-left: 15px;
            transition: color 0.3s;
        }

        .notification-close:hover {
            color: var(--primary-600);
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--sidebar-color), #172554);
            color: var(--white);
            padding: 20px 0;
            height: 100vh;
            position: fixed;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            z-index: 100;
            animation: slideInLeft 0.5s ease-out;
            transition: var(--transition);
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .logo-img {
            width: 40px;
            margin: 0 auto;
        }

        .sidebar.collapsed .menu-title,
        .sidebar.collapsed .menu-item span,
        .sidebar.collapsed .submenu {
            display: none;
        }

        .sidebar.collapsed .menu-item {
            justify-content: center;
            padding: 14px 0;
            margin: 5px 0;
        }

        .sidebar.collapsed .menu-item i {
            margin-right: 0;
            font-size: 20px;
        }

        .sidebar.collapsed .submenu-item {
            padding: 12px 0;
            justify-content: center;
        }

        .sidebar.collapsed .submenu-item i {
            margin-right: 0;
        }

        .logo-container {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: var(--transition);
        }

        .logo-container:hover {
            transform: translateY(-3px);
        }

        .logo-img {
            width: 100%;
            height: auto;
            aspect-ratio: 16/9;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
            transition: var(--transition);
        }

        .menu-title {
            padding: 15px 20px;
            font-size: 13px;
            color: rgba(255,255,255,0.7);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
            transition: var(--transition);
        }

        .menu-item {
            padding: 14px 20px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            margin: 5px 10px;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .menu-item i {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .menu-item:hover {
            background-color: rgba(255,255,255,0.15);
            transform: translateX(5px);
        }

        .menu-item.active {
            background: linear-gradient(90deg, var(--primary-600), var(--primary-400));
            box-shadow: 0 4px 12px rgba(26, 136, 255, 0.3);
        }

        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--white);
        }

        .submenu {
            padding-left: 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out, opacity 0.3s ease;
            opacity: 0;
        }

        .submenu.show {
            max-height: 300px;
            opacity: 1;
        }

        .submenu-item {
            padding: 12px 20px 12px 50px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 6px;
            margin: 2px 10px;
            transition: var(--transition);
            display: flex;
            align-items: center;
        }

        .submenu-item i {
            margin-right: 10px;
            font-size: 12px;
        }

        .submenu-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: var(--primary-200);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
            animation: fadeIn 0.6s 0.2s both;
            transition: var(--transition);
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* Header with Profile Dropdown */
        .header {
            position: relative;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--white);
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            animation: fadeIn 0.6s 0.3s both;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            color: var(--primary-500);
            font-size: 20px;
            cursor: pointer;
            margin-right: 15px;
            transition: var(--transition);
        }

        .toggle-sidebar:hover {
            transform: scale(1.1);
            color: var(--primary-700);
        }

        /* Page Title in Header */
        .header-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-700);
            flex-grow: 1; /* Allows title to take available space */
            text-align: left;
            margin-left: 15px; /* Space from toggle button */
            animation: fadeIn 0.6s 0.4s both;
        }

        /* Profile Dropdown */
        .user-profile {
            position: relative;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 8px 15px;
            border-radius: 30px;
            transition: var(--transition);
            z-index: 20;
            background: var(--primary-100);
            border: 1px solid var(--primary-200);
        }

        .user-profile:hover {
            background-color: var(--primary-200);
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            margin-right: 12px;
            text-align: right;
        }

        .profile-name {
            font-weight: 600;
            color: var(--primary-700);
            font-size: 14px;
        }

        .profile-role {
            font-size: 12px;
            color: var(--primary-500);
        }

        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            border: 2px solid var(--white);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .profile-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 200px;
            padding: 10px 0;
            z-index: 1000;
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .profile-dropdown.show {
            display: block;
        }

        .dropdown-item {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            transition: var(--transition);
            color: var(--text-color);
            text-decoration: none;
        }

        .dropdown-item i {
            margin-right: 10px;
            color: var(--primary-500);
            width: 20px;
            text-align: center;
        }

        .dropdown-item:hover {
            background-color: var(--primary-100);
            color: var(--primary-600);
        }

        .dropdown-divider {
            height: 1px;
            background-color: #e2e8f0;
            margin: 5px 0;
        }

        /* Welcome Box */
        .welcome-box {
            background: linear-gradient(135deg, var(--primary-100), var(--white));
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(26, 136, 255, 0.1);
            margin-bottom: 30px;
            border-left: 4px solid var(--primary-500);
            animation: fadeIn 0.6s 0.4s both;
            transition: var(--transition);
            position: relative;
            z-index: 1;
            margin-top: 10px;
        }

        .welcome-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 24px rgba(26, 136, 255, 0.15);
        }

        .welcome-title {
            color: var(--primary-700);
            margin-bottom: 10px;
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .welcome-title i {
            margin-right: 12px;
            color: var(--primary-500);
            background: var(--primary-100);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-box p {
            color: var(--text-color);
            line-height: 1.6;
            padding-left: 62px;
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            transition: var(--transition);
            animation: fadeIn 0.6s 0.5s both;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 15px;
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-title {
            font-size: 14px;
            color: var(--text-color);
            opacity: 0.8;
        }

        .card-1 .stat-icon {
            background-color: rgba(59, 130, 246, 0.15);
            color: var(--info);
        }

        .card-2 .stat-icon {
            background-color: rgba(34, 197, 94, 0.15);
            color: var(--success);
        }

        .card-3 .stat-icon {
            background-color: rgba(245, 158, 11, 0.15);
            color: var(--warning);
        }

        .card-4 .stat-icon {
            background-color: rgba(239, 68, 68, 0.15);
            color: var(--danger);
        }

        /* Content Section */
        .content-section {
            background-color: var(--white);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            animation: fadeIn 0.6s 0.6s both;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            color: var(--primary-600);
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            color: var(--primary-500);
        }

        .section-actions {
            display: flex;
            gap: 10px;
        }

        .btn-filter {
            background-color: var(--primary-100);
            border: 1px solid var(--primary-200);
            color: var(--primary-600);
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }

        .btn-filter:hover {
            background-color: var(--primary-200);
        }

        .btn-filter i {
            margin-right: 5px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }

        table thead th {
            text-align: left;
            padding: 12px 15px;
            background-color: var(--primary-100);
            color: var(--primary-700);
            font-weight: 600;
            border-bottom: 2px solid var(--primary-200);
        }

        table tbody tr {
            transition: var(--transition);
        }

        table tbody tr:hover {
            background-color: var(--primary-100);
        }

        table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--light-gray);
            vertical-align: middle;
        }

        /* Buttons */
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            margin: 2px;
        }

        .btn i {
            margin-right: 5px;
        }

        .btn-view {
            background-color: var(--primary-500);
            color: white;
        }

        .btn-view:hover {
            background-color: var(--primary-600);
            transform: translateY(-2px);
        }

        .btn-detail {
            background-color: #22c55e;
            color: white;
        }

        .btn-detail:hover {
            background-color: #16a34a;
            transform: translateY(-2px);
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-waiting {
            background-color: #fef3c7;
            color: #d97706;
        }

        .status-approved {
            background-color: #dcfce7;
            color: #16a34a;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .status-review {
            background-color: #dbeafe;
            color: #2563eb;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 20px;
        }

        .pagination button {
            margin: 0 3px;
            padding: 8px 12px;
            border: 1px solid var(--light-gray);
            background-color: var(--white);
            cursor: pointer;
            border-radius: 6px;
            transition: var(--transition);
        }

        .pagination button:hover:not(:disabled) {
            background-color: var(--primary-100);
            color: var(--primary-600);
        }

        .pagination button.active {
            background-color: var(--primary-500);
            color: white;
            border-color: var(--primary-500);
        }

        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Notification Popup */
        .notification-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: var(--white);
            padding: 20px 30px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 3000;
            animation: fadeIn 0.3s ease;
        }

        .notification-modal.show {
            display: block;
        }

        .notification-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .notification-message {
            font-size: 18px;
            color: var(--primary-700);
            font-weight: 500;
        }

        .notification-confirm {
            color: var(--warning);
        }

        .notification-success {
            color: var(--success);
        }

        /* Custom Buttons for Notification Modal */
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            border: none;
        }

        .btn-gray {
            background-color: #d1d5db;
            color: var(--text-color);
        }

        .btn-gray:hover {
            background-color: #b3b7bc;
        }

        .btn-blue {
            background: linear-gradient(45deg, var(--primary-500), var(--primary-600));
            color: white;
        }

        .btn-blue.loading::after {
            content: '';
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #fff;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 8px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <div class="notification-popup" id="notificationPopup">
        <i id="notificationIcon" class="notification-icon"></i>
        <div class="notification-content">
            <div id="notificationTitle" class="notification-title"></div>
            <div id="notificationMessage" class="notification-message"></div>
        </div>
        <button class="notification-close" id="closeNotification">&times;</button>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="logo-container">
            {{-- Pastikan asset 'images/logo_white.png' ada --}}
            <img src="{{ asset('images/logo_white.png') }}" alt="SIPRAKTA Logo" class="logo-img">
        </div>
        <div class="menu">
            {{-- Mengubah route() menjadi '#' atau javascript:void(0); --}}
            <div class="menu-item active" onclick="location.href='#'">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </div>
            <div class="menu-item has-submenu" id="pengajuanMenu">
                <i class="fas fa-file-alt"></i>
                <span>Manajemen Pengajuan <i class="fas fa-chevron-down dropdown-arrow"></i></span>
            </div>
            <div class="submenu" id="submenuPengajuan">
                <div class="submenu-item" onclick="location.href='#'">
                    <i class="fas fa-clock"></i> Pengajuan Pending
                </div>
                <div class="submenu-item" onclick="location.href='#'">
                    <i class="fas fa-check-circle"></i> Pengajuan Disetujui
                </div>
                <div class="submenu-item" onclick="location.href='#'">
                    <i class="fas fa-times-circle"></i> Pengajuan Ditolak
                </div>
            </div>
            {{-- Tambahkan menu Notifikasi --}}
            <div class="menu-item" onclick="location.href='#'">
                <i class="fas fa-bell"></i>
                <span>Notifikasi</span>
            </div>
        </div>
    </div>

    <div class="main-content" id="mainContent">
        <div class="header">
            <div class="header-content">
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="header-title">Dashboard Dosen</h1>
                <div class="user-profile" id="userProfile">
                    {{-- Pastikan Auth::user()->profile_picture ada atau sediakan default --}}
                    <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default_profile.png') }}" alt="Profile Picture" class="profile-pic">
                    <div class="profile-info">
                        <span class="profile-name">{{ Auth::user()->name ?? 'Nama Dosen' }}</span>
                        <span class="profile-role">Dosen</span>
                    </div>
                    <i class="fas fa-chevron-down" style="font-size: 12px; color: var(--primary-500);"></i>
                    <div class="profile-dropdown" id="profileDropdown">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user-circle"></i> Profil Saya
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-key"></i> Ubah Sandi
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item" id="logoutDropdown">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="welcome-box">
            <div class="welcome-title">
                <i class="fas fa-hand-sparkles"></i> Selamat Datang, {{ Auth::user()->name ?? 'Dosen' }}!
            </div>
            <p>Selamat datang di Dashboard Dosen SIPRAKTA. Di sini Anda dapat mengelola pengajuan, melihat jadwal sidang, dan lainnya.</p>
        </div>

        <div class="stats-container">
            <div class="stat-card card-1" onclick="location.href='#'">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-content">
                    {{-- Pastikan variabel ini tersedia dari controller --}}
                    <div class="stat-number">{{ $totalPengajuanPending ?? 0 }}</div>
                    <div class="stat-title">Pengajuan Pending</div>
                </div>
            </div>
            <div class="stat-card card-2" onclick="location.href='#'">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-content">
                    {{-- Pastikan variabel ini tersedia dari controller --}}
                    <div class="stat-number">{{ $totalPengajuanApproved ?? 0 }}</div>
                    <div class="stat-title">Pengajuan Disetujui</div>
                </div>
            </div>
            <div class="stat-card card-3" onclick="location.href='#'">
                <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="stat-content">
                    {{-- Pastikan variabel ini tersedia dari controller --}}
                    <div class="stat-number">{{ $totalSidangUpcoming ?? 0 }}</div>
                    <div class="stat-title">Sidang Mendatang</div>
                </div>
            </div>
             <div class="stat-card card-4" onclick="location.href='#'">
                <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
                <div class="stat-content">
                    {{-- Pastikan variabel ini tersedia dari controller --}}
                    <div class="stat-number">{{ $totalPengajuanRejected ?? 0 }}</div>
                    <div class="stat-title">Pengajuan Ditolak</div>
                </div>
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h3 class="section-title"><i class="fas fa-bell"></i> Notifikasi Terbaru</h3>
                <div class="section-actions">
                    <a href="#" class="btn btn-filter">Lihat Semua <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            {{-- Pastikan variabel $notifications tersedia dan merupakan Collection --}}
            @if (!empty($notifications) && $notifications->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Tipe</th>
                            <th>Pesan</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $notification)
                            <tr>
                                <td>
                                    @if ($notification->type == 'new_submission')
                                        <span class="status-badge status-review">Pengajuan Baru</span>
                                    @elseif ($notification->type == 'sidang_scheduled')
                                        <span class="status-badge status-info">Jadwal Sidang</span>
                                    @elseif ($notification->type == 'submission_status_update')
                                        <span class="status-badge status-warning">Update Status</span>
                                    @endif
                                </td>
                                <td>{{ $notification->message }}</td>
                                <td>{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</td>
                                <td>
                                    {{-- Mengubah route() menjadi '#' --}}
                                    @if ($notification->type == 'new_submission' && isset($notification->data['pengajuan_id']))
                                        <a href="#" class="btn btn-view"><i class="fas fa-eye"></i> Lihat</a>
                                    @elseif ($notification->type == 'sidang_scheduled' && isset($notification->data['sidang_id']))
                                        <a href="#" class="btn btn-view"><i class="fas fa-eye"></i> Lihat Sidang</a>
                                    @elseif ($notification->type == 'submission_status_update' && isset($notification->data['pengajuan_id']))
                                        <a href="#" class="btn btn-view"><i class="fas fa-eye"></i> Lihat Pengajuan</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="no-items-message">Tidak ada notifikasi baru.</p>
            @endif
        </div>

        <div class="content-section">
            <div class="section-header">
                <h3 class="section-title"><i class="fas fa-calendar-check"></i> Jadwal Sidang Saya</h3>
                <div class="section-actions">
                    <a href="#" class="btn btn-filter">Lihat Semua Sidang <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            {{-- Pastikan variabel $jadwalSidang tersedia dan merupakan Collection --}}
            @if (!empty($jadwalSidang) && $jadwalSidang->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>Jenis Sidang</th>
                            <th>Tanggal & Waktu</th>
                            <th>Ruangan</th>
                            <th>Peran Anda</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwalSidang as $sidang)
                            <tr>
                                <td>{{ $sidang->pengajuan->mahasiswa->nama_lengkap ?? 'N/A' }} ({{ $sidang->pengajuan->mahasiswa->nim ?? 'N/A' }})</td>
                                <td>{{ strtoupper(str_replace('_', ' ', $sidang->pengajuan->jenis_pengajuan ?? 'N/A')) }}</td>
                                <td>{{ \Carbon\Carbon::parse($sidang->tanggal_waktu_sidang)->translatedFormat('l, d F Y H:i') }} WIB</td>
                                <td>{{ $sidang->ruangan_sidang ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        // Pastikan $dosenLoginId tersedia dari controller atau Auth::id()
                                        $dosenLoginId = Auth::id(); // Atau dapatkan dari parameter $dosenLoginId yang dilewatkan ke view
                                        $roleDisplayed = '';
                                        if (isset($sidang->dosen_pembimbing_id) && $sidang->dosen_pembimbing_id == $dosenLoginId) $roleDisplayed = 'Pembimbing';
                                        elseif (isset($sidang->dosen_penguji1_id) && $sidang->dosen_penguji1_id == $dosenLoginId) $roleDisplayed = 'Penguji 1';
                                        elseif (isset($sidang->dosen_penguji2_id) && $sidang->dosen_penguji2_id == $dosenLoginId) $roleDisplayed = 'Penguji 2';
                                        echo $roleDisplayed ?: 'N/A';
                                    @endphp
                                </td>
                                <td>
                                    @if (($sidang->status_sidang ?? 'pending') == 'pending')
                                        <span class="status-badge status-waiting">Menunggu</span>
                                    @elseif (($sidang->status_sidang ?? 'pending') == 'approved')
                                        <span class="status-badge status-approved">Disetujui</span>
                                    @elseif (($sidang->status_sidang ?? 'pending') == 'rejected')
                                        <span class="status-badge status-danger">Ditolak</span>
                                    @else
                                        <span class="status-badge status-review">{{ ucfirst($sidang->status_sidang ?? 'N/A') }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Mengubah route() menjadi '#' --}}
                                    <a href="#" class="btn btn-detail"><i class="fas fa-info-circle"></i> Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="no-items-message">Tidak ada jadwal sidang mendatang.</p>
            @endif
        </div>

        <div class="content-section">
            <div class="section-header">
                <h3 class="section-title"><i class="fas fa-file-import"></i> Pengajuan Terbaru Menunggu Persetujuan Anda</h3>
                <div class="section-actions">
                    <a href="#" class="btn btn-filter">Lihat Semua Pengajuan Pending <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            {{-- Pastikan variabel $pengajuanMenunggu tersedia dan merupakan Collection --}}
            @if (!empty($pengajuanMenunggu) && $pengajuanMenunggu->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>Jenis Pengajuan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengajuanMenunggu as $pengajuan)
                            <tr>
                                <td>{{ $pengajuan->mahasiswa->nama_lengkap ?? 'N/A' }} ({{ $pengajuan->mahasiswa->nim ?? 'N/A' }})</td>
                                <td>{{ strtoupper(str_replace('_', ' ', $pengajuan->jenis_pengajuan ?? 'N/A')) }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengajuan->created_at)->translatedFormat('d F Y') }}</td>
                                <td><span class="status-badge status-waiting">Pending</span></td>
                                <td>
                                    {{-- Mengubah route() menjadi '#' --}}
                                    <a href="#" class="btn btn-detail"><i class="fas fa-info-circle"></i> Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="no-items-message">Tidak ada pengajuan yang menunggu persetujuan Anda saat ini.</p>
            @endif
        </div>

        <div class="notification-modal" id="logoutConfirmationModal">
            <i class="fas fa-question-circle notification-icon notification-confirm"></i>
            <p class="notification-message">Apakah Anda yakin ingin logout?</p>
            <div style="margin-top: 20px; display: flex; justify-content: center; gap: 10px;">
                <button class="btn btn-gray" id="cancelLogoutBtn">Batal</button>
                <button class="btn btn-blue" id="confirmLogoutBtn">Ya, Logout</button>
            </div>
        </div>

        <div class="notification-modal" id="logoutSuccessModal">
            <i class="fas fa-check-circle notification-icon notification-success"></i>
            <p class="notification-message">Berhasil Logout!</p>
        </div>

        {{-- Form logout ini akan berfungsi jika route 'dosen.logout' didefinisikan --}}
        <form id="logout-form" action="{{ '#' }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleSidebarBtn = document.getElementById('toggleSidebar');
        const mainContent = document.getElementById('mainContent');
        const userProfile = document.getElementById('userProfile');
        const profileDropdown = document.getElementById('profileDropdown');
        const logoutSidebarBtn = document.getElementById('logoutSidebar'); // Ini mungkin tidak lagi ada di DOM jika sidebar disederhanakan
        const logoutDropdownBtn = document.getElementById('logoutDropdown');
        const logoutConfirmationModal = document.getElementById('logoutConfirmationModal');
        const logoutSuccessModal = document.getElementById('logoutSuccessModal');
        const cancelLogoutBtn = document.getElementById('cancelLogoutBtn');
        const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
        const pengajuanMenu = document.getElementById('pengajuanMenu');
        const submenuPengajuan = document.getElementById('submenuPengajuan');
        const notificationPopup = document.getElementById('notificationPopup');
        const notificationTitle = document.getElementById('notificationTitle');
        const notificationMessage = document.getElementById('notificationMessage');
        const notificationIcon = document.getElementById('notificationIcon');
        const closeNotification = document.getElementById('closeNotification');

        // Sidebar Toggle
        toggleSidebarBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        // Profile Dropdown Toggle
        if (userProfile) {
            userProfile.addEventListener('click', (event) => {
                profileDropdown.classList.toggle('show');
                event.stopPropagation(); // Prevent click from closing immediately
            });

            document.addEventListener('click', (event) => {
                if (!userProfile.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.remove('show');
                }
            });
        }

        // Submenu Toggle for Manajemen Pengajuan
        if (pengajuanMenu) {
            pengajuanMenu.addEventListener('click', () => {
                submenuPengajuan.classList.toggle('show');
                pengajuanMenu.classList.toggle('active'); // Optional: Add active class to parent menu item
                const arrow = pengajuanMenu.querySelector('.dropdown-arrow');
                if (arrow) {
                    arrow.classList.toggle('fa-chevron-down');
                    arrow.classList.toggle('fa-chevron-up');
                }
            });
        }

        // Logout functionality (tetap dipertahankan untuk dropdown profil)
        function showLogoutConfirmation() {
            logoutConfirmationModal.classList.add('show');
        }

        function hideLogoutConfirmation() {
            logoutConfirmationModal.classList.remove('show');
        }

        function showNotification(title, message, type = 'info') {
            notificationTitle.textContent = title;
            notificationMessage.textContent = message;

            notificationPopup.className = 'notification-popup'; // Reset classes
            if (type === 'success') {
                notificationPopup.classList.add('success');
                notificationIcon.className = 'fas fa-check-circle notification-icon';
            } else if (type === 'error') {
                notificationPopup.classList.add('error');
                notificationIcon.className = 'fas fa-exclamation-circle notification-icon';
            } else { // info
                notificationPopup.classList.add('info');
                notificationIcon.className = 'fas fa-info-circle notification-icon';
            }

            notificationPopup.classList.add('show');
            setTimeout(() => {
                notificationPopup.classList.remove('show');
            }, 5000); // Auto hide after 5 seconds
        }

        function performLogout() {
            confirmLogoutBtn.classList.add('loading');
            confirmLogoutBtn.disabled = true;

            // Simulate API call for logout
            setTimeout(() => {
                hideLogoutConfirmation();
                showNotification('Simulasi Logout', 'Anda telah berhasil mencoba logout (fitur ini memerlukan konfigurasi rute backend).', 'success');
                setTimeout(() => {
                    // window.location.href = 'login.html'; // uncomment ini jika ingin redirect
                }, 2000);
                confirmLogoutBtn.classList.remove('loading');
                confirmLogoutBtn.disabled = false;
            }, 1500); // Simulated loading delay
        }

        // logoutSidebarBtn mungkin tidak lagi relevan jika dihapus dari DOM
        if (logoutSidebarBtn) {
            logoutSidebarBtn.addEventListener('click', showLogoutConfirmation);
        }

        if (logoutDropdownBtn) {
            logoutDropdownBtn.addEventListener('click', (event) => {
                event.preventDefault(); // Mencegah navigasi default '#'
                profileDropdown.classList.remove('show'); // Hide dropdown first
                showLogoutConfirmation();
            });
        }

        if (cancelLogoutBtn) {
            cancelLogoutBtn.addEventListener('click', hideLogoutConfirmation);
        }

        if (confirmLogoutBtn) {
            confirmLogoutBtn.addEventListener('click', performLogout);
        }

        if (closeNotification) {
            closeNotification.addEventListener('click', () => {
                notificationPopup.classList.remove('show');
            });
        }
    </script>
</body>
</html>