@extends('layouts.admin')

@section('title', 'Edit Kategori Berita')
@section('page-title', 'Edit Kategori Berita')

@section('page-actions')
<a href="{{ route('admin.kategori-berita.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Edit Kategori Berita</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kategori-berita.update', $kategoriBerita) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" 
                               id="nama_kategori" name="nama_kategori" 
                               value="{{ old('nama_kategori', $kategoriBerita->nama_kategori) }}" 
                               placeholder="Masukkan nama kategori" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" 
                               value="{{ old('slug', $kategoriBerita->slug) }}" 
                               placeholder="Otomatis dibuat dari nama kategori">
                        <div class="form-text">Kosongkan untuk membuat otomatis dari nama kategori</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="3" 
                                  placeholder="Deskripsi kategori (opsional)">{{ old('deskripsi', $kategoriBerita->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $kategoriBerita->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Kategori Aktif
                            </label>
                        </div>
                        <div class="form-text">Kategori aktif akan ditampilkan dalam pilihan saat membuat berita</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.kategori-berita.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Kategori
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>Dibuat</td>
                        <td>{{ $kategoriBerita->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td>Diupdate</td>
                        <td>{{ $kategoriBerita->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td>Total Berita</td>
                        <td>{{ $kategoriBerita->beritas()->count() }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Peringatan
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-0">
                    Mengubah slug akan mempengaruhi URL yang sudah ada. 
                    Pastikan untuk melakukan redirect jika diperlukan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const namaKategori = document.getElementById('nama_kategori');
    const slug = document.getElementById('slug');
    let autoSlug = true;
    
    namaKategori.addEventListener('input', function() {
        if (autoSlug) {
            slug.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
        }
    });
    
    slug.addEventListener('input', function() {
        autoSlug = false;
    });
});
</script>
@endpush
