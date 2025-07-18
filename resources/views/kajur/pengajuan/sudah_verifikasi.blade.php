<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard Kajur - SIPRAKTA</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            /* Salin semua CSS dari dashboard-admin.html di sini */
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
                
                --card-width: 300px;
                --card-height: 200px;
                --card-icon-size: 48px;
                --card-title-size: 20px;
                --card-padding: 25px;
                --card-border-radius: 12px;
                --card-gap: 25px;
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
            }
            
            .welcome-box p {
                color: var(--text-color);
                line-height: 1.6;
            }
            
            /* Stats Card */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 25px;
                margin-bottom: 40px;
            }
            
            .stats-card {
                background: var(--white);
                border-radius: 12px;
                padding: 25px;
                box-shadow: 0 6px 18px rgba(0, 0, 0, 0.07);
                display: flex;
                align-items: center;
                gap: 20px;
                transition: var(--transition);
                border: 1px solid rgba(0, 0, 0, 0.05);
            }
            
            .stats-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }
            
            .stats-icon {
                width: 60px;
                height: 60px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                color: white;
            }
            
            .stats-content h3 {
                font-size: 1.8rem;
                font-weight: 700;
                margin-bottom: 5px;
            }
            
            .stats-content p {
                color: var(--secondary);
                font-size: 0.95rem;
            }
            
            .icon-blue {
                background: linear-gradient(45deg, var(--primary-500), var(--info));
            }
            
            .icon-green {
                background: linear-gradient(45deg, var(--success), #20c997);
            }
            
            .icon-orange {
                background: linear-gradient(45deg, #fd7e14, var(--warning));
            }
            
            .icon-red {
                background: linear-gradient(45deg, var(--danger), #ff6b6b);
            }
            
            /* Cards */
            .card-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(var(--card-width), 1fr));
                gap: var(--card-gap);
                margin-bottom: 30px;
            }
            
            .card {
                background-color: var(--white);
                border-radius: var(--card-border-radius);
                padding: var(--card-padding);
                box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                transition: var(--transition);
                animation: fadeIn 0.6s 0.5s both;
                border-top: 3px solid var(--primary-500);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: var(--card-height);
                width: 100%;
            }
            
            .card.small {
                --card-height: 150px;
                --card-icon-size: 36px;
                --card-title-size: 18px;
            }
            
            .card.medium {
                --card-height: 200px;
                --card-icon-size: 48px;
                --card-title-size: 20px;
            }
            
            .card.large {
                --card-height: 250px;
                --card-icon-size: 60px;
                --card-title-size: 22px;
            }
            
            .card.wide {
                grid-column: span 2;
            }
            
            .card:nth-child(1) { animation-delay: 0.5s; }
            .card:nth-child(2) { animation-delay: 0.6s; }
            .card:nth-child(3) { animation-delay: 0.7s; }
            
            .clickable-card {
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .clickable-card:hover {
                transform: translateY(-5px) scale(1.02);
                box-shadow: 0 8px 25px rgba(26, 136, 255, 0.2);
            }
            
            .card-icon {
                font-size: var(--card-icon-size);
                color: var(--primary-500);
                margin-bottom: 20px;
                transition: all 0.3s ease;
            }
            
            .clickable-card:hover .card-icon {
                transform: scale(1.1);
                color: var(--primary-600);
            }
            
            .card-link {
                text-decoration: none;
                color: inherit;
                display: block;
                height: 100%;
                width: 100%;
            }
            
            .card-title {
                color: var(--primary-600);
                font-size: var(--card-title-size);
                font-weight: 600;
                text-align: center;
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
            
            /* Floating Action Button */
            .fab {
                position: fixed;
                bottom: 30px;
                right: 30px;
                width: 60px;
                height: 60px;
                background: linear-gradient(45deg, var(--primary-500), var(--primary-600));
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                box-shadow: 0 4px 20px rgba(26, 136, 255, 0.4);
                cursor: pointer;
                transition: var(--transition);
                z-index: 5;
                animation: pulse 2s infinite;
            }
            
            .fab:hover {
                transform: scale(1.1) rotate(10deg);
                box-shadow: 0 6px 25px rgba(26, 136, 255, 0.6);
                animation: none;
            }
            
            /* Tooltips */
            .tooltip {
                position: relative;
            }
            
            .tooltip .tooltiptext {
                visibility: hidden;
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
                opacity: 0;
                transition: opacity 0.3s;
                font-size: 12px;
            }
            
            .tooltip .tooltiptext::after {
                content: "";
                position: absolute;
                right: 100%;
                top: 50%;
                margin-top: -5px;
                border-width: 5px;
                border-style: solid;
                border-color: transparent #555 transparent transparent;
            }
            
            .tooltip:hover .tooltiptext {
                visibility: visible;
                opacity: 1;
            }
            
            /* Responsive */
            @media (max-width: 768px) {
                :root {
                    --card-width: 100%;
                    --card-gap: 15px;
                }
                
                .card.wide {
                    grid-column: span 1;
                }
                
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
            }
        </style>
    </head>
<body>
    <div class="container">
        <div class="sidebar" id="sidebar">
            <div class="logo-container">
                {{-- Pastikan path gambar ini benar di Laravel public folder Anda --}}
                <img src="{{ asset('assets/images/sipraktawhite2.png') }}" alt="Logo SIPRAKTA" class="logo-img">
            </div>
            
            <div class="menu-title">Menu Utama</div>
            <a href="{{ route('kajur.dashboard') }}" style="text-decoration: none; color: inherit;">
                <div class="menu-item {{ Request::routeIs('kajur.dashboard') ? 'active' : '' }} tooltip">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                    <span class="tooltiptext">Dashboard</span>
                </div>
            </a>
            
            <div class="menu-item tooltip {{ Request::routeIs('kajur.pengajuan.*') ? 'active' : '' }}" onclick="toggleSubmenu('pengajuan', event)">
                <i class="fas fa-file-alt"></i>
                <span>Pengajuan Sidang</span>
                <span class="tooltiptext">Pengajuan Sidang</span>
                <i class="fas fa-chevron-down" style="margin-left: auto;"></i>
            </div>
            <div class="submenu {{ Request::routeIs('kajur.pengajuan.*') ? 'show' : '' }}" id="pengajuan-submenu">
                <a href="{{ route('kajur.pengajuan.perlu_verifikasi') }}" style="text-decoration: none; color: inherit;">
                    <div class="submenu-item {{ Request::routeIs('kajur.pengajuan.perlu_verifikasi') ? 'active' : '' }} tooltip">
                        <i class="fas fa-chevron-right"></i>
                        <span>Perlu Verifikasi</span>
                        <span class="tooltiptext">Perlu Verifikasi</span>
                    </div>
                </a>
                <a href="{{ route('kajur.pengajuan.sudah_verifikasi') }}" style="text-decoration: none; color: inherit;">
                    <div class="submenu-item {{ Request::routeIs('kajur.pengajuan.sudah_verifikasi') ? 'active' : '' }} tooltip">
                        <i class="fas fa-chevron-right"></i>
                        <span>Sudah Verifikasi</span>
                        <span class="tooltiptext">Sudah Verifikasi</span>
                    </div>
                </a>
            </div>
            
            <div class="menu-item tooltip {{ Request::routeIs('kajur.sidang.*') ? 'active' : '' }}" onclick="toggleSubmenu('jadwal', event)">
                <i class="fas fa-calendar-alt"></i>
                <span>Jadwal Sidang</span>
                <span class="tooltiptext">Jadwal Sidang</span>
                <i class="fas fa-chevron-down" style="margin-left: auto;"></i>
            </div>
            <div class="submenu {{ Request::routeIs('kajur.sidang.*') ? 'show' : '' }}" id="jadwal-submenu">
                <a href="{{ route('kajur.sidang.sedang') }}" style="text-decoration: none; color: inherit;">
                    <div class="submenu-item {{ Request::routeIs('kajur.sidang.sedang') ? 'active' : '' }} tooltip">
                        <i class="fas fa-chevron-right"></i>
                        <span>Sidang Sedang Berlangsung</span>
                        <span class="tooltiptext">Sidang Sedang Berlangsung</span>
                    </div>
                </a>
                <a href="{{ route('kajur.sidang.telah') }}" style="text-decoration: none; color: inherit;">
                    <div class="submenu-item {{ Request::routeIs('kajur.sidang.telah') ? 'active' : '' }} tooltip">
                        <i class="fas fa-chevron-right"></i>
                        <span>Sidang Telah Berlangsung</span>
                        <span class="tooltiptext">Sidang Telah Berlangsung</span>
                    </div>
                </a>
                <a href="{{ route('kajur.sidang.akan') }}" style="text-decoration: none; color: inherit;">
                    <div class="submenu-item {{ Request::routeIs('kajur.sidang.akan') ? 'active' : '' }} tooltip">
                        <i class="fas fa-chevron-right"></i>
                        <span>Sidang Akan Datang</span>
                        <span class="tooltiptext">Sidang Akan Datang</span>
                    </div>
                </a>
            </div>
        </div>

        <div class="main-content" id="mainContent">
            <div class="header">
                <div class="header-content">
                    <div style="display: flex; align-items: center;">
                        <button class="toggle-sidebar" id="toggleSidebar">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 style="font-size: 28px; color: var(--primary-700);">
                            <i class="fas fa-check-circle" style="margin-right: 15px;"></i>
                            Pengajuan Sudah Diverifikasi
                        </h1>
                    </div>
                    <div class="user-profile" id="userProfile">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Kajur' }}&background=1a88ff&color=fff" 
                             style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                        <span style="font-weight: 500;">{{ Auth::user()->name ?? 'Kajur' }}</span>
                        <i class="fas fa-chevron-down" style="margin-left: 8px; font-size: 12px;"></i>
                        
                        <div class="profile-dropdown" id="profileDropdown">
                            <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Keluar</span>
                            </a>
                            <form id="logout-form" action="{{ route('kajur.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            @if (session('success'))
                <div class="alert alert-success" style="animation: fadeIn 0.6s 0.2s both;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" style="animation: fadeIn 0.6s 0.2s both;">
                    {{ session('error') }}
                </div>
            @endif

            @if ($pengajuanTerverifikasi->isEmpty())
                <p class="text-muted" style="text-align: center; margin-top: 50px;">Tidak ada pengajuan sidang yang sudah diverifikasi saat ini.</p>
            @else
                <div class="card" style="padding: 20px;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID Pengajuan</th>
                                <th>Nama Mahasiswa</th>
                                <th>Jenis Pengajuan</th>
                                <th>Tanggal Diajukan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengajuanTerverifikasi as $pengajuan)
                            <tr>
                                <td>{{ $pengajuan->id }}</td>
                                <td>{{ $pengajuan->mahasiswa->nama_lengkap }}</td>
                                <td>{{ Str::replace('_', ' ', Str::title($pengajuan->jenis_pengajuan)) }}</td>
                                <td>{{ $pengajuan->created_at->format('d M Y H:i') }}</td>
                                <td>{{ Str::replace('_', ' ', Str::title($pengajuan->status)) }}</td>
                                <td>
                                    @if ($pengajuan->sidang)
                                        <a href="{{ route('kajur.sidang.show', $pengajuan->sidang->id) }}" class="btn btn-primary">Lihat Detail</a>
                                    @else
                                        <span class="text-muted">Sidang Belum Dijadwalkan</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Toggle sidebar
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
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
        
        // Set active menu item based on current URL
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('.sidebar .menu-item').forEach(item => {
                const link = item.closest('a');
                if (link && link.href === window.location.href) {
                    item.classList.add('active');
                }
            });
            document.querySelectorAll('.sidebar .submenu-item').forEach(item => {
                const link = item.closest('a');
                if (link && link.href === window.location.href) {
                    item.classList.add('active');
                    const parentSubmenu = item.closest('.submenu');
                    if (parentSubmenu) {
                        parentSubmenu.classList.add('show');
                        const parentMenuItem = parentSubmenu.previousElementSibling;
                        if (parentMenuItem && parentMenuItem.classList.contains('menu-item')) {
                            const onclickAttr = parentMenuItem.getAttribute('onclick');
                            if (onclickAttr && onclickAttr.includes('toggleSubmenu')) {
                                parentMenuItem.classList.add('active');
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>