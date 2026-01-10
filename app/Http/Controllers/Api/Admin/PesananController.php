<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PesananController extends Controller
{
    /**
     * Get all orders (admin view)
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: Implement list all orders
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
     * Get order status history
     */
    public function histori(int $id): JsonResponse
    {
        // TODO: Implement get order history
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
