<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kupon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KuponController extends Controller
{
    /**
     * Validate coupon code
     * POST /api/v1/kupon/validasi
     * 
     * @bodyParam kode_kupon string required Kode kupon yang akan divalidasi.
     * @bodyParam subtotal number optional Subtotal belanja untuk menghitung diskon.
     */
    public function validasi(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'kode_kupon' => 'required|string|max:50',
            'subtotal' => 'nullable|numeric|min:0',
        ], [
            'kode_kupon.required' => 'Kode kupon wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $kupon = Kupon::where('kode_kupon', strtoupper($request->kode_kupon))->first();

        // Check if coupon exists
        if (!$kupon) {
            return response()->json([
                'success' => false,
                'message' => 'Kode kupon tidak ditemukan.',
            ], 404);
        }

        // Check if coupon is active
        if (!$kupon->is_aktif) {
            return response()->json([
                'success' => false,
                'message' => 'Kupon sudah tidak aktif.',
            ], 400);
        }

        // Check validity period
        if (!$kupon->isValid()) {
            if ($kupon->tgl_mulai > now()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kupon belum berlaku. Berlaku mulai ' . $kupon->tgl_mulai->format('d M Y'),
                ], 400);
            }
            return response()->json([
                'success' => false,
                'message' => 'Kupon sudah kadaluarsa.',
            ], 400);
        }

        // Check total usage limit
        if ($kupon->limit_total !== null) {
            $totalPemakaian = $kupon->pemakaian()->count();
            if ($totalPemakaian >= $kupon->limit_total) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kupon sudah habis digunakan.',
                ], 400);
            }
        }

        // Check per-user limit (if authenticated)
        if (Auth::check() && $kupon->limit_per_user !== null) {
            $userPemakaian = $kupon->pemakaian()
                ->where('id_pengguna', Auth::id())
                ->count();
            if ($userPemakaian >= $kupon->limit_per_user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mencapai batas pemakaian kupon ini.',
                ], 400);
            }
        }

        // Calculate discount if subtotal provided
        $subtotal = $request->input('subtotal', 0);
        $diskon = 0;
        $eligible = true;
        $message = 'Kupon valid dan dapat digunakan.';

        if ($subtotal > 0) {
            if ($subtotal < $kupon->min_belanja) {
                $eligible = false;
                $message = 'Minimum belanja Rp ' . number_format((float) $kupon->min_belanja, 0, ',', '.') . ' untuk menggunakan kupon ini.';
            } else {
                $diskon = $kupon->hitungDiskon($subtotal);
            }
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'kode' => $kupon->kode_kupon,
                'tipe' => $kupon->tipe_diskon,
                'nominal_diskon' => $kupon->tipe_diskon === 'nominal' ? (float) $kupon->nominal_diskon : null,
                'persen_diskon' => $kupon->tipe_diskon === 'persen' ? (float) $kupon->persen_diskon : null,
                'min_belanja' => (float) $kupon->min_belanja,
                'min_belanja_formatted' => 'Rp ' . number_format((float) $kupon->min_belanja, 0, ',', '.'),
                'berlaku_sampai' => $kupon->tgl_selesai->format('d M Y'),
                'eligible' => $eligible,
                'diskon' => (float) $diskon,
                'diskon_formatted' => 'Rp ' . number_format((float) $diskon, 0, ',', '.'),
            ],
        ]);
    }
}
