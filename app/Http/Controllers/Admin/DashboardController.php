<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\Gallery;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk dashboard
        $stats = [
            'total_berita' => Berita::count(),
            'berita_published' => Berita::where('status', 'published')->count(),
            'berita_draft' => Berita::where('status', 'draft')->count(),
            'total_kategori' => KategoriBerita::count(),
            'total_gallery' => Gallery::count(),
            'gallery_active' => Gallery::where('is_active', true)->count(),
            'total_views' => Berita::sum('views')
        ];

        // Berita terbaru
        $berita_terbaru = Berita::with(['kategoriBerita', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Gallery terbaru
        $gallery_terbaru = Gallery::with('user')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Berita populer (berdasarkan views)
        $berita_populer = Berita::with(['kategoriBerita'])
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        // Statistik per kategori
        $kategori_stats = KategoriBerita::withCount(['beritas', 'beritasPublished'])
            ->orderBy('beritas_count', 'desc')
            ->get();

        // Statistik gallery per kategori
        $gallery_stats = Gallery::selectRaw('kategori, COUNT(*) as total')
            ->groupBy('kategori')
            ->get()
            ->mapWithKeys(function ($item) {
                $kategoriOptions = Gallery::getKategoriOptions();
                return [$kategoriOptions[$item->kategori] => $item->total];
            });

        return view('admin.dashboard', compact(
            'stats',
            'berita_terbaru',
            'gallery_terbaru',
            'berita_populer',
            'kategori_stats',
            'gallery_stats'
        ));
    }
}
