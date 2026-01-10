<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProdukController extends Controller
{
    /**
     * Get all products (public)
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: Implement list products with filters
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Get product detail by slug
     */
    public function show(string $slug): JsonResponse
    {
        // TODO: Implement get product detail
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
