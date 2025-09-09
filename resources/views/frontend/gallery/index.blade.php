@extends('layouts.frontend')

@section('title', 'Galeri - SMA MADESU 1')
@section('description', 'Kumpulan foto dan galeri kegiatan SMA MADESU 1')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <h1 class="h2 mb-3">
                        <i class="fas fa-images text-primary me-2"></i>Galeri SMA MADESU 1
                    </h1>
                    <p class="text-muted mb-0">Lihat momen-momen terbaik dari kegiatan dan aktivitas SMA MADESU 1</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-12">
            <!-- Search and Filter -->
            <div class="search-form mb-4">
                <form method="GET" action="{{ route('gallery.index') }}">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="search" class="form-label">Cari Galeri</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" placeholder="Masukkan kata kunci...">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                        @if(request('search'))
                        <a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Reset Filter
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Results Info -->
            @if(request('search'))
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i>
                Menampilkan {{ $gallery->total() }} galeri untuk pencarian "<strong>{{ request('search') }}</strong>"
            </div>
            @endif

            <!-- Gallery Grid -->
            @if($gallery->count() > 0)
            <div class="gallery-grid">
                @foreach($gallery as $item)
                <div class="gallery-item">
                    @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" class="gallery-image" alt="{{ $item->judul }}">
                    @else
                    <div class="gallery-image bg-light d-flex align-items-center justify-content-center">
                        <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                    </div>
                    @endif
                    <div class="gallery-overlay">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary">{{ $kategoriOptions[$item->kategori] ?? $item->kategori }}</span>
                            @if($item->tanggal_foto)
                            <small class="text-white-50">
                                <i class="fas fa-calendar me-1"></i>{{ $item->tanggal_foto->format('d M Y') }}
                            </small>
                            @endif
                        </div>
                        <h5 class="gallery-title">{{ $item->judul }}</h5>
                        <p class="gallery-description">{{ Str::limit($item->deskripsi, 100) }}</p>
                        <a href="{{ route('gallery.show', $item->slug) }}" class="btn btn-light btn-sm">
                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $gallery->appends(request()->query())->links() }}
            </div>
            @else
            <!-- No Results -->
            <div class="text-center py-5">
                <i class="fas fa-images text-muted mb-3" style="font-size: 4rem;"></i>
                <h4 class="text-muted">Tidak ada galeri ditemukan</h4>
                <p class="text-muted">Coba gunakan kata kunci yang berbeda atau lihat semua galeri.</p>
                <a href="{{ route('gallery.index') }}" class="btn btn-primary">
                    <i class="fas fa-list me-2"></i>Lihat Semua Galeri
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
