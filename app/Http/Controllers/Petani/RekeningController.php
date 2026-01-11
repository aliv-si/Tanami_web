<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RekeningController extends Controller
{
    /**
     * Show bank accounts
     */
    public function index(): View
    {
        // TODO: Implement
        return view('petani.rekening');
    }

    /**
     * Store bank account
     */
    public function store(Request $request): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Update bank account
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Delete bank account
     */
    public function destroy(int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Set as primary
     */
    public function setUtama(int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }
}
