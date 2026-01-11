<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriController extends Controller
{
    /**
     * Show all categories
     */
    public function index(): View
    {
        // TODO: Implement
        return view('admin.master.kategori');
    }

    /**
     * Store category
     */
    public function store(Request $request): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Update category
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Delete category
     */
    public function destroy(int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }
}
