<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KuponController extends Controller
{
    /**
     * Get all coupons
     */
    public function index(): JsonResponse
    {
        // TODO: Implement list coupons
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Create coupon
     */
    public function store(Request $request): JsonResponse
    {
        // TODO: Implement create coupon
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Get coupon detail
     */
    public function show(int $id): JsonResponse
    {
        // TODO: Implement get coupon detail
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Update coupon
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // TODO: Implement update coupon
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Delete coupon
     */
    public function destroy(int $id): JsonResponse
    {
        // TODO: Implement delete coupon
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
