<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    /**
     * Show all users with filter
     */
    public function index(Request $request): View
    {
        $query = Pengguna::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role_pengguna', $request->input('role'));
        }

        // Filter by verified (for petani)
        if ($request->has('verified')) {
            $query->where('is_verified', $request->boolean('verified'));
        }

        // Search by nama/email
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $penggunaList = $query->orderBy('tgl_daftar', 'desc')->paginate(15)->withQueryString();

        // Counts
        $counts = [
            'total' => Pengguna::count(),
            'pembeli' => Pengguna::where('role_pengguna', 'pembeli')->count(),
            'petani' => Pengguna::where('role_pengguna', 'petani')->count(),
            'petani_pending' => Pengguna::where('role_pengguna', 'petani')->where('is_verified', false)->count(),
            'admin' => Pengguna::where('role_pengguna', 'admin')->count(),
        ];

        return view('admin.pengguna.index', [
            'penggunaList' => $penggunaList,
            'counts' => $counts,
            'currentRole' => $request->input('role'),
            'currentSearch' => $request->input('q'),
        ]);
    }

    /**
     * Show pending petani for verification
     */
    public function petaniPending(): View
    {
        $petaniList = Pengguna::where('role_pengguna', 'petani')
            ->where('is_verified', false)
            ->orderBy('tgl_daftar', 'desc')
            ->paginate(15);

        return view('admin.pengguna.petani', [
            'petaniList' => $petaniList,
        ]);
    }

    /**
     * Show user detail with related data
     */
    public function show(int $id): View
    {
        $pengguna = Pengguna::findOrFail($id);

        $relatedData = [];

        if ($pengguna->isPembeli()) {
            $relatedData['pesanan'] = $pengguna->pesanan()
                ->orderBy('tgl_dibuat', 'desc')
                ->limit(10)
                ->get();
            $relatedData['totalBelanja'] = $pengguna->pesanan()
                ->where('status_pesanan', 'selesai')
                ->sum('total_bayar');
        }

        if ($pengguna->isPetani()) {
            $relatedData['produk'] = $pengguna->produk()
                ->orderBy('tgl_dibuat', 'desc')
                ->limit(10)
                ->get();
            $relatedData['totalProduk'] = $pengguna->produk()->count();
            $relatedData['rekening'] = $pengguna->rekening()->get();
        }

        return view('admin.pengguna.show', [
            'pengguna' => $pengguna,
            'relatedData' => $relatedData,
        ]);
    }

    /**
     * Verify petani account
     */
    public function verify(int $id): RedirectResponse
    {
        $pengguna = Pengguna::where('role_pengguna', 'petani')->findOrFail($id);

        if ($pengguna->is_verified) {
            return back()->with('error', 'Petani sudah terverifikasi.');
        }

        $pengguna->update(['is_verified' => true]);

        return back()->with('success', 'Akun petani "' . $pengguna->nama_lengkap . '" berhasil diverifikasi.');
    }

    /**
     * Update user data
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $pengguna = Pengguna::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:pengguna,email,' . $id . ',id_pengguna'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'is_verified' => ['boolean'],
        ]);

        $pengguna->update([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'is_verified' => $request->boolean('is_verified', $pengguna->is_verified),
        ]);

        return back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Delete user (soft delete by deactivating)
     */
    public function destroy(int $id): RedirectResponse
    {
        $pengguna = Pengguna::findOrFail($id);

        // Prevent deleting admin
        if ($pengguna->isAdmin()) {
            return back()->with('error', 'Akun admin tidak dapat dihapus.');
        }

        // Check if petani has products with reserved stock
        if ($pengguna->isPetani()) {
            $hasReservedStock = $pengguna->produk()->where('stok_direserve', '>', 0)->exists();
            if ($hasReservedStock) {
                return back()->with('error', 'Petani tidak dapat dihapus karena masih ada pesanan aktif.');
            }
        }

        // Check if pembeli has active orders
        if ($pengguna->isPembeli()) {
            $hasActiveOrders = $pengguna->pesanan()
                ->whereNotIn('status_pesanan', ['selesai', 'dibatalkan', 'direfund'])
                ->exists();
            if ($hasActiveOrders) {
                return back()->with('error', 'Pembeli tidak dapat dihapus karena masih ada pesanan aktif.');
            }
        }

        $namaPengguna = $pengguna->nama_lengkap;
        $pengguna->delete();

        return redirect()->route('admin.pengguna')
            ->with('success', 'Pengguna "' . $namaPengguna . '" berhasil dihapus.');
    }
}
