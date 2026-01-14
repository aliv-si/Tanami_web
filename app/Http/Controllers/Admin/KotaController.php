<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use App\Models\Pesanan;
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
        $kotaList = Kota::withCount('pesanan')
            ->orderBy('nama_kota')
            ->get();

        return view('admin.master.kota', [
            'kotaList' => $kotaList,
        ]);
    }

    /**
     * Store city
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kota' => ['required', 'string', 'max:100'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'ongkir' => ['required', 'numeric', 'min:0'],
            'is_aktif' => ['boolean'],
        ], [
            'nama_kota.required' => 'Nama kota wajib diisi.',
            'ongkir.required' => 'Ongkir wajib diisi.',
            'ongkir.min' => 'Ongkir tidak boleh negatif.',
        ]);

        Kota::create([
            'nama_kota' => $validated['nama_kota'],
            'provinsi' => $validated['provinsi'] ?? null,
            'ongkir' => $validated['ongkir'],
            'is_aktif' => $request->boolean('is_aktif'),
        ]);

        return back()->with('success', 'Kota "' . $validated['nama_kota'] . '" berhasil ditambahkan.');
    }

    /**
     * Update city
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $kota = Kota::findOrFail($id);

        $validated = $request->validate([
            'nama_kota' => ['required', 'string', 'max:100'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'ongkir' => ['required', 'numeric', 'min:0'],
            'is_aktif' => ['boolean'],
        ], [
            'nama_kota.required' => 'Nama kota wajib diisi.',
            'ongkir.required' => 'Ongkir wajib diisi.',
        ]);

        $kota->update([
            'nama_kota' => $validated['nama_kota'],
            'provinsi' => $validated['provinsi'] ?? null,
            'ongkir' => $validated['ongkir'],
            'is_aktif' => $request->boolean('is_aktif'),
        ]);

        return back()->with('success', 'Kota "' . $kota->nama_kota . '" berhasil diperbarui.');
    }

    /**
     * Delete city
     */
    public function destroy(int $id): RedirectResponse
    {
        $kota = Kota::withCount('pesanan')->findOrFail($id);

        // Check if has orders
        if ($kota->pesanan_count > 0) {
            return back()->with('error', 'Kota tidak dapat dihapus karena sudah digunakan di ' . $kota->pesanan_count . ' pesanan.');
        }

        $namaKota = $kota->nama_kota;
        $kota->delete();

        return back()->with('success', 'Kota "' . $namaKota . '" berhasil dihapus.');
    }
}
