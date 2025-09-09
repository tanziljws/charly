@extends('layouts.frontend')

@section('title', 'Pencarian: ' . ($q ?: ''))
@section('description', 'Hasil pencarian untuk ' . ($q ?: ''))

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pencarian</li>
    </ol>
    @if($q)
    <small class="text-muted">Kata kunci: "{{ $q }}"</small>
    @endif
    <form method="GET" action="{{ route('search.index') }}" class="mt-2">
        <div class="input-group">
            <input type="text" name="q" class="form-control" value="{{ $q }}" placeholder="Cari berita atau galeri...">
            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
</nav>
@endsection

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header"><i class="fas fa-newspaper me-2"></i>Berita</div>
                <div class="card-body">
                    @if($q === '')
                        <p class="text-muted mb-0">Masukkan kata kunci untuk mencari berita.</p>
                    @elseif($beritas->isEmpty())
                        <p class="text-muted mb-0">Tidak ada hasil berita.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($beritas as $b)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <a href="{{ route('berita.show', $b->slug) }}" class="fw-semibold">{{ $b->judul }}</a>
                                        <div class="small text-muted">{{ Str::limit(strip_tags($b->konten), 90) }}</div>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header"><i class="fas fa-images me-2"></i>Galeri</div>
                <div class="card-body">
                    @if($q === '')
                        <p class="text-muted mb-0">Masukkan kata kunci untuk mencari galeri.</p>
                    @elseif($galleries->isEmpty())
                        <p class="text-muted mb-0">Tidak ada hasil galeri.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($galleries as $g)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <a href="{{ route('gallery.show', $g->slug) }}" class="fw-semibold">{{ $g->judul }}</a>
                                        <div class="small text-muted">{{ Str::limit($g->deskripsi, 90) }}</div>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


