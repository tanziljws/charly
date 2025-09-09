@extends('layouts.frontend')

@section('title', 'Terjadi Kesalahan Server')
@section('description', 'Maaf, terjadi kesalahan di sisi server.')

@section('content')
<div class="container py-5">
    <div class="text-center py-5">
        <i class="fas fa-exclamation-triangle text-warning mb-4" style="font-size: 4rem;"></i>
        <h1 class="h3 mb-3">Terjadi Kesalahan (500)</h1>
        <p class="text-muted mb-4">Kami sedang memperbaikinya. Silakan coba beberapa saat lagi.</p>
        <a href="{{ route('home') }}" class="btn btn-primary"><i class="fas fa-home me-2"></i>Kembali ke Beranda</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Butuh bantuan?</div>
                <div class="card-body">
                    <p class="mb-2">Hubungi kami melalui halaman kontak atau coba cari konten lain.</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <a class="btn btn-outline-primary" href="{{ route('contact.index') }}">Hubungi Kami</a>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#globalSearchModal"><i class="fas fa-search me-1"></i>Cari</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


