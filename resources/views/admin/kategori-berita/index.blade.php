@extends('layouts.admin')

@section('title', 'Kategori Berita')
@section('page-title', 'Kategori Berita')

@section('page-actions')
<a href="{{ route('admin.kategori-berita.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Tambah Kategori
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Kategori Berita</h5>
    </div>
    <div class="card-body">
        <div id="kategori-table-container">
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
    const apiUrl = '/api/v1';
    let currentPage = 1;
    
    // Load kategori data
    loadKategoriData();
    
    async function loadKategoriData() {
        try {
            const container = document.getElementById('kategori-table-container');
            container.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;
            
            // Build query parameters
            const params = new URLSearchParams();
            params.append('page', currentPage);
            params.append('per_page', 15);
            
            const response = await fetch(`${apiUrl}/kategori-berita?${params.toString()}`);
            const data = await response.json();
            
            if (data.data && data.data.length > 0) {
                renderKategoriTable(data.data, data.meta || {});
            } else {
                container.innerHTML = `
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada kategori berita</h5>
                            <p class="text-muted mb-4">Mulai dengan membuat kategori berita pertama Anda</p>
                            <a href="/admin/kategori-berita/create" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Buat Kategori Pertama
                            </a>
                        </div>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading kategori:', error);
            document.getElementById('kategori-table-container').innerHTML = `
                <div class="text-center py-3 text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Error loading data
                </div>
            `;
        }
    }
    
    function renderKategoriTable(kategoris, meta) {
        const container = document.getElementById('kategori-table-container');
        
        let html = `
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>Nama Kategori</th>
                            <th width="200">Slug</th>
                            <th width="100">Total Berita</th>
                            <th width="100">Published</th>
                            <th width="100">Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        kategoris.forEach((kategori, index) => {
            const statusBadge = kategori.is_active 
                ? '<span class="badge bg-success">Aktif</span>'
                : '<span class="badge bg-secondary">Tidak Aktif</span>';
            
            const canDelete = (kategori.beritas_count || 0) === 0;
            
            html += `
                <tr>
                    <td>${((currentPage - 1) * 15) + index + 1}</td>
                    <td>
                        <div>
                            <strong>${kategori.nama_kategori}</strong>
                            ${kategori.deskripsi ? `<br><small class="text-muted">${kategori.deskripsi.length > 50 ? kategori.deskripsi.substring(0, 50) + '...' : kategori.deskripsi}</small>` : ''}
                        </div>
                    </td>
                    <td><code class="small">${kategori.slug}</code></td>
                    <td>
                        <span class="badge bg-info">${kategori.beritas_count || 0}</span>
                    </td>
                    <td>
                        <span class="badge bg-success">${kategori.beritas_published_count || 0}</span>
                    </td>
                    <td>${statusBadge}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="/admin/kategori-berita/${kategori.id}" class="btn btn-outline-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/admin/kategori-berita/${kategori.id}/edit" class="btn btn-outline-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            ${canDelete ? `
                                <button type="button" class="btn btn-outline-danger" title="Hapus" onclick="deleteKategori(${kategori.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            ` : `
                                <button type="button" class="btn btn-outline-secondary" title="Tidak dapat dihapus (ada berita)" disabled>
                                    <i class="fas fa-lock"></i>
                                </button>
                            `}
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
                        dari ${meta.total} kategori
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
        loadKategoriData();
    };
    
    window.deleteKategori = async function(id) {
        const confirmed = await (window.showConfirm ? window.showConfirm({
            title: 'Hapus Kategori',
            message: 'Yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.',
            confirmText: 'Hapus',
            confirmVariant: 'danger',
            icon: 'trash'
        }) : Promise.resolve(confirm('Yakin ingin menghapus kategori ini?')));
        if (!confirmed) return;

        try {
            const response = await fetch(`${apiUrl}/kategori-berita/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            if (response.ok) {
                loadKategoriData();
                (window.showToast ? window.showToast('Kategori berhasil dihapus', 'SMA MADESU 1', 'success') : showAlert('Kategori berhasil dihapus', 'success'));
            } else {
                const errorData = await response.json();
                (window.showToast ? window.showToast(errorData.message || 'Gagal menghapus kategori', 'SMA MADESU 1', 'danger') : showAlert(errorData.message || 'Gagal menghapus kategori', 'danger'));
            }
        } catch (error) {
            console.error('Error deleting kategori:', error);
            (window.showToast ? window.showToast('Terjadi kesalahan', 'SMA MADESU 1', 'danger') : showAlert('Terjadi kesalahan', 'danger'));
        }
    };
    
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
