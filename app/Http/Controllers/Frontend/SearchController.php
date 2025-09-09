<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Gallery;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $beritas = collect();
        $galleries = collect();
        if ($q !== '') {
            $beritas = Berita::query()
                ->where('judul', 'like', "%{$q}%")
                ->orWhere('konten', 'like', "%{$q}%")
                ->latest()->limit(10)->get();

            $galleries = Gallery::query()
                ->where('judul', 'like', "%{$q}%")
                ->orWhere('deskripsi', 'like', "%{$q}%")
                ->latest()->limit(10)->get();
        }

        return view('frontend.search.index', [
            'q' => $q,
            'beritas' => $beritas,
            'galleries' => $galleries,
        ]);
    }
}


