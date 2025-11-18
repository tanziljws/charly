<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        // Show all gallery items regardless of active status
        $query = Gallery::query()->ordered();

        // Filter by category if provided
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        // Paginate 8 items per page as requested
        $gallery = $query->paginate(8);

        // Get category options
        $kategoriOptions = Gallery::getKategoriOptions();

        return view('frontend.gallery.index', compact('gallery', 'kategoriOptions'));
    }

    public function show($slug)
    {
        $gallery = Gallery::active()
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related gallery (same category, excluding current)
        $relatedGallery = Gallery::active()
            ->where('kategori', $gallery->kategori)
            ->where('id', '!=', $gallery->id)
            ->ordered()
            ->limit(6)
            ->get();

        return view('frontend.gallery.show', compact('gallery', 'relatedGallery'));
    }
}
