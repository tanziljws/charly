@extends('layouts.admin')

@section('title', 'Tambah Kategori Berita')
@section('page-title', 'Tambah Kategori Berita')

@section('page-actions')
<a href="{{ route('admin.kategori-berita.index') }}" class="btn btn-outline-primary">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Kategori Berita</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kategori-berita.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="nama_kategori" class="form-label">Nama Kategori *</label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" 
                               id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" 
                               placeholder="Masukkan nama kategori" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="3" 
                                  placeholder="Deskripsi kategori (opsional)">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.kategori-berita.index') }}" class="btn btn-outline-primary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
