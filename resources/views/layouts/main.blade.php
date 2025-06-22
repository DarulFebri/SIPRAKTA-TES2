<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPRAKTA')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
    @yield('head')
    <style>
        /* CSS Variables */
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
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --draft-button-bg: #6c757d;
            --draft-button-hover: #5a6268;
            --transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);

            /* For form elements */
            --light-blue-bg: #e6f2ff;
            --medium-grey: #dee2e6;
            --dark-grey: #495057;
            --border-color: #ced4da;
            --error-color: #dc3545;
            --shadow-medium: 0 4px 15px rgba(0,0,0,0.1);
            --border-radius: 10px;

            /* For notification */
            --section-bg: #fdfdfd;
            --section-border: #e0e0e0;
            --filter-btn-active-bg: var(--primary-500);
            --filter-btn-active-color: var(--white);
            --filter-btn-hover-bg: #f0f0f0;
            --notification-item-bg: var(--white);
            --notification-item-border: #eee;
            --notification-item-unread-bg: rgba(26, 136, 255, 0.05);
        }

        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
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

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--sidebar-color), #172554);
            color: var(--white);
            padding: 20px 0;
            height: 100vh;
            position: fixed;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            z-index: 10;
            animation: slideInLeft 0.5s ease-out;
            transition: width 0.4s ease;
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
            text-decoration: none; /* Ensure links don't have underline */
            color: inherit; /* Ensure link color is inherited */
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
            max-height: 300px; /* Adjust as needed for actual submenu height */
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
            text-decoration: none; /* Ensure links don't have underline */
            color: inherit; /* Ensure link color is inherited */
        }

        .submenu-item i {
            margin-right: 10px;
            font-size: 12px;
        }

        .submenu-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: var(--primary-200);
        }
        .submenu-item.active {
            background-color: rgba(255,255,255,0.2); /* Slightly different active for submenu */
            color: var(--primary-100);
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
            animation: fadeIn 0.6s 0.2s both;
            transition: margin-left 0.4s ease;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* Header Styles */
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

        /* User Profile Dropdown */
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

        /* General Container & Form Styling */
        .form-container, .card-container, .password-card, .notification-section, .list-container, .detail-container {
            background-color: var(--white);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            animation: fadeIn 0.6s 0.4s both;
        }
        .form-title, .section-title, .card-title, .welcome-title, .page-title {
            color: var(--primary-700);
            margin-bottom: 25px;
            font-size: 22px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        .form-title i, .section-title i, .card-title i, .page-title i {
            margin-right: 15px;
            color: var(--primary-500);
        }

        /* Form elements */
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }
        .form-group input:not([type="radio"]),
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 15px;
            transition: var(--transition);
            background-color: var(--light-blue-bg);
            color: var(--text-color);
        }
        .form-group input:not([type="radio"]):focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary-400);
            box-shadow: 0 0 0 3px var(--primary-100);
            outline: none;
        }
        .error-message {
            color: var(--error-color);
            font-size: 0.85em;
            margin-top: 5px;
            display: block;
        }
        .small-text {
            font-size: 0.8em;
            color: var(--dark-grey);
            margin-top: 5px;
            display: block;
        }
        .current-file {
            font-size: 0.9em;
            color: var(--dark-grey);
            margin-top: 5px;
        }
        .current-file a {
            color: var(--primary-500);
            text-decoration: none;
        }
        .current-file a:hover {
            text-decoration: underline;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            text-decoration: none; /* For anchor tags styled as buttons */
            display: inline-flex; /* For consistent icon alignment */
            align-items: center;
            justify-content: center;
        }
        .btn i {
            margin-right: 8px;
        }
        .btn-primary {
            background-color: var(--primary-500);
            color: var(--white);
        }
        .btn-primary:hover {
            background-color: var(--primary-600);
            transform: translateY(-2px);
        }
        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-500);
            color: var(--primary-500);
        }
        .btn-outline:hover {
            background-color: var(--primary-100);
            transform: translateY(-2px);
        }
        .btn-danger {
            background-color: var(--danger-color);
            color: var(--white);
        }
        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
        .btn-success {
            background-color: var(--success-color);
            color: var(--white);
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-info {
            background-color: var(--info-color);
            color: var(--white);
        }
        .btn-info:hover {
            background-color: #138496;
        }
        .btn-warning {
            background-color: var(--warning-color);
            color: var(--text-color);
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .footer-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }
        .back-link {
            display: inline-block;
            text-align: center;
            margin-top: 30px;
            color: var(--primary-500);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .back-link:hover {
            text-decoration: underline;
            color: var(--primary-700);
        }
        .button-draft {
            background-color: var(--draft-button-bg);
        }
        .button-draft:hover {
            background-color: var(--draft-button-hover);
        }

        /* Alert Box */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            animation: fadeIn 0.6s 0.3s both;
        }
        .alert-info {
            background-color: var(--primary-100);
            color: var(--primary-700);
            border-left: 4px solid var(--primary-500);
        }
        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
            border: 1px solid var(--success-color);
        }
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
            border: 1px solid var(--danger-color);
        }
        .alert i {
            margin-right: 15px;
            font-size: 20px;
        }

        /* Document Table (for forms with file requirements) */
        .document-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            animation: fadeIn 0.6s 0.5s both;
        }
        .document-table thead tr {
            background-color: var(--primary-600);
            color: var(--white);
            text-align: left;
        }
        .document-table th, .document-table td {
            padding: 15px 20px;
        }
        .document-table tbody tr {
            border-bottom: 1px solid #eee;
        }
        .document-table tbody tr:nth-of-type(even) {
            background-color: var(--light-gray);
        }
        .document-table tbody tr:last-of-type {
            border-bottom: 2px solid var(--primary-600);
        }
        .document-table tbody tr:hover {
            background-color: var(--primary-100);
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            display: inline-block;
        }
        .status-uploaded {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }
        .status-pending {
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--warning-color);
        }
        .status-verified {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }
        .status-rejected {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }

        /* Generic Table Styling (for lists) */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden; /* Ensures rounded corners apply to content */
        }
        table thead tr {
            background-color: var(--primary-600);
            color: var(--white);
            text-align: left;
        }
        table th, table td {
            padding: 15px 20px;
            border: 1px solid #e9e9e9;
            text-align: left;
            font-size: 0.95em;
        }
        table th {
            text-transform: uppercase;
        }
        table tbody tr:nth-child(even) {
            background-color: #fcfcfc;
        }
        table tbody tr:hover {
            background-color: var(--primary-100);
        }
        .no-data {
            text-align: center;
            color: #777;
            padding: 30px;
            font-size: 1.1em;
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        /* Detail View Styling */
        .detail-group {
            margin-bottom: 15px;
            padding-left: 15px;
            border-left: 5px solid var(--primary-500);
            background-color: var(--primary-100);
            padding: 10px 15px;
            border-radius: 4px;
        }
        .detail-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: var(--primary-700);
        }
        .detail-group p {
            margin: 0;
            color: var(--text-color);
            line-height: 1.5;
        }
        .detail-section-title {
            margin-top: 35px;
            margin-bottom: 20px;
            color: var(--primary-700);
            border-bottom: 2px solid var(--primary-500);
            padding-bottom: 8px;
            font-size: 1.5em;
            font-weight: 600;
        }
        .document-list {
            list-style: none;
            padding: 0;
            margin-top: 15px;
        }
        .document-item {
            margin-bottom: 10px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--white);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .document-item span {
            font-weight: bold;
            color: var(--text-color);
        }
        .document-item a {
            text-decoration: none;
            color: var(--primary-500);
            font-weight: bold;
            transition: color 0.2s ease-in-out;
        }
        .document-item a:hover {
            color: var(--primary-700);
            text-decoration: underline;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            display: flex; /* Use flexbox for centering */
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .modal.show {
            opacity: 1;
            visibility: visible;
        }
        .modal-content {
            background-color: var(--white);
            padding: 25px;
            border-radius: 12px;
            width: 500px;
            max-width: 90%;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            position: relative;
            transform: translateY(-20px);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        .modal.show .modal-content {
            transform: translateY(0);
            opacity: 1;
        }
        .close-modal {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            color: var(--text-color);
        }
        .modal-title {
            color: var(--primary-700);
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        .modal-title i {
            margin-right: 10px;
            color: var(--primary-500);
        }
        .modal-body {
            margin-bottom: 25px;
        }
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        /* File Upload Styles (for modals/separate forms) */
        .file-upload-container {
            margin-bottom: 20px;
        }
        .file-upload-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .file-upload-input {
            width: 100%;
            padding: 12px;
            border: 1px dashed #ccc;
            border-radius: 8px;
            background-color: var(--light-gray);
            cursor: pointer;
            transition: var(--transition);
        }
        .file-upload-input:hover {
            border-color: var(--primary-500);
            background-color: var(--primary-100);
        }

        /* Tooltip for sidebar collapsed */
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

        /* Welcome Box (for dashboards) */
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

        /* Card container for dashboards */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: var(--transition);
            border-top: 3px solid var(--primary-500);
            text-align: center;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }
        .card-icon {
            font-size: 40px;
            color: var(--primary-500);
            margin-bottom: 15px;
        }
        .card-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-700);
            margin-bottom: 5px;
        }
        .card-label {
            font-size: 16px;
            color: var(--text-color);
        }

        /* Notification specific styles */
        .notification-section {
            background-color: var(--section-bg);
            border: 1px solid var(--section-border);
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        .notification-filters .filter-btn {
            background-color: transparent;
            border: 1px solid var(--primary-500);
            color: var(--primary-500);
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
            margin-left: 10px;
        }
        .notification-filters .filter-btn:hover {
            background-color: var(--filter-btn-hover-bg);
        }
        .notification-filters .filter-btn.active {
            background-color: var(--filter-btn-active-bg);
            color: var(--filter-btn-active-color);
        }
        .notification-list {
            padding: 0;
            list-style: none;
        }
        .notification-item {
            display: flex;
            align-items: flex-start;
            padding: 15px 20px;
            border-bottom: 1px solid var(--notification-item-border);
            position: relative;
            transition: var(--transition);
            background-color: var(--notification-item-bg);
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .notification-item:last-child {
            border-bottom: none;
        }
        .notification-item:hover {
            background-color: var(--primary-100);
            padding-left: 25px;
        }
        .notification-icon {
            margin-right: 15px;
            font-size: 20px;
            margin-top: 3px;
            flex-shrink: 0;
        }
        .notification-content {
            flex: 1;
        }
        .notification-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--text-color);
            font-size: 16px; /* Override common form-title size */
        }
        .notification-message {
            color: var(--text-color);
            line-height: 1.5;
            margin-bottom: 5px;
        }
        .notification-time {
            font-size: 12px;
            color: #666;
        }
        .notification-badge {
            position: absolute;
            right: 20px;
            top: 20px;
            background-color: var(--primary-500);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
        }
        .notification-item.unread {
            background-color: var(--notification-item-unread-bg);
        }
        .notification-item.unread .notification-title {
            font-weight: 700;
        }

        /* Login page specific styling */
        .login-page-body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5; /* Light grey background */
            transition: none; /* Disable transition for simple login page */
        }
        .login-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 30px;
            text-align: center;
            animation: fadeIn 0.5s ease;
        }
        .login-logo-img {
            width: 200px;
            aspect-ratio: 16/9;
            object-fit: contain;
            display: block;
            margin: 0 auto 25px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        .login-input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .login-input-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        .login-input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .login-input-group input:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        .login-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            font-size: 14px;
        }
        .login-remember-me {
            display: flex;
            align-items: center;
        }
        .login-remember-me input {
            margin-right: 5px;
        }
        .login-forgot-password {
            color: #3498db;
            text-decoration: none;
        }
        .login-button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }
        .login-button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .login-footer {
            color: #7f8c8d;
            font-size: 12px;
            margin-top: 20px;
            line-height: 1.5;
        }
        .login-footer p:first-child {
            margin-bottom: 5px;
        }
        .auth-message {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 0.95em;
            text-align: center;
        }
        .auth-message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .auth-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .password-change-card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .password-change-header {
            margin-bottom: 30px;
            text-align: center;
        }
        .password-change-header h1 {
            color: var(--primary-600);
            margin-bottom: 10px;
        }
        .password-change-header p {
            color: var(--text-color);
            opacity: 0.8;
        }
        .password-form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }


        /* Responsive */
        @media (max-width: 768px) {
            .sidebar:not(.no-collapse) { /* Apply collapse only if not explicitly told not to */
                width: 80px;
            }
            .sidebar:not(.no-collapse) .menu-title,
            .sidebar:not(.no-collapse) .menu-item span,
            .sidebar:not(.no-collapse) .submenu {
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
            .footer-buttons, .password-form-actions {
                flex-direction: column;
                gap: 10px;
            }
            .btn {
                width: 100%;
            }
            .login-container {
                width: 90%;
                padding: 20px;
            }
            .login-logo-img {
                width: 180px;
            }
            table th, table td {
                padding: 10px 12px;
                font-size: 0.85em;
            }
            .document-table th, .document-table td {
                padding: 10px 12px;
            }
            .form-title, .section-title, .card-title, .welcome-title, .page-title {
                font-size: 20px;
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 15px;
            }
            .form-title i, .section-title i, .card-title i, .page-title i {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body class="@yield('body_class')">
    @if (!request()->routeIs('*.login') && !request()->routeIs('mahasiswa.forgot.password.form') && !request()->routeIs('mahasiswa.otp.verify.form') && !request()->routeIs('mahasiswa.password.reset.form') && !request()->routeIs('mahasiswa.password.reset.success'))
    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
        <div class="logo-container">
            <img src="{{ asset('assets/images/sipraktawhite2.png') }}" alt="Logo SIPRAKTA" class="logo-img">
        </div>

        <div class="menu-title">Menu Utama</div>

        {{-- Admin Menu --}}
        @auth('admin')
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} tooltip">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
                <span class="tooltiptext">Dashboard</span>
            </a>
            <div class="menu-item tooltip {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}" onclick="toggleSubmenu('mahasiswa')">
                <i class="fas fa-user-graduate"></i>
                <span>Mahasiswa</span>
                <span class="tooltiptext">Mahasiswa</span>
            </div>
            <div class="submenu {{ request()->routeIs('admin.mahasiswa.*') ? 'show' : '' }}" id="mahasiswa-submenu">
                <a href="{{ route('admin.mahasiswa.index') }}" class="submenu-item tooltip {{ request()->routeIs('admin.mahasiswa.index') || request()->routeIs('admin.mahasiswa.show') || request()->routeIs('admin.mahasiswa.edit') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Data Mahasiswa</span>
                    <span class="tooltiptext">Data Mahasiswa</span>
                </a>
                <a href="{{ route('admin.mahasiswa.create') }}" class="submenu-item tooltip {{ request()->routeIs('admin.mahasiswa.create') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Tambah Mahasiswa</span>
                    <span class="tooltiptext">Tambah Mahasiswa</span>
                </a>
                <a href="{{ route('admin.mahasiswa.import.form') }}" class="submenu-item tooltip {{ request()->routeIs('admin.mahasiswa.import.form') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Impor Mahasiswa</span>
                    <span class="tooltiptext">Impor Mahasiswa</span>
                </a>
            </div>
            <div class="menu-item tooltip {{ request()->routeIs('admin.dosen.*') ? 'active' : '' }}" onclick="toggleSubmenu('dosen')">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Dosen</span>
                <span class="tooltiptext">Dosen</span>
            </div>
            <div class="submenu {{ request()->routeIs('admin.dosen.*') ? 'show' : '' }}" id="dosen-submenu">
                <a href="{{ route('admin.dosen.index') }}" class="submenu-item tooltip {{ request()->routeIs('admin.dosen.index') || request()->routeIs('admin.dosen.show') || request()->routeIs('admin.dosen.edit') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Data Dosen</span>
                    <span class="tooltiptext">Data Dosen</span>
                </a>
                <a href="{{ route('admin.dosen.create') }}" class="submenu-item tooltip {{ request()->routeIs('admin.dosen.create') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Tambah Dosen</span>
                    <span class="tooltiptext">Tambah Dosen</span>
                </a>
                <a href="{{ route('admin.dosen.import.form') }}" class="submenu-item tooltip {{ request()->routeIs('admin.dosen.import.form') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Impor Dosen</span>
                    <span class="tooltiptext">Impor Dosen</span>
                </a>
            </div>
            <div class="menu-item tooltip {{ request()->routeIs('admin.pengajuan.*') || request()->routeIs('admin.pengajuan.verifikasi.*') ? 'active' : '' }}" onclick="toggleSubmenu('pengajuan')">
                <i class="fas fa-file-invoice"></i>
                <span>Pengajuan</span>
                <span class="tooltiptext">Pengajuan</span>
            </div>
            <div class="submenu {{ request()->routeIs('admin.pengajuan.*') || request()->routeIs('admin.pengajuan.verifikasi.*') ? 'show' : '' }}" id="pengajuan-submenu">
                <a href="{{ route('admin.pengajuan.index') }}" class="submenu-item tooltip {{ request()->routeIs('admin.pengajuan.index') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Semua Pengajuan</span>
                    <span class="tooltiptext">Semua Pengajuan</span>
                </a>
                <a href="{{ route('admin.pengajuan.verifikasi.index') }}" class="submenu-item tooltip {{ request()->routeIs('admin.pengajuan.verifikasi.index') || request()->routeIs('admin.pengajuan.verifikasi.show') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Verifikasi Pengajuan</span>
                    <span class="tooltiptext">Verifikasi Pengajuan</span>
                </a>
            </div>
            <div class="menu-item tooltip {{ request()->routeIs('admin.sidang.*') ? 'active' : '' }}" onclick="toggleSubmenu('sidang')">
                <i class="fas fa-calendar-alt"></i>
                <span>Sidang</span>
                <span class="tooltiptext">Sidang</span>
            </div>
            <div class="submenu {{ request()->routeIs('admin.sidang.*') ? 'show' : '' }}" id="sidang-submenu">
                <a href="{{ route('admin.sidang.index') }}" class="submenu-item tooltip {{ request()->routeIs('admin.sidang.index') || request()->routeIs('admin.sidang.show') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Daftar Sidang</span>
                    <span class="tooltiptext">Daftar Sidang</span>
                </a>
                <a href="{{ route('admin.sidang.kalender') }}" class="submenu-item tooltip {{ request()->routeIs('admin.sidang.kalender') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Kalender Sidang</span>
                    <span class="tooltiptext">Kalender Sidang</span>
                </a>
            </div>
            <a href="{{ route('admin.activities.index') }}" class="menu-item {{ request()->routeIs('admin.activities.index') ? 'active' : '' }} tooltip">
                <i class="fas fa-history"></i>
                <span>Log Aktivitas</span>
                <span class="tooltiptext">Log Aktivitas</span>
            </a>
        @endauth

        {{-- Mahasiswa Menu --}}
        @auth('mahasiswa')
            <a href="{{ route('mahasiswa.dashboard') }}" class="menu-item {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }} tooltip">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
                <span class="tooltiptext">Dashboard</span>
            </a>
            <div class="menu-item tooltip {{ request()->routeIs('mahasiswa.pengajuan.*') || request()->routeIs('mahasiswa.dokumen.*') ? 'active' : '' }}" onclick="toggleSubmenu('pengajuan_mhs')">
                <i class="fas fa-file-upload"></i>
                <span>Pengajuan Sidang</span>
                <span class="tooltiptext">Pengajuan Sidang</span>
            </div>
            <div class="submenu {{ request()->routeIs('mahasiswa.pengajuan.*') || request()->routeIs('mahasiswa.dokumen.*') ? 'show' : '' }}" id="pengajuan_mhs-submenu">
                <a href="{{ route('mahasiswa.pengajuan.pilih') }}" class="submenu-item tooltip {{ request()->routeIs('mahasiswa.pengajuan.pilih') || request()->routeIs('mahasiswa.pengajuan.create') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Buat Pengajuan Baru</span>
                    <span class="tooltiptext">Buat Pengajuan Baru</span>
                </a>
                <a href="{{ route('mahasiswa.pengajuan.index') }}" class="submenu-item tooltip {{ request()->routeIs('mahasiswa.pengajuan.index') || request()->routeIs('mahasiswa.pengajuan.show') || request()->routeIs('mahasiswa.pengajuan.edit') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Daftar Pengajuan Saya</span>
                    <span class="tooltiptext">Daftar Pengajuan Saya</span>
                </a>
            </div>
            <a href="{{ route('mahasiswa.dashboard') }}#jadwal-sidang" class="menu-item tooltip"> {{-- Assuming dashboard has a section for schedule --}}
                <i class="fas fa-calendar-alt"></i>
                <span>Jadwal Sidang</span>
                <span class="tooltiptext">Jadwal Sidang</span>
            </a>
            <a href="#" class="menu-item tooltip"> {{-- Placeholder for Mahasiswa Notifications --}}
                <i class="fas fa-bell"></i>
                <span>Notifikasi</span>
                <span class="tooltiptext">Notifikasi</span>
            </a>
        @endauth

        {{-- Dosen Menu --}}
        @auth('dosen')
            <a href="{{ route('dosen.dashboard') }}" class="menu-item {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }} tooltip">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
                <span class="tooltiptext">Dashboard</span>
            </a>
            <div class="menu-item tooltip {{ request()->routeIs('dosen.pengajuan.*') || request()->routeIs('dosen.dokumen.*') || request()->routeIs('dosen.jadwal.*') || request()->routeIs('dosen.sidang.*') ? 'active' : '' }}" onclick="toggleSubmenu('sidang_dosen')">
                <i class="fas fa-briefcase"></i>
                <span>Manajemen Sidang</span>
                <span class="tooltiptext">Manajemen Sidang</span>
            </div>
            <div class="submenu {{ request()->routeIs('dosen.pengajuan.*') || request()->routeIs('dosen.dokumen.*') || request()->routeIs('dosen.jadwal.*') || request()->routeIs('dosen.sidang.*') ? 'show' : '' }}" id="sidang_dosen-submenu">
                <a href="{{ route('dosen.pengajuan.saya') }}" class="submenu-item tooltip {{ request()->routeIs('dosen.pengajuan.saya') || request()->routeIs('dosen.pengajuan.show') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Pengajuan Saya</span>
                    <span class="tooltiptext">Pengajuan Saya</span>
                </a>
                <a href="{{ route('dosen.pengajuan.index') }}" class="submenu-item tooltip {{ request()->routeIs('dosen.pengajuan.index') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Semua Pengajuan</span>
                    <span class="tooltiptext">Semua Pengajuan</span>
                </a>
                <a href="{{ route('dosen.dashboard') }}" class="submenu-item tooltip"> {{-- Assuming dashboard lists schedules --}}
                    <i class="fas fa-chevron-right"></i>
                    <span>Jadwal Sidang</span>
                    <span class="tooltiptext">Jadwal Sidang</span>
                </a>
            </div>
            <a href="{{ route('dosen.notifications.markAsRead', ['notification' => 'dummy_id']) }}" class="menu-item tooltip {{ request()->routeIs('dosen.notifications.*') ? 'active' : '' }}"> {{-- This route seems like an action, not a view, adjusting for notification page --}}
                <i class="fas fa-bell"></i>
                <span>Notifikasi</span>
                <span class="tooltiptext">Notifikasi</span>
            </a>
        @endauth

        {{-- Kaprodi Menu --}}
        @auth('kaprodi')
            <a href="{{ route('kaprodi.dashboard') }}" class="menu-item {{ request()->routeIs('kaprodi.dashboard') ? 'active' : '' }} tooltip">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
                <span class="tooltiptext">Dashboard</span>
            </a>
            <div class="menu-item tooltip {{ request()->routeIs('kaprodi.pengajuan.*') ? 'active' : '' }}" onclick="toggleSubmenu('pengajuan_kaprodi')">
                <i class="fas fa-file-signature"></i>
                <span>Manajemen Pengajuan</span>
                <span class="tooltiptext">Manajemen Pengajuan</span>
            </div>
            <div class="submenu {{ request()->routeIs('kaprodi.pengajuan.*') ? 'show' : '' }}" id="pengajuan_kaprodi-submenu">
                <a href="{{ route('kaprodi.pengajuan.index') }}" class="submenu-item tooltip {{ request()->routeIs('kaprodi.pengajuan.index') || request()->routeIs('kaprodi.pengajuan.show') || request()->routeIs('kaprodi.pengajuan.aksi') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Daftar Pengajuan</span>
                    <span class="tooltiptext">Daftar Pengajuan</span>
                </a>
            </div>
            <a href="{{ route('kaprodi.dosen.index') }}" class="menu-item {{ request()->routeIs('kaprodi.dosen.index') ? 'active' : '' }} tooltip">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Daftar Dosen</span>
                <span class="tooltiptext">Daftar Dosen</span>
            </a>
            {{-- Assuming notifications for Kaprodi would be a separate page or integrated into dashboard --}}
            <a href="#" class="menu-item tooltip">
                <i class="fas fa-bell"></i>
                <span>Notifikasi</span>
                <span class="tooltiptext">Notifikasi</span>
            </a>
        @endauth

        {{-- Kajur Menu --}}
        @auth('kajur')
            <a href="{{ route('kajur.dashboard') }}" class="menu-item {{ request()->routeIs('kajur.dashboard') ? 'active' : '' }} tooltip">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
                <span class="tooltiptext">Dashboard</span>
            </a>
            <div class="menu-item tooltip {{ request()->routeIs('kajur.pengajuan.*') ? 'active' : '' }}" onclick="toggleSubmenu('pengajuan_kajur')">
                <i class="fas fa-tasks"></i>
                <span>Verifikasi Pengajuan</span>
                <span class="tooltiptext">Verifikasi Pengajuan</span>
            </div>
            <div class="submenu {{ request()->routeIs('kajur.pengajuan.*') ? 'show' : '' }}" id="pengajuan_kajur-submenu">
                <a href="{{ route('kajur.pengajuan.perlu_verifikasi') }}" class="submenu-item tooltip {{ request()->routeIs('kajur.pengajuan.perlu_verifikasi') || request()->routeIs('kajur.verifikasi.form') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Perlu Verifikasi</span>
                    <span class="tooltiptext">Perlu Verifikasi</span>
                </a>
                <a href="{{ route('kajur.pengajuan.sudah_verifikasi') }}" class="submenu-item tooltip {{ request()->routeIs('kajur.pengajuan.sudah_verifikasi') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Sudah Verifikasi</span>
                    <span class="tooltiptext">Sudah Verifikasi</span>
                </a>
            </div>
            <div class="menu-item tooltip {{ request()->routeIs('kajur.sidang.*') ? 'active' : '' }}" onclick="toggleSubmenu('sidang_kajur')">
                <i class="fas fa-calendar-check"></i>
                <span>Informasi Sidang</span>
                <span class="tooltiptext">Informasi Sidang</span>
            </div>
            <div class="submenu {{ request()->routeIs('kajur.sidang.*') ? 'show' : '' }}" id="sidang_kajur-submenu">
                <a href="{{ route('kajur.sidang.akan') }}" class="submenu-item tooltip {{ request()->routeIs('kajur.sidang.akan') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Sidang Akan Datang</span>
                    <span class="tooltiptext">Sidang Akan Datang</span>
                </a>
                <a href="{{ route('kajur.sidang.sedang') }}" class="submenu-item tooltip {{ request()->routeIs('kajur.sidang.sedang') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Sidang Sedang Berlangsung</span>
                    <span class="tooltiptext">Sidang Sedang Berlangsung</span>
                </a>
                <a href="{{ route('kajur.sidang.telah') }}" class="submenu-item tooltip {{ request()->routeIs('kajur.sidang.telah') ? 'active' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                    <span>Sidang Telah Selesai</span>
                    <span class="tooltiptext">Sidang Telah Selesai</span>
                </a>
            </div>
            {{-- Assuming notifications for Kajur would be a separate page or integrated into dashboard --}}
            <a href="#" class="menu-item tooltip">
                <i class="fas fa-bell"></i>
                <span>Notifikasi</span>
                <span class="tooltiptext">Notifikasi</span>
            </a>
        @endauth

        <form action="{{ route(Auth::getDefaultDriver() . '.logout') }}" method="POST" class="menu-item tooltip">
            @csrf
            <button type="submit" style="background: none; border: none; color: inherit; display: flex; align-items: center; width: 100%; cursor: pointer;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
                <span class="tooltiptext">Logout</span>
            </button>
        </form>
    </div>
    @endif

    <!-- Main Content -->
    <div class="main-content @if (request()->routeIs('*.login') || request()->routeIs('mahasiswa.forgot.password.form') || request()->routeIs('mahasiswa.otp.verify.form') || request()->routeIs('mahasiswa.password.reset.form') || request()->routeIs('mahasiswa.password.reset.success')) full-width-content @else expanded @endif" id="mainContent">
        @if (!request()->routeIs('*.login') && !request()->routeIs('mahasiswa.forgot.password.form') && !request()->routeIs('mahasiswa.otp.verify.form') && !request()->routeIs('mahasiswa.password.reset.form') && !request()->routeIs('mahasiswa.password.reset.success'))
        <div class="header" id="mainHeader">
            <div class="header-content">
                <div style="display: flex; align-items: center;">
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 style="font-size: 28px; color: var(--primary-700);">
                        @yield('header_title')
                    </h1>
                </div>
                <div class="user-profile" id="userProfile">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::check() ? urlencode(Auth::user()->name ?? Auth::user()->nama_lengkap ?? Auth::user()->email) : 'User' }}&background=1a88ff&color=fff"
                         style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                    <span style="font-weight: 500;">{{ Auth::check() ? (Auth::user()->name ?? Auth::user()->nama_lengkap ?? Auth::user()->email) : 'Guest' }}</span>
                    <i class="fas fa-chevron-down" style="margin-left: 8px; font-size: 12px;"></i>

                    <!-- Dropdown Menu -->
                    <div class="profile-dropdown" id="profileDropdown">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>Profil Saya</span>
                        </a>
                        <a href="{{ Auth::getDefaultDriver() == 'mahasiswa' ? route('mahasiswa.dashboard') : '#' }}" class="dropdown-item"> {{-- Adjust for specific user role password change if needed --}}
                            <i class="fas fa-key"></i>
                            <span>Ubah Sandi</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route(Auth::getDefaultDriver() . '.logout') }}" method="POST" class="dropdown-item">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: inherit; display: flex; align-items: center; width: 100%; cursor: pointer; text-align: left;">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @yield('content')
    </div>

    <script>
        // Check if the current route is a login/auth page to adjust sidebar visibility
        const isAuthPage = document.body.classList.contains('login-page-body');

        if (!isAuthPage) {
            // Toggle sidebar
            const toggleSidebar = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            // Set initial state of main content based on sidebar collapsed class
            if (sidebar.classList.contains('collapsed')) {
                mainContent.classList.add('expanded');
            } else {
                mainContent.classList.remove('expanded');
            }

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
            window.toggleSubmenu = function(menu) {
                const submenu = document.getElementById(`${menu}-submenu`);
                const menuItem = document.querySelector(`.menu-item[onclick="toggleSubmenu('${menu}')"]`);

                // Toggle current submenu
                if (submenu) { // Ensure submenu exists
                    submenu.classList.toggle('show');
                }


                // Close other submenus
                document.querySelectorAll('.submenu').forEach(item => {
                    if (item.id !== `${menu}-submenu`) {
                        item.classList.remove('show');
                    }
                });

                // Update active state for main menu item
                document.querySelectorAll('.menu-item').forEach(item => {
                    if (item !== menuItem && !item.contains(submenu)) { // Avoid deactivating parent if its submenu is open
                         // Only remove active if it's not the clicked item and not a parent of an active submenu
                         if (!item.classList.contains('active') || !item.querySelector('.submenu.show')) {
                             item.classList.remove('active');
                         }
                    }
                });

                if (menuItem) { // Ensure menuItem exists
                     if (submenu && submenu.classList.contains('show')) {
                        menuItem.classList.add('active');
                    } else {
                        // Deactivate only if no submenu is open under it
                        if (!menuItem.querySelector('.submenu.show')) {
                             menuItem.classList.remove('active');
                        }
                    }
                }
            };

            // Toggle profile dropdown
            const userProfile = document.getElementById('userProfile');
            const profileDropdown = document.getElementById('profileDropdown');

            if (userProfile) {
                userProfile.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('show');
                });
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                if (profileDropdown) {
                    profileDropdown.classList.remove('show');
                }
            });
        }


        // Modal functions
        window.showModal = function(modalId, title = '', body = '') {
            const modal = document.getElementById(modalId);
            if (modal) {
                const modalTitle = modal.querySelector('.modal-title');
                const modalBody = modal.querySelector('.modal-body');

                if (modalTitle && title) modalTitle.innerHTML = title;
                if (modalBody && body) modalBody.innerHTML = body;

                modal.classList.add('show');
            }
        }

        window.closeModal = function(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('show');
            }
        }

        // Auto-close success/error alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-success, .alert-danger');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease-out';
                    setTimeout(() => alert.remove(), 500);
                }, 5000); // 5 seconds
            });

            // Set active menu item on load based on current route
            const currentPath = window.location.pathname;
            document.querySelectorAll('.menu-item, .submenu-item').forEach(item => {
                const href = item.getAttribute('href');
                if (href && currentPath.includes(href.replace(/^\//, ''))) {
                    item.classList.add('active');
                    let parentSubmenu = item.closest('.submenu');
                    if (parentSubmenu) {
                        parentSubmenu.classList.add('show');
                        let parentMenuItem = parentSubmenu.previousElementSibling; // This assumes direct sibling
                        if (parentMenuItem && parentMenuItem.classList.contains('menu-item')) {
                            parentMenuItem.classList.add('active');
                        }
                    }
                }
            });
        });


    </script>
    @yield('scripts')
</body>
</html>
