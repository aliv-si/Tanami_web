<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show petani dashboard
     */
    public function index(): View
    {
        // TODO: Implement
        return view('petani.dashboard');
    }
}
