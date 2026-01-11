<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UlasanController extends Controller
{
    /**
     * Show reviews
     */
    public function index(): View
    {
        // TODO: Implement
        return view('petani.ulasan');
    }
}
