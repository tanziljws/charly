@extends('layouts.frontend')

@section('title', 'Galeri - SMKN 4 BOGOR')
@section('description', 'Kumpulan foto dan galeri kegiatan SMKN 4 BOGOR')

@push('styles')
<style>
    /* Hover animations for gallery */
    .gallery-item { transition: transform .3s ease, box-shadow .3s ease; }
    .gallery-item:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(0,0,0,.15); }
    .gallery-image { transition: transform .6s ease; }
    .gallery-item:hover .gallery-image { transform: scale(1.06); }
    .gallery-overlay { transition: transform .35s ease; }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-4 reveal">
        <div class="col-12">
            <div class="card contact-hero">
                <div class="card-body text-center py-5">
                    <i class="fas fa-images mb-3" style="font-size: 3rem;"></i>
                    <h1 class="display-4 fw-bold mb-3">Galeri SMKN 4 BOGOR</h1>
                    <p class="lead mb-0">Lihat momen-momen terbaik dari kegiatan dan aktivitas SMKN 4 BOGOR</p>
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
                        <div class="col-12 mb-3 filter-advanced" data-initial-open="{{ request('kategori') ? '1' : '0' }}" style="display: none;">
                            <label for="kategori" class="form-label">Kategori</label>
                            <div class="row g-2">
                                <div class="col-md-8">
                                    <select class="form-select" id="kategori" name="kategori">
                                        <option value="">Semua Kategori</option>
                                        @foreach($kategoriOptions as $key => $label)
                                        <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>{{ $label }}</option>
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
                        <a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary">
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
                Menampilkan {{ $gallery->total() }} galeri
                @if(request('search'))
                    untuk pencarian "<strong>{{ request('search') }}</strong>"
                @endif
                @if(request('kategori'))
                    pada kategori "<strong>{{ $kategoriOptions[request('kategori')] ?? request('kategori') }}</strong>"
                @endif
            </div>
            @endif

            <!-- Gallery Grid -->
            @if($gallery->count() > 0)
            <div class="gallery-grid">
                @foreach($gallery as $item)
                <div class="gallery-item reveal">
                    @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" class="gallery-image skeleton" alt="{{ $item->judul }}" loading="lazy" onload="this.classList.remove('skeleton')">
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
                {{ $gallery->appends(request()->query())->links('pagination::bootstrap-5') }}
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

        setVisible(filterSection.getAttribute('data-initial-open') === '1');

        toggleBtn.addEventListener('click', function() {
            var isHidden = filterSection.style.display === 'none' || filterSection.style.display === '' && getComputedStyle(filterSection).display === 'none';
            setVisible(isHidden);
        });
    })();
    </script>
@endpush
