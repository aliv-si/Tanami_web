<?php

namespace App\Http\Controllers\Api\Petani;

use App\Http\Controllers\Controller;
use App\Models\RekeningPetani;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RekeningController extends Controller
{
    /**
     * Get farmer's bank accounts
     * GET /api/v1/petani/rekening
     */
    public function index(Request $request): JsonResponse
    {
        $rekening = RekeningPetani::where('id_petani', Auth::id())
            ->orderByDesc('is_utama')
            ->orderBy('nama_bank')
            ->get()
            ->map(function ($item) {
                return $this->transformRekening($item);
            });

        return response()->json([
            'success' => true,
            'message' => 'Daftar rekening berhasil diambil.',
            'data' => $rekening,
        ]);
    }

    /**
     * Add new bank account
     * POST /api/v1/petani/rekening
     * 
     * @bodyParam nama_bank string required Nama bank. Example: BCA
     * @bodyParam no_rekening string required Nomor rekening. Example: 1234567890
     * @bodyParam atas_nama string required Nama pemilik rekening. Example: John Doe
     * @bodyParam is_utama boolean optional Set sebagai rekening utama.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_bank' => 'required|string|max:50',
            'no_rekening' => 'required|string|max:30',
            'atas_nama' => 'required|string|max:100',
            'is_utama' => 'boolean',
        ], [
            'nama_bank.required' => 'Nama bank wajib diisi.',
            'no_rekening.required' => 'Nomor rekening wajib diisi.',
            'atas_nama.required' => 'Nama pemilik rekening wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check duplicate no_rekening for this petani
        $exists = RekeningPetani::where('id_petani', Auth::id())
            ->where('no_rekening', $request->no_rekening)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor rekening sudah terdaftar.',
            ], 400);
        }

        try {
            $rekening = DB::transaction(function () use ($request) {
                $isUtama = $request->boolean('is_utama', false);

                // If setting as primary, unset other primary accounts
                if ($isUtama) {
                    RekeningPetani::where('id_petani', Auth::id())
                        ->where('is_utama', true)
                        ->update(['is_utama' => false]);
                }

                // If this is the first account, make it primary
                $count = RekeningPetani::where('id_petani', Auth::id())->count();
                if ($count === 0) {
                    $isUtama = true;
                }

                return RekeningPetani::create([
                    'id_petani' => Auth::id(),
                    'nama_bank' => $request->nama_bank,
                    'no_rekening' => $request->no_rekening,
                    'atas_nama' => $request->atas_nama,
                    'is_utama' => $isUtama,
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Rekening berhasil ditambahkan.',
                'data' => $this->transformRekening($rekening),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan rekening.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Update bank account
     * PUT /api/v1/petani/rekening/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $rekening = RekeningPetani::where('id_petani', Auth::id())->find($id);

        if (!$rekening) {
            return response()->json([
                'success' => false,
                'message' => 'Rekening tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_bank' => 'sometimes|required|string|max:50',
            'no_rekening' => 'sometimes|required|string|max:30',
            'atas_nama' => 'sometimes|required|string|max:100',
        ], [
            'nama_bank.required' => 'Nama bank tidak boleh kosong.',
            'no_rekening.required' => 'Nomor rekening tidak boleh kosong.',
            'atas_nama.required' => 'Nama pemilik rekening tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check duplicate no_rekening if changing
        if ($request->has('no_rekening') && $request->no_rekening !== $rekening->no_rekening) {
            $exists = RekeningPetani::where('id_petani', Auth::id())
                ->where('no_rekening', $request->no_rekening)
                ->where('id_rekening', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor rekening sudah terdaftar.',
                ], 400);
            }
        }

        $rekening->fill($request->only(['nama_bank', 'no_rekening', 'atas_nama']));
        $rekening->save();

        return response()->json([
            'success' => true,
            'message' => 'Rekening berhasil diperbarui.',
            'data' => $this->transformRekening($rekening),
        ]);
    }

    /**
     * Delete bank account
     * DELETE /api/v1/petani/rekening/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $rekening = RekeningPetani::where('id_petani', Auth::id())->find($id);

        if (!$rekening) {
            return response()->json([
                'success' => false,
                'message' => 'Rekening tidak ditemukan.',
            ], 404);
        }

        // Don't allow deletion of primary account if there are other accounts
        if ($rekening->is_utama) {
            $otherCount = RekeningPetani::where('id_petani', Auth::id())
                ->where('id_rekening', '!=', $id)
                ->count();

            if ($otherCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus rekening utama. Pilih rekening lain sebagai utama terlebih dahulu.',
                ], 400);
            }
        }

        $rekening->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rekening berhasil dihapus.',
        ]);
    }

    /**
     * Set as primary bank account
     * POST /api/v1/petani/rekening/{id}/utama
     */
    public function setUtama(int $id): JsonResponse
    {
        $rekening = RekeningPetani::where('id_petani', Auth::id())->find($id);

        if (!$rekening) {
            return response()->json([
                'success' => false,
                'message' => 'Rekening tidak ditemukan.',
            ], 404);
        }

        if ($rekening->is_utama) {
            return response()->json([
                'success' => false,
                'message' => 'Rekening ini sudah menjadi rekening utama.',
            ], 400);
        }

        try {
            DB::transaction(function () use ($rekening) {
                // Unset current primary
                RekeningPetani::where('id_petani', Auth::id())
                    ->where('is_utama', true)
                    ->update(['is_utama' => false]);

                // Set new primary
                $rekening->is_utama = true;
                $rekening->save();
            });

            return response()->json([
                'success' => true,
                'message' => 'Rekening berhasil dijadikan rekening utama.',
                'data' => $this->transformRekening($rekening->fresh()),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah rekening utama.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Transform rekening for response
     */
    private function transformRekening(RekeningPetani $rekening): array
    {
        return [
            'id' => $rekening->id_rekening,
            'nama_bank' => $rekening->nama_bank,
            'no_rekening' => $rekening->no_rekening,
            'atas_nama' => $rekening->atas_nama,
            'is_utama' => $rekening->is_utama,
            'tgl_dibuat' => $rekening->tgl_dibuat?->toIso8601String(),
        ];
    }
}
