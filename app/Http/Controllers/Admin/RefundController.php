<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RefundController extends Controller
{
    /**
     * Show refund requests
     */
    public function index(): View
    {
        // TODO: Implement
        return view('admin.refund');
    }

    /**
     * Approve refund
     */
    public function approve(int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Reject refund
     */
    public function reject(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }
}
