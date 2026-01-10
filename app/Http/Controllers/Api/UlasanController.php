<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UlasanController extends Controller
{
    /**
     * Get reviews by product
     */
    public function indexByProduk(int $id): JsonResponse
    {
        // TODO: Implement get reviews by product
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Create review for order item
     */
    public function store(Request $request): JsonResponse
    {
        // TODO: Implement create review
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
