<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KotaController extends Controller
{
    /**
     * Show all cities
     */
    public function index(): View
    {
        // TODO: Implement
        return view('admin.master.kota');
    }

    /**
     * Store city
     */
    public function store(Request $request): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Update city
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Delete city
     */
    public function destroy(int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }
}
