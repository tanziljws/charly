@extends('layouts.admin')

@section('title', 'Detail Gallery')
@section('page-title', 'Detail Gallery')

@section('page-actions')
<div class="btn-group">
    <a href="{{ route('admin.gallery.edit', $gallery) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>Edit
    </a>
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $gallery->judul }}</h5>
                <div>
                    @if($gallery->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Tidak Aktif</span>
                    @endif
                    <span class="badge bg-info ms-1">{{ App\Models\Gallery::getKategoriOptions()[$gallery->kategori] }}</span>
                </div>
            </div>
            
            <div class="card-img-top">
                <img src="{{ Storage::url($gallery->gambar) }}" 
                     class="img-fluid w-100" style="max-height: 500px; object-fit: contain; background: #f8f9fa;" 
                     alt="{{ $gallery->judul }}">
            </div>
            
            <div class="card-body">
                <div class="mb-4">
                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <i class="fas fa-user me-1"></i>
                            {{ $gallery->user->name ?? 'Admin' }}
                        </div>
                        <div class="col-md-6 text-md-end">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $gallery->tanggal_foto->format('d F Y') }}
                        </div>
                    </div>
                    <div class="row text-muted small mt-1">
                        <div class="col-md-6">
                            <i class="fas fa-layer-group me-1"></i>
                            Urutan: {{ $gallery->urutan }}
                        </div>
                        <div class="col-md-6 text-md-end">
                            <i class="fas fa-clock me-1"></i>
                            Dibuat: {{ $gallery->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>

                @if($gallery->deskripsi)
                <div class="mb-4">
                    <h6>Deskripsi</h6>
                    <p class="text-muted">{{ $gallery->deskripsi }}</p>
                </div>
                @endif

                @if($gallery->tags && count($gallery->tags) > 0)
                <div class="mt-4 pt-3 border-top">
                    <h6 class="mb-2">Tags:</h6>
                    @foreach($gallery->tags as $tag)
                        <span class="badge bg-light text-dark me-1 mb-1">#{{ $tag }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Gallery
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="100">Slug</td>
                        <td>: <code>{{ $gallery->slug }}</code></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>: 
                            @if($gallery->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td>: {{ App\Models\Gallery::getKategoriOptions()[$gallery->kategori] }}</td>
                    </tr>
                    <tr>
                        <td>Urutan</td>
                        <td>: {{ $gallery->urutan }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Foto</td>
                        <td>: {{ $gallery->tanggal_foto->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Dibuat</td>
                        <td>: {{ $gallery->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td>Diupdate</td>
                        <td>: {{ $gallery->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-cog me-2"></i>Aksi
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.gallery.edit', $gallery) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Gallery
                    </a>
                    
                    <a href="{{ route('admin.gallery.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Tambah Gallery Baru
                    </a>
                    
                    <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus gallery ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus Gallery
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-image me-2"></i>Detail Gambar
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td>Nama File</td>
                        <td>: <small>{{ basename($gallery->gambar) }}</small></td>
                    </tr>
                    <tr>
                        <td>Path</td>
                        <td>: <small><code>{{ $gallery->gambar }}</code></small></td>
                    </tr>
                </table>
                
                <div class="mt-3">
                    <a href="{{ Storage::url($gallery->gambar) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-external-link-alt me-1"></i>Lihat Full Size
                    </a>
                </div>
            </div>
        </div>

        <!-- Gallery lain dalam kategori yang sama -->
        @php
            $relatedGalleries = App\Models\Gallery::where('kategori', $gallery->kategori)
                ->where('id', '!=', $gallery->id)
                ->where('is_active', true)
                ->orderBy('urutan')
                ->limit(3)
                ->get();
        @endphp

        @if($relatedGalleries->count() > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-images me-2"></i>Gallery Terkait
                </h6>
            </div>
            <div class="card-body">
                @foreach($relatedGalleries as $related)
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ Storage::url($related->gambar) }}" 
                         class="me-2 rounded" style="width: 50px; height: 50px; object-fit: cover;" 
                         alt="{{ $related->judul }}">
                    <div class="flex-grow-1">
                        <h6 class="mb-0 small">
                            <a href="{{ route('admin.gallery.show', $related) }}" class="text-decoration-none">
                                {{ Str::limit($related->judul, 30) }}
                            </a>
                        </h6>
                        <small class="text-muted">{{ $related->tanggal_foto->format('d/m/Y') }}</small>
                    </div>
                </div>
                @endforeach
                
                <a href="{{ route('admin.gallery.index', ['kategori' => $gallery->kategori]) }}" 
                   class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
