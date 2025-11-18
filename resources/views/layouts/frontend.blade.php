<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SMKN 4 BOGOR')</title>
    <meta name="description" content="@yield('description', 'SMKN 4 BOGOR - Sekolah Menengah Kejuruan yang berkomitmen memberikan pendidikan berkualitas dan membentuk karakter siswa yang unggul')">
    
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

        /* Nav hover underline */
        .navbar-nav .nav-link { position: relative; }
        .navbar-nav .nav-link::after {
            content: ""; position: absolute; left: 1rem; right: 1rem; bottom: .5rem;
            height: 2px; background: var(--accent-color); transform: scaleX(0); transform-origin: left; transition: transform .25s ease;
        }
        .navbar-nav .nav-link:hover::after, .navbar-nav .nav-link.active::after { transform: scaleX(1); }

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

        /* Image skeleton */
        .skeleton { position: relative; background: #e5e7eb; overflow: hidden; }
        .skeleton::before { content: ""; position: absolute; inset: 0; background: linear-gradient(90deg, rgba(229,231,235,0) 0%, rgba(255,255,255,.6) 50%, rgba(229,231,235,0) 100%); transform: translateX(-100%); animation: shimmer 1.2s infinite; }
        @keyframes shimmer { to { transform: translateX(100%); } }

        /* Card skeleton */
        .card-skeleton { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; }
        .card-skeleton .skeleton-header { height: 200px; background: #e5e7eb; }
        .card-skeleton .skeleton-body { padding: 1.5rem; }
        .card-skeleton .skeleton-title { height: 1.5rem; background: #e5e7eb; border-radius: 4px; margin-bottom: 0.75rem; width: 80%; }
        .card-skeleton .skeleton-text { height: 1rem; background: #e5e7eb; border-radius: 4px; margin-bottom: 0.5rem; }
        .card-skeleton .skeleton-text:nth-child(3) { width: 60%; }
        .card-skeleton .skeleton-meta { height: 0.875rem; background: #e5e7eb; border-radius: 4px; width: 40%; margin-top: 1rem; }

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

        /* Subtle page transition */
        body.page-fade { opacity: 0; }
        body.page-fade-out { opacity: 0; transition: opacity .18s ease; }

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

        /* Extracurricular Modal Styles */
        .ekskul-card {
            transition: all 0.3s ease;
        }

        .ekskul-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .modal-content {
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            position: relative;
            overflow: hidden;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .modal-body h6 {
            font-weight: 600;
            color: var(--primary-color);
        }

        .modal-body .card {
            transition: all 0.3s ease;
        }

        .modal-body .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .modal-footer .btn {
            transition: all 0.3s ease;
        }

        .modal-footer .btn:hover {
            transform: translateY(-1px);
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
                    <i class="fas fa-graduation-cap me-2"></i>SMKN 4 BOGOR
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
                    <h5><i class="fas fa-graduation-cap me-2"></i>SMKN 4 BOGOR</h5>
                    <p class="mb-3">Sekolah Menengah Kejuruan yang berkomitmen memberikan pendidikan berkualitas dan membentuk karakter siswa yang unggul, berakhlak mulia, dan siap menghadapi tantangan masa depan.</p>
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
                    <p class="mb-0">&copy; {{ date('Y') }} SMKN 4 BOGOR. All rights reserved.</p>
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
    <script>
        // Reveal on scroll helper using IntersectionObserver
        (function() {
            const elements = document.querySelectorAll('.reveal');
            if (!elements.length) return;
            if (!('IntersectionObserver' in window)) {
                elements.forEach(function(el){ el.classList.add('visible'); });
                return;
            }
            const io = new IntersectionObserver(function(entries){
                entries.forEach(function(entry){
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            elements.forEach(function(el){ io.observe(el); });
        })();

        // Page fade-in/out transitions for internal navigation
        (function(){
            document.body.classList.add('page-fade');
            requestAnimationFrame(function(){ document.body.classList.remove('page-fade'); });
            document.addEventListener('click', function(e){
                const a = e.target.closest('a');
                if (!a) return;
                const href = a.getAttribute('href');
                const target = a.getAttribute('target');
                if (!href || href.startsWith('#') || target === '_blank') return;
                if (a.host !== location.host) return; // external
                e.preventDefault();
                document.body.classList.add('page-fade-out');
                setTimeout(function(){ location.href = href; }, 150);
            });
        })();

        // Smooth anchor scrolling with header offset
        (function(){
            document.addEventListener('click', function(e){
                const a = e.target.closest('a[href^="#"]');
                if (!a) return;
                const id = a.getAttribute('href').slice(1);
                const el = document.getElementById(id);
                if (!el) return;
                e.preventDefault();
                const y = el.getBoundingClientRect().top + window.pageYOffset - 72;
                window.scrollTo({ top: y, behavior: 'smooth' });
            });
        })();

        // Count-up utility
        (function(){
            const els = document.querySelectorAll('[data-count]');
            if (!els.length) return;
            const io = new IntersectionObserver((entries)=>{
                entries.forEach(entry=>{
                    if (!entry.isIntersecting) return;
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-count'), 10) || 0;
                    let current = 0; const dur = 1200; const start = performance.now();
                    function tick(t){
                        const p = Math.min(1, (t - start) / dur);
                        current = Math.floor(target * (0.1 + 0.9 * p));
                        el.textContent = current.toLocaleString();
                        if (p < 1) requestAnimationFrame(tick);
                    }
                    requestAnimationFrame(tick);
                    io.unobserve(el);
                });
            }, { threshold: 0.4 });
            els.forEach(el=>io.observe(el));
        })();

        // Scroll to top button
        (function(){
            const btn = document.createElement('button');
            btn.innerHTML = '<i class="fas fa-arrow-up"></i>';
            btn.className = 'scroll-to-top';
            btn.setAttribute('aria-label', 'Scroll to top');
            btn.style.cssText = `
                position: fixed; bottom: 2rem; right: 2rem; z-index: 1000;
                width: 3rem; height: 3rem; border-radius: 50%;
                background: linear-gradient(135deg, #0ea5e9, #0f172a);
                color: white; border: none; cursor: pointer;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                opacity: 0; transform: translateY(20px);
                transition: opacity 0.3s ease, transform 0.3s ease;
                display: flex; align-items: center; justify-content: center;
            `;
            document.body.appendChild(btn);

            function toggle() {
                const show = window.scrollY > 300;
                btn.style.opacity = show ? '1' : '0';
                btn.style.transform = show ? 'translateY(0)' : 'translateY(20px)';
            }

            btn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            window.addEventListener('scroll', toggle, { passive: true });
            toggle();
        })();
    </script>
</body>
</html>
