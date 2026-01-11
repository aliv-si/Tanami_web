<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProdukController extends Controller
{
    /**
     * Get all products (public) with filter, search, sort, pagination
     * 
     * Query Parameters:
     * - q: search keyword
     * - kategori: filter by kategori slug
     * - sort: terbaru|termurah|termahal|terlaris
     * - min_harga: minimum price
     * - max_harga: maximum price
     * - per_page: items per page (default 12, max 50)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Produk::query()
            ->tersedia()
            ->with(['kategori:id_kategori,nama_kategori,slug_kategori', 'petani:id_pengguna,nama_lengkap']);

        // Search by nama produk atau deskripsi
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter by kategori slug
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('slug_kategori', $request->input('kategori'));
            });
        }

        // Filter by price range
        if ($request->filled('min_harga')) {
            $query->where('harga', '>=', (float) $request->input('min_harga'));
        }
        if ($request->filled('max_harga')) {
            $query->where('harga', '<=', (float) $request->input('max_harga'));
        }

        // Sorting
        $sort = $request->input('sort', 'terbaru');
        switch ($sort) {
            case 'termurah':
                $query->orderBy('harga', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga', 'desc');
                break;
            case 'terlaris':
                $query->withCount('itemPesanan')
                      ->orderBy('item_pesanan_count', 'desc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('tgl_dibuat', 'desc');
                break;
        }

        // Pagination
        $perPage = min((int) $request->input('per_page', 12), 50);
        $produk = $query->paginate($perPage);

        // Transform response
        $produk->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id_produk,
                'nama' => $item->nama_produk,
                'slug' => $item->slug_produk,
                'harga' => (float) $item->harga,
                'stok_tersedia' => $item->stokTersedia(),
                'satuan' => $item->satuan,
                'foto' => $item->foto ? asset('storage/produk/' . $item->foto) : null,
                'kategori' => $item->kategori ? [
                    'id' => $item->kategori->id_kategori,
                    'nama' => $item->kategori->nama_kategori,
                    'slug' => $item->kategori->slug_kategori,
                ] : null,
                'petani' => $item->petani ? [
                    'id' => $item->petani->id_pengguna,
                    'nama' => $item->petani->nama_lengkap,
                ] : null,
                'rata_rating' => round($item->rata_rating, 1),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar produk berhasil diambil.',
            'data' => $produk,
        ]);
    }

    /**
     * Get product detail by slug
     */
    public function show(string $slug): JsonResponse
    {
        $produk = Produk::where('slug_produk', $slug)
            ->aktif()
            ->with(['kategori', 'petani:id_pengguna,nama_lengkap,alamat,no_hp', 'ulasan.pengguna:id_pengguna,nama_lengkap'])
            ->first();

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        // Rating statistics
        $ratingStats = [
            'rata_rata' => round($produk->ulasan->avg('rating') ?? 0, 1),
            'total_ulasan' => $produk->ulasan->count(),
            'distribusi' => [
                '5' => $produk->ulasan->where('rating', 5)->count(),
                '4' => $produk->ulasan->where('rating', 4)->count(),
                '3' => $produk->ulasan->where('rating', 3)->count(),
                '2' => $produk->ulasan->where('rating', 2)->count(),
                '1' => $produk->ulasan->where('rating', 1)->count(),
            ],
        ];

        // Transform ulasan
        $ulasanList = $produk->ulasan->map(function ($ulasan) {
            return [
                'id' => $ulasan->id_ulasan,
                'rating' => $ulasan->rating,
                'komentar' => $ulasan->komentar,
                'pengguna' => $ulasan->pengguna ? [
                    'id' => $ulasan->pengguna->id_pengguna,
                    'nama' => $ulasan->pengguna->nama_lengkap,
                ] : null,
                'tgl_dibuat' => $ulasan->tgl_dibuat?->toIso8601String(),
            ];
        });

        // Get related products
        $produkTerkait = Produk::where('id_kategori', $produk->id_kategori)
            ->where('id_produk', '!=', $produk->id_produk)
            ->tersedia()
            ->limit(4)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id_produk,
                    'nama' => $item->nama_produk,
                    'slug' => $item->slug_produk,
                    'harga' => (float) $item->harga,
                    'foto' => $item->foto ? asset('storage/produk/' . $item->foto) : null,
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
                'stok_tersedia' => $produk->stokTersedia(),
                'satuan' => $produk->satuan,
                'deskripsi' => $produk->deskripsi,
                'foto' => $produk->foto ? asset('storage/produk/' . $produk->foto) : null,
                'kategori' => $produk->kategori ? [
                    'id' => $produk->kategori->id_kategori,
                    'nama' => $produk->kategori->nama_kategori,
                    'slug' => $produk->kategori->slug_kategori,
                ] : null,
                'petani' => $produk->petani ? [
                    'id' => $produk->petani->id_pengguna,
                    'nama' => $produk->petani->nama_lengkap,
                    'alamat' => $produk->petani->alamat,
                ] : null,
                'rating' => $ratingStats,
                'ulasan' => $ulasanList,
                'produk_terkait' => $produkTerkait,
                'tgl_dibuat' => $produk->tgl_dibuat?->toIso8601String(),
            ],
        ]);
    }
}
