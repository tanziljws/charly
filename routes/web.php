<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriBeritaController as AdminKategoriBeritaController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend\SearchController;

// Storage file serving route (for Railway compatibility)
// This route serves files from storage/app/public when symlink doesn't work
Route::get('/storage/{path}', function ($path) {
    // Security: prevent directory traversal
    $path = str_replace('..', '', $path);
    $path = ltrim($path, '/');
    
    $filePath = storage_path('app/public/' . $path);
    
    // Check if file exists and is within storage/app/public directory
    if (!file_exists($filePath) || !str_starts_with(realpath($filePath), realpath(storage_path('app/public')))) {
        abort(404);
    }
    
    // Check if it's a file, not a directory
    if (!is_file($filePath)) {
        abort(404);
    }
    
    $file = \Illuminate\Support\Facades\File::get($filePath);
    $type = \Illuminate\Support\Facades\File::mimeType($filePath);
    
    return response($file, 200)
        ->header('Content-Type', $type)
        ->header('Cache-Control', 'public, max-age=31536000')
        ->header('Content-Length', filesize($filePath));
})->where('path', '.*');

// Frontend Routes
Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
Route::get('/berita', [App\Http\Controllers\Frontend\BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [App\Http\Controllers\Frontend\BeritaController::class, 'show'])->name('berita.show');
Route::get('/galeri', [App\Http\Controllers\Frontend\GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galeri/{slug}', [App\Http\Controllers\Frontend\GalleryController::class, 'show'])->name('gallery.show');
Route::get('/kontak', [App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [App\Http\Controllers\Frontend\ContactController::class, 'store'])->name('contact.store');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // Kategori Berita Admin Routes
    Route::resource('kategori-berita', AdminKategoriBeritaController::class)
        ->parameters(['kategori-berita' => 'kategori_berita']);
    
    // Berita Admin Routes (force parameter name to {berita} not {beritum})
    Route::resource('berita', AdminBeritaController::class)
        ->parameters(['berita' => 'berita'])
        ->except(['destroy']);
    Route::delete('berita/{berita}', [AdminBeritaController::class, 'destroy'])->name('berita.destroy');
    
    // Gallery Admin Routes
    Route::resource('gallery', AdminGalleryController::class)
        ->parameters(['gallery' => 'gallery']);
});
