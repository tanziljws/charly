<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriBeritaController as AdminKategoriBeritaController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Frontend Routes
Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
Route::get('/berita', [App\Http\Controllers\Frontend\BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [App\Http\Controllers\Frontend\BeritaController::class, 'show'])->name('berita.show');
Route::get('/galeri', [App\Http\Controllers\Frontend\GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galeri/{slug}', [App\Http\Controllers\Frontend\GalleryController::class, 'show'])->name('gallery.show');
Route::get('/kontak', [App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [App\Http\Controllers\Frontend\ContactController::class, 'store'])->name('contact.store');

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
    Route::delete('berita/{berita}', [AdminBeritaController::class, 'destroy'])->name('berita.destroy');
    Route::resource('berita', AdminBeritaController::class)
        ->parameters(['berita' => 'berita']);
    
    // Gallery Admin Routes
    Route::resource('gallery', AdminGalleryController::class)
        ->parameters(['gallery' => 'gallery']);
});
