<?php

namespace App\Http\Controllers\Api\Petani;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProdukController extends Controller
{
    /**
     * Get farmer's products
     */
    public function index(Request $request): JsonResponse
    {
        $petaniId = Auth::id();

        $query = Produk::where('id_petani', $petaniId)
            ->with('kategori:id_kategori,nama_kategori,slug_kategori');

        // Filter by status aktif
        if ($request->has('aktif')) {
            $query->where('is_aktif', $request->boolean('aktif'));
        }

        // Search
        if ($request->filled('q')) {
            $query->where('nama_produk', 'like', '%' . $request->input('q') . '%');
        }

        // Sort
        $sort = $request->input('sort', 'terbaru');
        switch ($sort) {
            case 'nama':
                $query->orderBy('nama_produk', 'asc');
                break;
            case 'stok_rendah':
                $query->orderByRaw('(stok - stok_direserve) ASC');
                break;
            case 'terbaru':
            default:
                $query->orderBy('tgl_dibuat', 'desc');
                break;
        }

        $perPage = min((int) $request->input('per_page', 10), 50);
        $produk = $query->paginate($perPage);

        // Transform
        $produk->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id_produk,
                'nama' => $item->nama_produk,
                'slug' => $item->slug_produk,
                'harga' => (float) $item->harga,
                'stok' => $item->stok,
                'stok_direserve' => $item->stok_direserve,
                'stok_tersedia' => $item->stokTersedia(),
                'satuan' => $item->satuan,
                'foto' => $item->foto ? asset('storage/produk/' . $item->foto) : null,
                'is_aktif' => $item->is_aktif,
                'kategori' => $item->kategori ? [
                    'id' => $item->kategori->id_kategori,
                    'nama' => $item->kategori->nama_kategori,
                ] : null,
                'tgl_dibuat' => $item->tgl_dibuat?->toIso8601String(),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar produk berhasil diambil.',
            'data' => $produk,
        ]);
    }

    /**
     * Create new product
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_produk' => ['required', 'string', 'max:150'],
            'id_kategori' => ['required', 'exists:kategori,id_kategori'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string'],
            'is_aktif' => ['boolean'],
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.exists' => 'Kategori tidak valid.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.min' => 'Stok tidak boleh negatif.',
            'satuan.required' => 'Satuan wajib diisi.',
        ]);

        // Generate slug
        $slug = Str::slug($validated['nama_produk']);
        $originalSlug = $slug;
        $counter = 1;
        while (Produk::where('slug_produk', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $produk = Produk::create([
            'id_petani' => Auth::id(),
            'id_kategori' => $validated['id_kategori'],
            'nama_produk' => $validated['nama_produk'],
            'slug_produk' => $slug,
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'stok_direserve' => 0,
            'satuan' => $validated['satuan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'is_aktif' => $validated['is_aktif'] ?? true,
        ]);

        $produk->load('kategori:id_kategori,nama_kategori');

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan.',
            'data' => [
                'id' => $produk->id_produk,
                'nama' => $produk->nama_produk,
                'slug' => $produk->slug_produk,
                'harga' => (float) $produk->harga,
                'stok' => $produk->stok,
                'satuan' => $produk->satuan,
                'deskripsi' => $produk->deskripsi,
                'is_aktif' => $produk->is_aktif,
                'kategori' => $produk->kategori ? [
                    'id' => $produk->kategori->id_kategori,
                    'nama' => $produk->kategori->nama_kategori,
                ] : null,
            ],
        ], 201);
    }

    /**
     * Get product detail (own product only)
     */
    public function show(int $id): JsonResponse
    {
        $produk = Produk::where('id_produk', $id)
            ->where('id_petani', Auth::id())
            ->with(['kategori', 'ulasan.pengguna:id_pengguna,nama_lengkap'])
            ->first();

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        $ulasanList = $produk->ulasan->map(function ($ulasan) {
            return [
                'id' => $ulasan->id_ulasan,
                'rating' => $ulasan->rating,
                'komentar' => $ulasan->komentar,
                'pengguna' => $ulasan->pengguna?->nama_lengkap,
                'tgl_dibuat' => $ulasan->tgl_dibuat?->toIso8601String(),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Detail produk berhasil diambil.',
            'data' => [
                'id' => $produk->id_produk,
                'nama' => $produk->nama_produk,
                'slug' => $produk->slug_produk,
                'harga' => (float) $produk->harga,
                'stok' => $produk->stok,
                'stok_direserve' => $produk->stok_direserve,
                'stok_tersedia' => $produk->stokTersedia(),
                'satuan' => $produk->satuan,
                'deskripsi' => $produk->deskripsi,
                'foto' => $produk->foto ? asset('storage/produk/' . $produk->foto) : null,
                'is_aktif' => $produk->is_aktif,
                'kategori' => $produk->kategori ? [
                    'id' => $produk->kategori->id_kategori,
                    'nama' => $produk->kategori->nama_kategori,
                    'slug' => $produk->kategori->slug_kategori,
                ] : null,
                'rata_rating' => round($produk->ulasan->avg('rating') ?? 0, 1),
                'total_ulasan' => $produk->ulasan->count(),
                'ulasan' => $ulasanList,
                'tgl_dibuat' => $produk->tgl_dibuat?->toIso8601String(),
                'tgl_update' => $produk->tgl_update?->toIso8601String(),
            ],
        ]);
    }

    /**
     * Update product (own product only)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $produk = Produk::where('id_produk', $id)
            ->where('id_petani', Auth::id())
            ->first();

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'nama_produk' => ['sometimes', 'required', 'string', 'max:150'],
            'id_kategori' => ['sometimes', 'required', 'exists:kategori,id_kategori'],
            'harga' => ['sometimes', 'required', 'numeric', 'min:0'],
            'stok' => ['sometimes', 'required', 'integer', 'min:0'],
            'satuan' => ['sometimes', 'required', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string'],
            'is_aktif' => ['boolean'],
        ]);

        // Regenerate slug if nama changed
        if (isset($validated['nama_produk']) && $validated['nama_produk'] !== $produk->nama_produk) {
            $slug = Str::slug($validated['nama_produk']);
            $originalSlug = $slug;
            $counter = 1;
            while (Produk::where('slug_produk', $slug)->where('id_produk', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug_produk'] = $slug;
        }

        $produk->update($validated);
        $produk->load('kategori:id_kategori,nama_kategori');

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diperbarui.',
            'data' => [
                'id' => $produk->id_produk,
                'nama' => $produk->nama_produk,
                'slug' => $produk->slug_produk,
                'harga' => (float) $produk->harga,
                'stok' => $produk->stok,
                'stok_tersedia' => $produk->stokTersedia(),
                'satuan' => $produk->satuan,
                'deskripsi' => $produk->deskripsi,
                'is_aktif' => $produk->is_aktif,
                'kategori' => $produk->kategori ? [
                    'id' => $produk->kategori->id_kategori,
                    'nama' => $produk->kategori->nama_kategori,
                ] : null,
            ],
        ]);
    }

    /**
     * Delete product (own product only)
     */
    public function destroy(int $id): JsonResponse
    {
        $produk = Produk::where('id_produk', $id)
            ->where('id_petani', Auth::id())
            ->first();

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        // Check if there's reserved stock (active orders)
        if ($produk->stok_direserve > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak dapat dihapus karena masih ada pesanan aktif.',
            ], 422);
        }

        // Delete photo if exists
        if ($produk->foto && Storage::disk('public')->exists('produk/' . $produk->foto)) {
            Storage::disk('public')->delete('produk/' . $produk->foto);
        }

        $produk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus.',
        ]);
    }

    /**
     * Upload product photo
     */
    public function uploadFoto(Request $request, int $id): JsonResponse
    {
        $produk = Produk::where('id_produk', $id)
            ->where('id_petani', Auth::id())
            ->first();

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'], // Max 5MB
        ], [
            'foto.required' => 'Foto wajib diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 5MB.',
        ]);

        // Delete old photo if exists
        if ($produk->foto && Storage::disk('public')->exists('produk/' . $produk->foto)) {
            Storage::disk('public')->delete('produk/' . $produk->foto);
        }

        // Store new photo
        $file = $request->file('foto');
        $filename = $produk->slug_produk . '-' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('produk', $filename, 'public');

        // Update produk
        $produk->update(['foto' => $filename]);

        return response()->json([
            'success' => true,
            'message' => 'Foto produk berhasil diunggah.',
            'data' => [
                'foto' => asset('storage/produk/' . $filename),
            ],
        ]);
    }
}
