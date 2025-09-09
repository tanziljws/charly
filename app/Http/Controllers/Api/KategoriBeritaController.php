<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class KategoriBeritaController extends Controller
{
    /**
     * Menampilkan daftar kategori berita
     */
    public function index(Request $request): JsonResponse
    {
        $query = KategoriBerita::query();

        // Filter berdasarkan status aktif
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Pencarian berdasarkan nama kategori
        if ($request->has('search')) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        // Always include count for admin interface
        $query->withCount(['beritas', 'beritasPublished']);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $kategoris = $query->orderBy('nama_kategori')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Data kategori berita berhasil diambil',
            'data' => $kategoris->items(),
            'meta' => [
                'current_page' => $kategoris->currentPage(),
                'per_page' => $kategoris->perPage(),
                'total' => $kategoris->total(),
                'last_page' => $kategoris->lastPage(),
                'from' => $kategoris->firstItem(),
                'to' => $kategoris->lastItem()
            ]
        ]);
    }

    /**
     * Menyimpan kategori berita baru
     */
    public function store(Request $request): JsonResponse
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

        $kategori = KategoriBerita::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Kategori berita berhasil dibuat',
            'data' => $kategori
        ], 201);
    }

    /**
     * Menampilkan detail kategori berita
     */
    public function show(KategoriBerita $kategoriBerita): JsonResponse
    {
        $kategoriBerita->loadCount(['beritas', 'beritasPublished']);
        
        return response()->json([
            'success' => true,
            'message' => 'Detail kategori berita berhasil diambil',
            'data' => $kategoriBerita
        ]);
    }

    /**
     * Mengupdate kategori berita
     */
    public function update(Request $request, KategoriBerita $kategoriBerita): JsonResponse
    {
        $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori_beritas', 'nama_kategori')->ignore($kategoriBerita->id)
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('kategori_beritas', 'slug')->ignore($kategoriBerita->id)
            ],
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean'
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique' => 'Nama kategori sudah ada',
            'slug.unique' => 'Slug sudah digunakan'
        ]);

        $kategoriBerita->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Kategori berita berhasil diupdate',
            'data' => $kategoriBerita
        ]);
    }

    /**
     * Menghapus kategori berita
     */
    public function destroy(KategoriBerita $kategoriBerita): JsonResponse
    {
        // Cek apakah kategori masih memiliki berita
        if ($kategoriBerita->beritas()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak dapat dihapus karena masih memiliki berita'
            ], 400);
        }

        $kategoriBerita->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berita berhasil dihapus'
        ]);
    }

    /**
     * Toggle status aktif kategori
     */
    public function toggleStatus(KategoriBerita $kategoriBerita): JsonResponse
    {
        $kategoriBerita->update([
            'is_active' => !$kategoriBerita->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status kategori berhasil diubah',
            'data' => $kategoriBerita
        ]);
    }
}
