<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita
     */
    public function index(Request $request): JsonResponse
    {
        $query = Berita::with(['kategoriBerita', 'user']);

        // Filter berdasarkan status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori_id')) {
            $query->where('kategori_berita_id', $request->kategori_id);
        }

        // Filter berita featured
        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        // Pencarian berdasarkan judul atau konten
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('konten', 'like', '%' . $search . '%');
            });
        }

        // Sorting - handle both sort_by/sort_order and sort/order parameters
        $sortBy = $request->get('sort_by', $request->get('sort', 'created_at'));
        $sortOrder = $request->get('sort_order', $request->get('order', 'desc'));
        $query->orderBy($sortBy, $sortOrder);

        // Handle limit parameter for dashboard
        if ($request->has('limit') && !$request->has('per_page')) {
            $perPage = $request->get('limit');
        } else {
            $perPage = $request->get('per_page', 10);
        }

        // Pagination
        $beritas = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Data berita berhasil diambil',
            'data' => $beritas->items(),
            'meta' => [
                'current_page' => $beritas->currentPage(),
                'per_page' => $beritas->perPage(),
                'total' => $beritas->total(),
                'last_page' => $beritas->lastPage(),
                'from' => $beritas->firstItem(),
                'to' => $beritas->lastItem()
            ]
        ]);
    }

    /**
     * Menyimpan berita baru
     */
    public function store(Request $request): JsonResponse
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
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50'
        ], [
            'judul.required' => 'Judul berita wajib diisi',
            'konten.required' => 'Konten berita wajib diisi',
            'kategori_berita_id.required' => 'Kategori berita wajib dipilih',
            'kategori_berita_id.exists' => 'Kategori berita tidak valid',
            'gambar_utama.image' => 'File harus berupa gambar',
            'gambar_utama.max' => 'Ukuran gambar maksimal 2MB'
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

        // Upload gambar jika ada
        if ($request->hasFile('gambar_utama')) {
            $data['gambar_utama'] = $request->file('gambar_utama')->store('berita', 'public');
        }

        // Set published_at jika status published
        if ($data['status'] === 'published' && !isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        $berita = Berita::create($data);
        $berita->load(['kategoriBerita', 'user']);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dibuat',
            'data' => $berita
        ], 201);
    }

    /**
     * Menampilkan detail berita
     */
    public function show(Berita $berita): JsonResponse
    {
        $berita->load(['kategoriBerita', 'user']);
        
        return response()->json([
            'success' => true,
            'message' => 'Detail berita berhasil diambil',
            'data' => $berita
        ]);
    }

    /**
     * Mengupdate berita
     */
    public function update(Request $request, Berita $berita): JsonResponse
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('beritas', 'slug')->ignore($berita->id)
            ],
            'konten' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_berita_id' => 'required|exists:kategori_beritas,id',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50'
        ]);

        $data = $request->except(['gambar_utama']);

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
        $berita->load(['kategoriBerita', 'user']);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil diupdate',
            'data' => $berita
        ]);
    }

    /**
     * Menghapus berita
     */
    public function destroy(Berita $berita): JsonResponse
    {
        try {
            // Hapus gambar jika ada
            if ($berita->gambar_utama) {
                Storage::disk('public')->delete($berita->gambar_utama);
            }
    
            $berita->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus berita: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle status featured
     */
    public function toggleFeatured(Berita $berita): JsonResponse
    {
        $berita->update([
            'is_featured' => !$berita->is_featured
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status featured berhasil diubah',
            'data' => $berita
        ]);
    }

    /**
     * Increment views
     */
    public function incrementViews(Berita $berita): JsonResponse
    {
        $berita->incrementViews();

        return response()->json([
            'success' => true,
            'message' => 'Views berhasil ditambah',
            'data' => ['views' => $berita->fresh()->views]
        ]);
    }
}
