@extends('layouts.admin')

@section('title', 'Gallery')
@section('page-title', 'Manajemen Gallery')

@section('page-actions')
@endsection

@section('content')
<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Gallery</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-5">
                <input type="text" class="form-control" name="search" placeholder="Cari judul atau deskripsi...">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="is_active">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-select" name="kategori">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriOptions as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Gallery</h5>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Gallery
        </a>
    </div>
    <div class="card-body">
        <div id="gallery-container">
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
/* Card improvements */
.gallery-card { transition: box-shadow 0.25s ease, transform 0.2s ease; }
.gallery-card:hover { box-shadow: 0 10px 30px rgba(0,0,0,0.12); transform: translateY(-2px); }

.thumb-wrap { position: relative; border-radius: 10px; overflow: hidden; border: 1px solid var(--border-color); }
.thumb-wrap img { width: 100%; height: 190px; object-fit: cover; transition: transform 0.3s ease; display: block; }
.gallery-card:hover .thumb-wrap img { transform: scale(1.04); }

.badge-spot { position: absolute; top: 10px; left: 10px; display: flex; gap: 6px; }
.badge-spot-right { position: absolute; top: 10px; right: 10px; }

.actions-overlay { position: absolute; inset: 0; background: rgba(17,24,39,0.35); opacity: 0; display: flex; align-items: center; justify-content: center; gap: 8px; transition: opacity 0.2s ease; }
.gallery-card:hover .actions-overlay { opacity: 1; }

.actions-overlay .btn { backdrop-filter: blur(2px); padding: 0.4rem 0.55rem; }

.card-meta { display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; color: var(--text-muted); }
.card-meta .left, .card-meta .right { display: flex; align-items: center; gap: 10px; }

