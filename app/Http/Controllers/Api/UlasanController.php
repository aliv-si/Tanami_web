<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItemPesanan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UlasanController extends Controller
{
    /**
     * Get reviews by product
     * GET /api/v1/produk/{id}/ulasan
     */
    public function indexByProduk(Request $request, int $id): JsonResponse
    {
        $produk = Produk::find($id);

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

        // Rating statistics
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
            'message' => 'Daftar ulasan berhasil diambil.',
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

    /**
     * Create review for order item
     * POST /api/v1/ulasan
     * 
     * @bodyParam id_item_pesanan int required ID item pesanan yang akan diulas.
     * @bodyParam rating int required Rating 1-5.
     * @bodyParam komentar string optional Komentar ulasan.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id_item_pesanan' => 'required|integer|exists:item_pesanan,id_item',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ], [
            'id_item_pesanan.required' => 'ID item pesanan wajib diisi.',
            'id_item_pesanan.exists' => 'Item pesanan tidak ditemukan.',
            'rating.required' => 'Rating wajib diisi.',
            'rating.min' => 'Rating minimal 1.',
            'rating.max' => 'Rating maksimal 5.',
            'komentar.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Load item pesanan with pesanan
        $itemPesanan = ItemPesanan::with('pesanan')->find($request->id_item_pesanan);

        // Check ownership
        if ($itemPesanan->pesanan->id_pembeli !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke item pesanan ini.',
            ], 403);
        }

        // Check order status - only completed orders can be reviewed
        if ($itemPesanan->pesanan->status_pesanan !== Pesanan::STATUS_SELESAI) {
            return response()->json([
                'success' => false,
                'message' => 'Ulasan hanya dapat diberikan untuk pesanan yang sudah selesai.',
            ], 400);
        }

        // Check if already reviewed
        $existingReview = Ulasan::where('id_item_pesanan', $request->id_item_pesanan)->first();
        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan ulasan untuk item ini.',
            ], 400);
        }

        // Create review
        $ulasan = Ulasan::create([
            'id_item_pesanan' => $request->id_item_pesanan,
            'id_pengguna' => Auth::id(),
            'id_produk' => $itemPesanan->id_produk,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        $ulasan->load(['pengguna:id_pengguna,nama_lengkap', 'produk:id_produk,nama_produk']);

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil ditambahkan. Terima kasih atas feedback Anda!',
            'data' => [
                'id' => $ulasan->id_ulasan,
                'rating' => $ulasan->rating,
                'komentar' => $ulasan->komentar,
                'produk' => $ulasan->produk ? [
                    'id' => $ulasan->produk->id_produk,
                    'nama' => $ulasan->produk->nama_produk,
                ] : null,
                'tgl_dibuat' => $ulasan->tgl_dibuat?->toIso8601String(),
            ],
        ], 201);
    }

    /**
     * Get reviews for farmer's products
     * GET /api/v1/petani/ulasan
     */
    public function index(Request $request): JsonResponse
    {
        $query = Ulasan::with(['pengguna:id_pengguna,nama_lengkap', 'produk:id_produk,nama_produk'])
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
}
