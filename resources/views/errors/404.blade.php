@extends('layouts.frontend')

@section('title', 'Halaman Tidak Ditemukan')
@section('description', 'Maaf, halaman yang Anda cari tidak ditemukan.')

@section('content')
<div class="container py-5">
    <div class="text-center py-5">
        <i class="fas fa-search-minus text-muted mb-4" style="font-size: 4rem;"></i>
        <h1 class="h3 mb-3">Halaman Tidak Ditemukan (404)</h1>
        <p class="text-muted mb-4">Maaf, halaman yang Anda cari mungkin sudah dipindahkan atau tidak tersedia.</p>
        <a href="{{ route('home') }}" class="btn btn-primary"><i class="fas fa-home me-2"></i>Kembali ke Beranda</a>
    </div>
</div>
@endsection


