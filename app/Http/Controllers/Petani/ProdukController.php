<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Show petani's products
     */
    public function index(): View
    {
        // TODO: Implement
        return view('petani.produk.index');
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        // TODO: Implement
        return view('petani.produk.form');
    }

    /**
     * Store new product
     */
    public function store(Request $request): RedirectResponse
    {
        // TODO: Implement
        return redirect()->route('petani.produk');
    }

    /**
     * Show edit form
     */
    public function edit(int $id): View
    {
        // TODO: Implement
        return view('petani.produk.form');
    }

    /**
     * Update product
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement
        return redirect()->route('petani.produk');
    }

    /**
     * Delete product
     */
    public function destroy(int $id): RedirectResponse
    {
        // TODO: Implement
        return redirect()->route('petani.produk');
    }
}
