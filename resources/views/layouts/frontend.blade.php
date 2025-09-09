<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SMA MADESU 1')</title>
    <meta name="description" content="@yield('description', 'SMA MADESU 1 - Sekolah Menengah Atas yang berkomitmen memberikan pendidikan berkualitas dan membentuk karakter siswa yang unggul')">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #0ea5e9;
            --primary-light: #0369a1;
            --secondary-color: #0ea5e9;
            --accent-color: #111827;
            --text-primary: #0f172a;
            --text-secondary: #334155;
            --text-muted: #6b7280;
            --bg-primary: #ffffff;
            --bg-secondary: #f9fafb;
            --bg-dark: #ffffff;
            --border-color: #e5e7eb;
            --border-dark: #e5e7eb;
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

        /* Header Styles */
        .header {
            background: var(--bg-primary);
            box-shadow: var(--shadow-light);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--accent-color) !important;
            text-decoration: none;
        }

        .navbar-brand:hover {
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--text-primary) !important;
            padding: 0.75rem 1rem !important;
            border-radius: 8px;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            background: var(--bg-secondary);
            color: var(--accent-color) !important;
        }

        /* Accessibility Controls (removed) */

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
        }

        /* Cards */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-light);
            background: var(--bg-primary);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .card-header {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .card-body {
            padding: 1.5rem;
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

        .btn-primary {
            background: var(--accent-color);
            border-color: var(--accent-color);
            color: #ffffff;
        }

        .btn-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-1px);
            box-shadow: var(--shadow-light);
        }

        .btn-outline-primary {
            border: 1px solid var(--accent-color);
            color: var(--accent-color);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--accent-color);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: var(--shadow-light);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--primary-color) 100%);
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        /* News Cards */
        .news-card {
            height: 100%;
            transition: all 0.3s ease;
        }

        .news-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-medium);
        }

        .news-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .news-meta {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .news-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .news-excerpt {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Gallery Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .gallery-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-medium);
        }

        .gallery-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
            padding: 1.5rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }

        .gallery-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .gallery-description {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            background: var(--accent-color);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        .footer h5 {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: white;
        }

        /* Pagination */
        .pagination .page-link {
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            margin: 0 0.25rem;
            border-radius: 8px;
        }

        .pagination .page-link:hover,
        .pagination .page-item.active .page-link {
            background: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
        }

        /* Search Form */
        .search-form {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow-light);
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(17, 24, 39, 0.25);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .gallery-grid {
                grid-template-columns: 1fr;
            }
            
            .navbar-nav {
                text-align: center;
                margin-top: 1rem;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-graduation-cap me-2"></i>SMA MADESU 1
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-home me-1"></i>Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('berita.*') ? 'active' : '' }}" href="{{ route('berita.index') }}">
                                <i class="fas fa-newspaper me-1"></i>Berita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}" href="{{ route('gallery.index') }}">
                                <i class="fas fa-images me-1"></i>Galeri
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.index') }}">
                                <i class="fas fa-envelope me-1"></i>Kontak
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center ms-3">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#globalSearchModal"><i class="fas fa-search me-1"></i>Cari</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    @hasSection('breadcrumbs')
    <section class="py-2" style="background: var(--bg-primary); border-bottom: 1px solid var(--border-color);">
        <div class="container">
            @yield('breadcrumbs')
        </div>
    </section>
    @endif

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-graduation-cap me-2"></i>SMA MADESU 1</h5>
                    <p class="mb-3">Sekolah Menengah Atas yang berkomitmen memberikan pendidikan berkualitas dan membentuk karakter siswa yang unggul, berakhlak mulia, dan siap menghadapi tantangan masa depan.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Menu Utama</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}"><i class="fas fa-home me-2"></i>Home</a></li>
                        <li class="mb-2"><a href="{{ route('berita.index') }}"><i class="fas fa-newspaper me-2"></i>Berita</a></li>
                        <li class="mb-2"><a href="{{ route('gallery.index') }}"><i class="fas fa-images me-2"></i>Galeri</a></li>
                        <li class="mb-2"><a href="{{ route('contact.index') }}"><i class="fas fa-envelope me-2"></i>Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Kontak Kami</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>Jl. Pendidikan No. 45, Madesu</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i>(021) 5555-0123</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i>info@smamadesu1.sch.id</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} SMA MADESU 1. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Dibuat dengan <i class="fas fa-heart text-danger"></i> untuk pendidikan</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    

    <!-- Global Search Modal -->
    <div class="modal fade" id="globalSearchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header border-0">
                    <h5 class="modal-title"><i class="fas fa-search me-2"></i>Pencarian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="GET" action="{{ route('search.index') }}">
                    <div class="modal-body pt-0">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Cari berita atau galeri..." required>
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
