<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KategoriController extends Controller
{
    /**
     * Get all categories
     */
    public function index(): JsonResponse
    {
        // TODO: Implement list categories
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Get category by slug
     */
    public function show(string $slug): JsonResponse
    {
        // TODO: Implement get category detail
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Get products by category
     */
    public function produk(string $slug): JsonResponse
    {
        // TODO: Implement get products by category
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
