@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 text-dark fw-bold">Dashboard</h4>
                <p class="text-muted mb-0">Selamat datang di panel admin SMKN 4 BOGOR</p>
            </div>
            <div class="text-muted small">
                <i class="fas fa-calendar-alt me-1"></i>
                {{ date('d M Y') }}
            </div>
        </div>
    </div>
</div>

<!-- Statistics Overview -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-body-modern">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-compact me-3">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <div>
                                <div class="stats-number-compact" id="total-berita">-</div>
                                <div class="stats-label-compact">Berita</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-compact me-3">
                                <i class="fas fa-images"></i>
                            </div>
                            <div>
                                <div class="stats-number-compact" id="gallery-active">-</div>
                                <div class="stats-label-compact">Gallery</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3 mb-md-0">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-compact me-3">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div>
                                <div class="stats-number-compact" id="total-views">-</div>
                                <div class="stats-label-compact">Views</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon-compact me-3">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div>
                                <div class="stats-number-compact" id="total-kategori">-</div>
                                <div class="stats-label-compact">Kategori</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div class="row mb-4">
    <div class="col-lg-6 mb-4">
        <div class="card-modern h-100">
            <div class="card-header-modern d-flex justify-content-between align-items-center">
                <h5 class="card-title-modern mb-0">
                    <i class="fas fa-newspaper me-2 text-primary"></i>
                    Berita Terbaru
                </h5>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-external-link-alt me-1"></i>Kelola
                </a>
            </div>
            <div class="card-body-modern">
                <div id="berita-terbaru-container">
                    <div class="text-center py-5">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted mt-3 mb-0 small">Memuat berita terbaru...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card-modern h-100">
            <div class="card-header-modern d-flex justify-content-between align-items-center">
                <h5 class="card-title-modern mb-0">
                    <i class="fas fa-images me-2 text-success"></i>
                    Galeri Terbaru
                </h5>
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-external-link-alt me-1"></i>Kelola
                </a>
            </div>
            <div class="card-body-modern">
                <div id="gallery-terbaru-container">
                    <div class="text-center py-5">
                        <div class="spinner-border spinner-border-sm text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted mt-3 mb-0 small">Memuat galeri terbaru...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Row -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card-modern">
            <div class="card-header-modern">
                <h5 class="card-title-modern mb-0">
                    <i class="fas fa-tags me-2 text-info"></i>
                    Statistik Kategori
                </h5>
            </div>
            <div class="card-body-modern">
                <div id="kategori-stats-container">
                    <div class="text-center py-5">
                        <div class="spinner-border spinner-border-sm text-info" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted mt-3 mb-0 small">Memuat statistik kategori...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card-modern">
            <div class="card-header-modern">
                <h5 class="card-title-modern mb-0">
                    <i class="fas fa-fire me-2 text-warning"></i>
                    Berita Populer
                </h5>
            </div>
            <div class="card-body-modern">
                <div id="berita-populer-container">
                    <div class="text-center py-5">
                        <div class="spinner-border spinner-border-sm text-warning" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted mt-3 mb-0 small">Memuat berita populer...</p>
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
            console.log('Loading stats...');
            
            const [beritaRes, galleryRes, kategoriRes] = await Promise.all([
                fetch(`${apiUrl}/berita`),
                fetch(`${apiUrl}/gallery`),
                fetch(`${apiUrl}/kategori-berita`)
            ]);
            
            console.log('API responses:', {
                berita: beritaRes.status,
                gallery: galleryRes.status,
                kategori: kategoriRes.status
            });
            
            const beritaData = await beritaRes.json();
            const galleryData = await galleryRes.json();
            const kategoriData = await kategoriRes.json();
            
            console.log('API data:', { beritaData, galleryData, kategoriData });
            
            // Update stats
            const totalBerita = beritaData.data ? beritaData.data.length : 0;
            const beritaPublished = beritaData.data ? beritaData.data.filter(b => b.status === 'published').length : 0;
            const totalGallery = galleryData.data ? galleryData.data.length : 0;
            const galleryActive = galleryData.data ? galleryData.data.filter(g => g.is_active).length : 0;
            const totalViews = beritaData.data ? beritaData.data.reduce((sum, b) => sum + (b.views || 0), 0) : 0;
            const totalKategori = kategoriData.data ? kategoriData.data.length : 0;
            
            console.log('Calculated stats:', {
                totalBerita, beritaPublished, totalGallery, galleryActive, totalViews, totalKategori
            });
            
            // Update DOM elements
            const elements = {
                'total-berita': totalBerita,
                'gallery-active': totalGallery,
                'total-views': totalViews.toLocaleString(),
                'total-kategori': totalKategori
            };
            
            Object.entries(elements).forEach(([id, value]) => {
                const element = document.getElementById(id);
                if (element) {
                    element.textContent = value;
                    console.log(`Updated ${id}: ${value}`);
                } else {
                    console.error(`Element not found: ${id}`);
                }
            });
            
        } catch (error) {
            console.error('Error loading stats:', error);
            
            // Set fallback values
            const fallbackElements = {
                'total-berita': '0',
                'gallery-active': '0', 
                'total-views': '0',
                'total-kategori': '0'
            };
            
            Object.entries(fallbackElements).forEach(([id, value]) => {
                const element = document.getElementById(id);
                if (element) {
                    element.textContent = value;
                }
            });
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
                    
                    html += `
                        <div class="border-0 py-3 border-bottom" style="border-color: #f1f5f9 !important;">
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-medium">
                                        <a href="/admin/berita/${berita.id}" class="text-decoration-none text-dark">
                                            ${berita.judul.length > 50 ? berita.judul.substring(0, 50) + '...' : berita.judul}
                                        </a>
                                    </h6>
                                    <div class="d-flex align-items-center gap-3 mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>${formatDate(berita.created_at)}
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-eye me-1"></i>${(berita.views || 0).toLocaleString()}
                                        </small>
                                        <span class="badge bg-light text-dark border">
                                            ${berita.kategori_berita?.nama_kategori || 'Uncategorized'}
                                        </span>
                                        ${statusBadge}
                                    </div>
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
                let html = '<div class="row">';
                
                data.data.forEach((kategori, index) => {
                    const beritaCount = kategori.beritas_count || 0;
                    const publishedCount = kategori.beritas_published_count || 0;
                    const percentage = beritaCount > 0 ? Math.min((beritaCount / Math.max(...data.data.map(k => k.beritas_count || 0))) * 100, 100) : 0;
                    
                    html += `
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border rounded" style="background: #fafbfc;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0 fw-medium">${kategori.nama_kategori}</h6>
                                    <span class="badge bg-light text-dark border">${beritaCount}</span>
                                </div>
                                <div class="progress bg-light mb-2" style="height: 6px; border-radius: 3px;">
                                    <div class="progress-bar bg-dark" style="width: ${percentage}%; border-radius: 3px;"></div>
                                </div>
                                <small class="text-muted">${publishedCount} published dari ${beritaCount} total</small>
                            </div>
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
                
                data.data.slice(0, 4).forEach(gallery => {
                    html += `
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center p-2 rounded border" style="background: #fafbfc;">
                                <img src="/storage/${gallery.gambar}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;" alt="${gallery.judul}">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-medium" style="font-size: 0.875rem;">${gallery.judul.length > 30 ? gallery.judul.substring(0, 30) + '...' : gallery.judul}</h6>
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
                
                data.data.forEach((berita, index) => {
                    html += `
                        <div class="d-flex align-items-center mb-3 p-2 rounded" style="background: #fafbfc;">
                            <div class="me-3">
                                <span class="badge bg-light text-dark border fw-bold" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">${index + 1}</span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-medium" style="font-size: 0.875rem;">
                                    <a href="/admin/berita/${berita.id}" class="text-decoration-none text-dark">
                                        ${berita.judul.length > 35 ? berita.judul.substring(0, 35) + '...' : berita.judul}
                                    </a>
                                </h6>
                                <div class="d-flex align-items-center gap-2">
                                    <small class="text-muted">${berita.kategori_berita?.nama_kategori || 'Uncategorized'}</small>
                                    <small class="text-muted">•</small>
                                    <small class="text-muted">${(berita.views || 0).toLocaleString()} views</small>
                                </div>
                            </div>
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
                return '<span class="badge bg-light text-success border border-success">Published</span>';
            case 'draft':
                return '<span class="badge bg-light text-muted border">Draft</span>';
            case 'archived':
                return '<span class="badge bg-light text-warning border border-warning">Archived</span>';
            default:
                return '<span class="badge bg-light text-muted border">Unknown</span>';
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
