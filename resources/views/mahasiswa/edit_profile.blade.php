<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPRAKTA - Edit Profil Mahasiswa</title>
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
            --sidebar-color: #1e3a8a; /* Dark blue from your image */
            --text-color: #2d3748;
            --light-gray: #f8fafc;
            --white: #ffffff;
            --success: #198754;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #0dcaf0;
            --transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);

            --card-border-radius: 12px;
            /* Removed --header-height as it's no longer fixed */
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
            /* Layout dikelola oleh positioning elemen-elemen di dalamnya */
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

        /* Layout Utama - NEW: Added .container for flexbox layout */
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
            position: fixed; /* Sidebar remains fixed */
            top: 0;
            left: 0;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            z-index: 100;
            animation: slideInLeft 0.5s ease-out;
            transition: var(--transition);
            overflow-y: auto;
            overflow-x: hidden;
            /* Removed padding-top here as logo is now part of scrollable content */
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .logo-img {
            width: 40px;
            margin: 0 auto;
        }

        /* Sembunyikan teks menu, judul, dan submenu saat sidebar diciutkan */
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

        /* Logo container in sidebar - Adjusted to match dashboard.blade.php */
        .logo-container {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: var(--transition);
            /* Removed absolute positioning */
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px; /* Add some space below the logo */
        }

        .logo-container:hover { /* Added from dashboard.blade.php */
            transform: translateY(-3px);
        }

        .sidebar.collapsed .logo-container {
            padding: 0; /* Adjust padding for collapsed state */
            justify-content: center;
            align-items: center;
        }

        .logo-img {
            width: 100%;
            height: auto;
            aspect-ratio: 16/9;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
            transition: var(--transition);
            max-width: 180px; /* Consistent with dashboard.blade.php */
        }
        .sidebar.collapsed .logo-img {
            max-width: 40px;
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

        .menu-item span { /* Pastikan span teks utama selalu display inline-block */
            display: inline-block;
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

        /* Main Content - Adjusted to match dashboard.blade.php */
        .main-content {
            flex: 1; /* NEW: Use flex to occupy remaining space */
            margin-left: 280px; /* Memberikan jarak dari sidebar */
            padding: 30px;
            /* Removed padding-top as header is no longer fixed */
            animation: fadeIn 0.6s 0.2s both;
            transition: margin-left var(--transition), padding-top var(--transition);
        }

        .main-content.expanded {
            margin-left: 80px; /* Jarak dari sidebar saat diciutkan */
        }

        /* Header (Now NOT Fixed, similar to dashboard.blade.php) */
        .header {
            position: relative; /* Changed from fixed to relative */
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--white);
            padding: 15px 25px;
            border-radius: 10px; /* Added border-radius from dashboard */
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px; /* Added margin-bottom from dashboard */
            animation: fadeIn 0.6s 0.3s both;
            /* Removed height, border-bottom as per dashboard.blade.php */
            box-sizing: border-box;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            /* Removed specific padding-left/right as it's handled by main-content margin */
            box-sizing: border-box;
        }

        /* Removed specific body.sidebar-collapsed .header .header-content */

        .toggle-sidebar { /* Added from dashboard.blade.php */
            background: none;
            border: none;
            color: var(--primary-500);
            font-size: 20px;
            cursor: pointer;
            margin-right: 15px;
            transition: var(--transition);
        }

        .toggle-sidebar:hover { /* Added from dashboard.blade.php */
            transform: scale(1.1);
            color: var(--primary-700);
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

        /* Hide tooltiptext when sidebar is NOT collapsed */
        .sidebar:not(.collapsed) .menu-item .tooltiptext {
            display: none;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        /* Form Styling - Renamed to .main-card to align with dashboard.blade.php's card styling */
        .main-card { /* Renamed from .form-container */
            background: var(--white);
            border-radius: var(--card-border-radius);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 30px;
            margin-bottom: 30px;
            animation: fadeIn 0.6s 0.4s both;
            /* Added border property from dashboard.blade.php's .dashboard-card */
            border: 1px solid rgba(0, 0, 0, 0.05);
            /* Added hover effect from dashboard.blade.php's .dashboard-card */
            transition: var(--transition);
        }

        .main-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-color);
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="number"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #94a3b8; /* Clearer border for input fields */
            border-radius: 8px;
            font-size: 1rem;
            color: var(--text-color);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="number"]:focus,
        .form-group input[type="password"]:focus {
            outline: none;
            border-color: var(--primary-500);
            box-shadow: 0 0 0 3px rgba(26, 136, 255, 0.2);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none; /* For links styled as buttons */
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-500), var(--primary-600));
            color: white;
            box-shadow: 0 4px 12px rgba(26, 136, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(26, 136, 255, 0.4);
        }

        .btn-secondary {
            background-color: var(--light-gray);
            color: var(--text-color);
            border: 1px solid var(--primary-100); /* Use a primary color for secondary button border */
        }

        .btn-secondary:hover {
            background-color: var(--primary-100);
            transform: translateY(-2px);
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .alert-success {
            background-color: rgba(40, 167, 69, 0.15);
            color: var(--success);
            border: 1px solid var(--success);
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.15);
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.875em;
            margin-top: 5px;
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
                /* Removed padding-top adjustment for fixed header */
            }

            .header {
                flex-direction: column; /* Changed from row to column to match dashboard */
                align-items: flex-start; /* Changed from center to flex-start */
                padding: 15px;
                height: auto;
            }

            .header-content {
                flex-direction: column; /* Changed from row to column */
                align-items: flex-start; /* Changed from center to flex-start */
                width: 100%;
                max-width: none;
                padding-left: 0;
                padding-right: 0;
            }

            /* Removed specific body > .header .header-content */

            .user-profile {
                margin-top: 15px; /* Added margin-top from dashboard */
                width: 100%; /* Set width to 100% from dashboard */
                justify-content: space-between; /* Set justify-content from dashboard */
            }

            .profile-dropdown {
                right: auto; /* Changed from right: 0 to auto */
                left: 0; /* Added left: 0 to align with dashboard */
                width: 100%; /* Set width to 100% from dashboard */
            }

            .form-actions {
                flex-direction: column;
                gap: 10px;
            }
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container"> <div class="sidebar" id="sidebar">
            <div class="logo-container">
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
            <div class="header"> <div class="header-content">
                    <div style="display: flex; align-items: center;">
                        <button class="toggle-sidebar" id="toggleSidebar">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 style="font-size: 28px; color: var(--primary-700);">
                            <i class="fas fa-user-edit" style="margin-right: 15px;"></i>
                            Edit Profil Mahasiswa
                        </h1>
                    </div>
                    <div class="user-profile" id="userProfile">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($mahasiswa->nama) }}&background=1a88ff&color=fff"
                             style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                        <span style="font-weight: 500;">{{ $mahasiswa->nama_lengkap }}</span>
                        <i class="fas fa-chevron-down" style="margin-left: 8px; font-size: 12px;"></i>

                        <div class="profile-dropdown" id="profileDropdown">
                            <a href="{{ route('mahasiswa.profile.edit') }}" class="dropdown-item active">
                                <i class="fas fa-user-edit"></i>
                                <span>Edit Profil</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('mahasiswa.logout') }}" method="POST" style="display: none;" id="logout-form">
                                @csrf
                            </form>
                            <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Keluar</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-card"> @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('mahasiswa.profile.update') }}" method="POST">
                    @csrf
                    @method('POST') {{-- Use POST method for form submission, but indicate it's an update --}}

                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama', $mahasiswa->nama_lengkap) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required>
                        @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $mahasiswa->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="prodi">Program Studi</label>
                        <input type="text" id="prodi" name="prodi" value="{{ old('prodi', $mahasiswa->prodi) }}">
                        @error('prodi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="angkatan">Angkatan</label>
                        <input type="number" id="angkatan" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}">
                        @error('angkatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nomor_hp">Nomor HP</label>
                        <input type="text" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp', $mahasiswa->nomor_hp) }}">
                        @error('nomor_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-actions">
                        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        // const body = document.body; // No longer needed for body class toggle

        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            // body.classList.toggle('sidebar-collapsed'); // Removed

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
            submenu.classList.toggle('show');

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

        // Set active menu item based on current route
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('.menu-item').forEach(item => {
                const link = item.querySelector('a');
                // Check if the menu-item itself is a direct link
                if (item.matches('a.menu-item') && item.href === window.location.href) {
                     item.classList.add('active');
                } else if (link && link.href === window.location.href) {
                    item.classList.add('active');
                }

                // Check for submenu items
                const submenuItems = item.querySelectorAll('.submenu-item a');
                submenuItems.forEach(subItem => {
                    if (subItem.href === window.location.href) {
                        subItem.parentElement.classList.add('active'); // Activate the submenu-item div
                        const parentSubmenu = subItem.closest('.submenu');
                        if (parentSubmenu) {
                            parentSubmenu.classList.add('show'); // Ensure parent submenu is open
                            // No need to add 'active' to the parent menu-item unless its own link matches
                        }
                    }
                });
            });

            // Specific activation for Edit Profil menu item if it's in the sidebar (which it isn't currently, but for completeness)
            const editProfileDropdownItem = document.querySelector('.profile-dropdown .dropdown-item[href="{{ route('mahasiswa.profile.edit') }}"]');
            if (editProfileDropdownItem) {
                editProfileDropdownItem.classList.add('active');
            }
        });
    </script>
</body>
</html>