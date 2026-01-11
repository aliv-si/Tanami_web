<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    /**
     * Show all users
     */
    public function index(Request $request): View
    {
        // TODO: Implement
        return view('admin.pengguna.index');
    }

    /**
     * Show pending petani
     */
    public function petaniPending(): View
    {
        // TODO: Implement
        return view('admin.pengguna.petani');
    }

    /**
     * Show user detail
     */
    public function show(int $id): View
    {
        // TODO: Implement
        return view('admin.pengguna.show');
    }

    /**
     * Verify petani
     */
    public function verify(int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Update user
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Delete user
     */
    public function destroy(int $id): RedirectResponse
    {
        // TODO: Implement
        return redirect()->route('admin.pengguna');
    }
}
