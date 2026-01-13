<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Set session lifetime to 2 hours (120 minutes)
            config(['session.lifetime' => 120]);

            $user = Auth::user();

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang, ' . $user->nama_lengkap . '!');
            } elseif ($user->isPetani()) {
                // Check if petani is verified
                if (!$user->is_verified) {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Akun petani Anda belum diverifikasi oleh admin.',
                    ])->onlyInput('email');
                }
                return redirect()->intended(route('petani.dashboard'))
                    ->with('success', 'Selamat datang, ' . $user->nama_lengkap . '!');
            } else {
                return redirect()->intended(route('home'))
                    ->with('success', 'Selamat datang, ' . $user->nama_lengkap . '!');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Show register form
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Handle register request
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:pengguna,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role_pengguna' => ['required', 'in:pembeli,petani'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'role_pengguna.required' => 'Pilih tipe akun.',
            'role_pengguna.in' => 'Tipe akun tidak valid.',
        ]);

        // Create user
        $user = Pengguna::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => $validated['password'], // Auto-hashed by model cast
            'role_pengguna' => $validated['role_pengguna'],
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'is_verified' => $validated['role_pengguna'] === 'pembeli', // Pembeli auto-verified
        ]);

        // Send welcome email
        try {
            Mail::to($user->email)->queue(new WelcomeMail($user));
        } catch (\Exception $e) {
            // Log error but don't fail registration
            \Log::error('Failed to send welcome email: ' . $e->getMessage());
        }

        // Auto login for pembeli
        if ($user->isPembeli()) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('home')
                ->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->nama_lengkap . '!');
        }

        // Petani needs admin verification
        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Akun petani Anda akan diverifikasi oleh admin dalam 1-2 hari kerja.');
    }

    /**
     * Logout user
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Show profile page
     */
    public function showProfil(): View
    {
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();
        
        // Order statistics
        $orderStats = [
            'total' => \App\Models\Pesanan::where('id_pembeli', $user->id_pengguna)->count(),
            'active' => \App\Models\Pesanan::where('id_pembeli', $user->id_pengguna)
                ->whereNotIn('status_pesanan', ['selesai', 'dibatalkan', 'direfund'])
                ->count(),
            'completed' => \App\Models\Pesanan::where('id_pembeli', $user->id_pengguna)
                ->where('status_pesanan', 'selesai')
                ->count(),
        ];
        
        return view('pembeli.profil', compact('user', 'orderStats'));
    }

    /**
     * Update profile
     */
    public function updateProfil(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:pengguna,email,' . $user->id_pengguna . ',id_pengguna'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // Check current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini salah.',
            ]);
        }

        $user->update([
            'password' => $validated['password'], // Auto-hashed by model cast
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Update profile photo
     */
    public function updateFoto(Request $request): RedirectResponse
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'foto.required' => 'Foto wajib dipilih.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();

        // Delete old photo if exists
        if ($user->foto && \Storage::disk('public')->exists($user->foto)) {
            \Storage::disk('public')->delete($user->foto);
        }

        // Store new photo
        $file = $request->file('foto');
        $filename = 'avatar_' . $user->id_pengguna . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('avatars', $filename, 'public');

        $user->update(['foto' => $path]);

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}
