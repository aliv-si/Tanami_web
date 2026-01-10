<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EscrowController extends Controller
{
    /**
     * Show escrow transactions
     */
    public function index(Request $request): View
    {
        // TODO: Implement
        return view('admin.escrow');
    }
}
