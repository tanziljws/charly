@extends('layouts.admin')

@section('title', 'Detail Kategori Berita')
@section('page-title', 'Detail Kategori Berita')

@section('page-actions')
<div class="btn-group">
    <a href="{{ route('admin.kategori-berita.edit', $kategoriBerita) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>Edit
    </a>
    <a href="{{ route('admin.kategori-berita.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $kategoriBerita->nama_kategori }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informasi Dasar</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="120">Nama Kategori</td>
                                <td>: {{ $kategoriBerita->nama_kategori }}</td>
                            </tr>
                            <tr>
                                <td>Slug</td>
                                <td>: <code>{{ $kategoriBerita->slug }}</code></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>: 
                                    @if($kategoriBerita->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Statistik</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="120">Total Berita</td>
                                <td>: <span class="badge bg-info">{{ $kategoriBerita->beritas_count }}</span></td>
                            </tr>
                            <tr>
                                <td>Published</td>
                                <td>: <span class="badge bg-success">{{ $kategoriBerita->beritas_published_count }}</span></td>
                            </tr>
                            <tr>
                                <td>Draft</td>
                                <td>: <span class="badge bg-warning">{{ $kategoriBerita->beritas_count - $kategoriBerita->beritas_published_count }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($kategoriBerita->deskripsi)
                <div class="mt-4">
                    <h6>Deskripsi</h6>
                    <p class="text-muted">{{ $kategoriBerita->deskripsi }}</p>
                </div>
                @endif

                <div class="mt-4">
                    <h6>Tanggal</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Dibuat: {{ $kategoriBerita->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Diupdate: {{ $kategoriBerita->updated_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($kategoriBerita->beritas()->count() > 0)
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Berita dalam Kategori Ini</h6>
                <a href="{{ route('admin.berita.index', ['kategori_id' => $kategoriBerita->id]) }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategoriBerita->beritas()->latest()->limit(5)->get() as $berita)
                            <tr>
                                <td>
                                    {{ Str::limit($berita->judul, 50) }}
                                    @if($berita->is_featured)
                                        <i class="fas fa-star text-warning ms-1" title="Featured"></i>
                                    @endif
                                </td>
                                <td>
                                    @if($berita->status === 'published')
                                        <span class="badge bg-success">Published</span>
                                    @elseif($berita->status === 'draft')
                                        <span class="badge bg-warning">Draft</span>
                                    @else
                                        <span class="badge bg-secondary">Archived</span>
                                    @endif
                                </td>
                                <td>{{ number_format($berita->views) }}</td>
                                <td>{{ $berita->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.berita.show', $berita) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-cog me-2"></i>Aksi
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.kategori-berita.edit', $kategoriBerita) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Kategori
                    </a>
                    <a href="{{ route('admin.berita.create', ['kategori_id' => $kategoriBerita->id]) }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Tambah Berita
                    </a>
                    @if($kategoriBerita->beritas()->count() == 0)
                    <form action="{{ route('admin.kategori-berita.destroy', $kategoriBerita) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus Kategori
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        @if($kategoriBerita->beritas()->count() > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Informasi
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-0">
                    Kategori ini tidak dapat dihapus karena masih memiliki {{ $kategoriBerita->beritas()->count() }} berita. 
                    Hapus atau pindahkan semua berita terlebih dahulu.
                </p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
