<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KeranjangController extends Controller
{
    /**
     * Get user's cart items
     * GET /api/v1/keranjang
     */
    public function index(Request $request): JsonResponse
    {
        $items = Keranjang::with(['produk.petani', 'produk.kategori'])
            ->where('id_pengguna', Auth::id())
            ->get();

        // Group items by petani
        $groupedItems = $items->groupBy(function ($item) {
            return $item->produk->id_petani;
        })->map(function ($group) {
            $petani = $group->first()->produk->petani;
            return [
                'petani' => $petani,
                'items' => $group,
                'subtotal' => $group->sum('subtotal'),
            ];
        });

        // Hitung total keseluruhan
        $total = $items->sum('subtotal');
        $jumlahItem = $items->sum('jumlah');

        return response()->json([
            'success' => true,
            'data' => [
                'grouped_items' => $groupedItems,
                'total' => $total,
                'jumlah_item' => $jumlahItem,
            ],
        ]);
    }

    /**
     * Add item to cart
     * POST /api/v1/keranjang
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id_produk' => 'required|integer|exists:produk,id_produk',
            'jumlah' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $produk = Produk::aktif()->find($request->id_produk);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan atau tidak aktif',
            ], 404);
        }

        $jumlahDiminta = $request->jumlah;

        // Cek apakah produk sudah ada di keranjang user
        $existingItem = Keranjang::where('id_pengguna', Auth::id())
            ->where('id_produk', $produk->id_produk)
            ->first();

        if ($existingItem) {
            // Produk sudah ada, tambah qty
            $totalJumlah = $existingItem->jumlah + $jumlahDiminta;

            // Cek stok tersedia untuk total jumlah
            if (!$produk->cekStok($totalJumlah)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi',
                    'errors' => [
                        'stok' => "Tersedia: {$produk->stokTersedia()}, di keranjang: {$existingItem->jumlah}"
                    ],
                ], 400);
            }

            $existingItem->update(['jumlah' => $totalJumlah]);

            return response()->json([
                'success' => true,
                'message' => 'Jumlah produk di keranjang berhasil ditambah',
                'data' => $existingItem->fresh()->load('produk'),
            ]);
        }

        // Produk belum ada, cek stok dan tambah baru
        if (!$produk->cekStok($jumlahDiminta)) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi',
                'errors' => [
                    'stok' => "Tersedia: {$produk->stokTersedia()}"
                ],
            ], 400);
        }

        $item = Keranjang::create([
            'id_pengguna' => Auth::id(),
            'id_produk' => $produk->id_produk,
            'jumlah' => $jumlahDiminta,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'data' => $item->load('produk'),
        ], 201);
    }

    /**
     * Update cart item quantity
     * PUT /api/v1/keranjang/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'jumlah' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $item = Keranjang::with('produk')
            ->where('id_pengguna', Auth::id())
            ->find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item keranjang tidak ditemukan',
            ], 404);
        }

        $jumlahBaru = $request->jumlah;

        // Cek stok tersedia
        if (!$item->produk->cekStok($jumlahBaru)) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi',
                'errors' => [
                    'stok' => "Tersedia: {$item->produk->stokTersedia()}"
                ],
            ], 400);
        }

        $item->update(['jumlah' => $jumlahBaru]);

        return response()->json([
            'success' => true,
            'message' => 'Jumlah berhasil diperbarui',
            'data' => $item->fresh()->load('produk'),
        ]);
    }

    /**
     * Remove item from cart
     * DELETE /api/v1/keranjang/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $item = Keranjang::where('id_pengguna', Auth::id())
            ->find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item keranjang tidak ditemukan',
            ], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang',
        ]);
    }

    /**
     * Clear all cart items
     * DELETE /api/v1/keranjang
     */
    public function clear(Request $request): JsonResponse
    {
        $deleted = Keranjang::where('id_pengguna', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan',
            'deleted_count' => $deleted,
        ]);
    }
}
