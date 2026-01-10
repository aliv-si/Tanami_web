<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin(): View
    {
        // TODO: Implement
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request): RedirectResponse
    {
        // TODO: Implement
        return redirect()->route('beranda');
    }

    /**
     * Show register form
     */
    public function showRegister(): View
    {
        // TODO: Implement
        return view('auth.register');
    }

    /**
     * Handle register request
     */
    public function register(Request $request): RedirectResponse
    {
        // TODO: Implement
        return redirect()->route('beranda');
    }

    /**
     * Logout user
     */
    public function logout(Request $request): RedirectResponse
    {
        // TODO: Implement
        return redirect()->route('home');
    }

    /**
     * Show profile page
     */
    public function showProfil(): View
    {
        // TODO: Implement
        return view('pembeli.profil');
    }

    /**
     * Update profile
     */
    public function updateProfil(Request $request): RedirectResponse
    {
        // TODO: Implement
        return back();
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        // TODO: Implement
        return back();
    }
}
