<?php

namespace App\Http\Controllers\Api\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UlasanController extends Controller
{
    /**
     * Get reviews for farmer's products
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: Implement list reviews for farmer's products
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
