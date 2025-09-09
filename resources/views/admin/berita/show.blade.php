@extends('layouts.admin')

@section('title', 'Detail Berita')
@section('page-title', 'Detail Berita')

@section('page-actions')
<div class="btn-group">
    <a href="{{ route('admin.berita.edit', $berita) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>Edit
    </a>
    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $berita->judul }}</h5>
                <div>
                    @if($berita->status === 'published')
                        <span class="badge bg-success">Published</span>
                    @elseif($berita->status === 'draft')
                        <span class="badge bg-warning">Draft</span>
                    @else
                        <span class="badge bg-secondary">Archived</span>
                    @endif
                    @if($berita->is_featured)
                        <span class="badge bg-info ms-1">Featured</span>
                    @endif
                </div>
            </div>
            
            @if($berita->gambar_utama)
            <div class="card-img-top">
                <img src="{{ Storage::url($berita->gambar_utama) }}" 
                     class="img-fluid w-100" style="max-height: 400px; object-fit: cover;" 
                     alt="{{ $berita->judul }}">
            </div>
            @endif
            
            <div class="card-body">
                <div class="mb-4">
                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <i class="fas fa-user me-1"></i>
                            {{ $berita->user->name ?? 'Admin' }}
                        </div>
                        <div class="col-md-6 text-md-end">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $berita->created_at->format('d F Y, H:i') }}
                        </div>
                    </div>
                    <div class="row text-muted small mt-1">
                        <div class="col-md-6">
                            <i class="fas fa-tag me-1"></i>
                            {{ $berita->kategoriBerita->nama_kategori }}
                        </div>
                        <div class="col-md-6 text-md-end">
                            <i class="fas fa-eye me-1"></i>
                            {{ number_format($berita->views) }} views
                        </div>
                    </div>
                </div>

                @if($berita->excerpt)
                <div class="alert alert-light border-start border-primary border-4 mb-4">
                    <h6 class="alert-heading">Ringkasan</h6>
                    <p class="mb-0">{{ $berita->excerpt }}</p>
                </div>
                @endif

                <div class="content">
                    {!! nl2br(e($berita->konten)) !!}
                </div>

                @if(!empty($berita->tags))
                <div class="mt-4 pt-3 border-top">
                    <h6 class="mb-2">Tags:</h6>
                    @php
                        $tags = is_array($berita->tags) ? $berita->tags : explode(',', $berita->tags);
                    @endphp
                    @foreach($tags as $tag)
                        <span class="badge bg-light text-dark me-1 mb-1">#{{ trim($tag) }}</span>
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
                    <i class="fas fa-info-circle me-2"></i>Informasi Berita
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="100">Slug</td>
                        <td>: <code>{{ $berita->slug }}</code></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>: 
                            @if($berita->status === 'published')
                                <span class="badge bg-success">Published</span>
                            @elseif($berita->status === 'draft')
                                <span class="badge bg-warning">Draft</span>
                            @else
                                <span class="badge bg-secondary">Archived</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td>: {{ $berita->kategoriBerita->nama_kategori }}</td>
                    </tr>
                    <tr>
                        <td>Views</td>
                        <td>: {{ number_format($berita->views) }}</td>
                    </tr>
                    <tr>
                        <td>Featured</td>
                        <td>: 
                            @if($berita->is_featured)
                                <span class="badge bg-info">Ya</span>
                            @else
                                <span class="badge bg-light text-dark">Tidak</span>
                            @endif
                        </td>
                    </tr>
                    @if($berita->published_at)
                    <tr>
                        <td>Dipublikasi</td>
                        <td>: {{ $berita->published_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Dibuat</td>
                        <td>: {{ $berita->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td>Diupdate</td>
                        <td>: {{ $berita->updated_at->format('d/m/Y H:i') }}</td>
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
                    <a href="{{ route('admin.berita.edit', $berita) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Berita
                    </a>
                    
                    @if($berita->status === 'published')
                    <button class="btn btn-info" onclick="incrementViews()">
                        <i class="fas fa-eye me-2"></i>Tambah View
                    </button>
                    @endif
                    
                    <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?')" class="d-grid">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus Berita
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if($berita->kategoriBerita)
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-tag me-2"></i>Kategori
                </h6>
            </div>
            <div class="card-body">
                <h6>{{ $berita->kategoriBerita->nama_kategori }}</h6>
                @if($berita->kategoriBerita->deskripsi)
                    <p class="text-muted small mb-2">{{ $berita->kategoriBerita->deskripsi }}</p>
                @endif
                <a href="{{ route('admin.berita.index', ['kategori_id' => $berita->kategoriBerita->id]) }}" 
                   class="btn btn-sm btn-outline-primary">
                    Lihat Berita Lain
                </a>
            </div>
        </div>
        @endif

        @if($berita->gambar_utama)
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-image me-2"></i>Gambar Utama
                </h6>
            </div>
            <div class="card-body">
                <img src="{{ Storage::url($berita->gambar_utama) }}" 
                     class="img-fluid rounded" alt="{{ $berita->judul }}">
                <div class="mt-2">
                    <small class="text-muted">{{ basename($berita->gambar_utama) }}</small>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function incrementViews() {
    fetch(`/api/v1/berita/{{ $berita->id }}/increment-views`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menambah view');
    });
}
</script>
@endpush
