<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - SMKN 4 BOGOR</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #0ea5e9; /* accent subtle, mostly unused */
            --primary-light: #0369a1;
            --secondary-color: #0ea5e9;
            --accent-color: #111827;
            --text-primary: #0f172a; /* slate-900 */
            --text-secondary: #334155; /* slate-700 */
            --text-muted: #6b7280; /* gray-500 */
            --bg-primary: #ffffff;
            --bg-secondary: #f9fafb; /* gray-50 */
            --bg-dark: #ffffff; /* topbar white */
            --border-color: #e5e7eb; /* gray-200 */
            --border-dark: #e5e7eb; 
            --sidebar-width: 240px;
            --sidebar-collapsed: 80px;
            --shadow-light: 0 2px 10px rgba(0, 0, 0, 0.05);
            --shadow-medium: 0 4px 20px rgba(0, 0, 0, 0.1);
            --shadow-heavy: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--bg-secondary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--bg-primary);
            z-index: 1000;
            overflow-y: auto;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-medium);
            border-right: 1px solid var(--border-color);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar-brand {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-primary);
        }

        .sidebar-brand h4 {
            color: var(--text-primary);
            margin: 0;
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.5px;
        }

        .sidebar .nav {
            padding: 1.5rem 0;
            gap: 6px;
        }

        .sidebar .nav-link {
            color: var(--text-secondary);
            padding: 1rem 1.5rem;
            margin: 0.35rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.9rem;
            border: 1px solid transparent;
        }

        .sidebar .nav-link:hover {
            color: var(--text-primary);
            background: var(--bg-secondary);
            border-color: var(--border-color);
            transform: translateX(3px);
        }

        .sidebar .nav-link.active {
            color: var(--text-primary);
            background: var(--bg-secondary);
            border-color: var(--border-color);
            font-weight: 600;
        }

        .sidebar .nav-link i {
            width: 18px;
            margin-right: 0.75rem;
            font-size: 0.9rem;
        }

        .sidebar .nav-link span {
            white-space: nowrap;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 1rem 0.75rem;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
            font-size: 1rem;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: var(--bg-secondary);
        }

        .main-content.collapsed {
            margin-left: var(--sidebar-collapsed);
        }

        .top-navbar {
            background: var(--bg-primary);
            color: var(--text-primary);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-dark);
            box-shadow: var(--shadow-light);
            margin-bottom: 2rem;
        }

        .top-navbar .btn-toggle {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            padding: 0.5rem 0.75rem;
        }

        .top-search {
            display: none;
        }

        @media (min-width: 768px) {
            .top-search { display: block; }
        }

        .top-search .form-control {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .top-search .form-control::placeholder { color: var(--text-muted); }

        .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            background: var(--bg-secondary);
        }

        .top-navbar h1,
        .top-navbar p,
        .top-navbar a,
        .top-navbar .nav-link { color: var(--text-primary); }

        .page-header {
            background: var(--bg-primary);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: var(--shadow-light);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        /* Cards */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-light);
            background: var(--bg-primary);
            overflow: hidden;
        }

        .card-header {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            font-size: 0.9rem;
        }


        .btn-outline-primary {
            border: 1px solid #111827;
            color: #111827;
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: #111827;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: var(--shadow-light);
        }

        .btn-light {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        .btn-light:hover {
            background: var(--bg-secondary);
            border-color: var(--bg-dark);
            color: var(--text-primary);
        }

        /* Modern Stats Cards */
        .stats-card-modern {
            background: var(--bg-primary);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
            position: relative;
        }

        .stats-card-modern:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-1px);
        }

        .stats-icon-modern {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #6b7280;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .stats-number-modern {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
            margin-bottom: 0.25rem;
        }

        .stats-label-modern {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .stats-sub-modern {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Modern Cards */
        .card-modern {
            background: var(--bg-primary);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .card-header-modern {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .card-body-modern {
            padding: 1.5rem;
        }

        .btn-link-modern {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .btn-link-modern:hover {
            color: var(--text-primary);
        }

        /* Modern Gallery Cards */
        .gallery-card-modern {
            background: var(--bg-primary);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .gallery-card-modern:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-1px);
        }

        .gallery-image-modern {
            position: relative;
            overflow: hidden;
            height: 140px;
        }

        .gallery-image-modern img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.2s ease;
        }

        .gallery-card-modern:hover .gallery-image-modern img {
            transform: scale(1.02);
        }

        .gallery-content-modern {
            padding: 1rem;
        }

        .gallery-title-modern {
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        /* Compact Stats */
        .stats-icon-compact {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #6b7280;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .stats-number-compact {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
            margin-bottom: 0.125rem;
        }

        .stats-label-compact {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Card Header Improvements */
        .card-header-modern {
            padding: 1.25rem 1.5rem 1rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            background: transparent;
        }

        .card-body-modern {
            padding: 1rem 1.5rem 1.5rem 1.5rem;
        }

        /* Loading States */
        .spinner-border-sm {
            width: 1.5rem;
            height: 1.5rem;
        }

        /* Button Improvements */
        .btn-outline-primary:hover {
            background: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }

        .btn-outline-success:hover {
            background: #198754;
            border-color: #198754;
            color: white;
        }

        .btn-outline-info:hover {
            background: #0dcaf0;
            border-color: #0dcaf0;
            color: white;
        }

        .btn-outline-warning:hover {
            background: #ffc107;
            border-color: #ffc107;
            color: black;
        }

        .btn-primary {
            background: #0d6efd;
            color: #ffffff;
            border: 1px solid #0d6efd;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #374151;
            border-color: #374151;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: var(--shadow-light);
        }

        .chart-container {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
        }

        .recent-activity {
            max-height: 400px;
            overflow-y: auto;
        }

        .activity-item {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s ease;
        }

        .activity-item:hover {
            background-color: #f8fafc;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .progress-ring {
            width: 120px;
            height: 120px;
        }

        .page-header {
            background: var(--bg-primary);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-light);
            border: 1px solid var(--border-color);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        /* Tables */
        .table {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-secondary);
            padding: 1rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-color: var(--border-color);
        }

        .table tbody tr:hover {
            background: var(--bg-secondary);
        }

        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.75rem;
            border: 1px solid transparent;
        }

        .bg-primary {
            background-color: #111827 !important;
            color: #ffffff !important;
        }

        .bg-success {
            background-color: #22c55e !important;
            color: #ffffff !important;
        }

        .bg-warning {
            background-color: #f59e0b !important;
            color: #ffffff !important;
        }

        .bg-secondary {
            background-color: #6b7280 !important;
            color: #ffffff !important;
        }

        /* Gallery Styles */
        .gallery-item {
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-3px);
        }

        .gallery-image {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            height: 120px;
            border: 1px solid var(--border-color);
        }

        .gallery-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .gallery-image img {
            transform: scale(1.05);
        }

        .placeholder-image {
            background: var(--bg-secondary);
            height: 120px;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
        }

        /* Empty State */
        .empty-state {
            padding: 2rem;
        }

        .empty-state i {
            opacity: 0.5;
            color: var(--text-muted);
        }

        /* Category Stats */
        .category-item {
            padding: 1rem;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 0.75rem;
        }

        .category-item:last-child {
            margin-bottom: 0;
        }

        /* Popular Posts */
        .popular-item {
            transition: all 0.2s ease;
            padding: 0.75rem;
            border-radius: 8px;
        }

        .popular-item:hover {
            background: var(--bg-secondary);
        }

        .popular-rank .badge {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            background: var(--bg-dark) !important;
            color: var(--accent-color) !important;
        }

        /* List Group Enhancements */
        .list-group-item {
            transition: all 0.2s ease;
            border-color: var(--border-color);
        }

        .list-group-item:hover {
            background: var(--bg-secondary);
        }

        /* Progress Bars */
        .progress {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
        }

        .progress-bar {
            background: var(--bg-dark);
        }

        .bg-info .progress-bar {
            background: var(--text-secondary);
        }

        /* Alerts */
        .alert {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem 1.5rem;
            background: var(--bg-primary);
        }

        .alert-success {
            border-color: var(--secondary-color);
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        .alert-danger {
            border-color: var(--primary-light);
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--text-muted);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--bg-dark);
        }

        /* Text Colors */
        .text-muted {
            color: var(--text-muted) !important;
        }

        .text-dark {
            color: var(--text-primary) !important;
        }

        .text-primary {
            color: var(--bg-dark) !important;
        }

        /* Form Controls */
        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem;
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        .form-control:focus {
            border-color: var(--bg-dark);
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1);
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        .form-label {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        /* Dropdown */
        .dropdown-menu {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: var(--shadow-medium);
            background: var(--bg-primary);
        }

        .dropdown-item {
            color: var(--text-primary);
            padding: 0.75rem 1rem;
        }

        .dropdown-item:hover {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }

        .dropdown-divider {
            border-color: var(--border-color);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="sidebar" id="sidebar">
                <div class="sidebar-brand">
                    <h4>
                        <i class="fas fa-school me-2"></i>
                        SMKN 4 BOGOR
                    </h4>
                </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.kategori-berita*') ? 'active' : '' }}" 
                               href="{{ route('admin.kategori-berita.index') }}">
                                <i class="fas fa-tags me-2"></i><span>Kategori Berita</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.berita*') ? 'active' : '' }}" 
                               href="{{ route('admin.berita.index') }}">
                                <i class="fas fa-newspaper me-2"></i><span>Berita</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.gallery*') ? 'active' : '' }}" 
                               href="{{ route('admin.gallery.index') }}">
                                <i class="fas fa-images me-2"></i><span>Gallery</span>
                            </a>
                        </li>
                    </ul>
                    <div class="px-3 mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Main content -->
            <main class="main-content">
            <div class="px-4 pt-4">

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
                
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sidebar = document.getElementById('sidebar');
            var main = document.querySelector('.main-content');
            var toggle = document.getElementById('sidebarToggle');
            if (toggle) {
                toggle.addEventListener('click', function () {
                    sidebar.classList.toggle('collapsed');
                    main.classList.toggle('collapsed');
                });
            }
        });
    </script>
    
    <!-- Global Fancy Confirm Modal -->
    <div class="modal fade" id="globalConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header border-0" id="gc-head">
                    <h5 class="modal-title" id="gc-title"><i class="fas fa-question-circle me-2"></i>Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <p class="mb-0" id="gc-message">Apakah Anda yakin?</p>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="gc-confirm-btn">
                        <i class="fas fa-trash me-2"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 2000">
        <div id="globalToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="gt-body">Halo admin!</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        // Global Confirm Helper (Promise-based)
        window.showConfirm = function({ title = 'Konfirmasi', message = 'Apakah Anda yakin?', confirmText = 'Ya', confirmVariant = 'danger', icon = 'question-circle' } = {}) {
            return new Promise((resolve) => {
                const modalEl = document.getElementById('globalConfirmModal');
                const titleEl = document.getElementById('gc-title');
                const msgEl = document.getElementById('gc-message');
                const btnEl = document.getElementById('gc-confirm-btn');
                const headEl = document.getElementById('gc-head');
                
                // Clear previous content
                titleEl.innerHTML = `<i class="fas fa-${icon} me-2"></i>${title}`;
                msgEl.textContent = message;
                btnEl.innerHTML = `<i class="fas fa-check me-2"></i>${confirmText}`;
                btnEl.className = `btn btn-${confirmVariant}`;
                headEl.className = `modal-header border-0 bg-${confirmVariant} bg-opacity-10`;

                const bsModal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: false
                });
                
                const onConfirm = () => { 
                    cleanup(); 
                    bsModal.hide();
                    resolve(true); 
                };
                const onCancel = () => { 
                    cleanup(); 
                    bsModal.hide();
                    resolve(false); 
                };
                const onHidden = () => { 
                    cleanup(); 
                };
                
                function cleanup() { 
                    btnEl.removeEventListener('click', onConfirm); 
                    modalEl.removeEventListener('hidden.bs.modal', onHidden);
                    // Remove any existing cancel listeners
                    const cancelBtns = modalEl.querySelectorAll('[data-bs-dismiss="modal"]');
                    cancelBtns.forEach(btn => btn.removeEventListener('click', onCancel));
                }
                
                btnEl.addEventListener('click', onConfirm);
                modalEl.addEventListener('hidden.bs.modal', onHidden, { once: true });
                
                // Add cancel listeners
                const cancelBtns = modalEl.querySelectorAll('[data-bs-dismiss="modal"]');
                cancelBtns.forEach(btn => btn.addEventListener('click', onCancel));
                
                bsModal.show();
            });
        }

        // Global Toast Helper
        window.showToast = function(message = 'Halo Admin!', title = 'SMKN 4 BOGOR', variant = 'primary') {
            const toastEl = document.getElementById('globalToast');
            const body = document.getElementById('gt-body');
            toastEl.className = `toast align-items-center text-bg-${variant} border-0`;
            body.innerHTML = `<strong>${title}:</strong> ${message}`;
            const t = new bootstrap.Toast(toastEl, { delay: 3500 });
            t.show();
        }
    </script>

    @stack('scripts')
</body>
</html>
