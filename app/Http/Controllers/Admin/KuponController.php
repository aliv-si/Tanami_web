<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kupon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class KuponController extends Controller
{
    /**
     * Show all coupons
     */
    public function index(): View
    {
        $kuponList = Kupon::withCount('pemakaian')
            ->orderBy('tgl_dibuat', 'desc')
            ->get();

        return view('admin.master.kupon', [
            'kuponList' => $kuponList,
        ]);
    }

    /**
     * Store coupon
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_kupon' => ['required', 'string', 'max:20', 'unique:kupon,kode_kupon'],
            'tipe_diskon' => ['required', 'in:nominal,persen'],
            'nilai_diskon' => ['required', 'numeric', 'min:0'],
            'min_belanja' => ['nullable', 'numeric', 'min:0'],
            'limit_per_user' => ['nullable', 'integer', 'min:1'],
            'limit_total' => ['nullable', 'integer', 'min:1'],
            'tgl_mulai' => ['required', 'date'],
            'tgl_selesai' => ['required', 'date', 'after_or_equal:tgl_mulai'],
            'is_aktif' => ['boolean'],
        ], [
            'kode_kupon.required' => 'Kode kupon wajib diisi.',
            'kode_kupon.unique' => 'Kode kupon sudah ada.',
            'tipe_diskon.required' => 'Tipe diskon wajib dipilih.',
            'nilai_diskon.required' => 'Nilai diskon wajib diisi.',
            'tgl_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tgl_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tgl_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        // Validate persen max 100
        if ($validated['tipe_diskon'] === 'persen' && $validated['nilai_diskon'] > 100) {
            return back()->withErrors(['nilai_diskon' => 'Diskon persen maksimal 100%.'])->withInput();
        }

        // Determine which column to use based on tipe_diskon
        $nominalDiskon = $validated['tipe_diskon'] === 'nominal' ? $validated['nilai_diskon'] : null;
        $persenDiskon = $validated['tipe_diskon'] === 'persen' ? $validated['nilai_diskon'] : null;

        Kupon::create([
            'kode_kupon' => Str::upper($validated['kode_kupon']),
            'tipe_diskon' => $validated['tipe_diskon'],
            'nominal_diskon' => $nominalDiskon,
            'persen_diskon' => $persenDiskon,
            'min_belanja' => $validated['min_belanja'] ?? 0,
            'limit_per_user' => $validated['limit_per_user'] ?? null,
            'limit_total' => $validated['limit_total'] ?? null,
            'tgl_mulai' => $validated['tgl_mulai'],
            'tgl_selesai' => $validated['tgl_selesai'],
            'is_aktif' => $request->boolean('is_aktif'),
        ]);

        return back()->with('success', 'Kupon "' . $validated['kode_kupon'] . '" berhasil ditambahkan.');
    }

    /**
     * Update coupon
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $kupon = Kupon::findOrFail($id);

        $validated = $request->validate([
            'kode_kupon' => ['required', 'string', 'max:20', 'unique:kupon,kode_kupon,' . $id . ',id_kupon'],
            'tipe_diskon' => ['required', 'in:nominal,persen'],
            'nilai_diskon' => ['required', 'numeric', 'min:0'],
            'min_belanja' => ['nullable', 'numeric', 'min:0'],
            'limit_per_user' => ['nullable', 'integer', 'min:1'],
            'limit_total' => ['nullable', 'integer', 'min:1'],
            'tgl_mulai' => ['required', 'date'],
            'tgl_selesai' => ['required', 'date', 'after_or_equal:tgl_mulai'],
            'is_aktif' => ['boolean'],
        ]);

        // Validate persen max 100
        if ($validated['tipe_diskon'] === 'persen' && $validated['nilai_diskon'] > 100) {
            return back()->withErrors(['nilai_diskon' => 'Diskon persen maksimal 100%.'])->withInput();
        }

        // Determine which column to use based on tipe_diskon
        $nominalDiskon = $validated['tipe_diskon'] === 'nominal' ? $validated['nilai_diskon'] : null;
        $persenDiskon = $validated['tipe_diskon'] === 'persen' ? $validated['nilai_diskon'] : null;

        $kupon->update([
            'kode_kupon' => Str::upper($validated['kode_kupon']),
            'tipe_diskon' => $validated['tipe_diskon'],
            'nominal_diskon' => $nominalDiskon,
            'persen_diskon' => $persenDiskon,
            'min_belanja' => $validated['min_belanja'] ?? 0,
            'limit_per_user' => $validated['limit_per_user'] ?? null,
            'limit_total' => $validated['limit_total'] ?? null,
            'tgl_mulai' => $validated['tgl_mulai'],
            'tgl_selesai' => $validated['tgl_selesai'],
            'is_aktif' => $request->boolean('is_aktif'),
        ]);

        return back()->with('success', 'Kupon "' . $kupon->kode_kupon . '" berhasil diperbarui.');
    }

    /**
     * Delete coupon
     */
    public function destroy(int $id): RedirectResponse
    {
        $kupon = Kupon::withCount('pemakaian')->findOrFail($id);

        // Check if has usage
        if ($kupon->pemakaian_count > 0) {
            return back()->with('error', 'Kupon tidak dapat dihapus karena sudah digunakan ' . $kupon->pemakaian_count . ' kali.');
        }

        $kodeKupon = $kupon->kode_kupon;
        $kupon->delete();

        return back()->with('success', 'Kupon "' . $kodeKupon . '" berhasil dihapus.');
    }
}
