<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EscrowController extends Controller
{
    /**
     * Get all escrow transactions
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: Implement list escrow transactions
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Get escrow detail
     */
    public function show(int $id): JsonResponse
    {
        // TODO: Implement get escrow detail
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Get escrow statistics
     */
    public function stats(): JsonResponse
    {
        // TODO: Implement escrow statistics
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
