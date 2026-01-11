<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PenggunaController extends Controller
{
    /**
     * Get all users
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: Implement list users with filters
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Get user detail
     */
    public function show(int $id): JsonResponse
    {
        // TODO: Implement get user detail
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Update user
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // TODO: Implement update user
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Verify farmer account
     */
    public function verify(int $id): JsonResponse
    {
        // TODO: Implement verify farmer
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Delete user
     */
    public function destroy(int $id): JsonResponse
    {
        // TODO: Implement delete user
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
