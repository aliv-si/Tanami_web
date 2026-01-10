<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PesananController extends Controller
{
    /**
     * Show incoming orders
     */
    public function index(Request $request): View
    {
        // TODO: Implement
        return view('petani.pesanan.index');
    }

    /**
     * Show order detail
     */
    public function show(int $id): View
    {
        // TODO: Implement
        return view('petani.pesanan.detail');
    }

    /**
     * Verify payment
     */
    public function verifikasi(int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Reject payment
     */
    public function tolak(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Mark as processing
     */
    public function proses(int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Ship order
     */
    public function kirim(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }
}
