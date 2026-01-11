<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KeranjangController extends Controller
{
    /**
     * Show cart page
     */
    public function index(): View
    {
        // TODO: Implement
        return view('pembeli.keranjang');
    }

    /**
     * Add to cart
     */
    public function store(Request $request): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Update cart item
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Remove from cart
     */
    public function destroy(int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Clear cart
     */
    public function clear(): RedirectResponse
    {
        // TODO: Implement
        return back();
    }
}
