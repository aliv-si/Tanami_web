<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KotaController extends Controller
{
    /**
     * Get all cities with shipping cost
     */
    public function index(): JsonResponse
    {
        // TODO: Implement list cities
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
