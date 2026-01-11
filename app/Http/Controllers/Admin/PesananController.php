<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PesananController extends Controller
{
    /**
     * Show all orders
     */
    public function index(Request $request): View
    {
        // TODO: Implement
        return view('admin.pesanan.index');
    }

    /**
     * Show order detail
     */
    public function show(int $id): View
    {
        // TODO: Implement
        return view('admin.pesanan.detail');
    }
}
