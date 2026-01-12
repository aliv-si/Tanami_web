<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PenggunaController extends Controller
{
    /**
     * Get all users
     * GET /api/v1/admin/pengguna
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pengguna::query()->orderByDesc('tgl_daftar');

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role_pengguna', $request->role);
        }

        // Filter by verification status (for petani)
        if ($request->filled('is_verified')) {
            $query->where('is_verified', $request->boolean('is_verified'));
        }

        // Search by name or email
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $perPage = min((int) $request->input('per_page', 15), 50);
        $pengguna = $query->paginate($perPage);

        // Transform data
        $pengguna->getCollection()->transform(function ($item) {
            return $this->transformPengguna($item);
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar pengguna berhasil diambil.',
            'data' => $pengguna,
        ]);
    }

    /**
     * Get user detail
     * GET /api/v1/admin/pengguna/{id}
     */
    public function show(int $id): JsonResponse
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan.',
            ], 404);
        }

        // Load additional data based on role
        $additionalData = [];

        if ($pengguna->isPetani()) {
            $pengguna->loadCount(['produk', 'rekening']);
            $additionalData['produk'] = $pengguna->produk()
                ->select('id_produk', 'nama_produk', 'harga', 'stok', 'is_aktif')
                ->limit(10)
                ->get();
        } elseif ($pengguna->isPembeli()) {
            $pengguna->loadCount(['pesanan', 'ulasan']);
            $additionalData['pesanan_terbaru'] = $pengguna->pesanan()
                ->select('id_pesanan', 'total_bayar', 'status_pesanan', 'tgl_dibuat')
                ->orderByDesc('tgl_dibuat')
                ->limit(10)
                ->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pengguna berhasil diambil.',
            'data' => array_merge($this->transformPengguna($pengguna, true), $additionalData),
        ]);
    }

    /**
     * Update user
     * PUT /api/v1/admin/pengguna/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan.',
            ], 404);
        }

        // Prevent modifying own account or other admins
        if ($pengguna->id_pengguna === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat mengubah akun sendiri melalui endpoint ini.',
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:pengguna,email,' . $id . ',id_pengguna',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'role_pengguna' => 'sometimes|in:admin,petani,pembeli',
            'is_verified' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $pengguna->fill($request->only([
            'nama_lengkap', 'email', 'no_hp', 'alamat', 'role_pengguna', 'is_verified'
        ]));
        $pengguna->save();

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil diperbarui.',
            'data' => $this->transformPengguna($pengguna),
        ]);
    }

    /**
     * Verify farmer account
     * POST /api/v1/admin/pengguna/{id}/verify
     */
    public function verify(int $id): JsonResponse
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan.',
            ], 404);
        }

        if (!$pengguna->isPetani()) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi hanya berlaku untuk akun petani.',
            ], 400);
        }

        if ($pengguna->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Akun petani sudah terverifikasi.',
            ], 400);
        }

        $pengguna->is_verified = true;
        $pengguna->save();

        return response()->json([
            'success' => true,
            'message' => 'Akun petani berhasil diverifikasi.',
            'data' => $this->transformPengguna($pengguna),
        ]);
    }

    /**
     * Delete (soft delete) user
     * DELETE /api/v1/admin/pengguna/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan.',
            ], 404);
        }

        // Prevent deleting own account
        if ($pengguna->id_pengguna === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus akun sendiri.',
            ], 400);
        }

        // Prevent deleting if has active orders
        $activeOrders = Pesanan::where('id_pembeli', $id)
            ->whereNotIn('status_pesanan', [
                Pesanan::STATUS_SELESAI,
                Pesanan::STATUS_DIBATALKAN,
                Pesanan::STATUS_DIREFUND,
            ])
            ->count();

        if ($activeOrders > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus pengguna dengan pesanan aktif.',
            ], 400);
        }

        // Soft delete by setting email to deleted format
        $pengguna->email = 'deleted_' . $pengguna->id_pengguna . '_' . $pengguna->email;
        $pengguna->is_verified = false;
        $pengguna->save();
        $pengguna->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil dihapus.',
        ]);
    }

    /**
     * Transform pengguna for response
     */
    private function transformPengguna(Pengguna $pengguna, bool $detailed = false): array
    {
        $data = [
            'id' => $pengguna->id_pengguna,
            'nama_lengkap' => $pengguna->nama_lengkap,
            'email' => $pengguna->email,
            'role' => $pengguna->role_pengguna,
            'is_verified' => $pengguna->is_verified,
            'tgl_daftar' => $pengguna->tgl_daftar?->toIso8601String(),
        ];

        if ($detailed) {
            $data['no_hp'] = $pengguna->no_hp;
            $data['alamat'] = $pengguna->alamat;
            
            if ($pengguna->isPetani()) {
                $data['total_produk'] = $pengguna->produk_count ?? 0;
                $data['total_rekening'] = $pengguna->rekening_count ?? 0;
            } elseif ($pengguna->isPembeli()) {
                $data['total_pesanan'] = $pengguna->pesanan_count ?? 0;
                $data['total_ulasan'] = $pengguna->ulasan_count ?? 0;
            }
        }

        return $data;
    }
}
