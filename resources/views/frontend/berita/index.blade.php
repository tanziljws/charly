@extends('layouts.frontend')

@section('title', 'Berita - SMKN 4 BOGOR')
@section('description', 'Kumpulan berita terbaru dari SMKN 4 BOGOR')

@push('styles')
<style>
    /* Animations for Berita cards */
    .news-card { transition: transform .3s ease, box-shadow .3s ease; }
    .news-card:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(0,0,0,.15); }
    .news-card .card-img-top { transition: transform .6s ease; }
    .news-card:hover .card-img-top { transform: scale(1.05); }
    .news-title { transition: color .2s ease; }
    .news-card:hover .news-title { color: var(--accent-color); }
    .badge.bg-warning { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #111827; }
    .news-meta small { opacity: .85; }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-4 reveal">
        <div class="col-12">
            <div class="card contact-hero">
                <div class="card-body text-center py-5">
                    <i class="fas fa-newspaper mb-3" style="font-size: 3rem;"></i>
                    <h1 class="display-4 fw-bold mb-3">Berita SMKN 4 BOGOR</h1>
                    <p class="lead mb-0">Dapatkan informasi terbaru tentang kegiatan dan perkembangan SMKN 4 BOGOR</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-12">
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
                        <div class="col-12 mb-3 filter-advanced" data-initial-open="{{ request('kategori') ? '1' : '0' }}" style="display: none;">
                            <label for="kategori" class="form-label">Kategori</label>
                            <div class="row g-2">
                                <div class="col-md-8">
                                    <select class="form-select" id="kategori" name="kategori">
                                        <option value="">Semua Kategori</option>
                                        @foreach($kategoriBerita as $kategori)
                                        <option value="{{ $kategori->slug }}" {{ request('kategori') == $kategori->slug ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }} ({{ $kategori->beritas_published_count }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 d-grid d-md-block">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-check me-2"></i>Terapkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-primary btn-toggle-filter">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                        @if(request('search') || request('kategori'))
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
            <div class="row g-4">
                @foreach($berita as $item)
                <div class="col-md-6 reveal">
                    <div class="card news-card h-100 reveal">
                        @if($item->gambar_utama)
                        <img src="{{ asset('storage/' . $item->gambar_utama) }}" class="card-img-top news-image skeleton" alt="{{ $item->judul }}" loading="lazy" onload="this.classList.remove('skeleton')">
                        @else
                        <div class="card-img-top news-image bg-light d-flex align-items-center justify-content-center">
                            <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="news-meta mb-2">
                                <span class="badge bg-primary me-2">{{ $item->kategoriBerita->nama_kategori ?? 'Umum' }}</span>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>{{ $item->published_at ? $item->published_at->format('d M Y') : 'Belum dipublikasi' }}
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
                {{ $berita->appends(request()->query())->links('pagination::bootstrap-5') }}
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
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function() {
        var container = document.currentScript.closest('body');
        var filterSection = container.querySelector('.filter-advanced');
        var toggleBtn = container.querySelector('.btn-toggle-filter');
        if (!filterSection || !toggleBtn) return;

        function setVisible(visible) {
            filterSection.style.display = visible ? '' : 'none';
        }

        // Initialize based on query
        setVisible(filterSection.getAttribute('data-initial-open') === '1');

        toggleBtn.addEventListener('click', function() {
            var isHidden = filterSection.style.display === 'none' || filterSection.style.display === '' && getComputedStyle(filterSection).display === 'none';
            setVisible(isHidden);
        });
    })();
</script>
@endpush
