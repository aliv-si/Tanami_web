<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index(): View
    {
        // TODO: Implement
        return view('admin.dashboard');
    }
}
