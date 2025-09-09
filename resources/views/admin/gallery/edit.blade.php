@extends('layouts.admin')

@section('title', 'Edit Gallery')
@section('page-title', 'Edit Gallery')

@section('page-actions')
<a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
@endsection

@section('content')
<form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Gallery</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Gallery <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" name="judul" value="{{ old('judul', $gallery->judul) }}" 
                               placeholder="Masukkan judul gallery" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug', $gallery->slug) }}" 
                               placeholder="Otomatis dibuat dari judul">
                        <div class="form-text">Kosongkan untuk membuat otomatis dari judul</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="4" 
                                  placeholder="Deskripsi gallery (opsional)">{{ old('deskripsi', $gallery->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar Saat Ini</label>
                        <div class="mb-2">
                            <img src="{{ Storage::url($gallery->gambar) }}" 
                                 class="img-fluid rounded" style="max-height: 300px;" alt="{{ $gallery->judul }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Ganti Gambar</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                               id="gambar" name="gambar" accept="image/*">
                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 5MB. Kosongkan jika tidak ingin mengganti.</div>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="image_preview" style="display: none;" class="mb-3">
                        <label class="form-label">Preview Gambar Baru</label>
                        <div>
                            <img id="preview_img" src="" class="img-fluid rounded" style="max-height: 300px;" alt="Preview">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                               id="tags" name="tags" 
                               value="{{ old('tags', $gallery->tags ? implode(', ', $gallery->tags) : '') }}" 
                               placeholder="Pisahkan dengan koma, contoh: sekolah, kegiatan, prestasi">
                        <div class="form-text">Pisahkan setiap tag dengan koma</div>
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Pengaturan Gallery</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('kategori') is-invalid @enderror" 
                                id="kategori" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriOptions as $key => $label)
                                <option value="{{ $key }}" {{ old('kategori', $gallery->kategori) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_foto" class="form-label">Tanggal Foto <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_foto') is-invalid @enderror" 
                               id="tanggal_foto" name="tanggal_foto" 
                               value="{{ old('tanggal_foto', $gallery->tanggal_foto->format('Y-m-d')) }}" required>
                        @error('tanggal_foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="urutan" class="form-label">Urutan</label>
                        <input type="number" class="form-control @error('urutan') is-invalid @enderror" 
                               id="urutan" name="urutan" value="{{ old('urutan', $gallery->urutan) }}" 
                               min="0" placeholder="Otomatis jika kosong">
                        <div class="form-text">Kosongkan untuk urutan otomatis</div>
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Gallery Aktif
                            </label>
                        </div>
                        <div class="form-text">Gallery aktif akan ditampilkan di halaman publik</div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Gallery
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td>Dibuat</td>
                            <td>{{ $gallery->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Diupdate</td>
                            <td>{{ $gallery->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td>File Gambar</td>
                            <td><small>{{ basename($gallery->gambar) }}</small></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Gallery
                        </button>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto generate slug
    const judulInput = document.getElementById('judul');
    const slugInput = document.getElementById('slug');
    let autoSlug = false; // Don't auto-generate for existing content
    
    judulInput.addEventListener('input', function() {
        if (autoSlug) {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
        }
    });
    
    slugInput.addEventListener('input', function() {
        autoSlug = false;
    });

    // Image preview
    const gambarInput = document.getElementById('gambar');
    const imagePreview = document.getElementById('image_preview');
    const previewImg = document.getElementById('preview_img');
    
    gambarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // Check file size (5MB = 5 * 1024 * 1024 bytes)
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 5MB.');
                this.value = '';
                imagePreview.style.display = 'none';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });
});
</script>
@endpush
