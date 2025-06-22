<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Sandi - SIPRAKTA Mahasiswa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --success: #198754;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #0dcaf0;
            --transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);

            --card-border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
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

        /* Layout Utama */
        .container {
            display: flex;
            min-height: 100vh;
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
        .sidebar.collapsed .menu-item span, /* This hides the main text when collapsed */
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
            width: 100%;
            align-items: center;
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

        /* Welcome Box (from old dashboard) - Not needed for change password page, but keeping styles for consistency if reused */
        .welcome-box-dashboard {
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

        .welcome-box-dashboard:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 24px rgba(26, 136, 255, 0.15);
        }

        .welcome-title-dashboard {
            color: var(--primary-700);
            margin-bottom: 10px;
            font-size: 24px;
            font-weight: 700;
        }

        .welcome-box-dashboard p {
            color: var(--text-color);
            line-height: 1.6;
        }

        /* Stats Card (from old dashboard, adapted) - Not needed for change password page, but keeping styles for consistency if reused */
        .dashboard-content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .dashboard-card {
            background: var(--white);
            border-radius: var(--card-border-radius);
            padding: 25px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.07);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            background: linear-gradient(45deg, var(--primary-500), var(--info));
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Specific icon backgrounds */
        .card-icon.bg-blue { background: linear-gradient(45deg, var(--primary-500), var(--info)); }
        .card-icon.bg-green { background: linear-gradient(45deg, var(--success), #20c997); }
        .card-icon.bg-orange { background: linear-gradient(45deg, #fd7e14, var(--warning)); }
        .card-icon.bg-red { background: linear-gradient(45deg, var(--danger), #ff6b6b); }


        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--primary-700);
        }

        .card-description {
            color: var(--text-color);
            font-size: 0.95rem;
            flex-grow: 1;
        }

        .card-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background-color: var(--primary-500);
            color: var(--white);
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .card-link:hover {
            background-color: var(--primary-600);
            transform: translateY(-2px);
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
        }

        .user-profile:hover {
            background-color: var(--primary-100);
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

        /* Tooltips */
        .tooltip {
            position: relative;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s, visibility 0.3s;
            width: 120px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 15px;
            font-size: 12px;
            white-space: nowrap;
            pointer-events: none;
        }

        /* Ensure tooltiptext is hidden when sidebar is expanded */
        .sidebar:not(.collapsed) .menu-item .tooltiptext {
            display: none;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        /* Table Styling (from mahasiswa.html) - Not needed for change password page, but keeping styles for consistency if reused */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            animation: fadeIn 0.5s both;
        }

        .section-title {
            font-size: 24px;
            color: var(--primary-700);
            font-weight: 600;
        }

        .section-title i {
            margin-right: 12px;
        }

        .table-container {
            background: var(--white);
            border-radius: var(--card-border-radius);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            animation: fadeIn 0.5s 0.3s both;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background-color: var(--primary-100);
            color: var(--primary-700);
            font-weight: 600;
            text-align: left;
            padding: 16px 20px;
            border-bottom: 2px solid var(--primary-200);
        }

        .data-table td {
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tr:hover {
            background-color: var(--primary-50);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-active {
            background-color: rgba(25, 135, 84, 0.15);
            color: var(--success);
        }

        .status-inactive {
            background-color: rgba(220, 53, 69, 0.15);
            color: var(--danger);
        }

        .action-cell {
            display: flex;
            gap: 10px;
        }

        .action-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .view-icon {
            background-color: rgba(26, 136, 255, 0.15);
            color: var(--primary-600);
        }

        .action-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Styles specifically for the change password form card */
        .password-change-card {
            background-color: var(--white);
            border-radius: var(--card-border-radius);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.07);
            padding: 30px;
            margin: 40px auto; /* Center the card horizontally */
            max-width: 550px; /* Limit width for better readability */
            animation: fadeIn 0.6s 0.2s both;
        }

        .password-change-card .card-header {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-700);
            margin-bottom: 25px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
            font-size: 1rem;
        }

        .form-group input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group input[type="password"]:focus {
            outline: none;
            border-color: var(--primary-500);
            box-shadow: 0 0 0 3px rgba(26, 136, 255, 0.2);
        }

        .password-strength-indicator {
            margin-top: 10px;
            height: 8px;
            background-color: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }

        .strength-meter {
            height: 100%;
            width: 0;
            background-color: transparent;
            transition: width 0.3s ease-in-out, background-color 0.3s ease-in-out;
        }

        .strength-text {
            margin-top: 8px;
            font-size: 0.875rem;
            color: var(--text-color);
            display: none;
            font-weight: 500;
        }

        .password-match-message {
            margin-top: 8px;
            font-size: 0.875rem;
            display: none;
            font-weight: 500;
        }

        .btn-primary {
            background-color: var(--primary-500);
            color: var(--white);
            border: none;
            padding: 14px 25px;
            border-radius: 8px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s, transform 0.2s;
            margin-top: 15px;
        }

        .btn-primary:hover {
            background-color: var(--primary-600);
            transform: translateY(-2px);
        }

        .alert {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }

        .alert i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .alert-success {
            background-color: rgba(25, 135, 84, 0.1);
            color: var(--success);
            border: 1px solid rgba(25, 135, 84, 0.2);
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }

            .sidebar .menu-title,
            .sidebar .menu-item span,
            .sidebar .submenu {
                display: none;
            }

            .main-content {
                margin-left: 80px;
                padding: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .user-profile {
                margin-top: 15px;
                width: 100%;
                justify-content: space-between;
            }

            .profile-dropdown {
                right: auto;
                left: 0;
                width: 100%;
            }

            .password-change-card {
                margin: 20px auto;
                padding: 20px;
            }
            .password-change-card .card-header {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar" id="sidebar">
            <div class="logo-container">
                {{-- Ensure you have an asset at this path or replace with a placeholder --}}
                <img src="{{ asset('assets/images/sipraktawhite2.png') }}" alt="Logo SIPRAKTA" class="logo-img">
            </div>

            <div class="menu-title">Menu Utama</div>
            <a href="{{ route('mahasiswa.dashboard') }}" style="text-decoration: none; color: inherit;">
                <div class="menu-item tooltip">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                    <span class="tooltiptext">Dashboard</span>
                </div>
            </a>

            {{-- Example of a menu item with a submenu. Adjust routes as per your application. --}}
            <div class="menu-item tooltip" onclick="toggleSubmenu('pengajuan', event)">
                <i class="fas fa-file-alt"></i>
                <span>Pengajuan Sidang</span>
                <span class="tooltiptext">Pengajuan Sidang</span>
                <i class="fas fa-chevron-down" style="margin-left: auto;"></i>
            </div>
            <div class="submenu" id="pengajuan-submenu">
                <a href="{{ route('mahasiswa.pengajuan.index') }}" style="text-decoration: none; color: inherit;">
                    <div class="submenu-item tooltip">
                        <i class="fas fa-chevron-right"></i>
                        <span>Lihat Pengajuan</span>
                        <span class="tooltiptext">Lihat Pengajuan</span>
                    </div>
                </a>
                <a href="{{ route('mahasiswa.pengajuan.pilih') }}" style="text-decoration: none; color: inherit;">
                    <div class="submenu-item tooltip">
                        <i class="fas fa-chevron-right"></i>
                        <span>Buat Pengajuan</span>
                        <span class="tooltiptext">Buat Pengajuan</span>
                    </div>
                </a>
            </div>

            <a href="#" style="text-decoration: none; color: inherit;">
                <div class="menu-item tooltip">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Jadwal Sidang</span>
                    <span class="tooltiptext">Jadwal Sidang</span>
                </div>
            </a>

            <a href="#" style="text-decoration: none; color: inherit;">
                <div class="menu-item tooltip">
                    <i class="fas fa-bell"></i>
                    <span>Notifikasi</span>
                    <span class="tooltiptext">Notifikasi</span>
                </div>
            </a>

            <a href="#" style="text-decoration: none; color: inherit;">
                <div class="menu-item tooltip">
                    <i class="fas fa-file-upload"></i>
                    <span>Dokumen</span>
                    <span class="tooltiptext">Dokumen</span>
                </div>
            </a>
        </div>

        <div class="main-content" id="mainContent">
            <div class="header">
                <div class="header-content">
                    <div style="display: flex; align-items: center;">
                        <button class="toggle-sidebar" id="toggleSidebar">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 style="font-size: 28px; color: var(--primary-700);">
                            <i class="fas fa-key" style="margin-right: 15px;"></i>
                            Ubah Sandi
                        </h1>
                    </div>
                    <div class="user-profile" id="userProfile">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Pengguna') }}&background=1a88ff&color=fff"
                             style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                        <span style="font-weight: 500;">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                        <i class="fas fa-chevron-down" style="margin-left: 8px; font-size: 12px;"></i>

                        <div class="profile-dropdown" id="profileDropdown">
                            <a href="{{ route('mahasiswa.profile.edit') }}" class="dropdown-item">
                                <i class="fas fa-user-circle"></i> Edit Profil
                            </a>
                            <a href="{{ route('mahasiswa.password.change.form') }}" class="dropdown-item active">
                                <i class="fas fa-key"></i> Ubah Sandi
                            </a>
                            <form action="{{ route('mahasiswa.logout') }}" method="POST" style="display: none;" id="logout-form">
                                @csrf
                            </form>
                            <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

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

        </div>
    </div>

    <script>
        // Toggle sidebar
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded'); // Use 'expanded' as per dashboard.blade.php

            // Change toggle icon
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-indent');
            } else {
                icon.classList.remove('fa-indent');
                icon.classList.add('fa-bars');
            }
        });

        // Toggle submenu
        function toggleSubmenu(menu, event) {
            event.preventDefault();
            const submenu = document.getElementById(`${menu}-submenu`);
            const menuItem = document.querySelector(`.menu-item[onclick="toggleSubmenu('${menu}', event)"]`);

            // Toggle current submenu
            submenu.classList.toggle('show');

            // Close other submenus
            document.querySelectorAll('.submenu').forEach(item => {
                if (item.id !== `${menu}-submenu`) {
                    item.classList.remove('show');
                }
            });
        }

        // Toggle profile dropdown
        const userProfile = document.getElementById('userProfile');
        const profileDropdown = document.getElementById('profileDropdown');

        userProfile.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            profileDropdown.classList.remove('show');
        });

        // Password Strength and Match Logic
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('new_password_confirmation');
        const strengthMeter = document.getElementById('strengthMeter');
        const strengthText = document.getElementById('strengthText');
        const passwordMatchMessage = document.getElementById('passwordMatchMessage');

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

        // Active menu item logic based on current URL
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.sidebar .menu-item');
            const submenuItems = document.querySelectorAll('.submenu-item');
            const profileDropdownItems = document.querySelectorAll('.profile-dropdown .dropdown-item');

            // Function to remove all active classes
            function removeAllActiveClasses() {
                menuItems.forEach(item => item.classList.remove('active'));
                submenuItems.forEach(item => item.classList.remove('active'));
                profileDropdownItems.forEach(item => item.classList.remove('active'));
                document.querySelectorAll('.submenu').forEach(submenu => submenu.classList.remove('show'));
            }

            // Set active class for sidebar menu items
            menuItems.forEach(item => {
                let link = item.getAttribute('href');
                if (link && currentPath.startsWith(link)) {
                    removeAllActiveClasses(); // Clear previous active states
                    item.classList.add('active');
                }
            });

            // Handle submenu active states and expansion
            submenuItems.forEach(item => {
                let link = item.querySelector('a')?.getAttribute('href');
                if (link && currentPath.startsWith(link)) {
                    removeAllActiveClasses(); // Clear previous active states
                    item.classList.add('active');
                    // Find parent submenu and add 'show' class
                    const parentSubmenu = item.closest('.submenu');
                    if (parentSubmenu) {
                        parentSubmenu.classList.add('show');
                        // Find the parent menu item and add active class if desired
                        const parentMenuItem = document.querySelector(`.menu-item[onclick*="${parentSubmenu.id.replace('-submenu', '')}"]`);
                        if (parentMenuItem) {
                            parentMenuItem.classList.add('active');
                        }
                    }
                }
            });

            // Handle 'Ubah Sandi' specifically for the active state
            const changePasswordLink = '{{ route('mahasiswa.password.change.form', [], false) }}';
            if (currentPath === changePasswordLink) {
                removeAllActiveClasses(); // Clear all active classes first
                const changePasswordMenuItem = document.querySelector('.profile-dropdown .dropdown-item[href="{{ route('mahasiswa.password.change.form') }}"]');
                if (changePasswordMenuItem) {
                    changePasswordMenuItem.classList.add('active');
                }
            }

            // Handle dashboard active state
            if (currentPath === '{{ route('mahasiswa.dashboard', [], false) }}') {
                removeAllActiveClasses();
                document.querySelector('.sidebar .menu-item[href="{{ route('mahasiswa.dashboard') }}"]').classList.add('active');
            }

            // Set active class for profile dropdown items
            profileDropdownItems.forEach(item => {
                // Check if the current URL exactly matches the dropdown item's href
                if (item.href === window.location.href) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>