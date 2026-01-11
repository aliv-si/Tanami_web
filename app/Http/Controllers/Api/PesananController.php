<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Kota;
use App\Models\Kupon;
use App\Models\Pesanan;
use App\Models\ItemPesanan;
use App\Models\PemakaianKupon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
    /**
     * Get user's orders
     * GET /api/v1/pesanan?status=pending
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pesanan::with(['kota', 'items.produk'])
            ->where('id_pembeli', Auth::id())
            ->orderByDesc('tgl_dibuat');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_pesanan', $request->status);
        }

        $pesanan = $query->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $pesanan,
        ]);
    }

    /**
     * Get order detail
     * GET /api/v1/pesanan/{id}
     */
    public function show(int $id): JsonResponse
    {
        $pesanan = Pesanan::with([
            'kota',
            'items.produk.petani',
            'historiStatus.pengubah',
            'pemakaianKupon.kupon',
        ])
            ->where('id_pembeli', Auth::id())
            ->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pesanan,
        ]);
    }

    /**
     * Create order from cart (checkout)
     * POST /api/v1/checkout
     */
    public function checkout(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id_kota_tujuan' => 'required|exists:kota,id_kota',
            'kode_kupon' => 'nullable|string|max:50',
            'catatan' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Load keranjang dengan produk
        $items = Keranjang::with('produk')
            ->where('id_pengguna', Auth::id())
            ->get();

        if ($items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang belanja kosong',
            ], 400);
        }

        // Validasi stok tersedia untuk semua item
        foreach ($items as $item) {
            if (!$item->produk->cekStok($item->jumlah)) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok {$item->produk->nama_produk} tidak mencukupi",
                    'errors' => [
                        'stok' => "Tersedia: {$item->produk->stokTersedia()}, diminta: {$item->jumlah}"
                    ]
                ], 400);
            }
        }

        // Load kota untuk ongkir
        $kota = Kota::aktif()->find($request->id_kota_tujuan);
        if (!$kota) {
            return response()->json([
                'success' => false,
                'message' => 'Kota tidak ditemukan atau tidak aktif',
            ], 400);
        }

        // Hitung subtotal
        $subtotal = $items->sum('subtotal');
        $ongkir = $kota->ongkir;
        $diskon = 0;
        $kupon = null;

        // Validasi kupon jika ada
        if ($request->filled('kode_kupon')) {
            $kupon = Kupon::where('kode_kupon', $request->kode_kupon)->first();

            if (!$kupon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode kupon tidak ditemukan',
                ], 400);
            }

            if (!$kupon->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kupon sudah tidak berlaku',
                ], 400);
            }

            // Cek minimum belanja
            if ($subtotal < $kupon->min_belanja) {
                return response()->json([
                    'success' => false,
                    'message' => "Minimum belanja Rp " . number_format((float) $kupon->min_belanja, 0, ',', '.') . " untuk menggunakan kupon ini",
                ], 400);
            }

            // Cek limit total pemakaian
            if ($kupon->limit_total !== null) {
                $totalPemakaian = $kupon->pemakaian()->count();
                if ($totalPemakaian >= $kupon->limit_total) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kupon sudah habis digunakan',
                    ], 400);
                }
            }

            // Cek limit per user
            if ($kupon->limit_per_user !== null) {
                $userPemakaian = $kupon->pemakaian()
                    ->where('id_pengguna', Auth::id())
                    ->count();
                if ($userPemakaian >= $kupon->limit_per_user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda sudah mencapai batas pemakaian kupon ini',
                    ], 400);
                }
            }

            $diskon = $kupon->hitungDiskon($subtotal);
        }

        // Hitung total
        $totalBayar = $subtotal + $ongkir - $diskon;

        // Process dalam transaction
        try {
            $pesanan = DB::transaction(function () use ($items, $kota, $subtotal, $ongkir, $diskon, $totalBayar, $kupon, $request) {
                // 1. Reserve stock untuk semua item
                foreach ($items as $item) {
                    $item->produk->reserveStok($item->jumlah);
                }

                // 2. Create pesanan
                $pesanan = Pesanan::create([
                    'id_pembeli' => Auth::id(),
                    'id_kota_tujuan' => $kota->id_kota,
                    'subtotal' => $subtotal,
                    'ongkir' => $ongkir,
                    'diskon' => $diskon,
                    'total_bayar' => $totalBayar,
                    'status_pesanan' => Pesanan::STATUS_PENDING,
                    'batas_bayar' => now()->addHours(24),
                    'catatan' => $request->catatan,
                ]);

                // 3. Create item_pesanan
                foreach ($items as $item) {
                    ItemPesanan::create([
                        'id_pesanan' => $pesanan->id_pesanan,
                        'id_produk' => $item->produk->id_produk,
                        'id_petani' => $item->produk->id_petani,
                        'jumlah' => $item->jumlah,
                        'harga_snapshot' => $item->produk->harga,
                        'subtotal' => $item->subtotal,
                    ]);
                }

                // 4. Record pemakaian kupon jika ada
                if ($kupon) {
                    PemakaianKupon::create([
                        'id_kupon' => $kupon->id_kupon,
                        'id_pengguna' => Auth::id(),
                        'id_pesanan' => $pesanan->id_pesanan,
                        'diskon_dipakai' => $diskon,
                    ]);
                }

                // 5. Clear keranjang
                Keranjang::where('id_pengguna', Auth::id())->delete();

                return $pesanan;
            });

            // Load relasi untuk response
            $pesanan->load(['items.produk', 'kota']);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat! Silakan upload bukti pembayaran sebelum ' . $pesanan->batas_bayar->format('d M Y H:i'),
                'data' => [
                    'id_pesanan' => $pesanan->id_pesanan,
                    'subtotal' => $pesanan->subtotal,
                    'ongkir' => $pesanan->ongkir,
                    'diskon' => $pesanan->diskon,
                    'total_bayar' => $pesanan->total_bayar,
                    'status_pesanan' => $pesanan->status_pesanan,
                    'batas_bayar' => $pesanan->batas_bayar->toISOString(),
                    'items' => $pesanan->items,
                    'kota' => $pesanan->kota,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat pesanan',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Upload payment proof
     * POST /api/v1/pesanan/{id}/upload-bukti
     */
    public function uploadBukti(Request $request, int $id): JsonResponse
    {
        // TODO: Implement (3.5)
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Cancel order
     * POST /api/v1/pesanan/{id}/batal
     */
    public function batal(int $id): JsonResponse
    {
        // TODO: Implement (3.5)
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Confirm order received
     * POST /api/v1/pesanan/{id}/konfirmasi
     */
    public function konfirmasi(int $id): JsonResponse
    {
        // TODO: Implement (3.5)
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Request refund
     * POST /api/v1/pesanan/{id}/refund
     */
    public function mintaRefund(Request $request, int $id): JsonResponse
    {
        // TODO: Implement (3.5)
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
