<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KuponController extends Controller
{
    /**
     * Validate coupon code
     */
    public function validasi(Request $request): JsonResponse
    {
        // TODO: Implement coupon validation
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
