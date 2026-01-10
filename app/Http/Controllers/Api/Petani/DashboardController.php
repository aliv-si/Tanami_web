<?php

namespace App\Http\Controllers\Api\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Get farmer dashboard data
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: Implement farmer dashboard (sales, orders, ratings)
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