.title-wrap { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
.desc-wrap { color: var(--text-muted); font-size: 0.88rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.6em; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const apiUrl = '/api/v1';
    let currentPage = 1;
    let currentSearch = '';
    let currentStatus = '';
    let currentKategori = '';
    
    // Gallery kategori options
    const kategoriOptions = {
        'kegiatan_sekolah': 'Kegiatan Sekolah',
        'prestasi': 'Prestasi',
        'fasilitas': 'Fasilitas',
        'acara_khusus': 'Acara Khusus',
        'lainnya': 'Lainnya'
    };
    
    // Load gallery data
    loadGalleryData();
    
    // Search functionality
    const searchInput = document.querySelector('input[name="search"]');
    const statusSelect = document.querySelector('select[name="is_active"]');
    const kategoriSelect = document.querySelector('select[name="kategori"]');
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            currentSearch = this.value;
            currentPage = 1;
            loadGalleryData();
        }, 500));
    }
    
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            currentStatus = this.value;
            currentPage = 1;
            loadGalleryData();
        });
    }
    
    if (kategoriSelect) {
        kategoriSelect.addEventListener('change', function() {
            currentKategori = this.value;
            currentPage = 1;
            loadGalleryData();
        });
    }
    
    async function loadGalleryData() {
        try {
            const container = document.getElementById('gallery-container');
            container.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;
            
            // Build query parameters
            const params = new URLSearchParams();
            if (currentSearch) params.append('search', currentSearch);
            if (currentStatus) params.append('is_active', currentStatus);
            if (currentKategori) params.append('kategori', currentKategori);
            params.append('page', currentPage);
            params.append('per_page', 12);
            
            const response = await fetch(`${apiUrl}/gallery?${params.toString()}`);
            const data = await response.json();
            
            if (data.data && data.data.length > 0) {
                renderGalleryGrid(data.data, data.meta || {});
            } else {
                container.innerHTML = `
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-images fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada gallery</h5>
                            <p class="text-muted mb-4">Mulai dengan membuat gallery pertama Anda</p>
                            <a href="/admin/gallery/create" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Buat Gallery Pertama
                            </a>
                        </div>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading gallery:', error);
            document.getElementById('gallery-container').innerHTML = `
                <div class="text-center py-3 text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Error loading data
                </div>
            `;
        }
    }
    
    function renderGalleryGrid(galleries, meta) {
        const container = document.getElementById('gallery-container');
        
        let html = '<div class="row">';
        
        galleries.forEach(gallery => {
            const statusBadge = gallery.is_active 
                ? '<span class="badge bg-success">Aktif</span>'
                : '<span class="badge bg-secondary">Tidak Aktif</span>';
            
            const kategoriLabel = kategoriOptions[gallery.kategori] || gallery.kategori;
            
            html += `
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card gallery-card h-100">
                        <div class="thumb-wrap">
                            <img src="/storage/${gallery.gambar}" alt="${gallery.judul}">
                            <div class="badge-spot">${statusBadge}</div>
                            <div class="badge-spot-right"><span class="badge bg-info">${kategoriLabel}</span></div>
                            <div class="actions-overlay">
                                <a href="/admin/gallery/${gallery.id}" class="btn btn-light btn-sm" title="Lihat"><i class="fas fa-eye"></i></a>
                                <a href="/admin/gallery/${gallery.id}/edit" class="btn btn-light btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                <button type="button" onclick="deleteGallery(${gallery.id})" class="btn btn-light btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="mb-1 title-wrap">${gallery.judul}</h6>
                            ${gallery.deskripsi ? `<div class="desc-wrap">${gallery.deskripsi}</div>` : '<div class="desc-wrap"></div>'}
                            <div class="mt-3 card-meta">
                                <div class="left">
                                    <span><i class="fas fa-calendar me-1"></i>${formatDate(gallery.tanggal_foto)}</span>
                                </div>
                                <div class="right">
                                    <span><i class="fas fa-sort me-1"></i>${gallery.urutan}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        
        // Add pagination if available
        if (meta.total > meta.per_page) {
            html += renderPagination(meta);
        }
        
        container.innerHTML = html;
    }
    
    function renderPagination(meta) {
        const totalPages = Math.ceil(meta.total / meta.per_page);
        let html = `
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <small class="text-muted">
                        Menampilkan ${((currentPage - 1) * meta.per_page) + 1} - ${Math.min(currentPage * meta.per_page, meta.total)} 
                        dari ${meta.total} gallery
                    </small>
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
        `;
        
        // Previous button
        html += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <button class="page-link" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
                    <i class="fas fa-chevron-left"></i>
                </button>
            </li>
        `;
        
        // Page numbers
        const startPage = Math.max(1, currentPage - 2);
        const endPage = Math.min(totalPages, currentPage + 2);
        
        for (let i = startPage; i <= endPage; i++) {
            html += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <button class="page-link" onclick="changePage(${i})">${i}</button>
                </li>
            `;
        }
        
        // Next button
        html += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <button class="page-link" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
                    <i class="fas fa-chevron-right"></i>
                </button>
            </li>
        `;
        
        html += `
                    </ul>
                </nav>
            </div>
        `;
        
        return html;
    }
    
    // Global functions
    window.changePage = function(page) {
        currentPage = page;
        loadGalleryData();
    };
    
    window.deleteGallery = async function(id) {
        const confirmed = await (window.showConfirm ? window.showConfirm({
            title: 'Hapus Gallery',
            message: 'Yakin ingin menghapus gallery ini? Tindakan ini tidak dapat dibatalkan.',
            confirmText: 'Hapus',
            confirmVariant: 'danger',
            icon: 'trash'
        }) : Promise.resolve(confirm('Yakin ingin menghapus gallery ini?')));
        
        if (!confirmed) return;

        try {
            // Close any open modals first
            const modalEl = document.getElementById('globalConfirmModal');
            if (modalEl) {
                const bsModal = bootstrap.Modal.getInstance(modalEl);
                if (bsModal) {
                    bsModal.hide();
                }
            }

            const response = await fetch(`${apiUrl}/gallery/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            if (response.ok) {
                loadGalleryData();
                (window.showToast ? window.showToast('Gallery berhasil dihapus', 'SMKN 4 BOGOR', 'success') : showAlert('Gallery berhasil dihapus', 'success'));
            } else {
                (window.showToast ? window.showToast('Gagal menghapus gallery', 'SMKN 4 BOGOR', 'danger') : showAlert('Gagal menghapus gallery', 'danger'));
            }
        } catch (error) {
            console.error('Error deleting gallery:', error);
            (window.showToast ? window.showToast('Terjadi kesalahan', 'SMKN 4 BOGOR', 'danger') : showAlert('Terjadi kesalahan', 'danger'));
        }
    };
    
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', { 
            day: '2-digit', 
            month: '2-digit', 
            year: 'numeric' 
        });
    }
    
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    function showAlert(message, type) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        const container = document.querySelector('.container-fluid');
        container.insertAdjacentHTML('afterbegin', alertHtml);
        
        setTimeout(() => {
            const alert = container.querySelector('.alert');
            if (alert) alert.remove();
        }, 3000);
    }
});
</script>
@endpush
