@extends('layouts.frontend')

@section('title', $berita->judul . ' - Gallery Sekolah')
@section('description', $berita->excerpt)

@section('content')
<div class="container py-4">
    <!-- Scroll progress bar -->
    <div id="readProgress" style="position:sticky;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,#0ea5e9,#0f172a);transform:scaleX(0);transform-origin:left;z-index:1020"></div>
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
            @if($berita->kategoriBerita)
            <li class="breadcrumb-item">
                <a href="{{ route('berita.index', ['kategori' => $berita->kategoriBerita->slug]) }}">
                    {{ $berita->kategoriBerita->nama_kategori }}
                </a>
            </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($berita->judul, 50) }}</li>
        </ol>
    </nav>

    <!-- Back to News Button -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('berita.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Berita
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-12">
            <article class="card reveal">
                <!-- Article Header -->
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            @if($berita->kategoriBerita)
                            <span class="badge bg-primary">{{ $berita->kategoriBerita->nama_kategori }}</span>
                            @endif
                            @if($berita->is_featured)
                            <span class="badge bg-warning">
                                <i class="fas fa-star me-1"></i>Featured
                            </span>
                            @endif
                        </div>
                        
                        <h1 class="h2 mb-3">{{ $berita->judul }}</h1>
                        
                        <div class="d-flex flex-wrap align-items-center text-muted small mb-4">
                            <div class="me-4">
                                <i class="fas fa-user me-1"></i>
                                <span>{{ $berita->user->name ?? 'Admin' }}</span>
                            </div>
                            <div class="me-4">
                                <i class="fas fa-calendar me-1"></i>
                                <span>{{ $berita->published_at ? $berita->published_at->format('d M Y, H:i') : 'Belum dipublikasi' }}</span>
                            </div>
                            <div class="me-4">
                                <i class="fas fa-eye me-1"></i>
                                <span>{{ $berita->views }} views</span>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    @if($berita->gambar_utama)
                    <div class="mb-4 reveal">
                        <img src="{{ asset('storage/' . $berita->gambar_utama) }}" 
                             class="img-fluid rounded skeleton" loading="lazy" onload="this.classList.remove('skeleton')"
                             alt="{{ $berita->judul }}"
                             style="width: 100%; max-height: 400px; object-fit: cover;">
                    </div>
                    @endif

                    <!-- Article Content -->
                    <div class="article-content">
                        {!! $berita->konten !!}
                    </div>

                    <!-- Tags -->
                    @if($berita->tags && count($berita->tags) > 0)
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="mb-3">
                            <i class="fas fa-tags me-2"></i>Tags:
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($berita->tags as $tag)
                            <span class="badge bg-light text-dark border">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="mb-3">
                            <i class="fas fa-share-alt me-2"></i>Bagikan:
                        </h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook-f me-1"></i>Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" 
                               target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter me-1"></i>Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . request()->url()) }}" 
                               target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fab fa-whatsapp me-1"></i>WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Related News -->
            @if($relatedBerita->count() > 0)
            <div class="mt-5 reveal">
                <h3 class="h4 mb-4">
                    <i class="fas fa-newspaper me-2"></i>Berita Terkait
                </h3>
                <div class="row g-3">
                    @foreach($relatedBerita as $related)
                    <div class="col-md-6">
                        <div class="card h-100 news-card">
                            <div class="row g-0">
                                <div class="col-4">
                                    @if($related->gambar_utama)
                                    <img src="{{ asset('storage/' . $related->gambar_utama) }}" 
                                         class="img-fluid rounded-start h-100" loading="lazy"
                                         alt="{{ $related->judul }}"
                                         style="object-fit: cover;">
                                    @else
                                    <div class="bg-light h-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-3">
                                        <h6 class="card-title">
                                            <a href="{{ route('berita.show', $related->slug) }}" 
                                               class="text-decoration-none text-dark">
                                                {{ Str::limit($related->judul, 60) }}
                                            </a>
                                        </h6>
                                        <p class="card-text small text-muted mb-2">
                                            {{ $related->published_at ? $related->published_at->format('d M Y') : 'Belum dipublikasi' }}
                                        </p>
                                        <p class="card-text small">{{ Str::limit($related->excerpt, 80) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.article-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.article-content h1,
.article-content h2,
.article-content h3,
.article-content h4,
.article-content h5,
.article-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.article-content p {
    margin-bottom: 1.5rem;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.article-content blockquote {
    border-left: 4px solid var(--primary-color);
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    background: var(--bg-secondary);
    padding: 1rem;
    border-radius: 0 8px 8px 0;
}

.article-content ul,
.article-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}
</style>
@endpush
@endsection

@push('scripts')
<script>
    (function(){
        const bar = document.getElementById('readProgress');
        if (!bar) return;
        function update(){
            const el = document.querySelector('.article-content');
            if (!el) return;
            const total = el.scrollHeight - window.innerHeight + el.getBoundingClientRect().top;
            const scrolled = Math.min(total, window.scrollY);
            const ratio = total > 0 ? scrolled / total : 0;
            bar.style.transform = 'scaleX(' + ratio + ')';
        }
        window.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
        update();
    })();
</script>
@endpush
