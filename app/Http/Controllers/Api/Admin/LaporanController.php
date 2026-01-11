<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LaporanController extends Controller
{
    /**
     * Get sales report
     */
    public function penjualan(Request $request): JsonResponse
    {
        // TODO: Implement sales report
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Get best selling products
     */
    public function produkTerlaris(Request $request): JsonResponse
    {
        // TODO: Implement best selling products report
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Get top farmers
     */
    public function petaniTerbaik(Request $request): JsonResponse
    {
        // TODO: Implement top farmers report
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
