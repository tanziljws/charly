<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::with(['kategoriBerita', 'user'])
            ->published()
            ->orderBy('published_at', 'desc');

        // Filter by category if provided
        if ($request->has('kategori') && $request->kategori) {
            $query->whereHas('kategoriBerita', function($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('konten', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        $berita = $query->paginate(9);

        // Get all categories for filter
        $kategoriBerita = KategoriBerita::where('is_active', true)
            ->withCount('beritasPublished')
            ->orderBy('nama_kategori')
            ->get();

        return view('frontend.berita.index', compact('berita', 'kategoriBerita'));
    }

    public function show($slug)
    {
        $berita = Berita::with(['kategoriBerita', 'user'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views
        $berita->incrementViews();

        // Get related news (same category, excluding current)
        $relatedBerita = Berita::with(['kategoriBerita', 'user'])
            ->published()
            ->where('kategori_berita_id', $berita->kategori_berita_id)
            ->where('id', '!=', $berita->id)
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        return view('frontend.berita.show', compact('berita', 'relatedBerita'));
    }
}
