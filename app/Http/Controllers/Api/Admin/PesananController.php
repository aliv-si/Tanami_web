<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoriStatus;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PesananController extends Controller
{
    /**
     * Get all orders (admin view)
     * GET /api/v1/admin/pesanan
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pesanan::with([
            'pembeli:id_pengguna,nama_lengkap,email',
            'kota:id_kota,nama_kota,provinsi',
        ])->orderByDesc('tgl_dibuat');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_pesanan', $request->status);
        }

        // Filter by pembeli
        if ($request->filled('id_pembeli')) {
            $query->where('id_pembeli', $request->id_pembeli);
        }

        // Filter by date range
        if ($request->filled('dari')) {
            $query->whereDate('tgl_dibuat', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tgl_dibuat', '<=', $request->sampai);
        }

        // Search by order ID
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('id_pesanan', 'like', "%{$search}%")
                  ->orWhereHas('pembeli', function ($q2) use ($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $perPage = min((int) $request->input('per_page', 15), 50);
        $pesanan = $query->paginate($perPage);

        // Transform data
        $pesanan->getCollection()->transform(function ($item) {
            return $this->transformPesanan($item);
        });

        // Status counts for quick filter
        $statusCounts = Pesanan::selectRaw('status_pesanan, COUNT(*) as total')
            ->groupBy('status_pesanan')
            ->pluck('total', 'status_pesanan');

        return response()->json([
            'success' => true,
            'message' => 'Daftar pesanan berhasil diambil.',
            'data' => [
                'status_counts' => $statusCounts,
                'pesanan' => $pesanan,
            ],
        ]);
    }

    /**
     * Get order detail
     * GET /api/v1/admin/pesanan/{id}
     */
    public function show(int $id): JsonResponse
    {
        $pesanan = Pesanan::with([
            'pembeli',
            'kota',
            'items.produk.petani:id_pengguna,nama_lengkap',
            'escrow.penerima:id_pengguna,nama_lengkap',
            'historiStatus.pengubah:id_pengguna,nama_lengkap',
            'pemakaianKupon.kupon',
        ])->find($id);

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
     * Get order status history
     * GET /api/v1/admin/pesanan/{id}/histori
     */
    public function histori(int $id): JsonResponse
    {
        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        $histori = HistoriStatus::with('pengubah:id_pengguna,nama_lengkap,role_pengguna')
            ->where('id_pesanan', $id)
            ->orderBy('tgl_dibuat')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id_histori,
                    'status_lama' => $item->status_lama,
                    'status_baru' => $item->status_baru,
                    'alasan' => $item->alasan,
                    'pengubah' => $item->pengubah ? [
                        'id' => $item->pengubah->id_pengguna,
                        'nama' => $item->pengubah->nama_lengkap,
                        'role' => $item->pengubah->role_pengguna,
                    ] : ['nama' => 'System', 'role' => 'system'],
                    'tgl_dibuat' => $item->tgl_dibuat?->toIso8601String(),
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Histori status pesanan berhasil diambil.',
            'data' => [
                'pesanan' => [
                    'id' => $pesanan->id_pesanan,
                    'status_saat_ini' => $pesanan->status_pesanan,
                ],
                'histori' => $histori,
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
                'email' => $pesanan->pembeli->email,
            ] : null,
            'kota' => $pesanan->kota ? [
                'id' => $pesanan->kota->id_kota,
                'nama' => $pesanan->kota->nama_kota,
                'provinsi' => $pesanan->kota->provinsi,
            ] : null,
            'subtotal' => (float) $pesanan->subtotal,
            'ongkir' => (float) $pesanan->ongkir,
            'diskon' => (float) $pesanan->diskon,
            'total_bayar' => (float) $pesanan->total_bayar,
            'total_formatted' => 'Rp ' . number_format((float) $pesanan->total_bayar, 0, ',', '.'),
            'tgl_dibuat' => $pesanan->tgl_dibuat?->toIso8601String(),
        ];

        if ($detailed) {
            $data['pembeli']['no_hp'] = $pesanan->pembeli?->no_hp;
            $data['pembeli']['alamat'] = $pesanan->pembeli?->alamat;
            
            $data['bukti_bayar'] = $pesanan->bukti_bayar 
                ? asset('storage/bukti-bayar/' . $pesanan->bukti_bayar) 
                : null;
            $data['no_resi'] = $pesanan->no_resi;
            $data['catatan'] = $pesanan->catatan;
            $data['batas_bayar'] = $pesanan->batas_bayar?->toIso8601String();
            $data['tgl_verifikasi'] = $pesanan->tgl_verifikasi?->toIso8601String();
            $data['tgl_selesai'] = $pesanan->tgl_selesai?->toIso8601String();
            $data['tgl_dibatalkan'] = $pesanan->tgl_dibatalkan?->toIso8601String();
            $data['alasan_batal'] = $pesanan->alasan_batal;
            $data['alasan_tolak'] = $pesanan->alasan_tolak;
            $data['alasan_refund'] = $pesanan->alasan_refund;

            // Items
            if ($pesanan->relationLoaded('items')) {
                $data['items'] = $pesanan->items->map(function ($item) {
                    return [
                        'id' => $item->id_item,
                        'produk' => $item->produk ? [
                            'id' => $item->produk->id_produk,
                            'nama' => $item->produk->nama_produk,
                            'petani' => $item->produk->petani?->nama_lengkap,
                        ] : null,
                        'jumlah' => $item->jumlah,
                        'harga' => (float) $item->harga_snapshot,
                        'subtotal' => (float) $item->subtotal,
                    ];
                });
            }

            // Escrow
            if ($pesanan->relationLoaded('escrow') && $pesanan->escrow) {
                $data['escrow'] = [
                    'id' => $pesanan->escrow->id_escrow,
                    'jumlah' => (float) $pesanan->escrow->jumlah,
                    'status' => $pesanan->escrow->status_escrow,
                    'penerima' => $pesanan->escrow->penerima?->nama_lengkap,
                    'tgl_ditahan' => $pesanan->escrow->tgl_ditahan?->toIso8601String(),
                    'tgl_kirim' => $pesanan->escrow->tgl_kirim?->toIso8601String(),
                ];
            }

            // Kupon
            if ($pesanan->relationLoaded('pemakaianKupon') && $pesanan->pemakaianKupon) {
                $data['kupon'] = [
                    'kode' => $pesanan->pemakaianKupon->kupon?->kode_kupon,
                    'diskon' => (float) $pesanan->pemakaianKupon->diskon_dipakai,
                ];
            }

            // Histori status
            if ($pesanan->relationLoaded('historiStatus')) {
                $data['histori'] = $pesanan->historiStatus->map(function ($h) {
                    return [
                        'status_lama' => $h->status_lama,
                        'status_baru' => $h->status_baru,
                        'alasan' => $h->alasan,
                        'pengubah' => $h->pengubah?->nama_lengkap ?? 'System',
                        'tgl' => $h->tgl_dibuat?->toIso8601String(),
                    ];
                });
            }
        }

        return $data;
    }
}
