<?php

namespace App\Http\Controllers\Api\Petani;

use App\Http\Controllers\Controller;
use App\Models\Escrow;
use App\Models\ItemPesanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
    /**
     * Get incoming orders for farmer
     * GET /api/v1/petani/pesanan
     */
    public function index(Request $request): JsonResponse
    {
        $petaniId = Auth::id();

        $query = Pesanan::with(['pembeli:id_pengguna,nama_lengkap,no_hp', 'kota', 'items' => function ($q) use ($petaniId) {
            $q->where('id_petani', $petaniId)->with('produk:id_produk,nama_produk,foto');
        }])
            ->whereHas('items', function ($q) use ($petaniId) {
                $q->where('id_petani', $petaniId);
            })
            ->orderByDesc('tgl_dibuat');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_pesanan', $request->status);
        }

        // Only show orders that need farmer attention (not cancelled/refunded by default)
        if (!$request->filled('status') && !$request->boolean('semua')) {
            $query->whereNotIn('status_pesanan', [
                Pesanan::STATUS_DIBATALKAN,
                Pesanan::STATUS_DIREFUND,
                Pesanan::STATUS_PENDING, // Still waiting for payment proof
            ]);
        }

        $perPage = min((int) $request->input('per_page', 10), 50);
        $pesanan = $query->paginate($perPage);

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
     * GET /api/v1/petani/pesanan/{id}
     */
    public function show(int $id): JsonResponse
    {
        $petaniId = Auth::id();

        $pesanan = Pesanan::with([
            'pembeli:id_pengguna,nama_lengkap,email,no_hp,alamat',
            'kota',
            'items' => function ($q) use ($petaniId) {
                $q->where('id_petani', $petaniId)->with('produk');
            },
            'historiStatus.pengubah',
            'escrow',
        ])
            ->whereHas('items', function ($q) use ($petaniId) {
                $q->where('id_petani', $petaniId);
            })
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
     * Verify payment (approve)
     * POST /api/v1/petani/pesanan/{id}/verifikasi
     * 
     * Actions:
     * - Status → dibayar
     * - Kurangi stok aktual
     * - Release reserved stock
     * - Create escrow dengan status ditahan
     */
    public function verifikasi(Request $request, int $id): JsonResponse
    {
        $petaniId = Auth::id();

        $pesanan = Pesanan::with(['items' => function ($q) use ($petaniId) {
            $q->where('id_petani', $petaniId)->with('produk');
        }])
            ->whereHas('items', function ($q) use ($petaniId) {
                $q->where('id_petani', $petaniId);
            })
            ->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        // Check if can verify
        if (!$pesanan->bisaDiverifikasi()) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak dapat diverifikasi. Status harus "menunggu_verifikasi".',
            ], 400);
        }

        try {
            DB::transaction(function () use ($pesanan, $petaniId) {
                // 1. Update stock: release reserved, reduce actual
                foreach ($pesanan->items as $item) {
                    if ($item->produk) {
                        // Release reserved stock
                        $item->produk->releaseStok($item->jumlah);
                        // Reduce actual stock
                        $item->produk->kurangiStok($item->jumlah);
                    }
                }

                // 2. Update pesanan status
                $pesanan->status_pesanan = Pesanan::STATUS_DIBAYAR;
                $pesanan->tgl_verifikasi = now();
                $pesanan->id_verifikator = $petaniId;
                $pesanan->save();

                // 3. Create escrow (only for items owned by this petani)
                $jumlahEscrow = $pesanan->items->sum('subtotal');
                
                Escrow::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'jumlah' => $jumlahEscrow,
                    'status_escrow' => Escrow::STATUS_DITAHAN,
                    'tgl_ditahan' => now(),
                ]);
            });

            $pesanan->refresh()->load('escrow');

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diverifikasi. Dana ditahan di escrow. Silakan proses pesanan.',
                'data' => [
                    'id_pesanan' => $pesanan->id_pesanan,
                    'status' => $pesanan->status_pesanan,
                    'tgl_verifikasi' => $pesanan->tgl_verifikasi->toIso8601String(),
                    'escrow' => [
                        'jumlah' => (float) $pesanan->escrow->jumlah,
                        'status' => $pesanan->escrow->status_escrow,
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memverifikasi pembayaran.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Reject payment
     * POST /api/v1/petani/pesanan/{id}/tolak
     * 
     * @bodyParam alasan string required Alasan penolakan.
     */
    public function tolak(Request $request, int $id): JsonResponse
    {
        $petaniId = Auth::id();

        $pesanan = Pesanan::with(['items' => function ($q) use ($petaniId) {
            $q->where('id_petani', $petaniId)->with('produk');
        }])
            ->whereHas('items', function ($q) use ($petaniId) {
                $q->where('id_petani', $petaniId);
            })
            ->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        // Check if can reject
        if (!$pesanan->bisaDiverifikasi()) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak dapat ditolak. Status harus "menunggu_verifikasi".',
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'alasan' => 'required|string|max:500',
        ], [
            'alasan.required' => 'Alasan penolakan wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::transaction(function () use ($pesanan, $request) {
                // 1. Release reserved stock
                foreach ($pesanan->items as $item) {
                    if ($item->produk) {
                        $item->produk->releaseStok($item->jumlah);
                    }
                }

                // 2. Update pesanan status
                $pesanan->status_pesanan = Pesanan::STATUS_DIBATALKAN;
                $pesanan->alasan_tolak = $request->alasan;
                $pesanan->tgl_dibatalkan = now();
                $pesanan->save();
            });

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran ditolak. Stok telah dikembalikan.',
                'data' => [
                    'id_pesanan' => $pesanan->id_pesanan,
                    'status' => $pesanan->status_pesanan,
                    'alasan_tolak' => $pesanan->alasan_tolak,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak pembayaran.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Mark order as processing
     * POST /api/v1/petani/pesanan/{id}/proses
     */
    public function proses(int $id): JsonResponse
    {
        $petaniId = Auth::id();

        $pesanan = Pesanan::whereHas('items', function ($q) use ($petaniId) {
            $q->where('id_petani', $petaniId);
        })->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        // Check if can process
        if ($pesanan->status_pesanan !== Pesanan::STATUS_DIBAYAR) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak dapat diproses. Status harus "dibayar".',
            ], 400);
        }

        $pesanan->status_pesanan = Pesanan::STATUS_DIPROSES;
        $pesanan->save();

        return response()->json([
            'success' => true,
            'message' => 'Pesanan sedang diproses. Segera kirim pesanan dan input nomor resi.',
            'data' => [
                'id_pesanan' => $pesanan->id_pesanan,
                'status' => $pesanan->status_pesanan,
            ],
        ]);
    }

    /**
     * Ship order (with resi number)
     * POST /api/v1/petani/pesanan/{id}/kirim
     * 
     * @bodyParam no_resi string required Nomor resi pengiriman.
     */
    public function kirim(Request $request, int $id): JsonResponse
    {
        $petaniId = Auth::id();

        $pesanan = Pesanan::whereHas('items', function ($q) use ($petaniId) {
            $q->where('id_petani', $petaniId);
        })->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        // Check if can ship
        if (!in_array($pesanan->status_pesanan, [Pesanan::STATUS_DIBAYAR, Pesanan::STATUS_DIPROSES])) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak dapat dikirim. Status harus "dibayar" atau "diproses".',
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'no_resi' => 'required|string|max:100',
        ], [
            'no_resi.required' => 'Nomor resi wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $pesanan->status_pesanan = Pesanan::STATUS_DIKIRIM;
        $pesanan->no_resi = $request->no_resi;
        $pesanan->save();

        return response()->json([
            'success' => true,
            'message' => 'Pesanan telah dikirim. Menunggu konfirmasi penerimaan dari pembeli.',
            'data' => [
                'id_pesanan' => $pesanan->id_pesanan,
                'status' => $pesanan->status_pesanan,
                'no_resi' => $pesanan->no_resi,
            ],
        ]);
    }

    /**
     * Mark order as delivered (terkirim)
     * POST /api/v1/petani/pesanan/{id}/terkirim
     */
    public function terkirim(int $id): JsonResponse
    {
        $petaniId = Auth::id();

        $pesanan = Pesanan::whereHas('items', function ($q) use ($petaniId) {
            $q->where('id_petani', $petaniId);
        })->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        // Check if can mark as delivered
        if ($pesanan->status_pesanan !== Pesanan::STATUS_DIKIRIM) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan belum dikirim.',
            ], 400);
        }

        $pesanan->status_pesanan = Pesanan::STATUS_TERKIRIM;
        $pesanan->save();

        return response()->json([
            'success' => true,
            'message' => 'Pesanan ditandai sudah terkirim. Menunggu konfirmasi dari pembeli.',
            'data' => [
                'id_pesanan' => $pesanan->id_pesanan,
                'status' => $pesanan->status_pesanan,
            ],
        ]);
    }

    /**
     * Transform pesanan for response
     */
    private function transformPesanan(Pesanan $pesanan, bool $detailed = false): array
    {
        $data = [
            'id' => $pesanan->id_pesanan,
            'status' => $pesanan->status_pesanan,
            'pembeli' => $pesanan->pembeli ? [
                'id' => $pesanan->pembeli->id_pengguna,
                'nama' => $pesanan->pembeli->nama_lengkap,
                'no_hp' => $pesanan->pembeli->no_hp,
            ] : null,
            'kota_tujuan' => $pesanan->kota ? [
                'id' => $pesanan->kota->id_kota,
                'nama' => $pesanan->kota->nama_kota,
                'provinsi' => $pesanan->kota->provinsi,
            ] : null,
            'total_bayar' => (float) $pesanan->total_bayar,
            'total_formatted' => 'Rp ' . number_format((float) $pesanan->total_bayar, 0, ',', '.'),
            'bukti_bayar' => $pesanan->bukti_bayar ? asset('storage/bukti-bayar/' . $pesanan->bukti_bayar) : null,
            'catatan' => $pesanan->catatan,
            'tgl_dibuat' => $pesanan->tgl_dibuat?->toIso8601String(),
        ];

        // Items for this petani
        if ($pesanan->relationLoaded('items')) {
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
            $data['subtotal_petani'] = (float) $pesanan->items->sum('subtotal');
        }

        // Detailed info
        if ($detailed) {
            $data['pembeli']['email'] = $pesanan->pembeli?->email;
            $data['pembeli']['alamat'] = $pesanan->pembeli?->alamat;
            
            $data['subtotal'] = (float) $pesanan->subtotal;
            $data['ongkir'] = (float) $pesanan->ongkir;
            $data['diskon'] = (float) $pesanan->diskon;
            $data['no_resi'] = $pesanan->no_resi;
            $data['tgl_verifikasi'] = $pesanan->tgl_verifikasi?->toIso8601String();

            // Escrow info
            if ($pesanan->relationLoaded('escrow') && $pesanan->escrow) {
                $data['escrow'] = [
                    'jumlah' => (float) $pesanan->escrow->jumlah,
                    'status' => $pesanan->escrow->status_escrow,
                    'tgl_ditahan' => $pesanan->escrow->tgl_ditahan?->toIso8601String(),
                    'tgl_kirim' => $pesanan->escrow->tgl_kirim?->toIso8601String(),
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
        }

        return $data;
    }
}
