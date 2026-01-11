<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KeranjangController extends Controller
{
    /**
     * Get user's cart items
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: Implement get cart items
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Add item to cart
     */
    public function store(Request $request): JsonResponse
    {
        // TODO: Implement add to cart
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // TODO: Implement update cart item
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Remove item from cart
     */
    public function destroy(int $id): JsonResponse
    {
        // TODO: Implement remove from cart
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Clear all cart items
     */
    public function clear(Request $request): JsonResponse
    {
        // TODO: Implement clear cart
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
