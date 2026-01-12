<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KategoriController extends Controller
{
    /**
     * Get all categories
     * GET /api/v1/kategori
     */
    public function index(): JsonResponse
    {
        $kategori = Kategori::withCount(['produk' => function ($query) {
            $query->where('is_aktif', true)
                  ->whereRaw('stok - stok_direserve > 0');
        }])
        ->orderBy('nama_kategori')
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id_kategori,
                'nama' => $item->nama_kategori,
                'slug' => $item->slug_kategori,
                'deskripsi' => $item->deskripsi,
                'jumlah_produk' => $item->produk_count,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar kategori berhasil diambil.',
            'data' => $kategori,
        ]);
    }

    /**
     * Get category by slug
     * GET /api/v1/kategori/{slug}
     */
    public function show(string $slug): JsonResponse
    {
        $kategori = Kategori::where('slug_kategori', $slug)
            ->withCount(['produk' => function ($query) {
                $query->where('is_aktif', true)
                      ->whereRaw('stok - stok_direserve > 0');
            }])
            ->first();

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail kategori berhasil diambil.',
            'data' => [
                'id' => $kategori->id_kategori,
                'nama' => $kategori->nama_kategori,
                'slug' => $kategori->slug_kategori,
                'deskripsi' => $kategori->deskripsi,
                'jumlah_produk' => $kategori->produk_count,
                'tgl_dibuat' => $kategori->tgl_dibuat?->toIso8601String(),
            ],
        ]);
    }

    /**
     * Get products by category
     * GET /api/v1/kategori/{slug}/produk
     */
    public function produk(Request $request, string $slug): JsonResponse
    {
        $kategori = Kategori::where('slug_kategori', $slug)->first();

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.',
            ], 404);
        }

        $query = Produk::where('id_kategori', $kategori->id_kategori)
            ->tersedia()
            ->with(['petani:id_pengguna,nama_lengkap']);

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
                'petani' => $item->petani ? [
                    'id' => $item->petani->id_pengguna,
                    'nama' => $item->petani->nama_lengkap,
                ] : null,
                'rata_rating' => round($item->rata_rating ?? 0, 1),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar produk kategori berhasil diambil.',
            'data' => [
                'kategori' => [
                    'id' => $kategori->id_kategori,
                    'nama' => $kategori->nama_kategori,
                    'slug' => $kategori->slug_kategori,
                ],
                'produk' => $produk,
            ],
        ]);
    }
}
