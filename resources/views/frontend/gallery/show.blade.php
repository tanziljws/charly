@extends('layouts.frontend')

@section('title', $gallery->judul . ' - Gallery Sekolah')
@section('description', $gallery->deskripsi)

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Galeri</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('gallery.index', ['kategori' => $gallery->kategori]) }}">
                    {{ \App\Models\Gallery::getKategoriOptions()[$gallery->kategori] ?? $gallery->kategori }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($gallery->judul, 50) }}</li>
        </ol>
    </nav>

    <!-- Back to Gallery Button -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('gallery.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Galeri
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Gallery Header -->
                    <div class="mb-4">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <span class="badge bg-primary">
                                {{ \App\Models\Gallery::getKategoriOptions()[$gallery->kategori] ?? $gallery->kategori }}
                            </span>
                            @if($gallery->tanggal_foto)
                            <span class="badge bg-secondary">
                                <i class="fas fa-calendar me-1"></i>{{ $gallery->tanggal_foto->format('d M Y') }}
                            </span>
                            @endif
                        </div>
                        
                        <h1 class="h2 mb-3">{{ $gallery->judul }}</h1>
                        
                        @if($gallery->deskripsi)
                        <p class="lead text-muted">{{ $gallery->deskripsi }}</p>
                        @endif
                    </div>

                    <!-- Gallery Image -->
                    @if($gallery->gambar)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $gallery->gambar) }}" 
                             class="img-fluid rounded shadow" 
                             alt="{{ $gallery->judul }}"
                             style="width: 100%; max-height: 500px; object-fit: cover;">
                    </div>
                    @else
                    <div class="text-center py-5 mb-4">
                        <i class="fas fa-image text-muted mb-3" style="font-size: 4rem;"></i>
                        <h4 class="text-muted">Gambar tidak tersedia</h4>
                    </div>
                    @endif

                    <!-- Gallery Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-info-circle me-2"></i>Informasi Galeri
                                    </h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <strong>Judul:</strong> {{ $gallery->judul }}
                                        </li>
                                        <li class="mb-2">
                                            <strong>Kategori:</strong> 
                                            {{ \App\Models\Gallery::getKategoriOptions()[$gallery->kategori] ?? $gallery->kategori }}
                                        </li>
                                        @if($gallery->tanggal_foto)
                                        <li class="mb-2">
                                            <strong>Tanggal Foto:</strong> {{ $gallery->tanggal_foto->format('d M Y') }}
                                        </li>
                                        @endif
                                        <li class="mb-2">
                                            <strong>Status:</strong> 
                                            <span class="badge bg-success">Aktif</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-share-alt me-2"></i>Bagikan Galeri
                                    </h6>
                                    <div class="d-grid gap-2">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                           target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="fab fa-facebook-f me-2"></i>Facebook
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($gallery->judul) }}" 
                                           target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fab fa-twitter me-2"></i>Twitter
                                        </a>
                                        <a href="https://wa.me/?text={{ urlencode($gallery->judul . ' - ' . request()->url()) }}" 
                                           target="_blank" class="btn btn-outline-success btn-sm">
                                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    @if($gallery->tags && count($gallery->tags) > 0)
                    <div class="mb-4">
                        <h6 class="mb-3">
                            <i class="fas fa-tags me-2"></i>Tags:
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($gallery->tags as $tag)
                            <span class="badge bg-light text-dark border">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Related Gallery -->
            @if($relatedGallery->count() > 0)
            <div class="mt-5">
                <h3 class="h4 mb-4">
                    <i class="fas fa-images me-2"></i>Galeri Terkait
                </h3>
                <div class="gallery-grid">
                    @foreach($relatedGallery as $related)
                    <div class="gallery-item">
                        @if($related->gambar)
                        <img src="{{ asset('storage/' . $related->gambar) }}" class="gallery-image" alt="{{ $related->judul }}">
                        @else
                        <div class="gallery-image bg-light d-flex align-items-center justify-content-center">
                            <i class="fas fa-image text-muted" style="font-size: 2rem;"></i>
                        </div>
                        @endif
                        <div class="gallery-overlay">
                            <h6 class="gallery-title">{{ $related->judul }}</h6>
                            <p class="gallery-description">{{ Str::limit($related->deskripsi, 80) }}</p>
                            <a href="{{ route('gallery.show', $related->slug) }}" class="btn btn-light btn-sm">
                                Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
