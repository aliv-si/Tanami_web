<?php

namespace App\Http\Controllers\Api\Admin;

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
     * Create category
     */
    public function store(Request $request): JsonResponse
    {
        // TODO: Implement create category
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Get category detail
     */
    public function show(int $id): JsonResponse
    {
        // TODO: Implement get category detail
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Update category
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // TODO: Implement update category
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Delete category
     */
    public function destroy(int $id): JsonResponse
    {
        // TODO: Implement delete category
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
