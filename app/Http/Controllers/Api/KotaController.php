<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KotaController extends Controller
{
    /**
     * Get all cities with shipping cost
     * GET /api/v1/kota
     */
    public function index(Request $request): JsonResponse
    {
        $query = Kota::aktif()->orderBy('provinsi')->orderBy('nama_kota');

        // Search by name
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('nama_kota', 'like', "%{$search}%")
                  ->orWhere('provinsi', 'like', "%{$search}%");
            });
        }

        // Filter by province
        if ($request->filled('provinsi')) {
            $query->where('provinsi', $request->input('provinsi'));
        }

        $kota = $query->get()->map(function ($item) {
            return [
                'id' => $item->id_kota,
                'nama' => $item->nama_kota,
                'provinsi' => $item->provinsi,
                'ongkir' => (float) $item->ongkir,
                'ongkir_formatted' => 'Rp ' . number_format((float) $item->ongkir, 0, ',', '.'),
            ];
        });

        // Get unique provinces for filter
        $provinsiList = Kota::aktif()
            ->distinct()
            ->pluck('provinsi')
            ->sort()
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Daftar kota berhasil diambil.',
            'data' => [
                'kota' => $kota,
                'provinsi' => $provinsiList,
            ],
        ]);
    }
}
