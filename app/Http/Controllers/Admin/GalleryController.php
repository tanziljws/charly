<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::with('user');

        // Filter berdasarkan status
        if ($request->has('is_active') && $request->is_active !== '') {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori !== '') {
            $query->where('kategori', $request->kategori);
        }

        // Pencarian
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $galleries = $query->ordered()->paginate(12);
        $kategoriOptions = Gallery::getKategoriOptions();

        return view('admin.gallery.index', compact('galleries', 'kategoriOptions'));
    }

    public function create()
    {
        $kategoriOptions = Gallery::getKategoriOptions();
        return view('admin.gallery.create', compact('kategoriOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:galleries,slug',
            'deskripsi' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'kategori' => 'required|in:kegiatan_sekolah,prestasi,fasilitas,acara_khusus,lainnya',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer|min:0',
            'tanggal_foto' => 'required|date',
            'tags' => 'nullable|string'
        ], [
            'judul.required' => 'Judul gallery wajib diisi',
            'gambar.required' => 'Gambar wajib diupload',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.max' => 'Ukuran gambar maksimal 5MB',
            'kategori.required' => 'Kategori wajib dipilih',
            'tanggal_foto.required' => 'Tanggal foto wajib diisi'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id() ?? 1;

        // Convert tags string to array
        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('gallery', 'public');
        }

        // Set urutan default jika tidak ada
        if (!isset($data['urutan']) || $data['urutan'] === '') {
            $maxUrutan = Gallery::where('kategori', $data['kategori'])->max('urutan');
            $data['urutan'] = ($maxUrutan ?? 0) + 1;
        }

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery berhasil dibuat');
    }

    public function show(Gallery $gallery)
    {
        $gallery->load('user');
        return view('admin.gallery.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        $kategoriOptions = Gallery::getKategoriOptions();
        return view('admin.gallery.edit', compact('gallery', 'kategoriOptions'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:galleries,slug,' . $gallery->id,
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'kategori' => 'required|in:kegiatan_sekolah,prestasi,fasilitas,acara_khusus,lainnya',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer|min:0',
            'tanggal_foto' => 'required|date',
            'tags' => 'nullable|string'
        ]);

        $data = $request->except(['gambar']);

        // Convert tags string to array
        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($gallery->gambar) {
                Storage::disk('public')->delete($gallery->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery berhasil diupdate');
    }

    public function destroy(Gallery $gallery)
    {
        // Hapus gambar
        if ($gallery->gambar) {
            Storage::disk('public')->delete($gallery->gambar);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery berhasil dihapus');
    }
}
