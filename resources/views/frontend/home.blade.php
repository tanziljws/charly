@extends('layouts.frontend')

@section('title', 'Home - SMKN 4 BOGOR')
@section('description', 'SMKN 4 BOGOR - Sekolah Menengah Kejuruan yang berkomitmen memberikan pendidikan berkualitas dan membentuk karakter siswa yang unggul')

@push('styles')
<style>
    /* Hero Section Styles */
    .hero-section {
        position: relative;
        min-height: 100vh;
        background: linear-gradient(135deg, rgba(17, 24, 39, 0.8) 0%, rgba(14, 165, 233, 0.8) 100%),
                    url('{{ asset('image/praskib.JPG') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        color: white;
        overflow: hidden;
    }
    
    /* Soft parallax effect */
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255,255,255,0.05) 0%, transparent 50%),
            radial-gradient(circle at 40% 60%, rgba(255,255,255,0.08) 0%, transparent 50%);
        transform: translateZ(0);
        will-change: transform;
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.4rem;
        margin-bottom: 2.5rem;
        opacity: 0.95;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-hero {
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-hero:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    /* Floating Animation */
    .floating {
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    /* Reveal on Scroll */
    .reveal { opacity: 0; transform: translateY(24px); transition: opacity .6s ease, transform .6s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    .reveal-delay-1 { transition-delay: .1s; }
    .reveal-delay-2 { transition-delay: .2s; }
    .reveal-delay-3 { transition-delay: .3s; }

    /* Section Spacing */
    .section-padding {
        padding: 5rem 0;
    }

    /* Card Hover Effects */
    .card-hover {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .card-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    /* Testimonial Styles */
    .testimonial-card {
        background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
        background-size: 200% 200%;
        color: white;
        border-radius: 16px;
        padding: 1.75rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 28px rgba(0,0,0,0.15);
        transition: transform .3s ease, box-shadow .3s ease, background-position .6s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        min-height: 240px;
    }

    .testimonial-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.2); background-position: 100% 0; }

    .testimonial-card::before {
        content: '"';
        position: absolute;
        top: -10px;
        left: 20px;
        font-size: 6rem;
        opacity: 0.15;
        font-family: serif;
    }

    .testimonial-avatar { width: 50px; height: 50px; background: rgba(255,255,255,0.95); color: #0ea5e9; border-radius: 50%; display: grid; place-items: center; box-shadow: 0 6px 16px rgba(0,0,0,.15); }

    .testimonial-name { font-weight: 700; }
    .testimonial-role { opacity: .8; }

    /* Announcement Banner */
    .announcement-banner {
        background: linear-gradient(45deg, #ff6b6b, #feca57);
        color: white;
        padding: 1rem 0;
        position: relative;
        overflow: hidden;
    }

    .announcement-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    /* Gallery Grid */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .gallery-item {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .gallery-item:hover {
        transform: scale(1.05);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }

    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        color: white;
        padding: 2rem;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }

    .gallery-item:hover .gallery-overlay {
        transform: translateY(0);
    }

    /* Vision & Mission redesigned */
    .vm-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(0,0,0,.08);
        overflow: hidden;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .vm-card:hover { transform: translateY(-6px); box-shadow: 0 20px 48px rgba(0,0,0,.12); }
    .vm-header { display: flex; align-items: center; gap: .75rem; padding: 1rem 1.25rem; color: #fff; }
    .vm-header.visi { background: linear-gradient(135deg, #0ea5e9, #0f172a); }
    .vm-header.misi { background: linear-gradient(135deg, #10b981, #0f172a); }
    .icon-circle { width: 42px; height: 42px; border-radius: 50%; display: grid; place-items: center; background: rgba(255,255,255,.2); }
    .vm-quote { font-size: 1.1rem; line-height: 1.8; margin: 0; }
    .vm-list { list-style: none; padding: 0; margin: 0; }
    .vm-item { display: flex; gap: .75rem; align-items: flex-start; padding: .6rem 0; }
    .vm-check { color: #10b981; }
    .vm-meta { font-size: .85rem; color: #64748b; }
    .vm-timeline { position: relative; margin-top: .5rem; }
    .vm-timeline::before { content: ''; position: absolute; left: 20px; top: 0; bottom: 0; width: 2px; background: #e5e7eb; }
    .vm-step { position: relative; padding-left: 56px; padding-top: .25rem; padding-bottom: .75rem; }
    .vm-dot { position: absolute; left: 12px; top: .35rem; width: 16px; height: 16px; border-radius: 50%; background: #0ea5e9; box-shadow: 0 0 0 4px rgba(14,165,233,.15); }
    .vm-badge { display: inline-block; font-size: .75rem; padding: .25rem .5rem; border-radius: 999px; background: #e0f2fe; color: #0369a1; }
    /* Misi extras */
    .vm-kpis { display: flex; flex-wrap: wrap; gap: .75rem; margin-bottom: .75rem; }
    .vm-kpi { background: #f1f5f9; border: 1px solid #e5e7eb; border-radius: 12px; padding: .6rem .8rem; display: flex; gap: .6rem; align-items: center; }
    .vm-kpi i { color: #0ea5e9; }
    .vm-progress { background: #e5e7eb; height: 8px; border-radius: 999px; overflow: hidden; }
    .vm-progress > span { display: block; height: 100%; background: linear-gradient(90deg, #0ea5e9, #10b981); width: 0; }
    .vm-progress[data-value] > span { width: attr(data-value percentage); }
    @keyframes growBar { from { width: 0; } }
    .vm-progress.reveal.visible > span { animation: growBar 1.2s ease forwards; }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
        }
        
        .hero-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .btn-hero {
            width: 100%;
            max-width: 300px;
        }
    }

    /* Reduced motion accessibility */
    @media (prefers-reduced-motion: reduce) {
        .floating, .card-hover, .gallery-item, .reveal { animation: none !important; transition: none !important; }
    }

    /* Final CTA */
    .cta-section {
        background: linear-gradient(135deg, #0ea5e9 0%, #0f172a 100%);
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .cta-section::after {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(ellipse at 20% 20%, rgba(255,255,255,.08), transparent 40%),
                    radial-gradient(ellipse at 80% 10%, rgba(255,255,255,.06), transparent 45%);
        pointer-events: none;
    }
    .cta-title { font-weight: 800; letter-spacing: .3px; }
    .cta-subtitle { opacity: .9; max-width: 56ch; }
    .cta-actions { display: flex; gap: .75rem; flex-wrap: wrap; align-items: center; }
    @media (max-width: 992px) {
        .cta-actions { justify-content: flex-start; }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 hero-content reveal visible">
                <h1 class="hero-title">SMKN 4 BOGOR</h1>
                <p class="hero-subtitle">Membangun Generasi Unggul, Berakhlak Mulia, dan Siap Menghadapi Masa Depan</p>
                <div class="hero-buttons">
                    <a href="#about" class="btn btn-light btn-hero">
                        <i class="fas fa-info-circle me-2"></i>Lihat Profil
                    </a>
                    <a href="{{ route('contact.index') }}" class="btn btn-outline-light btn-hero">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About School Section -->
<section id="about" class="section-padding bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="h1 mb-4">
                    <span class="text-primary">Tentang</span> SMKN 4 BOGOR
                </h2>
                <p class="lead mb-4">
                    SMKN 4 BOGOR adalah sekolah menengah kejuruan yang telah berdiri sejak tahun 1985, 
                    dengan komitmen memberikan pendidikan berkualitas tinggi dan membentuk karakter 
                    siswa yang unggul, berakhlak mulia, dan siap menghadapi tantangan masa depan.
                </p>
                <p class="mb-4">
                    Dengan lebih dari 35 tahun pengalaman dalam dunia pendidikan, kami telah 
                    menghasilkan ribuan alumni yang berhasil di berbagai bidang. Sekolah kami 
                    dilengkapi dengan fasilitas modern, guru-guru berpengalaman, dan program 
                    pembelajaran yang komprehensif.
                </p>
                <div class="d-flex gap-3">
                    <a href="#programs" class="btn btn-primary btn-lg">
                        <i class="fas fa-graduation-cap me-2"></i>Lihat Program
                    </a>
                    <a href="{{ route('contact.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-phone me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
            <div class="col-lg-6 reveal">
                <div class="row">
                    <div class="col-6 mb-4 reveal reveal-delay-1">
                        <div class="card card-hover text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-calendar-alt text-primary mb-3" style="font-size: 3rem;"></i>
                                <h4 class="text-primary mb-2">1985</h4>
                                <h6 class="card-title">Didirikan</h6>
                                <p class="small text-muted">35+ tahun melayani pendidikan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4 reveal reveal-delay-2">
                        <div class="card card-hover text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-users text-primary mb-3" style="font-size: 3rem;"></i>
                                <h4 class="text-primary mb-2"><span data-count="1200">0</span>+</h4>
                                <h6 class="card-title">Siswa Aktif</h6>
                                <p class="small text-muted">Kelas X, XI, XII</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4 reveal reveal-delay-3">
                        <div class="card card-hover text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-chalkboard-teacher text-primary mb-3" style="font-size: 3rem;"></i>
                                <h4 class="text-primary mb-2"><span data-count="80">0</span>+</h4>
                                <h6 class="card-title">Guru & Staff</h6>
                                <p class="small text-muted">Pendidik berkualitas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4 reveal">
                        <div class="card card-hover text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-award text-primary mb-3" style="font-size: 3rem;"></i>
                                <h4 class="text-primary mb-2">A</h4>
                                <h6 class="card-title">Akreditasi</h6>
                                <p class="small text-muted">Grade terbaik</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4 reveal">
                <div class="vm-card h-100">
                    <div class="vm-header visi">
                        <div class="icon-circle"><i class="fas fa-eye"></i></div>
                        <h5 class="mb-0">Visi</h5>
                    </div>
                    <div class="card-body">
                        <p class="vm-quote mb-3">
                            "Menjadi sekolah unggulan yang menghasilkan lulusan berkarakter, berprestasi, dan siap menghadapi tantangan global dengan landasan iman dan takwa."
                        </p>
                        <div class="vm-timeline">
                            <div class="vm-step">
                                <div class="vm-dot"></div>
                                <div class="fw-semibold">Unggul dalam Karakter</div>
                                <div class="vm-meta">Integritas, disiplin, dan kepedulian sosial</div>
                            </div>
                            <div class="vm-step">
                                <div class="vm-dot"></div>
                                <div class="fw-semibold">Unggul dalam Prestasi</div>
                                <div class="vm-meta">Akademik dan non-akademik yang berkelanjutan</div>
                            </div>
                            <div class="vm-step">
                                <div class="vm-dot"></div>
                                <div class="fw-semibold">Siap Bersaing Global</div>
                                <div class="vm-meta">Berwawasan teknologi dan literasi digital</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4 reveal">
                <div class="vm-card h-100">
                    <div class="vm-header misi">
                        <div class="icon-circle"><i class="fas fa-bullseye"></i></div>
                        <h5 class="mb-0">Misi</h5>
                    </div>
                    <div class="card-body">
                        <ul class="vm-list mb-3">
                            <li class="vm-item"><i class="fas fa-check vm-check mt-1"></i>
                                <div>
                                    Menyelenggarakan pembelajaran <span class="vm-badge">berkualitas</span> dan berpusat pada siswa
                                </div>
                            </li>
                            <li class="vm-item"><i class="fas fa-check vm-check mt-1"></i>
                                <div>Membentuk karakter berakhlak mulia melalui pembiasaan positif</div>
                            </li>
                            <li class="vm-item"><i class="fas fa-check vm-check mt-1"></i>
                                <div>Mengembangkan potensi akademik, seni, dan olahraga secara seimbang</div>
                            </li>
                            <li class="vm-item"><i class="fas fa-check vm-check mt-1"></i>
                                <div>Menjalin kemitraan industri untuk <span class="vm-badge">magang</span> dan penempatan kerja</div>
                            </li>
                            <li class="vm-item"><i class="fas fa-check vm-check mt-1"></i>
                                <div>Menyiapkan lulusan siap kerja dan siap kuliah</div>
                            </li>
                        </ul>
                        <div class="vm-kpis mb-2">
                            <div class="vm-kpi"><i class="fas fa-user-graduate"></i><span>95% Lulusan Terserap</span></div>
                            <div class="vm-kpi"><i class="fas fa-handshake"></i><span>30+ Mitra Industri</span></div>
                            <div class="vm-kpi"><i class="fas fa-laptop-code"></i><span>100% Literasi Digital</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Program Jurusan Section -->
<section id="programs" class="section-padding bg-light">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-12 text-center">
                <h2 class="h1 mb-3">
                    <span class="text-primary">Program</span> Jurusan
                </h2>
                <p class="lead text-muted">Program kejuruan yang mempersiapkan siswa untuk dunia kerja</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 reveal">
                <div class="card card-hover text-center h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-code text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">PPLG</h5>
                        <p class="card-text text-muted">Pengembangan Perangkat Lunak dan Gim</p>
                        <p class="small">Fokus pada pemrograman, web development, dan game development</p>
                        <div class="mt-3">
                            <span class="badge bg-primary">Teknologi</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 reveal reveal-delay-1">
                <div class="card card-hover text-center h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-network-wired text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">TKJ</h5>
                        <p class="card-text text-muted">Teknik Komputer dan Jaringan</p>
                        <p class="small">Fokus pada jaringan komputer, server, dan sistem informasi</p>
                        <div class="mt-3">
                            <span class="badge bg-success">Networking</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 reveal reveal-delay-2">
                <div class="card card-hover text-center h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-fire text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">TEKNIK PENGELASAN</h5>
                        <p class="card-text text-muted">Teknik Pengelasan</p>
                        <p class="small">Fokus pada teknik pengelasan berbagai jenis material</p>
                        <div class="mt-3">
                            <span class="badge bg-warning">Manufaktur</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 reveal reveal-delay-3">
                <div class="card card-hover text-center h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-car text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">TEKNIK OTOMATIF</h5>
                        <p class="card-text text-muted">Teknik Otomotif</p>
                        <p class="small">Fokus pada perbaikan dan perawatan kendaraan bermotor</p>
                        <div class="mt-3">
                            <span class="badge bg-info">Otomotif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest News Section -->
@if($latestBerita->count() > 0)
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-8 reveal">
                <h2 class="h1 mb-3">
                    <span class="text-primary">Berita</span> Terbaru
                </h2>
                <p class="lead text-muted">Informasi terkini dari SMKN 4 BOGOR</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('berita.index') }}" class="btn btn-outline-primary btn-lg">
                    Lihat Semua Berita <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        
        <div class="row">
            @foreach($latestBerita->take(4) as $berita)
            <div class="col-lg-3 col-md-6 mb-4 reveal">
                <div class="card card-hover h-100">
                    @if($berita->gambar_utama)
                    <img src="{{ asset('storage/' . $berita->gambar_utama) }}" class="card-img-top" alt="{{ $berita->judul }}" style="height: 200px; object-fit: cover;" loading="lazy">
                    @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                    </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-primary me-2">{{ $berita->kategoriBerita->nama_kategori ?? 'Umum' }}</span>
                            <small class="text-muted">{{ $berita->published_at ? $berita->published_at->format('d M Y') : 'Belum dipublikasi' }}</small>
                        </div>
                        <h6 class="card-title">{{ Str::limit($berita->judul, 60) }}</h6>
                        <p class="card-text small text-muted flex-grow-1">{{ Str::limit($berita->excerpt, 100) }}</p>
                        <a href="{{ route('berita.show', $berita->slug) }}" class="btn btn-outline-primary btn-sm mt-auto">
                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Gallery Section -->
@if($featuredGallery->count() > 0)
<section class="section-padding bg-light">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-8 reveal">
                <h2 class="h1 mb-3">
                    <span class="text-primary">Galeri</span> Kegiatan
                </h2>
                <p class="lead text-muted">Momen-momen terbaik dari kegiatan SMKN 4 BOGOR</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('gallery.index') }}" class="btn btn-outline-primary btn-lg">
                    Lihat Semua Galeri <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        
        <div class="row">
            @foreach($featuredGallery->take(3) as $gallery)
            <div class="col-lg-4 col-md-6 mb-4 reveal">
                <div class="gallery-item">
                    @if($gallery->gambar)
                    <img src="{{ asset('storage/' . $gallery->gambar) }}" class="gallery-image" alt="{{ $gallery->judul }}" loading="lazy">
                    @else
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center">
                        <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                    </div>
                    @endif
                    <div class="gallery-overlay">
                        <h5 class="gallery-title">{{ $gallery->judul }}</h5>
                        <p class="gallery-description">{{ Str::limit($gallery->deskripsi, 100) }}</p>
                        <a href="{{ route('gallery.show', $gallery->slug) }}" class="btn btn-light btn-sm">
                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Extracurricular & Achievements Section -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-12 text-center">
                <h2 class="h1 mb-3">
                    <span class="text-primary">Ekstrakurikuler</span>
                </h2>
                <p class="lead text-muted">Kembangkan bakat dan raih prestasi terbaik</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-hover text-center h-100 ekskul-card" data-bs-toggle="modal" data-bs-target="#ekskulModal" data-ekskul="paskibra" style="cursor: pointer;">
                    <div class="card-body">
                        <i class="fas fa-flag text-primary mb-3" style="font-size: 3rem;"></i>
                        <h5 class="card-title">Paskibra</h5>
                        <p class="card-text small">Pasukan Pengibar Bendera</p>
                        <div class="mt-3">
                            <span class="badge bg-danger">Prestasi</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-hover text-center h-100 ekskul-card" data-bs-toggle="modal" data-bs-target="#ekskulModal" data-ekskul="pramuka" style="cursor: pointer;">
                    <div class="card-body">
                        <i class="fas fa-hiking text-primary mb-3" style="font-size: 3rem;"></i>
                        <h5 class="card-title">Pramuka</h5>
                        <p class="card-text small">Praja Muda Karana</p>
                        <div class="mt-3">
                            <span class="badge bg-success">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-hover text-center h-100 ekskul-card" data-bs-toggle="modal" data-bs-target="#ekskulModal" data-ekskul="pmr" style="cursor: pointer;">
                    <div class="card-body">
                        <i class="fas fa-heart text-primary mb-3" style="font-size: 3rem;"></i>
                        <h5 class="card-title">PMR</h5>
                        <p class="card-text small">Palang Merah Remaja</p>
                        <div class="mt-3">
                            <span class="badge bg-warning">Kemanusiaan</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-hover text-center h-100 ekskul-card" data-bs-toggle="modal" data-bs-target="#ekskulModal" data-ekskul="rohis" style="cursor: pointer;">
                    <div class="card-body">
                        <i class="fas fa-mosque text-primary mb-3" style="font-size: 3rem;"></i>
                        <h5 class="card-title">Rohis</h5>
                        <p class="card-text small">Rohani Islam</p>
                        <div class="mt-3">
                            <span class="badge bg-info">Keagamaan</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-hover text-center h-100 ekskul-card" data-bs-toggle="modal" data-bs-target="#ekskulModal" data-ekskul="osis" style="cursor: pointer;">
                    <div class="card-body">
                        <i class="fas fa-users text-primary mb-3" style="font-size: 3rem;"></i>
                        <h5 class="card-title">OSIS</h5>
                        <p class="card-text small">Organisasi Siswa Intra Sekolah</p>
                        <div class="mt-3">
                            <span class="badge bg-primary">Kepemimpinan</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-hover text-center h-100 ekskul-card" data-bs-toggle="modal" data-bs-target="#ekskulModal" data-ekskul="mpk" style="cursor: pointer;">
                    <div class="card-body">
                        <i class="fas fa-gavel text-primary mb-3" style="font-size: 3rem;"></i>
                        <h5 class="card-title">MPK</h5>
                        <p class="card-text small">Majelis Perwakilan Kelas</p>
                        <div class="mt-3">
                            <span class="badge bg-secondary">Perwakilan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Extracurricular Modal -->
<div class="modal fade" id="ekskulModal" tabindex="-1" aria-labelledby="ekskulModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #0ea5e9, #0f172a); color: white; padding: 2rem;">
                <div class="d-flex align-items-center">
                    <div id="modalIcon" class="me-3" style="font-size: 2.5rem;"></div>
                    <div>
                        <h4 class="modal-title mb-1" id="modalTitle">Judul Ekstrakurikuler</h4>
                        <p class="mb-0 opacity-75" id="modalSubtitle">Subtitle</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Deskripsi</h6>
                        <p id="modalDescription" class="text-muted mb-4">Deskripsi ekstrakurikuler akan muncul di sini.</p>
                        
                        <h6 class="text-primary mb-3"><i class="fas fa-trophy me-2"></i>Prestasi & Kegiatan</h6>
                        <ul id="modalAchievements" class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Prestasi akan muncul di sini</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center">
                                <h6 class="text-primary mb-3"><i class="fas fa-calendar-alt me-2"></i>Jadwal Kegiatan</h6>
                                <p id="modalSchedule" class="small text-muted mb-3">Jadwal akan muncul di sini</p>
                                
                                <h6 class="text-primary mb-3"><i class="fas fa-user-tie me-2"></i>Pembina</h6>
                                <p id="modalSupervisor" class="small text-muted mb-3">Nama pembina akan muncul di sini</p>
                                
                                <h6 class="text-primary mb-3"><i class="fas fa-users me-2"></i>Jumlah Anggota</h6>
                                <p id="modalMembers" class="small text-muted mb-3">Jumlah anggota akan muncul di sini</p>
                                
                                <div class="mt-3">
                                    <span id="modalBadge" class="badge bg-primary">Kategori</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="showContactInfo()">
                    <i class="fas fa-envelope me-2"></i>Hubungi Pembina
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-12 text-center">
                <h2 class="h1 mb-3">
                    <span class="text-primary">Testimoni</span> Alumni & Orang Tua
                </h2>
                <p class="lead text-muted">Pendapat mereka tentang SMKN 4 BOGOR</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 mb-4 reveal">
                <div class="testimonial-card">
                    <p class="mb-3">"SMKN 4 BOGOR memberikan fondasi yang kuat untuk masa depan. Guru-guru yang berkualitas dan lingkungan belajar yang kondusif membantu saya meraih impian kuliah di universitas ternama."</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="testimonial-avatar"><i class="fas fa-user"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Ahmad Rizki</h6>
                            <small class="testimonial-role">Alumni 2020 - Mahasiswa ITB</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4 reveal reveal-delay-1">
                <div class="testimonial-card">
                    <p class="mb-3">"Program kejuruan di SMKN 4 BOGOR sangat membantu anak saya mengembangkan skill yang dibutuhkan di dunia kerja. Sekarang dia sudah bekerja di perusahaan teknologi ternama."</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="testimonial-avatar"><i class="fas fa-user"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Ibu Sari</h6>
                            <small class="testimonial-role">Orang Tua Siswa</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4 reveal reveal-delay-2">
                <div class="testimonial-card">
                    <p class="mb-3">"Ekstrakurikuler yang beragam di SMKN 4 BOGOR membantu saya menemukan passion dalam bidang seni. Sekarang saya bekerja sebagai desainer grafis profesional."</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="testimonial-avatar"><i class="fas fa-user"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Siti Nurhaliza</h6>
                            <small class="testimonial-role">Alumni 2019 - Desainer Grafis</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4 reveal">
                <div class="testimonial-card">
                    <p class="mb-3">"Fasilitas sekolah yang lengkap membuat proses belajar menjadi menyenangkan. Guru-guru selalu mendukung dan memberikan arahan yang tepat."</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="testimonial-avatar"><i class="fas fa-user"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Budi Santoso</h6>
                            <small class="testimonial-role">Alumni 2021 - Karyawan Teknologi</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4 reveal reveal-delay-1">
                <div class="testimonial-card">
                    <p class="mb-3">"Anak saya berkembang pesat sejak masuk SMKN 4 BOGOR. Lingkungan sekolah yang positif membuatnya lebih percaya diri."</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="testimonial-avatar"><i class="fas fa-user"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Pak Andi</h6>
                            <small class="testimonial-role">Orang Tua Siswa</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4 reveal reveal-delay-2">
                <div class="testimonial-card">
                    <p class="mb-3">"Program magang yang diadakan sekolah sangat bermanfaat. Saya mendapatkan pengalaman kerja nyata sebelum lulus."</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="testimonial-avatar"><i class="fas fa-user"></i></div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Rina Amelia</h6>
                            <small class="testimonial-role">Alumni 2022 - Magang di Perusahaan IT</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact & Location Section -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-12 text-center">
                <h2 class="h1 mb-3">
                    <span class="text-primary">Kontak</span> & Lokasi
                </h2>
                <p class="lead text-muted">Hubungi kami untuk informasi lebih lanjut</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card card-hover">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>Lokasi Sekolah
                        </h5>
                        <div class="rounded overflow-hidden" style="height: 300px;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.049839558919!2d106.8246939!3d-6.640733399999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c8b16ee07ef5%3A0x14ab253dd267de49!2sSMKN%204%20Bogor!5e0!3m2!1sen!2sid!4v1757425432957!5m2!1sen!2sid"
                                width="100%"
                                height="100%"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="text-center mt-3">
                            <a href="https://maps.app.goo.gl/Q84Ug3JoMqanQ4xb6" class="btn btn-primary" target="_blank" rel="noopener">
                                <i class="fas fa-external-link-alt me-2"></i>Buka di Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card card-hover h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-phone text-primary me-2"></i>Kontak Cepat
                        </h5>
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-envelope text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-0">Email</h6>
                                    <p class="text-muted mb-0">info@smamadesu1.sch.id</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fab fa-whatsapp text-success me-3"></i>
                                <div>
                                    <h6 class="mb-0">WhatsApp</h6>
                                    <p class="text-muted mb-0">+62 812-3456-7890</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('contact.index') }}" class="btn btn-primary">
                                <i class="fas fa-envelope me-2"></i>Kirim Pesan
                            </a>
                            <a href="https://wa.me/6281234567890" class="btn btn-success" target="_blank">
                                <i class="fab fa-whatsapp me-2"></i>Chat WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final Call to Action -->
<section class="section-padding cta-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-3 mb-lg-0 reveal">
                <h2 class="display-5 cta-title mb-3">Siap Bergabung dengan SMKN 4 BOGOR?</h2>
                <p class="lead cta-subtitle mb-0">Daftarkan putra-putri Anda sekarang dan wujudkan impian mereka untuk masa depan yang cerah!</p>
            </div>
            <div class="col-lg-4 text-lg-end reveal">
                <div class="cta-actions">
                    <a href="{{ route('contact.index') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </a>
                    <a href="{{ route('berita.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-newspaper me-2"></i>Lihat Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
// Extracurricular data
const ekskulData = {
    paskibra: {
        icon: '<i class="fas fa-flag"></i>',
        title: 'Paskibra',
        subtitle: 'Pasukan Pengibar Bendera',
        description: 'Paskibra adalah ekstrakurikuler yang membentuk karakter disiplin, patriotisme, dan nasionalisme. Anggota Paskibra dilatih untuk menjadi pasukan pengibar bendera yang profesional dan bertanggung jawab.',
        achievements: [
            'Juara 1 Lomba Paskibra Tingkat Kabupaten Bogor 2023',
            'Juara 2 Lomba Paskibra Tingkat Provinsi Jawa Barat 2023',
            'Mengikuti Upacara Bendera di berbagai acara penting',
            'Pelatihan baris-berbaris dan kedisiplinan rutin'
        ],
        schedule: 'Setiap hari Sabtu, 07.00 - 10.00 WIB',
        supervisor: 'Bapak/Ibu Pembina Paskibra',
        members: '25-30 siswa',
        badge: 'Prestasi',
        badgeClass: 'bg-danger'
    },
    pramuka: {
        icon: '<i class="fas fa-hiking"></i>',
        title: 'Pramuka',
        subtitle: 'Praja Muda Karana',
        description: 'Pramuka mengajarkan nilai-nilai kepramukaan, kemandirian, dan kepedulian terhadap lingkungan. Melalui berbagai kegiatan outdoor dan survival, siswa belajar untuk menjadi pribadi yang tangguh dan bertanggung jawab.',
        achievements: [
            'Juara 1 Lomba Pramuka Tingkat Kabupaten Bogor 2023',
            'Mengikuti Jambore Nasional 2023',
            'Kegiatan camping dan hiking rutin',
            'Pelatihan survival dan navigasi'
        ],
        schedule: 'Setiap hari Minggu, 08.00 - 12.00 WIB',
        supervisor: 'Bapak/Ibu Pembina Pramuka',
        members: '40-50 siswa',
        badge: 'Aktif',
        badgeClass: 'bg-success'
    },
    pmr: {
        icon: '<i class="fas fa-heart"></i>',
        title: 'PMR',
        subtitle: 'Palang Merah Remaja',
        description: 'PMR membentuk karakter kemanusiaan dan kepedulian sosial. Anggota PMR dilatih untuk memberikan pertolongan pertama dan menjadi relawan dalam berbagai kegiatan kemanusiaan.',
        achievements: [
            'Juara 1 Lomba PMR Tingkat Kabupaten Bogor 2023',
            'Mengikuti kegiatan donor darah rutin',
            'Pelatihan pertolongan pertama dan P3K',
            'Kegiatan bakti sosial di masyarakat'
        ],
        schedule: 'Setiap hari Jumat, 15.00 - 17.00 WIB',
        supervisor: 'Bapak/Ibu Pembina PMR',
        members: '30-35 siswa',
        badge: 'Kemanusiaan',
        badgeClass: 'bg-warning'
    },
    rohis: {
        icon: '<i class="fas fa-mosque"></i>',
        title: 'Rohis',
        subtitle: 'Rohani Islam',
        description: 'Rohis menguatkan keimanan dan ketaqwaan siswa melalui berbagai kegiatan keagamaan. Anggota Rohis belajar untuk menjadi muslim yang berakhlak mulia dan berprestasi.',
        achievements: [
            'Juara 1 Lomba MTQ Tingkat Kabupaten Bogor 2023',
            'Mengadakan kajian rutin dan tadarus',
            'Kegiatan bakti sosial dan zakat',
            'Pelatihan public speaking dan dakwah'
        ],
        schedule: 'Setiap hari Selasa & Kamis, 15.00 - 17.00 WIB',
        supervisor: 'Bapak/Ibu Pembina Rohis',
        members: '35-40 siswa',
        badge: 'Keagamaan',
        badgeClass: 'bg-info'
    },
    osis: {
        icon: '<i class="fas fa-users"></i>',
        title: 'OSIS',
        subtitle: 'Organisasi Siswa Intra Sekolah',
        description: 'OSIS adalah organisasi siswa yang mengembangkan jiwa kepemimpinan dan organisasi. Anggota OSIS belajar untuk mengelola berbagai kegiatan sekolah dan menjadi perwakilan siswa.',
        achievements: [
            'Mengorganisir berbagai acara sekolah',
            'Juara 1 Lomba OSIS Tingkat Kabupaten Bogor 2023',
            'Pelatihan kepemimpinan dan manajemen',
            'Kegiatan sosial dan pengabdian masyarakat'
        ],
        schedule: 'Setiap hari Rabu, 15.00 - 17.00 WIB',
        supervisor: 'Bapak/Ibu Pembina OSIS',
        members: '20-25 siswa',
        badge: 'Kepemimpinan',
        badgeClass: 'bg-primary'
    },
    mpk: {
        icon: '<i class="fas fa-gavel"></i>',
        title: 'MPK',
        subtitle: 'Majelis Perwakilan Kelas',
        description: 'MPK adalah badan perwakilan siswa yang berfungsi sebagai pengawas dan penyeimbang OSIS. Anggota MPK belajar untuk menjadi pengawas yang adil dan bertanggung jawab.',
        achievements: [
            'Mengawasi kinerja OSIS secara objektif',
            'Mengadakan sidang-sidang penting',
            'Pelatihan hukum dan perundang-undangan',
            'Kegiatan pengawasan dan evaluasi'
        ],
        schedule: 'Setiap hari Senin, 15.00 - 17.00 WIB',
        supervisor: 'Bapak/Ibu Pembina MPK',
        members: '15-20 siswa',
        badge: 'Perwakilan',
        badgeClass: 'bg-secondary'
    }
};

// Handle modal opening
document.addEventListener('DOMContentLoaded', function() {
    const ekskulCards = document.querySelectorAll('.ekskul-card');
    const modal = document.getElementById('ekskulModal');
    
    ekskulCards.forEach(card => {
        card.addEventListener('click', function() {
            const ekskulType = this.getAttribute('data-ekskul');
            const data = ekskulData[ekskulType];
            
            if (data) {
                // Update modal content
                document.getElementById('modalIcon').innerHTML = data.icon;
                document.getElementById('modalTitle').textContent = data.title;
                document.getElementById('modalSubtitle').textContent = data.subtitle;
                document.getElementById('modalDescription').textContent = data.description;
                document.getElementById('modalSchedule').textContent = data.schedule;
                document.getElementById('modalSupervisor').textContent = data.supervisor;
                document.getElementById('modalMembers').textContent = data.members;
                
                // Update badge
                const badge = document.getElementById('modalBadge');
                badge.textContent = data.badge;
                badge.className = `badge ${data.badgeClass}`;
                
                // Update achievements
                const achievementsList = document.getElementById('modalAchievements');
                achievementsList.innerHTML = '';
                data.achievements.forEach(achievement => {
                    const li = document.createElement('li');
                    li.className = 'mb-2';
                    li.innerHTML = `<i class="fas fa-check-circle text-success me-2"></i>${achievement}`;
                    achievementsList.appendChild(li);
                });
            }
        });
    });
});

// Contact info function
function showContactInfo() {
    alert('Untuk informasi lebih lanjut tentang ekstrakurikuler, silakan hubungi:\n\nEmail: info@smamadesu1.sch.id\nWhatsApp: +62 812-3456-7890\n\nAtau datang langsung ke sekolah pada jam kerja.');
}
</script>
@endpush
@endsection
