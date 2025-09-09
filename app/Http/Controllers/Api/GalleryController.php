<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Menampilkan daftar gallery
     */
    public function index(Request $request): JsonResponse
    {
        $query = Gallery::with('user');

        // Filter berdasarkan status aktif
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Pencarian berdasarkan judul atau deskripsi
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_dari')) {
            $query->where('tanggal_foto', '>=', $request->tanggal_dari);
        }
        if ($request->has('tanggal_sampai')) {
            $query->where('tanggal_foto', '<=', $request->tanggal_sampai);
        }

        // Sorting - handle both sort_by/sort_order and sort/order parameters
        $sortBy = $request->get('sort_by', $request->get('sort', 'urutan'));
        $sortOrder = $request->get('sort_order', $request->get('order', 'asc'));
        
        if ($sortBy === 'urutan') {
            $query->ordered();
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Handle limit parameter for dashboard
        if ($request->has('limit') && !$request->has('per_page')) {
            $perPage = $request->get('limit');
        } else {
            $perPage = $request->get('per_page', 12);
        }

        // Pagination
        $galleries = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Data gallery berhasil diambil',
            'data' => $galleries->items(),
            'meta' => [
                'current_page' => $galleries->currentPage(),
                'per_page' => $galleries->perPage(),
                'total' => $galleries->total(),
                'last_page' => $galleries->lastPage(),
                'from' => $galleries->firstItem(),
                'to' => $galleries->lastItem()
            ]
        ]);
    }

    /**
     * Menyimpan gallery baru
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:galleries,slug',
            'deskripsi' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'kategori' => 'required|in:kegiatan_sekolah,prestasi,fasilitas,acara_khusus,lainnya',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer|min:0',
            'tanggal_foto' => 'required|date',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50'
        ], [
            'judul.required' => 'Judul gallery wajib diisi',
            'gambar.required' => 'Gambar wajib diupload',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.max' => 'Ukuran gambar maksimal 5MB',
            'kategori.required' => 'Kategori wajib dipilih',
            'tanggal_foto.required' => 'Tanggal foto wajib diisi'
        ]);

        $data = $request->all();
        
        // Set user_id - use authenticated user or first available user
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        } else {
            $firstUser = \App\Models\User::first();
            if ($firstUser) {
                $data['user_id'] = $firstUser->id;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No users found. Please create a user first.'
                ], 400);
            }
        }

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('gallery', 'public');
        }

        // Set urutan default jika tidak ada
        if (!isset($data['urutan'])) {
            $maxUrutan = Gallery::where('kategori', $data['kategori'])->max('urutan');
            $data['urutan'] = ($maxUrutan ?? 0) + 1;
        }

        $gallery = Gallery::create($data);
        $gallery->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Gallery berhasil dibuat',
            'data' => $gallery
        ], 201);
    }

    /**
     * Menampilkan detail gallery
     */
    public function show(Gallery $gallery): JsonResponse
    {
        $gallery->load('user');
        
        return response()->json([
            'success' => true,
            'message' => 'Detail gallery berhasil diambil',
            'data' => $gallery
        ]);
    }

    /**
     * Mengupdate gallery
     */
    public function update(Request $request, Gallery $gallery): JsonResponse
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('galleries', 'slug')->ignore($gallery->id)
            ],
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'kategori' => 'required|in:kegiatan_sekolah,prestasi,fasilitas,acara_khusus,lainnya',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer|min:0',
            'tanggal_foto' => 'required|date',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50'
        ]);

        $data = $request->except(['gambar']);

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($gallery->gambar) {
                Storage::disk('public')->delete($gallery->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('gallery', 'public');
        }

        $gallery->update($data);
        $gallery->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Gallery berhasil diupdate',
            'data' => $gallery
        ]);
    }

    /**
     * Menghapus gallery
     */
    public function destroy(Gallery $gallery): JsonResponse
    {
        // Hapus gambar
        if ($gallery->gambar) {
            Storage::disk('public')->delete($gallery->gambar);
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery berhasil dihapus'
        ]);
    }

    /**
     * Toggle status aktif
     */
    public function toggleStatus(Gallery $gallery): JsonResponse
    {
        $gallery->update([
            'is_active' => !$gallery->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status gallery berhasil diubah',
            'data' => $gallery
        ]);
    }

    /**
     * Update urutan gallery
     */
    public function updateUrutan(Request $request): JsonResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:galleries,id',
            'items.*.urutan' => 'required|integer|min:0'
        ]);

        foreach ($request->items as $item) {
            Gallery::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan gallery berhasil diupdate'
        ]);
    }

    /**
     * Mendapatkan daftar kategori
     */
    public function getKategori(): JsonResponse
    {
        $kategori = Gallery::getKategoriOptions();

        return response()->json([
            'success' => true,
            'message' => 'Daftar kategori berhasil diambil',
            'data' => $kategori
        ]);
    }
}
