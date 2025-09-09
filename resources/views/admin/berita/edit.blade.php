@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita')

@section('page-actions')
<a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
@endsection

@section('content')
<form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Berita</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" 
                               placeholder="Masukkan judul berita" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug', $berita->slug) }}" 
                               placeholder="Otomatis dibuat dari judul">
                        <div class="form-text">Kosongkan untuk membuat otomatis dari judul</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Ringkasan</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                  id="excerpt" name="excerpt" rows="3" 
                                  placeholder="Ringkasan berita (opsional, otomatis dibuat dari konten)">{{ old('excerpt', $berita->excerpt) }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="konten" class="form-label">Konten Berita <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('konten') is-invalid @enderror" 
                                  id="konten" name="konten" rows="10" 
                                  placeholder="Tulis konten berita di sini..." required>{{ old('konten', $berita->konten) }}</textarea>
                        @error('konten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                               id="tags" name="tags" 
                               value="{{ old('tags', is_array($berita->tags) ? implode(', ', $berita->tags) : $berita->tags) }}" 
                               placeholder="Pisahkan dengan koma, contoh: sekolah, pendidikan, prestasi">
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
                    <h6 class="mb-0">Pengaturan Publikasi</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="kategori_berita_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('kategori_berita_id') is-invalid @enderror" 
                                id="kategori_berita_id" name="kategori_berita_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" 
                                        {{ old('kategori_berita_id', $berita->kategori_berita_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_berita_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status', $berita->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="published_at_field">
                        <label for="published_at" class="form-label">Tanggal Publikasi</label>
                        <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                               id="published_at" name="published_at" 
                               value="{{ old('published_at', $berita->published_at ? $berita->published_at->format('Y-m-d\TH:i') : '') }}">
                        <div class="form-text">Kosongkan untuk menggunakan waktu sekarang</div>
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $berita->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                Berita Unggulan
                            </label>
                        </div>
                        <div class="form-text">Berita unggulan akan ditampilkan di halaman utama</div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Gambar Utama</h6>
                </div>
                <div class="card-body">
                    @if($berita->gambar_utama)
                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label>
                            <div>
                                <img src="{{ Storage::url($berita->gambar_utama) }}" 
                                     class="img-fluid rounded" alt="{{ $berita->judul }}">
                            </div>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="gambar_utama" class="form-label">
                            {{ $berita->gambar_utama ? 'Ganti Gambar' : 'Upload Gambar' }}
                        </label>
                        <input type="file" class="form-control @error('gambar_utama') is-invalid @enderror" 
                               id="gambar_utama" name="gambar_utama" accept="image/*">
                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                        @error('gambar_utama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div id="image_preview" style="display: none;">
                        <img id="preview_img" src="" class="img-fluid rounded" alt="Preview">
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Informasi</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td>Dibuat</td>
                            <td>{{ $berita->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Diupdate</td>
                            <td>{{ $berita->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Views</td>
                            <td>{{ number_format($berita->views) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Berita
                        </button>
                        <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
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

    // Show/hide published_at field
    const statusSelect = document.getElementById('status');
    const publishedAtField = document.getElementById('published_at_field');
    
    function togglePublishedAtField() {
        if (statusSelect.value === 'published') {
            publishedAtField.style.display = 'block';
        } else {
            publishedAtField.style.display = 'none';
        }
    }
    
    statusSelect.addEventListener('change', togglePublishedAtField);
    togglePublishedAtField(); // Initial check

    // Image preview
    const gambarInput = document.getElementById('gambar_utama');
    const imagePreview = document.getElementById('image_preview');
    const previewImg = document.getElementById('preview_img');
    
    gambarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
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
