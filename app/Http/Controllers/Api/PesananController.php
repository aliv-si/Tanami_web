<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PesananController extends Controller
{
    /**
     * Get user's orders
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: Implement list user orders
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
     * Create order from cart (checkout)
     */
    public function checkout(Request $request): JsonResponse
    {
        // TODO: Implement checkout logic
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Upload payment proof
     */
    public function uploadBukti(Request $request, int $id): JsonResponse
    {
        // TODO: Implement upload payment proof
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Cancel order
     */
    public function batal(int $id): JsonResponse
    {
        // TODO: Implement cancel order
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Confirm order received
     */
    public function konfirmasi(int $id): JsonResponse
    {
        // TODO: Implement confirm order received
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Request refund
     */
    public function mintaRefund(Request $request, int $id): JsonResponse
    {
        // TODO: Implement request refund
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
