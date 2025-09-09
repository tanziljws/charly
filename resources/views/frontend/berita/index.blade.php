@extends('layouts.frontend')

@section('title', 'Berita - SMA MADESU 1')
@section('description', 'Kumpulan berita terbaru dari SMA MADESU 1')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <h1 class="h2 mb-3">
                        <i class="fas fa-newspaper text-primary me-2"></i>Berita SMA MADESU 1
                    </h1>
                    <p class="text-muted mb-0">Dapatkan informasi terbaru tentang kegiatan dan perkembangan SMA MADESU 1</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Search and Filter -->
            <div class="search-form mb-4">
                <form method="GET" action="{{ route('berita.index') }}">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="search" class="form-label">Cari Berita</label>
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
                        <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Reset Filter
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Results Info -->
            @if(request('search') || request('kategori'))
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i>
                Menampilkan {{ $berita->total() }} berita
                @if(request('search'))
                    untuk pencarian "<strong>{{ request('search') }}</strong>"
                @endif
                @if(request('kategori'))
                    dalam kategori "<strong>{{ $kategoriBerita->where('slug', request('kategori'))->first()->nama_kategori ?? '' }}</strong>"
                @endif
            </div>
            @endif

            <!-- News Grid -->
            @if($berita->count() > 0)
            <div class="row">
                @foreach($berita as $item)
                <div class="col-md-6 mb-4">
                    <div class="card news-card h-100">
                        @if($item->gambar_utama)
                        <img src="{{ asset('storage/' . $item->gambar_utama) }}" class="card-img-top news-image" alt="{{ $item->judul }}">
                        @else
                        <div class="card-img-top news-image bg-light d-flex align-items-center justify-content-center">
                            <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="news-meta mb-2">
                                <span class="badge bg-primary me-2">{{ $item->kategoriBerita->nama_kategori ?? 'Umum' }}</span>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>{{ $item->published_at->format('d M Y') }}
                                    <i class="fas fa-eye ms-3 me-1"></i>{{ $item->views }} views
                                </small>
                            </div>
                            <h5 class="news-title">{{ $item->judul }}</h5>
                            <p class="news-excerpt flex-grow-1">{{ $item->excerpt }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <a href="{{ route('berita.show', $item->slug) }}" class="btn btn-outline-primary btn-sm">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                                @if($item->is_featured)
                                <span class="badge bg-warning">
                                    <i class="fas fa-star me-1"></i>Featured
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $berita->appends(request()->query())->links() }}
            </div>
            @else
            <!-- No Results -->
            <div class="text-center py-5">
                <i class="fas fa-newspaper text-muted mb-3" style="font-size: 4rem;"></i>
                <h4 class="text-muted">Tidak ada berita ditemukan</h4>
                <p class="text-muted">Coba gunakan kata kunci yang berbeda atau lihat semua berita.</p>
                <a href="{{ route('berita.index') }}" class="btn btn-primary">
                    <i class="fas fa-list me-2"></i>Lihat Semua Berita
                </a>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Categories -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tags me-2"></i>Kategori Berita
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('berita.index') }}" 
                           class="list-group-item list-group-item-action {{ !request('kategori') ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Semua Kategori</span>
                                <span class="badge bg-primary rounded-pill">{{ $kategoriBerita->sum('beritas_published_count') }}</span>
                            </div>
                        </a>
                        @foreach($kategoriBerita as $kategori)
                        <a href="{{ route('berita.index', ['kategori' => $kategori->slug]) }}" 
                           class="list-group-item list-group-item-action {{ request('kategori') == $kategori->slug ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ $kategori->nama_kategori }}</span>
                                <span class="badge bg-secondary rounded-pill">{{ $kategori->beritas_published_count }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
