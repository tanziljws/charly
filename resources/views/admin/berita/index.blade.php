@extends('layouts.admin')

@section('title', 'Berita')
@section('page-title', 'Manajemen Berita')

@section('page-actions')
@endsection

@section('content')
<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Berita</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-5">
                <input type="text" class="form-control" name="search" placeholder="Cari judul atau konten...">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-select" name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Berita</h5>
        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Berita
        </a>
    </div>
    <div class="card-body">
        <div id="berita-table-container">
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const apiUrl = '/api/v1';
    let currentPage = 1;
    let currentSearch = '';
    let currentKategori = '';
    let currentStatus = '';
    
    // Load berita data
    loadBeritaData();
    
    // Search functionality
    const searchInput = document.querySelector('input[name="search"]');
    const kategoriSelect = document.querySelector('select[name="kategori_id"]');
    const statusSelect = document.querySelector('select[name="status"]');
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            currentSearch = this.value;
            currentPage = 1;
            loadBeritaData();
        }, 500));
    }
    
    if (kategoriSelect) {
        kategoriSelect.addEventListener('change', function() {
            currentKategori = this.value;
            currentPage = 1;
            loadBeritaData();
        });
    }
    
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            currentStatus = this.value;
            currentPage = 1;
            loadBeritaData();
        });
    }
    
    async function loadBeritaData() {
        try {
            const container = document.getElementById('berita-table-container');
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
            if (currentKategori) params.append('kategori_id', currentKategori);
            if (currentStatus) params.append('status', currentStatus);
            params.append('page', currentPage);
            params.append('per_page', 10);
            
            const response = await fetch(`${apiUrl}/berita?${params.toString()}`);
            const data = await response.json();
            
            if (data.data && data.data.length > 0) {
                renderBeritaTable(data.data, data.meta || {});
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
            console.error('Error loading berita:', error);
            document.getElementById('berita-table-container').innerHTML = `
                <div class="text-center py-3 text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Error loading data
                </div>
            `;
        }
    }
    
    function renderBeritaTable(beritas, meta) {
        const container = document.getElementById('berita-table-container');
        
        let html = `
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>Judul</th>
                            <th width="150">Kategori</th>
                            <th width="100">Status</th>
                            <th width="80">Views</th>
                            <th width="100">Tanggal</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        beritas.forEach((berita, index) => {
            const statusBadge = getStatusBadge(berita.status);
            const featuredIcon = berita.is_featured ? '<i class="fas fa-star text-warning ms-1" title="Featured"></i>' : '';
            const imageHtml = berita.gambar_utama 
                ? `<img src="/storage/${berita.gambar_utama}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;" alt="${berita.judul}">`
                : '';
            
            html += `
                <tr>
                    <td>${((currentPage - 1) * 10) + index + 1}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            ${imageHtml}
                            <div>
                                <h6 class="mb-0">${berita.judul.length > 50 ? berita.judul.substring(0, 50) + '...' : berita.judul}</h6>
                                ${featuredIcon}
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-primary">${berita.kategori_berita?.nama_kategori || 'Uncategorized'}</span>
                    </td>
                    <td>${statusBadge}</td>
                    <td>
                        <small class="text-muted">${(berita.views || 0).toLocaleString()}</small>
                    </td>
                    <td>
                        <small class="text-muted">${formatDate(berita.created_at)}</small>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="/admin/berita/${berita.id}" class="btn btn-outline-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/admin/berita/${berita.id}/edit" class="btn btn-outline-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/admin/berita/${berita.id}" method="POST" onsubmit="return (window.__confirmDeleteBerita ? window.__confirmDeleteBerita(event) : confirm('Yakin ingin menghapus berita ini?'))" class="d-inline">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        html += `
                    </tbody>
                </table>
            </div>
        `;
        
        // Add pagination if available
        if (meta.total > meta.per_page) {
            html += renderPagination(meta);
        }
        
        container.innerHTML = html;
    }
    
    function renderPagination(meta) {
        const totalPages = Math.ceil(meta.total / meta.per_page);
        let html = `
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">
                        Menampilkan ${((currentPage - 1) * meta.per_page) + 1} - ${Math.min(currentPage * meta.per_page, meta.total)} 
                        dari ${meta.total} berita
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
        loadBeritaData();
    };
    
    
    function getStatusBadge(status) {
        switch (status) {
            case 'published':
                return '<span class="badge bg-success">Published</span>';
            case 'draft':
                return '<span class="badge bg-secondary">Draft</span>';
            case 'archived':
                return '<span class="badge bg-warning">Archived</span>';
            default:
                return '<span class="badge bg-light text-dark">Unknown</span>';
        }
    }
    
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

    // Intercept delete form submit to use themed confirm modal
    window.__confirmDeleteBerita = async function(e) {
        if (!window.showConfirm) return true;
        e.preventDefault();
        const ok = await window.showConfirm({
            title: 'Hapus Berita',
            message: 'Yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.',
            confirmText: 'Hapus',
            confirmVariant: 'danger',
            icon: 'trash'
        });
        
        if (ok) {
            // Close any open modals first
            const modalEl = document.getElementById('globalConfirmModal');
            if (modalEl) {
                const bsModal = bootstrap.Modal.getInstance(modalEl);
                if (bsModal) {
                    bsModal.hide();
                }
            }
            
            // Wait a bit for modal to close, then submit
            setTimeout(() => {
                e.target.submit();
            }, 300);
        }
        return false;
    }
});
</script>
@endpush
