<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kupon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KuponController extends Controller
{
    /**
     * Get all coupons
     * GET /api/v1/admin/kupon
     */
    public function index(Request $request): JsonResponse
    {
        $query = Kupon::withCount('pemakaian')->orderByDesc('tgl_dibuat');

        // Search by code
        if ($request->filled('q')) {
            $query->where('kode_kupon', 'like', '%' . $request->input('q') . '%');
        }

        // Filter by active status
        if ($request->filled('is_aktif')) {
            $query->where('is_aktif', $request->boolean('is_aktif'));
        }

        // Filter by validity
        if ($request->filled('status')) {
            switch ($request->input('status')) {
                case 'valid':
                    $query->valid();
                    break;
                case 'expired':
                    $query->where('tgl_selesai', '<', now());
                    break;
                case 'upcoming':
                    $query->where('tgl_mulai', '>', now());
                    break;
            }
        }

        $kupon = $query->get()->map(function ($item) {
            return $this->transformKupon($item);
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar kupon berhasil diambil.',
            'data' => $kupon,
        ]);
    }

    /**
     * Create coupon
     * POST /api/v1/admin/kupon
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'kode_kupon' => 'required|string|max:50|unique:kupon,kode_kupon',
            'tipe_diskon' => 'required|in:nominal,persen',
            'nominal_diskon' => 'required_if:tipe_diskon,nominal|nullable|numeric|min:0',
            'persen_diskon' => 'required_if:tipe_diskon,persen|nullable|numeric|min:0|max:100',
            'min_belanja' => 'required|numeric|min:0',
            'limit_total' => 'nullable|integer|min:1',
            'limit_per_user' => 'nullable|integer|min:1',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'is_aktif' => 'boolean',
        ], [
            'kode_kupon.required' => 'Kode kupon wajib diisi.',
            'kode_kupon.unique' => 'Kode kupon sudah ada.',
            'tipe_diskon.required' => 'Tipe diskon wajib dipilih.',
            'tipe_diskon.in' => 'Tipe diskon harus nominal atau persen.',
            'nominal_diskon.required_if' => 'Nominal diskon wajib diisi untuk tipe nominal.',
            'persen_diskon.required_if' => 'Persen diskon wajib diisi untuk tipe persen.',
            'persen_diskon.max' => 'Persen diskon maksimal 100%.',
            'min_belanja.required' => 'Minimum belanja wajib diisi.',
            'tgl_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tgl_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tgl_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $kupon = Kupon::create([
            'kode_kupon' => strtoupper($request->kode_kupon),
            'tipe_diskon' => $request->tipe_diskon,
            'nominal_diskon' => $request->tipe_diskon === 'nominal' ? $request->nominal_diskon : null,
            'persen_diskon' => $request->tipe_diskon === 'persen' ? $request->persen_diskon : null,
            'min_belanja' => $request->min_belanja,
            'limit_total' => $request->limit_total,
            'limit_per_user' => $request->limit_per_user,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'is_aktif' => $request->boolean('is_aktif', true),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil ditambahkan.',
            'data' => $this->transformKupon($kupon),
        ], 201);
    }

    /**
     * Get coupon detail
     * GET /api/v1/admin/kupon/{id}
     */
    public function show(int $id): JsonResponse
    {
        $kupon = Kupon::withCount('pemakaian')->find($id);

        if (!$kupon) {
            return response()->json([
                'success' => false,
                'message' => 'Kupon tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail kupon berhasil diambil.',
            'data' => $this->transformKupon($kupon),
        ]);
    }

    /**
     * Update coupon
     * PUT /api/v1/admin/kupon/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $kupon = Kupon::find($id);

        if (!$kupon) {
            return response()->json([
                'success' => false,
                'message' => 'Kupon tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kode_kupon' => 'sometimes|required|string|max:50|unique:kupon,kode_kupon,' . $id . ',id_kupon',
            'tipe_diskon' => 'sometimes|in:nominal,persen',
            'nominal_diskon' => 'nullable|numeric|min:0',
            'persen_diskon' => 'nullable|numeric|min:0|max:100',
            'min_belanja' => 'sometimes|numeric|min:0',
            'limit_total' => 'nullable|integer|min:1',
            'limit_per_user' => 'nullable|integer|min:1',
            'tgl_mulai' => 'sometimes|date',
            'tgl_selesai' => 'sometimes|date',
            'is_aktif' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->has('kode_kupon')) {
            $kupon->kode_kupon = strtoupper($request->kode_kupon);
        }
        
        $kupon->fill($request->only([
            'tipe_diskon', 'nominal_diskon', 'persen_diskon', 'min_belanja',
            'limit_total', 'limit_per_user', 'tgl_mulai', 'tgl_selesai', 'is_aktif'
        ]));
        $kupon->save();

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil diperbarui.',
            'data' => $this->transformKupon($kupon),
        ]);
    }

    /**
     * Delete coupon
     * DELETE /api/v1/admin/kupon/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $kupon = Kupon::withCount('pemakaian')->find($id);

        if (!$kupon) {
            return response()->json([
                'success' => false,
                'message' => 'Kupon tidak ditemukan.',
            ], 404);
        }

        if ($kupon->pemakaian_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus kupon yang sudah pernah digunakan. Nonaktifkan saja.',
            ], 400);
        }

        $kupon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil dihapus.',
        ]);
    }

    private function transformKupon(Kupon $kupon): array
    {
        $status = 'inactive';
        if ($kupon->is_aktif) {
            if ($kupon->tgl_selesai < now()) {
                $status = 'expired';
            } elseif ($kupon->tgl_mulai > now()) {
                $status = 'upcoming';
            } else {
                $status = 'valid';
            }
        }

        return [
            'id' => $kupon->id_kupon,
            'kode' => $kupon->kode_kupon,
            'tipe_diskon' => $kupon->tipe_diskon,
            'nominal_diskon' => $kupon->tipe_diskon === 'nominal' ? (float) $kupon->nominal_diskon : null,
            'persen_diskon' => $kupon->tipe_diskon === 'persen' ? (float) $kupon->persen_diskon : null,
            'diskon_display' => $kupon->tipe_diskon === 'nominal'
                ? 'Rp ' . number_format((float) $kupon->nominal_diskon, 0, ',', '.')
                : $kupon->persen_diskon . '%',
            'min_belanja' => (float) $kupon->min_belanja,
            'min_belanja_formatted' => 'Rp ' . number_format((float) $kupon->min_belanja, 0, ',', '.'),
            'limit_total' => $kupon->limit_total,
            'limit_per_user' => $kupon->limit_per_user,
            'tgl_mulai' => $kupon->tgl_mulai?->toIso8601String(),
            'tgl_selesai' => $kupon->tgl_selesai?->toIso8601String(),
            'is_aktif' => $kupon->is_aktif,
            'status' => $status,
            'total_pemakaian' => $kupon->pemakaian_count ?? 0,
            'tgl_dibuat' => $kupon->tgl_dibuat?->toIso8601String(),
        ];
    }
}
