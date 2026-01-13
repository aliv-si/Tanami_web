<?php

namespace App\Http\Controllers\Api\Petani;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    /**
     * Get reviews for farmer's products
     * GET /api/v1/petani/ulasan
     */
    public function index(Request $request): JsonResponse
    {
        $query = Ulasan::with(['pengguna:id_pengguna,nama_lengkap', 'produk:id_produk,nama_produk,foto'])
            ->whereHas('produk', function ($q) {
                $q->where('id_petani', Auth::id());
            })
            ->orderByDesc('tgl_dibuat');

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by product
        if ($request->filled('id_produk')) {
            $query->where('id_produk', $request->id_produk);
        }

        $perPage = min((int) $request->input('per_page', 10), 50);
        $ulasan = $query->paginate($perPage);

        // Transform data
        $ulasan->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id_ulasan,
                'rating' => $item->rating,
                'komentar' => $item->komentar,
                'pengguna' => $item->pengguna ? [
                    'id' => $item->pengguna->id_pengguna,
                    'nama' => $item->pengguna->nama_lengkap,
                ] : null,
                'produk' => $item->produk ? [
                    'id' => $item->produk->id_produk,
                    'nama' => $item->produk->nama_produk,
                    'foto' => $item->produk->foto ? asset('storage/produk/' . $item->produk->foto) : null,
                ] : null,
                'tgl_dibuat' => $item->tgl_dibuat?->toIso8601String(),
            ];
        });

        // Rating statistics for farmer
        $stats = [
            'rata_rata' => round(
                Ulasan::whereHas('produk', fn($q) => $q->where('id_petani', Auth::id()))->avg('rating') ?? 0,
                1
            ),
            'total' => Ulasan::whereHas('produk', fn($q) => $q->where('id_petani', Auth::id()))->count(),
            'distribusi' => [
                '5' => Ulasan::whereHas('produk', fn($q) => $q->where('id_petani', Auth::id()))->where('rating', 5)->count(),
                '4' => Ulasan::whereHas('produk', fn($q) => $q->where('id_petani', Auth::id()))->where('rating', 4)->count(),
                '3' => Ulasan::whereHas('produk', fn($q) => $q->where('id_petani', Auth::id()))->where('rating', 3)->count(),
                '2' => Ulasan::whereHas('produk', fn($q) => $q->where('id_petani', Auth::id()))->where('rating', 2)->count(),
                '1' => Ulasan::whereHas('produk', fn($q) => $q->where('id_petani', Auth::id()))->where('rating', 1)->count(),
            ],
        ];

        return response()->json([
            'success' => true,
            'message' => 'Daftar ulasan berhasil diambil.',
            'data' => [
                'statistik' => $stats,
                'ulasan' => $ulasan,
            ],
        ]);
    }

    /**
     * Get reviews for specific product owned by farmer
     * GET /api/v1/petani/ulasan/produk/{id}
     */
    public function byProduk(Request $request, int $id): JsonResponse
    {
        // Verify product ownership
        $produk = \App\Models\Produk::where('id_petani', Auth::id())->find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        $query = Ulasan::with(['pengguna:id_pengguna,nama_lengkap'])
            ->where('id_produk', $id)
            ->orderByDesc('tgl_dibuat');

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $perPage = min((int) $request->input('per_page', 10), 50);
        $ulasan = $query->paginate($perPage);

        // Transform data
        $ulasan->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id_ulasan,
                'rating' => $item->rating,
                'komentar' => $item->komentar,
                'pengguna' => $item->pengguna ? [
                    'id' => $item->pengguna->id_pengguna,
                    'nama' => $item->pengguna->nama_lengkap,
                ] : null,
                'tgl_dibuat' => $item->tgl_dibuat?->toIso8601String(),
            ];
        });

        // Rating stats for this product
        $stats = [
            'rata_rata' => round(Ulasan::where('id_produk', $id)->avg('rating') ?? 0, 1),
            'total' => Ulasan::where('id_produk', $id)->count(),
            'distribusi' => [
                '5' => Ulasan::where('id_produk', $id)->where('rating', 5)->count(),
                '4' => Ulasan::where('id_produk', $id)->where('rating', 4)->count(),
                '3' => Ulasan::where('id_produk', $id)->where('rating', 3)->count(),
                '2' => Ulasan::where('id_produk', $id)->where('rating', 2)->count(),
                '1' => Ulasan::where('id_produk', $id)->where('rating', 1)->count(),
            ],
        ];

        return response()->json([
            'success' => true,
            'message' => 'Daftar ulasan produk berhasil diambil.',
            'data' => [
                'produk' => [
                    'id' => $produk->id_produk,
                    'nama' => $produk->nama_produk,
                ],
                'statistik' => $stats,
                'ulasan' => $ulasan,
            ],
        ]);
    }
}
