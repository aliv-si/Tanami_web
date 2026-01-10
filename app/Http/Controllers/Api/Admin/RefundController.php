<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RefundController extends Controller
{
    /**
     * Get all refund requests
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: Implement list refund requests
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Approve refund request
     */
    public function approve(Request $request, int $id): JsonResponse
    {
        // TODO: Implement approve refund
        return response()->json(['message' => 'Not implemented'], 501);
    }

    /**
     * Reject refund request
     */
    public function reject(Request $request, int $id): JsonResponse
    {
        // TODO: Implement reject refund
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
