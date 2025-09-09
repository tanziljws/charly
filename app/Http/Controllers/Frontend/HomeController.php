<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Gallery;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured news
        $featuredBerita = Berita::with(['kategoriBerita', 'user'])
            ->published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Get latest news
        $latestBerita = Berita::with(['kategoriBerita', 'user'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        // Get featured gallery
        $featuredGallery = Gallery::active()
            ->ordered()
            ->limit(8)
            ->get();

        // Get news categories
        $kategoriBerita = KategoriBerita::where('is_active', true)
            ->withCount('beritasPublished')
            ->orderBy('nama_kategori')
            ->get();

        return view('frontend.home', compact(
            'featuredBerita',
            'latestBerita', 
            'featuredGallery',
            'kategoriBerita'
        ));
    }
}
