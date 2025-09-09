<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;

class KategoriBeritaController extends Controller
{
    public function index()
    {
        $kategoris = KategoriBerita::withCount(['beritas', 'beritasPublished'])
            ->orderBy('nama_kategori')
            ->paginate(10);

        return view('admin.kategori-berita.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori-berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_beritas,nama_kategori',
            'slug' => 'nullable|string|max:255|unique:kategori_beritas,slug',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean'
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique' => 'Nama kategori sudah ada',
            'slug.unique' => 'Slug sudah digunakan'
        ]);

        KategoriBerita::create($request->all());

        return redirect()->route('admin.kategori-berita.index')
            ->with('success', 'Kategori berita berhasil dibuat');
    }

    public function show(KategoriBerita $kategoriBerita)
    {
        $kategoriBerita->loadCount(['beritas', 'beritasPublished']);
        
        return view('admin.kategori-berita.show', compact('kategoriBerita'));
    }

    public function edit(KategoriBerita $kategoriBerita)
    {
        return view('admin.kategori-berita.edit', compact('kategoriBerita'));
    }

    public function update(Request $request, KategoriBerita $kategoriBerita)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_beritas,nama_kategori,' . $kategoriBerita->id,
            'slug' => 'nullable|string|max:255|unique:kategori_beritas,slug,' . $kategoriBerita->id,
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean'
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique' => 'Nama kategori sudah ada',
            'slug.unique' => 'Slug sudah digunakan'
        ]);

        $kategoriBerita->update($request->all());

        return redirect()->route('admin.kategori-berita.index')
            ->with('success', 'Kategori berita berhasil diupdate');
    }

    public function destroy(KategoriBerita $kategoriBerita)
    {
        if ($kategoriBerita->beritas()->count() > 0) {
            return redirect()->route('admin.kategori-berita.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki berita');
        }

        $kategoriBerita->delete();

        return redirect()->route('admin.kategori-berita.index')
            ->with('success', 'Kategori berita berhasil dihapus');
    }
}
