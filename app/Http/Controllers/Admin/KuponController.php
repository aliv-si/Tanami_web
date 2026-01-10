<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KuponController extends Controller
{
    /**
     * Show all coupons
     */
    public function index(): View
    {
        // TODO: Implement
        return view('admin.master.kupon');
    }

    /**
     * Store coupon
     */
    public function store(Request $request): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Update coupon
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Delete coupon
     */
    public function destroy(int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }
}
