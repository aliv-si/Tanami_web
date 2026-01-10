<?php

namespace App\Http\Controllers\Api\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PesananController extends Controller
{
    /**
     * Get incoming orders for farmer
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: Implement list farmer's incoming orders
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Get order detail
     */
    public function show(int $id): JsonResponse
    {
        // TODO: Implement get order detail
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Verify payment (approve)
     */
    public function verifikasi(Request $request, int $id): JsonResponse
    {
        // TODO: Implement verify payment
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Reject payment
     */
    public function tolak(Request $request, int $id): JsonResponse
    {
        // TODO: Implement reject payment
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Mark order as processing
     */
    public function proses(int $id): JsonResponse
    {
        // TODO: Implement mark as processing
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Ship order (with resi number)
     */
    public function kirim(Request $request, int $id): JsonResponse
    {
        // TODO: Implement ship order
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
