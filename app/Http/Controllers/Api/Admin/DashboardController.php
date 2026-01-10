<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Get admin dashboard data
     */
    public function index(Request $request): JsonResponse
    {
        // TODO: Implement admin dashboard (GMV, transactions, active users)
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
