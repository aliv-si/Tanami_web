<?php

namespace App\Http\Controllers\Api\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RekeningController extends Controller
{
    /**
     * Get farmer's bank accounts
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: Implement list bank accounts
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Add new bank account
     */
    public function store(Request $request): JsonResponse
    {
        // TODO: Implement add bank account
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Update bank account
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // TODO: Implement update bank account
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Delete bank account
     */
    public function destroy(int $id): JsonResponse
    {
        // TODO: Implement delete bank account
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Set as primary bank account
     */
    public function setUtama(int $id): JsonResponse
    {
        // TODO: Implement set as primary
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
