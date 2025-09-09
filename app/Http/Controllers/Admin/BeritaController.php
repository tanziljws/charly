<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::with(['kategoriBerita', 'user']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_berita_id', $request->kategori_id);
        }

        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('konten', 'like', '%' . $search . '%');
            });
        }

        $beritas = $query->orderBy('created_at', 'desc')->paginate(10);
        $kategoris = KategoriBerita::where('is_active', true)->orderBy('nama_kategori')->get();

        return view('admin.berita.index', compact('beritas', 'kategoris'));
    }

    public function create()
    {
        $kategoris = KategoriBerita::where('is_active', true)->orderBy('nama_kategori')->get();
        return view('admin.berita.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:beritas,slug',
            'konten' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_berita_id' => 'required|exists:kategori_beritas,id',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'tags' => 'nullable|string'
        ], [
            'judul.required' => 'Judul berita wajib diisi',
            'konten.required' => 'Konten berita wajib diisi',
            'kategori_berita_id.required' => 'Kategori berita wajib dipilih',
            'kategori_berita_id.exists' => 'Kategori berita tidak valid',
            'gambar_utama.image' => 'File harus berupa gambar',
            'gambar_utama.max' => 'Ukuran gambar maksimal 2MB'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id() ?? 1;

        // Convert tags string to array
        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Upload gambar jika ada
        if ($request->hasFile('gambar_utama')) {
            $data['gambar_utama'] = $request->file('gambar_utama')->store('berita', 'public');
        }

        // Set published_at jika status published
        if ($data['status'] === 'published' && !isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        Berita::create($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dibuat');
    }

    public function show(Berita $berita)
    {
        $berita->load(['kategoriBerita', 'user']);
        return view('admin.berita.show', compact('berita'));
    }

    public function edit(Berita $berita)
    {
        $kategoris = KategoriBerita::where('is_active', true)->orderBy('nama_kategori')->get();
        return view('admin.berita.edit', compact('berita', 'kategoris'));
    }

    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:beritas,slug,' . $berita->id,
            'konten' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_berita_id' => 'required|exists:kategori_beritas,id',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'tags' => 'nullable|string'
        ]);

        $data = $request->except(['gambar_utama']);

        // Convert tags string to array
        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar_utama')) {
            // Hapus gambar lama
            if ($berita->gambar_utama) {
                Storage::disk('public')->delete($berita->gambar_utama);
            }
            $data['gambar_utama'] = $request->file('gambar_utama')->store('berita', 'public');
        }

        // Set published_at jika status berubah ke published
        if ($data['status'] === 'published' && $berita->status !== 'published' && !isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diupdate');
    }

    public function destroy(Berita $berita)
    {
        try {
            // Hapus gambar jika ada
            if ($berita->gambar_utama) {
                Storage::disk('public')->delete($berita->gambar_utama);
            }
    
            $berita->delete();
    
            return redirect()->route('admin.berita.index')
                ->with('success', 'Berita berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus berita: ' . $e->getMessage());
        }
    }
}
