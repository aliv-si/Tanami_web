<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Show katalog page
     */
    public function katalog(Request $request): View
    {
        // TODO: Implement
        return view('pages.katalog');
    }

    /**
     * Show product detail
     */
    public function show(string $slug): View
    {
        // TODO: Implement
        return view('pages.produk-detail');
    }

    /**
     * Show products by category
     */
    public function byKategori(string $slug): View
    {
        // TODO: Implement
        return view('pages.kategori');
    }
}
