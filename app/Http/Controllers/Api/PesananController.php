<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Kota;
use App\Models\Kupon;
use App\Models\Pesanan;
use App\Models\Escrow;
use App\Models\ItemPesanan;
use App\Models\PemakaianKupon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

        // Transform data
        $pesanan->getCollection()->transform(function ($item) {
            return $this->transformPesanan($item);
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar pesanan berhasil diambil.',
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
            'escrow',
        ])
            ->where('id_pembeli', Auth::id())
            ->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pesanan berhasil diambil.',
            'data' => $this->transformPesanan($pesanan, true),
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
                'data' => $this->transformPesanan($pesanan),
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
     * 
     * @bodyParam bukti_bayar file required File bukti bayar (JPG/PNG, max 2MB).
     */
    public function uploadBukti(Request $request, int $id): JsonResponse
    {
        $pesanan = Pesanan::where('id_pembeli', Auth::id())->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        // Check if can upload
        if (!$pesanan->bisaUploadBukti()) {
            if ($pesanan->status_pesanan !== Pesanan::STATUS_PENDING) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bukti bayar sudah diupload atau pesanan tidak dalam status pending.',
                ], 400);
            }
            if ($pesanan->batas_bayar <= now()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Batas waktu pembayaran sudah lewat.',
                ], 400);
            }
        }

        $validator = Validator::make($request->all(), [
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'bukti_bayar.required' => 'File bukti bayar wajib diupload.',
            'bukti_bayar.image' => 'File harus berupa gambar.',
            'bukti_bayar.mimes' => 'Format file harus JPG atau PNG.',
            'bukti_bayar.max' => 'Ukuran file maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::transaction(function () use ($request, $pesanan) {
                // Upload file
                $file = $request->file('bukti_bayar');
                $filename = 'bukti_' . $pesanan->id_pesanan . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/bukti-bayar', $filename);

                // Delete old file if exists
                if ($pesanan->bukti_bayar) {
                    Storage::delete('public/bukti-bayar/' . $pesanan->bukti_bayar);
                }

                // Update pesanan
                $pesanan->bukti_bayar = $filename;
                $pesanan->status_pesanan = Pesanan::STATUS_MENUNGGU_VERIFIKASI;
                $pesanan->save();
            });

            $pesanan->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diupload. Menunggu verifikasi dari petani.',
                'data' => [
                    'id_pesanan' => $pesanan->id_pesanan,
                    'status' => $pesanan->status_pesanan,
                    'bukti_bayar' => asset('storage/bukti-bayar/' . $pesanan->bukti_bayar),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload bukti pembayaran.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Cancel order
     * POST /api/v1/pesanan/{id}/batal
     * 
     * @bodyParam alasan string optional Alasan pembatalan.
     */
    public function batal(Request $request, int $id): JsonResponse
    {
        $pesanan = Pesanan::with('items.produk')
            ->where('id_pembeli', Auth::id())
            ->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        // Check if can cancel
        if (!$pesanan->bisaDibatalkan()) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak dapat dibatalkan. Status saat ini: ' . $pesanan->status_pesanan,
            ], 400);
        }

        try {
            DB::transaction(function () use ($request, $pesanan) {
                // Release reserved stock
                foreach ($pesanan->items as $item) {
                    if ($item->produk) {
                        $item->produk->releaseStok($item->jumlah);
                    }
                }

                // Update pesanan
                $pesanan->status_pesanan = Pesanan::STATUS_DIBATALKAN;
                $pesanan->alasan_batal = $request->input('alasan', 'Dibatalkan oleh pembeli');
                $pesanan->tgl_dibatalkan = now();
                $pesanan->save();
            });

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibatalkan.',
                'data' => [
                    'id_pesanan' => $pesanan->id_pesanan,
                    'status' => $pesanan->status_pesanan,
                    'alasan_batal' => $pesanan->alasan_batal,
                    'tgl_dibatalkan' => $pesanan->tgl_dibatalkan->toIso8601String(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan pesanan.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Confirm order received
     * POST /api/v1/pesanan/{id}/konfirmasi
     */
    public function konfirmasi(int $id): JsonResponse
    {
        $pesanan = Pesanan::with(['escrow', 'items.produk'])
            ->where('id_pembeli', Auth::id())
            ->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        // Check if can confirm
        if (!$pesanan->bisaDikonfirmasi()) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak dapat dikonfirmasi. Status harus "terkirim".',
            ], 400);
        }

        try {
            DB::transaction(function () use ($pesanan) {
                // Update pesanan
                $pesanan->status_pesanan = Pesanan::STATUS_SELESAI;
                $pesanan->tgl_selesai = now();
                $pesanan->id_konfirmasi = Auth::id();
                $pesanan->save();

                // Release escrow to petani
                if ($pesanan->escrow && $pesanan->escrow->status_escrow === Escrow::STATUS_DITAHAN) {
                    // Get petani from first item
                    $idPetani = $pesanan->items->first()->id_petani ?? null;
                    if ($idPetani) {
                        $pesanan->escrow->kirimKePetani($idPetani, 'Dikonfirmasi oleh pembeli');
                    }
                }
            });

            $pesanan->refresh()->load('escrow');

            return response()->json([
                'success' => true,
                'message' => 'Pesanan telah dikonfirmasi selesai. Terima kasih telah berbelanja!',
                'data' => [
                    'id_pesanan' => $pesanan->id_pesanan,
                    'status' => $pesanan->status_pesanan,
                    'tgl_selesai' => $pesanan->tgl_selesai->toIso8601String(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengkonfirmasi pesanan.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Request refund
     * POST /api/v1/pesanan/{id}/refund
     * 
     * @bodyParam alasan string required Alasan request refund.
     */
    public function mintaRefund(Request $request, int $id): JsonResponse
    {
        $pesanan = Pesanan::where('id_pembeli', Auth::id())->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        // Check if can request refund
        if (!$pesanan->bisaRefund()) {
            return response()->json([
                'success' => false,
                'message' => 'Refund hanya dapat diminta untuk pesanan dengan status "terkirim".',
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'alasan' => 'required|string|max:500',
        ], [
            'alasan.required' => 'Alasan refund wajib diisi.',
            'alasan.max' => 'Alasan maksimal 500 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $pesanan->status_pesanan = Pesanan::STATUS_MINTA_REFUND;
            $pesanan->alasan_refund = $request->alasan;
            $pesanan->save();

            return response()->json([
                'success' => true,
                'message' => 'Permintaan refund berhasil dikirim. Admin akan meninjau permintaan Anda.',
                'data' => [
                    'id_pesanan' => $pesanan->id_pesanan,
                    'status' => $pesanan->status_pesanan,
                    'alasan_refund' => $pesanan->alasan_refund,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengajukan refund.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Transform pesanan for response
     */
    private function transformPesanan(Pesanan $pesanan, bool $detailed = false): array
    {
        $data = [
            'id' => $pesanan->id_pesanan,
            'status' => $pesanan->status_pesanan,
            'subtotal' => (float) $pesanan->subtotal,
            'ongkir' => (float) $pesanan->ongkir,
            'diskon' => (float) $pesanan->diskon,
            'total_bayar' => (float) $pesanan->total_bayar,
            'total_formatted' => 'Rp ' . number_format((float) $pesanan->total_bayar, 0, ',', '.'),
            'batas_bayar' => $pesanan->batas_bayar?->toIso8601String(),
            'batas_bayar_formatted' => $pesanan->batas_bayar?->format('d M Y H:i'),
            'bukti_bayar' => $pesanan->bukti_bayar ? asset('storage/bukti-bayar/' . $pesanan->bukti_bayar) : null,
            'catatan' => $pesanan->catatan,
            'tgl_dibuat' => $pesanan->tgl_dibuat?->toIso8601String(),
            'kota' => $pesanan->kota ? [
                'id' => $pesanan->kota->id_kota,
                'nama' => $pesanan->kota->nama_kota,
                'provinsi' => $pesanan->kota->provinsi,
            ] : null,
        ];

        // Items summary
        if ($pesanan->relationLoaded('items')) {
            $data['jumlah_item'] = $pesanan->items->sum('jumlah');
            $data['items'] = $pesanan->items->map(function ($item) {
                return [
                    'id' => $item->id_item,
                    'produk' => $item->produk ? [
                        'id' => $item->produk->id_produk,
                        'nama' => $item->produk->nama_produk,
                        'foto' => $item->produk->foto ? asset('storage/produk/' . $item->produk->foto) : null,
                    ] : null,
                    'jumlah' => $item->jumlah,
                    'harga' => (float) $item->harga_snapshot,
                    'subtotal' => (float) $item->subtotal,
                ];
            });
        }

        // Detailed info
        if ($detailed) {
            $data['no_resi'] = $pesanan->no_resi;
            $data['tgl_verifikasi'] = $pesanan->tgl_verifikasi?->toIso8601String();
            $data['tgl_selesai'] = $pesanan->tgl_selesai?->toIso8601String();
            $data['tgl_dibatalkan'] = $pesanan->tgl_dibatalkan?->toIso8601String();
            $data['alasan_batal'] = $pesanan->alasan_batal;
            $data['alasan_tolak'] = $pesanan->alasan_tolak;
            $data['alasan_refund'] = $pesanan->alasan_refund;

            // Escrow info
            if ($pesanan->relationLoaded('escrow') && $pesanan->escrow) {
                $data['escrow'] = [
                    'id' => $pesanan->escrow->id_escrow,
                    'jumlah' => (float) $pesanan->escrow->jumlah,
                    'status' => $pesanan->escrow->status_escrow,
                ];
            }

            // Histori status
            if ($pesanan->relationLoaded('historiStatus')) {
                $data['histori'] = $pesanan->historiStatus->map(function ($h) {
                    return [
                        'status_lama' => $h->status_lama,
                        'status_baru' => $h->status_baru,
                        'alasan' => $h->alasan,
                        'pengubah' => $h->pengubah?->nama_lengkap,
                        'tgl' => $h->tgl_dibuat?->toIso8601String(),
                    ];
                });
            }

            // Kupon info
            if ($pesanan->relationLoaded('pemakaianKupon') && $pesanan->pemakaianKupon) {
                $data['kupon'] = [
                    'kode' => $pesanan->pemakaianKupon->kupon?->kode_kupon,
                    'diskon' => (float) $pesanan->pemakaianKupon->diskon_dipakai,
                ];
            }
        }

        return $data;
    }
}
