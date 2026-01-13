<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Register new user
     * POST /api/v1/auth/register
     * 
     * @bodyParam nama_lengkap string required Nama lengkap pengguna. Example: John Doe
     * @bodyParam email string required Email unik. Example: john@example.com
     * @bodyParam password string required Password minimal 8 karakter. Example: password123
     * @bodyParam password_confirmation string required Konfirmasi password.
     * @bodyParam role_pengguna string required Role: pembeli atau petani. Example: pembeli
     * @bodyParam no_hp string optional Nomor HP. Example: 081234567890
     * @bodyParam alamat string optional Alamat lengkap.
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role_pengguna' => 'required|in:pembeli,petani',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'role_pengguna.required' => 'Role pengguna wajib dipilih.',
            'role_pengguna.in' => 'Role harus pembeli atau petani.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create user
        $pengguna = Pengguna::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => $request->password, // Will be hashed by model cast
            'role_pengguna' => $request->role_pengguna,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'is_verified' => $request->role_pengguna === 'pembeli', // Petani perlu verifikasi admin
        ]);

        // Create token
        $token = $pengguna->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => $request->role_pengguna === 'petani' 
                ? 'Registrasi berhasil. Akun petani menunggu verifikasi admin.'
                : 'Registrasi berhasil.',
            'data' => [
                'user' => $this->transformUser($pengguna),
                'token' => $token,
                'token_type' => 'Bearer',
            ],
        ], 201);
    }

    /**
     * Login user
     * POST /api/v1/auth/login
     * 
     * @bodyParam email string required Email pengguna. Example: john@example.com
     * @bodyParam password string required Password pengguna. Example: password123
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Attempt login
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        $pengguna = Pengguna::where('email', $request->email)->firstOrFail();

        // Check if petani is verified
        if ($pengguna->isPetani() && !$pengguna->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Akun petani belum diverifikasi oleh admin.',
            ], 403);
        }

        // Create new token
        $token = $pengguna->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'user' => $this->transformUser($pengguna),
                'token' => $token,
                'token_type' => 'Bearer',
            ],
        ]);
    }

    /**
     * Logout user
     * POST /api/v1/auth/logout
     */
    public function logout(Request $request): JsonResponse
    {
        // Revoke current access token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }

    /**
     * Get authenticated user info
     * GET /api/v1/auth/me
     */
    public function me(Request $request): JsonResponse
    {
        $pengguna = $request->user();

        // Load additional data based on role
        if ($pengguna->isPetani()) {
            $pengguna->loadCount(['produk', 'pesananDiverifikasi']);
        } elseif ($pengguna->isPembeli()) {
            $pengguna->loadCount(['pesanan', 'keranjang', 'ulasan']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pengguna berhasil diambil.',
            'data' => $this->transformUser($pengguna, true),
        ]);
    }

    /**
     * Update user profile
     * PUT /api/v1/auth/profile
     * 
     * @bodyParam nama_lengkap string optional Nama lengkap baru.
     * @bodyParam no_hp string optional Nomor HP baru.
     * @bodyParam alamat string optional Alamat baru.
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $pengguna = $request->user();

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'sometimes|required|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ], [
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update only provided fields
        $pengguna->fill($request->only(['nama_lengkap', 'no_hp', 'alamat']));
        $pengguna->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data' => $this->transformUser($pengguna),
        ]);
    }

    /**
     * Update user password
     * PUT /api/v1/auth/password
     * 
     * @bodyParam current_password string required Password saat ini.
     * @bodyParam password string required Password baru minimal 8 karakter.
     * @bodyParam password_confirmation string required Konfirmasi password baru.
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $pengguna = $request->user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password baru minimal 8 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check current password
        if (!Hash::check($request->current_password, $pengguna->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini salah.',
                'errors' => [
                    'current_password' => ['Password saat ini tidak sesuai.'],
                ],
            ], 422);
        }

        // Update password
        $pengguna->password = $request->password; // Will be hashed by model cast
        $pengguna->save();

        // Revoke all tokens except current one for security
        $currentTokenId = $request->user()->currentAccessToken()->id;
        $pengguna->tokens()->where('id', '!=', $currentTokenId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui.',
        ]);
    }

    /**
     * Send forgot password email
     * POST /api/v1/auth/forgot-password
     * 
     * @bodyParam email string required Email pengguna.
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:pengguna,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // TODO: Implement actual password reset email
        // For now, just return success message
        // In production, use: Password::sendResetLink($request->only('email'));

        return response()->json([
            'success' => true,
            'message' => 'Jika email terdaftar, link reset password akan dikirim.',
        ]);
    }

    /**
     * Reset password with token
     * POST /api/v1/auth/reset-password
     * 
     * @bodyParam email string required Email pengguna.
     * @bodyParam token string required Token reset password.
     * @bodyParam password string required Password baru.
     * @bodyParam password_confirmation string required Konfirmasi password.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:pengguna,email',
            'token' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.exists' => 'Email tidak terdaftar.',
            'token.required' => 'Token reset wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // TODO: Implement actual password reset logic
        // In production, use: Password::reset($request->only(...), function($user, $password) {...});

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil direset. Silakan login dengan password baru.',
        ]);
    }

    /**
     * Transform user data for response
     */
    private function transformUser(Pengguna $pengguna, bool $withCounts = false): array
    {
        $data = [
            'id' => $pengguna->id_pengguna,
            'nama_lengkap' => $pengguna->nama_lengkap,
            'email' => $pengguna->email,
            'role' => $pengguna->role_pengguna,
            'no_hp' => $pengguna->no_hp,
            'alamat' => $pengguna->alamat,
            'is_verified' => $pengguna->is_verified,
            'tgl_daftar' => $pengguna->tgl_daftar?->toIso8601String(),
        ];

        // Add counts if requested
        if ($withCounts) {
            if ($pengguna->isPetani()) {
                $data['total_produk'] = $pengguna->produk_count ?? 0;
                $data['total_pesanan_diverifikasi'] = $pengguna->pesanan_diverifikasi_count ?? 0;
            } elseif ($pengguna->isPembeli()) {
                $data['total_pesanan'] = $pengguna->pesanan_count ?? 0;
                $data['total_keranjang'] = $pengguna->keranjang_count ?? 0;
                $data['total_ulasan'] = $pengguna->ulasan_count ?? 0;
            }
        }

        return $data;
    }
}
