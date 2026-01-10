<?php

namespace App\Http\Controllers\Api\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProdukController extends Controller
{
    /**
     * Get farmer's products
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: Implement list farmer's products
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Create new product
     */
    public function store(Request $request): JsonResponse
    {
        // TODO: Implement create product
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Get product detail
     */
    public function show(int $id): JsonResponse
    {
        // TODO: Implement get product detail
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Update product
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // TODO: Implement update product
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Delete product
     */
    public function destroy(int $id): JsonResponse
    {
        // TODO: Implement delete product
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Upload product photo
     */
    public function uploadFoto(Request $request, int $id): JsonResponse
    {
        // TODO: Implement upload product photo
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
