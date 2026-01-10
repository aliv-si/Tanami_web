<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PesananController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout(): View
    {
        // TODO: Implement
        return view('pembeli.checkout');
    }

    /**
     * Process checkout
     */
    public function store(Request $request): RedirectResponse
    {
        // TODO: Implement
        return redirect()->route('pesanan');
    }

    /**
     * Show user's orders
     */
    public function index(): View
    {
        // TODO: Implement
        return view('pembeli.pesanan');
    }

    /**
     * Show order detail
     */
    public function show(int $id): View
    {
        // TODO: Implement
        return view('pembeli.pesanan-detail');
    }

    /**
     * Upload payment proof
     */
    public function uploadBukti(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Cancel order
     */
    public function batal(int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Confirm order received
     */
    public function konfirmasi(int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Request refund
     */
    public function mintaRefund(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }
}
