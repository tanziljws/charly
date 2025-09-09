<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KategoriBeritaController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\GalleryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Test route to verify API is working
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is working',
        'timestamp' => now()
    ]);
});

// API Routes untuk Gallery Sekolah
Route::prefix('v1')->group(function () {
    
    // Kategori Berita Routes
    Route::apiResource('kategori-berita', KategoriBeritaController::class);
    Route::patch('kategori-berita/{kategoriBerita}/toggle-status', [KategoriBeritaController::class, 'toggleStatus']);
    
    // Berita Routes
    Route::apiResource('berita', BeritaController::class);
    Route::patch('berita/{berita}/toggle-featured', [BeritaController::class, 'toggleFeatured']);
    Route::post('berita/{berita}/increment-views', [BeritaController::class, 'incrementViews']);
    
    // Gallery Routes
    Route::apiResource('gallery', GalleryController::class);
    Route::patch('gallery/{gallery}/toggle-status', [GalleryController::class, 'toggleStatus']);
    Route::patch('gallery/update-urutan', [GalleryController::class, 'updateUrutan']);
    Route::get('gallery-kategori', [GalleryController::class, 'getKategori']);
    
    // Public Routes (untuk frontend)
    Route::prefix('public')->group(function () {
        // Berita public
        Route::get('berita', [BeritaController::class, 'index'])->name('api.berita.public');
        Route::get('berita/{berita:slug}', [BeritaController::class, 'show'])->name('api.berita.show.public');
        Route::get('kategori-berita', [KategoriBeritaController::class, 'index'])->name('api.kategori.public');
        
        // Gallery public
        Route::get('gallery', [GalleryController::class, 'index'])->name('api.gallery.public');
        Route::get('gallery/{gallery:slug}', [GalleryController::class, 'show'])->name('api.gallery.show.public');
        Route::get('gallery-kategori', [GalleryController::class, 'getKategori'])->name('api.gallery.kategori.public');
    });
});
