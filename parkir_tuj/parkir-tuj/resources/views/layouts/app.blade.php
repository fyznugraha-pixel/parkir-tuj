<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Sistem Parkir TU Jakarta</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --telkom-red: #E31E24;
            --telkom-red-dark: #b71c21;
            --telkom-red-light: #ff4d52;
            --telkom-dark: #1a1a1a;
            --telkom-gray: #6c757d;
            --telkom-light: #f8f9fa;
            --sidebar-width: 260px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f5f5;
            overflow-x: hidden;
        }
        
        /* Sidebar Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: white;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            z-index: 999;
            transition: transform 0.3s ease;
        }
        
        body.sidebar-closed .sidebar {
            transform: translateX(-100%);
        }
        
        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid #e5e7eb;
            background: linear-gradient(135deg, var(--telkom-red) 0%, var(--telkom-red-dark) 100%);
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .sidebar-logo-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--telkom-red);
            font-size: 24px;
        }
        
        .sidebar-logo-text h4 {
            font-size: 16px;
            font-weight: 700;
            color: white;
            margin: 0;
        }
        
        .sidebar-logo-text small {
            font-size: 11px;
            color: rgba(255,255,255,0.8);
        }
        
        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
            overflow-y: auto;
        }
        
        .nav-item {
            margin: 4px 12px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--telkom-gray);
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .nav-link i {
            font-size: 18px;
            width: 20px;
        }
        
        .nav-link:hover {
            background: #f8f9fa;
            color: var(--telkom-red);
        }
        
        .nav-link.active {
            background: linear-gradient(135deg, rgba(227, 30, 36, 0.1) 0%, rgba(227, 30, 36, 0.05) 100%);
            color: var(--telkom-red);
            font-weight: 600;
            border-left: 3px solid var(--telkom-red);
        }
        
        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid #e5e7eb;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 12px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--telkom-red);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }
        
        .user-info h6 {
            font-size: 13px;
            font-weight: 600;
            color: var(--telkom-dark);
            margin: 0;
        }
        
        .user-info small {
            font-size: 11px;
            color: var(--telkom-gray);
        }
        
        .btn-logout {
            width: 100%;
            padding: 10px;
            background: white;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            color: var(--telkom-gray);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-logout:hover {
            background: #fff5f5;
            border-color: var(--telkom-red);
            color: var(--telkom-red);
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }
        
        body.sidebar-closed .main-content {
            margin-left: 0;
        }
        
        /* Top Navbar */
        .top-navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 997;
        }
        
        .navbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        /* Toggle Sidebar Button - Double Chevron */
        .toggle-sidebar-btn {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background: white;
            border: 1.5px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            font-size: 18px;
            color: var(--telkom-gray);
        }
        
        .toggle-sidebar-btn:hover {
            background: #fff5f5;
            border-color: var(--telkom-red);
            color: var(--telkom-red);
            transform: translateX(-2px);
        }
        
        .toggle-sidebar-btn i {
            transition: transform 0.3s ease;
        }
        
        .toggle-sidebar-btn:hover i {
            transform: scale(1.1);
        }
        
        /* Change icon based on sidebar state */
        body:not(.sidebar-closed) .toggle-sidebar-btn .icon-open {
            display: inline-block;
        }
        
        body:not(.sidebar-closed) .toggle-sidebar-btn .icon-closed {
            display: none;
        }
        
        body.sidebar-closed .toggle-sidebar-btn .icon-open {
            display: none;
        }
        
        body.sidebar-closed .toggle-sidebar-btn .icon-closed {
            display: inline-block;
        }
        
        .page-title h5 {
            font-size: 20px;
            font-weight: 700;
            color: var(--telkom-dark);
            margin: 0;
        }
        
        .navbar-info {
            display: flex;
            align-items: center;
            gap: 24px;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--telkom-gray);
        }
        
        .info-item i {
            color: var(--telkom-red);
        }
        
        /* Content Area */
        .content-area {
            flex: 1;
            padding: 32px;
        }
        
        /* Cards */
        .card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        /* Alerts */
        .alert {
            border-radius: 8px;
            border: none;
            border-left: 3px solid;
        }
        
        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border-left-color: #22c55e;
        }
        
        .alert-danger {
            background: #fff5f5;
            color: #c81e1e;
            border-left-color: var(--telkom-red);
        }
        
        .alert-info {
            background: #f0f9ff;
            color: #075985;
            border-left-color: #0284c7;
        }
        
        /* Dark Mode Toggle */
        .dark-mode-toggle {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #E31E24;
            color: white;
            border: none;
            box-shadow: 0 4px 16px rgba(227, 30, 36, 0.3);
            cursor: pointer;
            z-index: 9999;
            font-size: 20px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .dark-mode-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 24px rgba(227, 30, 36, 0.4);
        }
        
        /* ============================================
        DARK MODE - COMPREHENSIVE STYLING
        ============================================ */

        /* Base Dark Mode */
        body.dark-mode {
            background: #1a1a1a !important;
            color: #e5e7eb !important;
        }

        /* ============================================
        SIDEBAR
        ============================================ */
        body.dark-mode .sidebar {
            background: #2d2d2d !important;
            border-color: #404040 !important;
        }

        body.dark-mode .sidebar-header {
            background: linear-gradient(135deg, #b71c21 0%, #8b1619 100%) !important;
        }

        body.dark-mode .nav-link {
            color: #d1d5db !important;
        }

        body.dark-mode .nav-link:hover,
        body.dark-mode .nav-link.active {
            background: #404040 !important;
            color: white !important;
        }

        body.dark-mode .user-profile {
            background: #404040 !important;
        }

        body.dark-mode .user-info h6 {
            color: #f3f4f6 !important;
        }

        body.dark-mode .user-info small {
            color: #9ca3af !important;
        }

        body.dark-mode .btn-logout {
            background: #353535 !important;
            border-color: #505050 !important;
            color: #d1d5db !important;
        }

        body.dark-mode .btn-logout:hover {
            background: #4a1a1c !important;
            border-color: #E31E24 !important;
            color: #ff6b6f !important;
        }

        /* ============================================
        TOP NAVBAR
        ============================================ */
        body.dark-mode .top-navbar {
            background: #2d2d2d !important;
            border-color: #404040 !important;
        }

        body.dark-mode .toggle-sidebar-btn {
            background: #404040 !important;
            border-color: #505050 !important;
            color: #d1d5db !important;
        }

        body.dark-mode .toggle-sidebar-btn:hover {
            background: #4a1a1c !important;
            border-color: #E31E24 !important;
            color: #ff6b6f !important;
        }

        body.dark-mode .page-title h5 {
            color: #f3f4f6 !important;
        }

        body.dark-mode .info-item {
            color: #d1d5db !important;
        }

        body.dark-mode .info-item i {
            color: #ff6b6f !important;
        }

        /* ============================================
        CONTENT AREA
        ============================================ */
        body.dark-mode .content-area {
            background: #1a1a1a !important;
        }

        /* ============================================
        WELCOME BANNER (Dashboard)
        ============================================ */
        body.dark-mode .welcome-banner {
            background: linear-gradient(135deg, #2d2d2d 0%, #252525 100%) !important;
            border-color: #404040 !important;
        }

        body.dark-mode .welcome-banner h4 {
            color: #f3f4f6 !important;
        }

        body.dark-mode .welcome-time {
            color: #9ca3af !important;
        }

        /* ============================================
        SLOT CARDS
        ============================================ */
        body.dark-mode .slot-card {
            background: #2d2d2d !important;
            border-color: #f3f3f3 !important;
        }

        body.dark-mode .slot-card .slot-info h3 {
            color: #f3f4f6 !important;
        }

        body.dark-mode .slot-card .slot-info p {
            color: #f3f3f3 !important;
        }

        body.dark-mode .slot-progress {
            background: #f3f4f6 !important;
        }

        /* ============================================
        STAT CARDS
        ============================================ */
        body.dark-mode .stat-card {
            background: #2d2d2d !important;
            border-color: #f3f3f3 !important;
        }

        body.dark-mode .stat-label {
            color: #f3f4f3 !important;
        }

        body.dark-mode .stat-value {
            color: #f3f4f6 !important;
        }

        body.dark-mode .stat-desc {
            color: #f3f3f3!important;
        }

        body.dark-mode .stat-link {
            color: #ff6b6f !important;
        }

        /* ============================================
        VEHICLE CARDS
        ============================================ */
        body.dark-mode .vehicle-card {
            background: #2d2d2d !important;
            border-color: #f3f3f3 !important;
        }

        body.dark-mode .vehicle-card h5 {
            color: #f3f4f6 !important;
        }

        body.dark-mode .vehicle-stats .stat-number {
            color: #f3f4f6 !important;
        }

        body.dark-mode .vehicle-stats .stat-text {
            color: #f3f3f3   !important;
        }

        body.dark-mode .progress-bar-custom {
            background: #404040 !important;
        }

        /* ============================================
        CARDS
        ============================================ */
        body.dark-mode .card {
            background: #2d2d2d !important;
            border-color: #404040 !important;
            color: #e5e7eb !important;
        }

        body.dark-mode .card-header {
            background: #252525 !important;
            border-color: #404040 !important;
            color: #e5e7eb !important;
        }

        body.dark-mode .card-header h5 {
            color: #f3f4f6 !important;
        }

        body.dark-mode .card-body {
            background: #2d2d2d !important;
            color: #e5e7eb !important;
        }

        /* ============================================
        TABLES
        ============================================ */
        body.dark-mode .table {
            color: #e5e7eb !important;
            background: transparent !important;
        }

        body.dark-mode .table thead {
            background: #252525 !important;
        }

        body.dark-mode .table thead th {
            color: #9ca3af !important;
            border-color: #404040 !important;
            background: #252525 !important;
        }

        body.dark-mode .table tbody {
            background: #2d2d2d !important;
        }

        body.dark-mode .table tbody td {
            border-color: #353535 !important;
            color: #e5e7eb !important;
            background: transparent !important;
        }

        body.dark-mode .table tbody tr {
            background: transparent !important;
        }

        body.dark-mode .table tbody tr:hover {
            background: #353535 !important;
        }

        body.dark-mode .table-hover tbody tr:hover {
            background: #353535 !important;
        }

        /* Table responsive wrapper */
        body.dark-mode .table-responsive {
            background: #2d2d2d !important;
        }


        /* ============================================
        BADGES
        ============================================ */
        body.dark-mode .badge-count {
            background: #E31E24 !important;
            color: white !important;
        }

        body.dark-mode .badge-vehicle {
            filter: brightness(1.1);
        }

        body.dark-mode .badge-duration {
            background: #404040 !important;
            color: #d1d5db !important;
        }

        body.dark-mode .badge-status {
            filter: brightness(1.1);
        }

        body.dark-mode .badge {
            filter: brightness(1.2);
        }

        /* ============================================
        ACTIVITY LIST
        ============================================ */
        body.dark-mode .activity-list {
            background: #2d2d2d !important;
        }

        body.dark-mode .activity-item {
            border-color: #404040 !important;
        }

        body.dark-mode .activity-item:hover {
            background: #353535 !important;
        }

        body.dark-mode .activity-text {
            color: #e5e7eb !important;
        }

        body.dark-mode .activity-meta {
            color: #9ca3af !important;
        }

        /* ============================================
        BUTTONS
        ============================================ */
        body.dark-mode .btn-link-custom {
            color: #ff6b6f !important;
        }

        body.dark-mode .btn-primary {
            background: #E31E24 !important;
            border-color: #E31E24 !important;
        }

        body.dark-mode .btn-secondary {
            background: #404040 !important;
            border-color: #505050 !important;
            color: #d1d5db !important;
        }

        body.dark-mode .btn-danger {
            background: #dc2626 !important;
            border-color: #b91c1c !important;
        }

        body.dark-mode .btn-success {
            background: #16a34a !important;
            border-color: #15803d !important;
        }

        body.dark-mode .btn-warning {
            background: #d97706 !important;
            border-color: #b45309 !important;
        }

        /* ============================================
        FORMS
        ============================================ */
        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background: #353535 !important;
            border-color: #404040 !important;
            color: #2d2d2d !important;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
            background: #404040 !important;
            border-color: #E31E24 !important;
            color: #e5e7eb !important;
            box-shadow: 0 0 0 0.2rem rgba(227, 30, 36, 0.25) !important;
        }

        body.dark-mode .form-control::placeholder {
            color: #6b7280 !important;
        }

        body.dark-mode .form-label {
            color: #d1d5db !important;
        }

        body.dark-mode .input-group-text {
            background: #353535 !important;
            border-color: #404040 !important;
            color: #d1d5db !important;
        }

        /* ============================================
        ALERTS
        ============================================ */
        body.dark-mode .alert-success {
            background: #1a3d2a !important;
            color: #86efac !important;
            border-left-color: #22c55e !important;
        }

        body.dark-mode .alert-danger {
            background: #3d1a1a !important;
            color: #fca5a5 !important;
            border-left-color: #ef4444 !important;
        }

        body.dark-mode .alert-info {
            background: #1a2d3d !important;
            color: #7dd3fc !important;
            border-left-color: #0284c7 !important;
        }

        body.dark-mode .alert-warning {
            background: #3d2d1a !important;
            color: #fcd34d !important;
            border-left-color: #f59e0b !important;
        }

        /* ============================================
        MODALS
        ============================================ */
        body.dark-mode .modal-content {
            background: #2d2d2d !important;
            color: #e5e7eb !important;
            border-color: #404040 !important;
        }

        body.dark-mode .modal-header {
            background: #252525 !important;
            border-color: #404040 !important;
        }

        body.dark-mode .modal-header .modal-title {
            color: #f3f4f6 !important;
        }

        body.dark-mode .modal-footer {
            border-color: #404040 !important;
            background: #252525 !important;
        }

        body.dark-mode .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* ============================================
        DARK MODE TOGGLE BUTTON
        ============================================ */
        body.dark-mode .dark-mode-toggle {
            background: #404040 !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.4) !important;
        }

        body.dark-mode .dark-mode-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 24px rgba(227, 30, 36, 0.4) !important;
        }

        /* ============================================
        EMPTY STATE
        ============================================ */
        body.dark-mode .empty-state {
            color: #6b7280 !important;
        }

        body.dark-mode .empty-state i {
            color: #4b5563 !important;
        }

        /* ============================================
        HEADINGS
        ============================================ */
        body.dark-mode h1, 
        body.dark-mode h2, 
        body.dark-mode h3, 
        body.dark-mode h4, 
        body.dark-mode h5, 
        body.dark-mode h6 {
            color: #f3f4f6 !important;
        }

        /* ============================================
        TEXT UTILITIES
        ============================================ */
        body.dark-mode .text-muted {
            color: #9ca3af !important;
        }

        body.dark-mode .text-secondary {
            color: #d1d5db !important;
        }

        body.dark-mode small {
            color: #9ca3af !important;
        }

        /* ============================================
        LINKS
        ============================================ */
        body.dark-mode a {
            color: #ff6b6f !important;
        }

        body.dark-mode a:hover {
            color: #ff8a8d !important;
        }

        /* ============================================
        BORDERS & DIVIDERS
        ============================================ */
        body.dark-mode hr {
            border-color: #404040 !important;
        }

        body.dark-mode .border {
            border-color: #404040 !important;
        }

        /* ============================================
        PAGINATION
        ============================================ */
        body.dark-mode .pagination .page-link {
            background: #2d2d2d !important;
            border-color: #404040 !important;
            color: #d1d5db !important;
        }

        body.dark-mode .pagination .page-link:hover {
            background: #404040 !important;
            border-color: #E31E24 !important;
            color: #ff6b6f !important;
        }

        body.dark-mode .pagination .page-item.active .page-link {
            background: #E31E24 !important;
            border-color: #E31E24 !important;
        }

        /* ============================================
        DROPDOWNS
        ============================================ */
        body.dark-mode .dropdown-menu {
            background: #2d2d2d !important;
            border-color: #404040 !important;
        }

        body.dark-mode .dropdown-item {
            color: #d1d5db !important;
        }

        body.dark-mode .dropdown-item:hover {
            background: #404040 !important;
            color: #f3f4f6 !important;
        }

        /* ============================================
        SEARCH BAR
        ============================================ */
        body.dark-mode .search-bar input {
            background: #353535 !important;
            border-color: #404040 !important;
            color: #e5e7eb !important;
        }

        body.dark-mode .search-bar input::placeholder {
            color: #6b7280 !important;
        }

        /* ============================================
        FILTER BUTTONS
        ============================================ */
        body.dark-mode .filter-btn {
            background: #353535 !important;
            border-color: #404040 !important;
            color: #d1d5db !important;
        }

        body.dark-mode .filter-btn:hover,
        body.dark-mode .filter-btn.active {
            background: #E31E24 !important;
            border-color: #E31E24 !important;
            color: white !important;
        }

        /* ============================================
        STATISTICS BOXES
        ============================================ */
        body.dark-mode .stat-box {
            background: #2d2d2d !important;
            border-color: #404040 !important;
        }

        body.dark-mode .stat-box h3 {
            color: #f3f4f6 !important;
        }

        body.dark-mode .stat-box p {
            color: #9ca3af !important;
        }

        /* ============================================
        USER STATISTICS CARDS (Halaman Pengguna)
        ============================================ */
        body.dark-mode .user-stat-card,
        body.dark-mode .stat-card-item {
            background: #2d2d2d !important;
            border-color: #404040 !important;
            border-radius: 12px !important;
        }

        body.dark-mode .user-stat-card h6,
        body.dark-mode .user-stat-card p,
        body.dark-mode .stat-card-item h6,
        body.dark-mode .stat-card-item p {
            color: #e5e7eb !important;
        }

        /* Generic white card fix for dark mode */
        body.dark-mode [class*="card"]:not(.card):not(.stat-card):not(.slot-card):not(.vehicle-card) {
            background: #2d2d2d !important;
            border-color: #404040 !important;
            border-radius: 12px !important;
        }

        /* Force border radius on all card-like elements */
        body.dark-mode .rounded,
        body.dark-mode .rounded-3,
        body.dark-mode .rounded-lg {
            border-radius: 12px !important;
        }

        body.dark-mode .shadow,
        body.dark-mode .shadow-sm {
            box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .top-navbar {
                padding: 16px;
            }
            
            .content-area {
                padding: 16px;
            }
            
            .navbar-info {
                gap: 12px;
            }
            
            .info-item {
                font-size: 12px;
            }
            
            .info-item:first-child {
                display: none;
            }
        }
        
        @media (min-width: 769px) {
            /* Desktop: hide overlay when sidebar is open */
            body:not(.sidebar-closed) .sidebar-overlay {
                display: none;
            }
            
            /* Desktop: show overlay when sidebar is closed for better UX */
            body.sidebar-closed .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <i class="bi bi-p-square-fill"></i>
                </div>
                <div class="sidebar-logo-text">
                    <h4>Sistem Parkir</h4>
                    <small>Telkom University Jakarta</small>
                </div>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('scan.index') }}" class="nav-link {{ request()->routeIs('scan.*') ? 'active' : '' }}">
                    <i class="bi bi-qr-code-scan"></i>
                    <span>Scan QR code</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('pengguna.index') }}" class="nav-link {{ request()->routeIs('pengguna.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Pengguna</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('kendaraan.index') }}" class="nav-link {{ request()->routeIs('kendaraan.*') ? 'active' : '' }}">
                    <i class="bi bi-car-front"></i>
                    <span>Kendaraan</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('akses-parkir.index') }}" class="nav-link {{ request()->routeIs('akses-parkir.*') ? 'active' : '' }}">
                    <i class="bi bi-door-open"></i>
                    <span>Akses Parkir</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('log.index') }}" class="nav-link {{ request()->routeIs('log.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Log Aktivitas</span>
                </a>
            </div>
        </nav>
        
        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="bi bi-person"></i>
                </div>
                <div class="user-info">
                    <h6>{{ session('admin_nama') ?? 'Admin' }}</h6>
                    <small>Administrator</small>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="navbar-left">
                <button class="toggle-sidebar-btn" id="toggleSidebarBtn" title="Toggle Sidebar">
                    <i class="bi bi-chevron-double-left icon-open"></i>
                    <i class="bi bi-chevron-double-right icon-closed"></i>
                </button>
                <div class="page-title">
                    <h5>@yield('page-title')</h5>
                </div>
            </div>
            <div class="navbar-info">
                <div class="info-item">
                    <i class="bi bi-calendar3"></i>
                    <span>{{ date('d F Y') }}</span>
                </div>
                <div class="info-item">
                    <i class="bi bi-clock"></i>
                    <span id="jam"></span>
                </div>
            </div>
        </nav>
        
        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <!-- Dark Mode Toggle Button -->
    <button type="button" class="dark-mode-toggle" id="darkModeToggle">
        <i class="bi bi-moon-fill"></i>
    </button>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle Sidebar with Double Chevron
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const body = document.body;
        
        // Load sidebar state from localStorage
        if (localStorage.getItem('sidebarClosed') === 'true') {
            body.classList.add('sidebar-closed');
        }
        
        // Toggle sidebar
        toggleSidebarBtn.addEventListener('click', function() {
            body.classList.toggle('sidebar-closed');
            
            // Show overlay when sidebar is closed (especially for mobile)
            if (body.classList.contains('sidebar-closed')) {
                sidebarOverlay.classList.remove('show');
                localStorage.setItem('sidebarClosed', 'true');
            } else {
                if (window.innerWidth <= 768) {
                    sidebarOverlay.classList.add('show');
                }
                localStorage.setItem('sidebarClosed', 'false');
            }
        });
        
        // Close sidebar when clicking overlay
        sidebarOverlay.addEventListener('click', function() {
            body.classList.add('sidebar-closed');
            sidebarOverlay.classList.remove('show');
            localStorage.setItem('sidebarClosed', 'true');
        });
        
        // Auto close sidebar on mobile when clicking nav link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    body.classList.add('sidebar-closed');
                    sidebarOverlay.classList.remove('show');
                }
            });
        });
        
        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        
        // Load saved theme
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
            darkModeToggle.innerHTML = '<i class="bi bi-sun-fill"></i>';
        }
        
        // Toggle dark mode
        darkModeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
                darkModeToggle.innerHTML = '<i class="bi bi-sun-fill"></i>';
            } else {
                localStorage.setItem('darkMode', 'disabled');
                darkModeToggle.innerHTML = '<i class="bi bi-moon-fill"></i>';
            }
        });
        
        // Jam Real-time
        function updateJam() {
            const now = new Date();
            const jam = String(now.getHours()).padStart(2, '0');
            const menit = String(now.getMinutes()).padStart(2, '0');
            const detik = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('jam').textContent = `${jam}:${menit}:${detik}`;
        }
        
        setInterval(updateJam, 1000);
        updateJam();
    </script>
    
    @stack('scripts')
</body>
</html>