@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Section removed for cleaner UI -->

<!-- Statistics Cards -->
<div class="row mb-4" id="stats-cards">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card stats-card-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-label">Total Berita</div>
                    <div class="stats-number" id="total-berita">-</div>
                    <small class="opacity-75">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span id="berita-published">-</span> Published
                    </small>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card stats-card-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-label">Gallery Aktif</div>
                    <div class="stats-number" id="gallery-active">-</div>
                    <small class="opacity-75">
                        <i class="fas fa-images me-1"></i>
                        dari <span id="total-gallery">-</span> total
                    </small>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-images"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card stats-card-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-label">Total Views</div>
                    <div class="stats-number" id="total-views">-</div>
                    <small class="opacity-75">
                        <i class="fas fa-eye me-1"></i>
                        Semua berita
                    </small>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-eye"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card stats-card-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-label">Kategori</div>
                    <div class="stats-number" id="total-kategori">-</div>
                    <small class="opacity-75">
                        <i class="fas fa-tags me-1"></i>
                        Kategori berita
                    </small>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Berita Terbaru -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-newspaper me-2"></i>
                    Berita Terbaru
                </h5>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body p-0" id="berita-terbaru-container">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Kategori -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Statistik Kategori
                </h5>
            </div>
            <div class="card-body" id="kategori-stats-container">
                <div class="text-center py-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Gallery Terbaru -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-images me-2"></i>
                    Galeri Terbaru
                </h5>
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body" id="gallery-terbaru-container">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Berita Populer -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-fire me-2"></i>
                    Berita Populer
                </h5>
            </div>
            <div class="card-body" id="berita-populer-container">
                <div class="text-center py-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart untuk Gallery per Kategori -->

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Base API URL
    const apiUrl = '/api/v1';
    
    // Load dashboard data
    loadDashboardData();
    
    async function loadDashboardData() {
        try {
            // Load stats
            await loadStats();
            
            // Load berita terbaru
            await loadBeritaTerbaru();
            
            // Load kategori stats
            await loadKategoriStats();
            
            // Load gallery terbaru
            await loadGalleryTerbaru();
            
            // Load berita populer
            await loadBeritaPopuler();
            
        } catch (error) {
            console.error('Error loading dashboard data:', error);
        }
    }
    
    async function loadStats() {
        try {
            const [beritaRes, galleryRes, kategoriRes] = await Promise.all([
                fetch(`${apiUrl}/berita`),
                fetch(`${apiUrl}/gallery`),
                fetch(`${apiUrl}/kategori-berita`)
            ]);
            
            const beritaData = await beritaRes.json();
            const galleryData = await galleryRes.json();
            const kategoriData = await kategoriRes.json();
            
            // Update stats
            const totalBerita = beritaData.data ? beritaData.data.length : 0;
            const beritaPublished = beritaData.data ? beritaData.data.filter(b => b.status === 'published').length : 0;
            const totalGallery = galleryData.data ? galleryData.data.length : 0;
            const galleryActive = galleryData.data ? galleryData.data.filter(g => g.is_active).length : 0;
            const totalViews = beritaData.data ? beritaData.data.reduce((sum, b) => sum + (b.views || 0), 0) : 0;
            const totalKategori = kategoriData.data ? kategoriData.data.length : 0;
            
            document.getElementById('total-berita').textContent = totalBerita;
            document.getElementById('berita-published').textContent = beritaPublished;
            document.getElementById('total-gallery').textContent = totalGallery;
            document.getElementById('gallery-active').textContent = galleryActive;
            document.getElementById('total-views').textContent = totalViews.toLocaleString();
            document.getElementById('total-kategori').textContent = totalKategori;
            
        } catch (error) {
            console.error('Error loading stats:', error);
        }
    }
    
    async function loadBeritaTerbaru() {
        try {
            const response = await fetch(`${apiUrl}/berita?limit=5&sort=created_at&order=desc`);
            const data = await response.json();
            
            const container = document.getElementById('berita-terbaru-container');
            
            if (data.data && data.data.length > 0) {
                let html = '<div class="list-group list-group-flush">';
                
                data.data.forEach(berita => {
                    const statusBadge = getStatusBadge(berita.status);
                    const featuredBadge = berita.is_featured ? '<span class="badge bg-warning rounded-pill ms-1">Featured</span>' : '';
                    
                    html += `
                        <div class="list-group-item border-0 py-3">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h6 class="mb-1">
                                        <a href="/admin/berita/${berita.id}" class="text-decoration-none text-dark">
                                            ${berita.judul.length > 40 ? berita.judul.substring(0, 40) + '...' : berita.judul}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>Admin • 
                                        <i class="fas fa-calendar me-1"></i>${formatDate(berita.created_at)}
                                    </small>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge bg-primary rounded-pill">
                                        ${berita.kategori_berita?.nama_kategori || 'Uncategorized'}
                                    </span>
                                    ${featuredBadge}
                                </div>
                                <div class="col-md-2 text-center">
                                    ${statusBadge}
                                </div>
                                <div class="col-md-1 text-end">
                                    <small class="text-muted">
                                        <i class="fas fa-eye me-1"></i>${(berita.views || 0).toLocaleString()}
                                    </small>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                html += '</div>';
                container.innerHTML = html;
            } else {
                container.innerHTML = `
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada berita</h5>
                            <p class="text-muted mb-4">Mulai dengan membuat berita pertama Anda</p>
                            <a href="/admin/berita/create" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Buat Berita Pertama
                            </a>
                        </div>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading berita terbaru:', error);
            document.getElementById('berita-terbaru-container').innerHTML = '<div class="text-center py-3 text-danger">Error loading data</div>';
        }
    }
    
    async function loadKategoriStats() {
        try {
            const response = await fetch(`${apiUrl}/kategori-berita`);
            const data = await response.json();
            
            const container = document.getElementById('kategori-stats-container');
            
            if (data.data && data.data.length > 0) {
                let html = '<div class="category-stats">';
                
                data.data.forEach(kategori => {
                    const beritaCount = kategori.beritas_count || 0;
                    const publishedCount = kategori.beritas_published_count || 0;
                    
                    html += `
                        <div class="category-item mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-medium">${kategori.nama_kategori}</span>
                                <span class="text-muted">${beritaCount}</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-info" style="width: ${beritaCount > 0 ? (beritaCount / 10) * 100 : 0}%"></div>
                            </div>
                            <small class="text-muted">${publishedCount} published</small>
                        </div>
                    `;
                });
                
                html += '</div>';
                container.innerHTML = html;
            } else {
                container.innerHTML = `
                    <div class="text-center py-3">
                        <i class="fas fa-tags fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-2">Belum ada kategori</p>
                        <a href="/admin/kategori-berita/create" class="btn btn-info btn-sm">
                            <i class="fas fa-plus me-2"></i>Tambah Kategori
                        </a>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading kategori stats:', error);
            document.getElementById('kategori-stats-container').innerHTML = '<div class="text-center py-3 text-danger">Error loading data</div>';
        }
    }
    
    async function loadGalleryTerbaru() {
        try {
            const response = await fetch(`${apiUrl}/gallery?limit=6&sort=created_at&order=desc`);
            const data = await response.json();
            
            const container = document.getElementById('gallery-terbaru-container');
            
            if (data.data && data.data.length > 0) {
                let html = '<div class="row">';
                
                data.data.slice(0, 6).forEach(gallery => {
                    html += `
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="/storage/${gallery.gambar}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="${gallery.judul}">
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1">${gallery.judul.length > 30 ? gallery.judul.substring(0, 30) + '...' : gallery.judul}</h6>
                                    <small class="text-muted">${formatDate(gallery.tanggal_foto)}</small>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                html += '</div>';
                container.innerHTML = html;
            } else {
                container.innerHTML = `
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-images fa-3x mb-3"></i>
                        <p>Belum ada gallery</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading gallery terbaru:', error);
            document.getElementById('gallery-terbaru-container').innerHTML = '<div class="text-center py-3 text-danger">Error loading data</div>';
        }
    }
    
    async function loadBeritaPopuler() {
        try {
            const response = await fetch(`${apiUrl}/berita?sort=views&order=desc&limit=5`);
            const data = await response.json();
            
            const container = document.getElementById('berita-populer-container');
            
            if (data.data && data.data.length > 0) {
                let html = '';
                
                data.data.forEach(berita => {
                    html += `
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="/admin/berita/${berita.id}" class="text-decoration-none">
                                        ${berita.judul.length > 40 ? berita.judul.substring(0, 40) + '...' : berita.judul}
                                    </a>
                                </h6>
                                <small class="text-muted">${berita.kategori_berita?.nama_kategori || 'Uncategorized'}</small>
                            </div>
                            <span class="badge bg-warning text-dark">${(berita.views || 0).toLocaleString()} views</span>
                        </div>
                    `;
                });
                
                container.innerHTML = html;
            } else {
                container.innerHTML = `
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-fire fa-3x mb-3"></i>
                        <p>Belum ada data</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading berita populer:', error);
            document.getElementById('berita-populer-container').innerHTML = '<div class="text-center py-3 text-danger">Error loading data</div>';
        }
    }
    
    function getStatusBadge(status) {
        switch (status) {
            case 'published':
                return '<span class="badge bg-success rounded-pill">Published</span>';
            case 'draft':
                return '<span class="badge bg-secondary rounded-pill">Draft</span>';
            case 'archived':
                return '<span class="badge bg-warning rounded-pill">Archived</span>';
            default:
                return '<span class="badge bg-light text-dark rounded-pill">Unknown</span>';
        }
    }
    
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', { 
            day: 'numeric', 
            month: 'short', 
            year: 'numeric' 
        });
    }
});
</script>
@endpush
