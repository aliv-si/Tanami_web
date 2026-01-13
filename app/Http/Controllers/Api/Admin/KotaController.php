<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class KotaController extends Controller
{
    /**
     * Get all cities
     * GET /api/v1/admin/kota
     */
    public function index(Request $request): JsonResponse
    {
        $query = Kota::withCount('pesanan')->orderBy('provinsi')->orderBy('nama_kota');

        // Search
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('nama_kota', 'like', "%{$search}%")
                  ->orWhere('provinsi', 'like', "%{$search}%");
            });
        }

        // Filter by province
        if ($request->filled('provinsi')) {
            $query->where('provinsi', $request->provinsi);
        }

        // Filter by status
        if ($request->filled('is_aktif')) {
            $query->where('is_aktif', $request->boolean('is_aktif'));
        }

        $kota = $query->get()->map(function ($item) {
            return $this->transformKota($item);
        });

        // Get provinces for filter
        $provinsi = Kota::distinct()->pluck('provinsi')->sort()->values();

        return response()->json([
            'success' => true,
            'message' => 'Daftar kota berhasil diambil.',
            'data' => [
                'kota' => $kota,
                'provinsi' => $provinsi,
            ],
        ]);
    }

    /**
     * Create city
     * POST /api/v1/admin/kota
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'ongkir' => 'required|numeric|min:0',
            'is_aktif' => 'boolean',
        ], [
            'nama_kota.required' => 'Nama kota wajib diisi.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'ongkir.required' => 'Ongkir wajib diisi.',
            'ongkir.min' => 'Ongkir tidak boleh negatif.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check duplicate
        $exists = Kota::where('nama_kota', $request->nama_kota)
            ->where('provinsi', $request->provinsi)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Kota dengan nama dan provinsi tersebut sudah ada.',
            ], 400);
        }

        $kota = Kota::create([
            'nama_kota' => $request->nama_kota,
            'provinsi' => $request->provinsi,
            'ongkir' => $request->ongkir,
            'is_aktif' => $request->boolean('is_aktif', true),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kota berhasil ditambahkan.',
            'data' => $this->transformKota($kota),
        ], 201);
    }

    /**
     * Get city detail
     * GET /api/v1/admin/kota/{id}
     */
    public function show(int $id): JsonResponse
    {
        $kota = Kota::withCount('pesanan')->find($id);

        if (!$kota) {
            return response()->json([
                'success' => false,
                'message' => 'Kota tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail kota berhasil diambil.',
            'data' => $this->transformKota($kota),
        ]);
    }

    /**
     * Update city
     * PUT /api/v1/admin/kota/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $kota = Kota::find($id);

        if (!$kota) {
            return response()->json([
                'success' => false,
                'message' => 'Kota tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_kota' => 'sometimes|required|string|max:100',
            'provinsi' => 'sometimes|required|string|max:100',
            'ongkir' => 'sometimes|required|numeric|min:0',
            'is_aktif' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $kota->fill($request->only(['nama_kota', 'provinsi', 'ongkir', 'is_aktif']));
        $kota->save();

        return response()->json([
            'success' => true,
            'message' => 'Kota berhasil diperbarui.',
            'data' => $this->transformKota($kota),
        ]);
    }

    /**
     * Delete city
     * DELETE /api/v1/admin/kota/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $kota = Kota::withCount('pesanan')->find($id);

        if (!$kota) {
            return response()->json([
                'success' => false,
                'message' => 'Kota tidak ditemukan.',
            ], 404);
        }

        if ($kota->pesanan_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus kota yang memiliki pesanan. Nonaktifkan saja.',
            ], 400);
        }

        $kota->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kota berhasil dihapus.',
        ]);
    }

    private function transformKota(Kota $kota): array
    {
        return [
            'id' => $kota->id_kota,
            'nama' => $kota->nama_kota,
            'provinsi' => $kota->provinsi,
            'ongkir' => (float) $kota->ongkir,
            'ongkir_formatted' => 'Rp ' . number_format((float) $kota->ongkir, 0, ',', '.'),
            'is_aktif' => $kota->is_aktif,
            'jumlah_pesanan' => $kota->pesanan_count ?? 0,
            'tgl_dibuat' => $kota->tgl_dibuat?->toIso8601String(),
        ];
    }
}
