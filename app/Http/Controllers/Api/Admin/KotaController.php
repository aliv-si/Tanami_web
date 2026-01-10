<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KotaController extends Controller
{
    /**
     * Get all cities
     */
    public function index(): JsonResponse
    {
        // TODO: Implement list cities
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Create city
     */
    public function store(Request $request): JsonResponse
    {
        // TODO: Implement create city
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Get city detail
     */
    public function show(int $id): JsonResponse
    {
        // TODO: Implement get city detail
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Update city
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // TODO: Implement update city
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Delete city
     */
    public function destroy(int $id): JsonResponse
    {
        // TODO: Implement delete city
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
