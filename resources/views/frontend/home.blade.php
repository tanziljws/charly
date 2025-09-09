@extends('layouts.frontend')

@section('title', 'Home - SMA MADESU 1')
@section('description', 'SMA MADESU 1 - Sekolah Menengah Atas yang berkomitmen memberikan pendidikan berkualitas dan membentuk karakter siswa yang unggul')

@push('styles')
<style>
    /* Hero Section Styles */
    .hero-section {
        position: relative;
        min-height: 100vh;
        background: linear-gradient(135deg, rgba(17, 24, 39, 0.8) 0%, rgba(14, 165, 233, 0.8) 100%),
                    url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800"><rect fill="%23f3f4f6" width="1200" height="800"/><circle fill="%23e5e7eb" cx="200" cy="200" r="100"/><circle fill="%23d1d5db" cx="800" cy="300" r="150"/><circle fill="%23e5e7eb" cx="1000" cy="600" r="120"/></svg>');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        color: white;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .testimonial-card::before {
        content: '"';
        position: absolute;
        top: -10px;
        left: 20px;
        font-size: 6rem;
        opacity: 0.3;
        font-family: serif;
    }

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
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 hero-content">
                <h1 class="hero-title">SMA MADESU 1</h1>
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
            <div class="col-lg-4 text-center">
                <div class="floating">
                    <i class="fas fa-graduation-cap" style="font-size: 8rem; opacity: 0.3;"></i>
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
                    <span class="text-primary">Tentang</span> SMA MADESU 1
                </h2>
                <p class="lead mb-4">
                    SMA MADESU 1 adalah sekolah menengah atas yang telah berdiri sejak tahun 1985, 
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
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-6 mb-4">
                        <div class="card card-hover text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-calendar-alt text-primary mb-3" style="font-size: 3rem;"></i>
                                <h4 class="text-primary mb-2">1985</h4>
                                <h6 class="card-title">Didirikan</h6>
                                <p class="small text-muted">35+ tahun melayani pendidikan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card card-hover text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-users text-primary mb-3" style="font-size: 3rem;"></i>
                                <h4 class="text-primary mb-2">1,200+</h4>
                                <h6 class="card-title">Siswa Aktif</h6>
                                <p class="small text-muted">Kelas X, XI, XII</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card card-hover text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-chalkboard-teacher text-primary mb-3" style="font-size: 3rem;"></i>
                                <h4 class="text-primary mb-2">80+</h4>
                                <h6 class="card-title">Guru & Staff</h6>
                                <p class="small text-muted">Pendidik berkualitas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
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
            <div class="col-lg-6 mb-4">
                <div class="card card-hover h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-eye me-2"></i>Visi
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="lead mb-0">
                            "Menjadi sekolah unggulan yang menghasilkan lulusan berkarakter, berprestasi, dan siap menghadapi tantangan global dengan landasan iman dan takwa."
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card card-hover h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-bullseye me-2"></i>Misi
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Menyelenggarakan pendidikan berkualitas tinggi</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Membangun karakter siswa yang berakhlak mulia</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Mengembangkan potensi akademik dan non-akademik</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Menyiapkan siswa untuk pendidikan tinggi</li>
                            <li class="mb-0"><i class="fas fa-check text-success me-2"></i>Membentuk generasi yang siap bersaing global</li>
                        </ul>
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
            <div class="col-lg-3 col-md-6 mb-4">
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
            <div class="col-lg-3 col-md-6 mb-4">
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
            <div class="col-lg-3 col-md-6 mb-4">
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
            <div class="col-lg-3 col-md-6 mb-4">
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
            <div class="col-md-8">
                <h2 class="h1 mb-3">
                    <span class="text-primary">Berita</span> Terbaru
                </h2>
                <p class="lead text-muted">Informasi terkini dari SMA MADESU 1</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('berita.index') }}" class="btn btn-outline-primary btn-lg">
                    Lihat Semua Berita <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        
        <div class="row">
            @foreach($latestBerita->take(4) as $berita)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card card-hover h-100">
                    @if($berita->gambar_utama)
                    <img src="{{ asset('storage/' . $berita->gambar_utama) }}" class="card-img-top" alt="{{ $berita->judul }}" style="height: 200px; object-fit: cover;">
                    @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                    </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-primary me-2">{{ $berita->kategoriBerita->nama_kategori ?? 'Umum' }}</span>
                            <small class="text-muted">{{ $berita->published_at->format('d M Y') }}</small>
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
            <div class="col-md-8">
                <h2 class="h1 mb-3">
                    <span class="text-primary">Galeri</span> Kegiatan
                </h2>
                <p class="lead text-muted">Momen-momen terbaik dari kegiatan SMA MADESU 1</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('gallery.index') }}" class="btn btn-outline-primary btn-lg">
                    Lihat Semua Galeri <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        
        <div class="row">
            @foreach($featuredGallery->take(3) as $gallery)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="gallery-item">
                    @if($gallery->gambar)
                    <img src="{{ asset('storage/' . $gallery->gambar) }}" class="gallery-image" alt="{{ $gallery->judul }}">
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
                <div class="card card-hover text-center h-100">
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
                <div class="card card-hover text-center h-100">
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
                <div class="card card-hover text-center h-100">
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
                <div class="card card-hover text-center h-100">
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
                <div class="card card-hover text-center h-100">
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
                <div class="card card-hover text-center h-100">
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

<!-- Testimonials Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-12 text-center">
                <h2 class="h1 mb-3">
                    <span class="text-primary">Testimoni</span> Alumni & Orang Tua
                </h2>
                <p class="lead text-muted">Pendapat mereka tentang SMA MADESU 1</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="testimonial-card">
                    <p class="mb-3">"SMA MADESU 1 memberikan fondasi yang kuat untuk masa depan. Guru-guru yang berkualitas dan lingkungan belajar yang kondusif membantu saya meraih impian kuliah di universitas ternama."</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Ahmad Rizki</h6>
                            <small class="text-white-50">Alumni 2020 - Mahasiswa ITB</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="testimonial-card">
                    <p class="mb-3">"Program kejuruan di SMA MADESU 1 sangat membantu anak saya mengembangkan skill yang dibutuhkan di dunia kerja. Sekarang dia sudah bekerja di perusahaan teknologi ternama."</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Ibu Sari</h6>
                            <small class="text-white-50">Orang Tua Siswa</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="testimonial-card">
                    <p class="mb-3">"Ekstrakurikuler yang beragam di SMA MADESU 1 membantu saya menemukan passion dalam bidang seni. Sekarang saya bekerja sebagai desainer grafis profesional."</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Siti Nurhaliza</h6>
                            <small class="text-white-50">Alumni 2019 - Desainer Grafis</small>
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
                        <div class="bg-light rounded p-4 text-center" style="height: 300px;">
                            <i class="fas fa-map text-muted mb-3" style="font-size: 3rem;"></i>
                            <h6>Google Maps</h6>
                            <p class="text-muted mb-3">Jl. Pendidikan No. 45, Kecamatan Madesu, Kota Madesu</p>
                            <a href="#" class="btn btn-primary">
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
                                <i class="fas fa-phone text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-0">Telepon</h6>
                                    <p class="text-muted mb-0">(021) 5555-0123</p>
                                </div>
                            </div>
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
<section class="section-padding bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="h1 mb-3">Siap Bergabung dengan SMA MADESU 1?</h2>
                <p class="lead mb-0">Daftarkan putra-putri Anda sekarang dan wujudkan impian mereka untuk masa depan yang cerah!</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-grid gap-2 d-lg-block">
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
@endsection
