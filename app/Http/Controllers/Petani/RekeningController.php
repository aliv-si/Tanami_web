<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\RekeningPetani;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RekeningController extends Controller
{
    /**
     * Show bank accounts
     */
    public function index(): View
    {
        $petaniId = Auth::id();

        $rekeningList = RekeningPetani::where('id_petani', $petaniId)
            ->orderByDesc('is_utama')
            ->orderBy('nama_bank')
            ->get();

        return view('petani.rekening', [
            'rekeningList' => $rekeningList,
        ]);
    }

    /**
     * Store new bank account
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_bank' => ['required', 'string', 'max:50'],
            'no_rekening' => ['required', 'string', 'max:30'],
            'atas_nama' => ['required', 'string', 'max:100'],
            'is_utama' => ['boolean'],
        ], [
            'nama_bank.required' => 'Nama bank wajib diisi.',
            'no_rekening.required' => 'Nomor rekening wajib diisi.',
            'atas_nama.required' => 'Nama pemilik rekening wajib diisi.',
        ]);

        $petaniId = Auth::id();
        $isUtama = $request->boolean('is_utama');

        DB::beginTransaction();
        try {
            // If this is set as primary, unset other primary
            if ($isUtama) {
                RekeningPetani::where('id_petani', $petaniId)
                    ->where('is_utama', true)
                    ->update(['is_utama' => false]);
            }

            // If this is first rekening, set as primary automatically
            $existingCount = RekeningPetani::where('id_petani', $petaniId)->count();
            if ($existingCount === 0) {
                $isUtama = true;
            }

            $rekening = RekeningPetani::create([
                'id_petani' => $petaniId,
                'nama_bank' => $validated['nama_bank'],
                'no_rekening' => $validated['no_rekening'],
                'atas_nama' => $validated['atas_nama'],
                'is_utama' => $isUtama,
            ]);

            DB::commit();

            return back()->with('success', 'Rekening ' . $rekening->nama_bank . ' berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update bank account
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $rekening = RekeningPetani::where('id_rekening', $id)
            ->where('id_petani', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'nama_bank' => ['required', 'string', 'max:50'],
            'no_rekening' => ['required', 'string', 'max:30'],
            'atas_nama' => ['required', 'string', 'max:100'],
        ], [
            'nama_bank.required' => 'Nama bank wajib diisi.',
            'no_rekening.required' => 'Nomor rekening wajib diisi.',
            'atas_nama.required' => 'Nama pemilik rekening wajib diisi.',
        ]);

        $rekening->update($validated);

        return back()->with('success', 'Rekening ' . $rekening->nama_bank . ' berhasil diperbarui.');
    }

    /**
     * Delete bank account
     */
    public function destroy(int $id): RedirectResponse
    {
        $rekening = RekeningPetani::where('id_rekening', $id)
            ->where('id_petani', Auth::id())
            ->firstOrFail();

        $petaniId = Auth::id();
        $wasUtama = $rekening->is_utama;
        $namaBank = $rekening->nama_bank;

        DB::beginTransaction();
        try {
            $rekening->delete();

            // If deleted was primary, set another as primary
            if ($wasUtama) {
                $newUtama = RekeningPetani::where('id_petani', $petaniId)->first();
                if ($newUtama) {
                    $newUtama->update(['is_utama' => true]);
                }
            }

            DB::commit();

            return back()->with('success', 'Rekening ' . $namaBank . ' berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Set as primary bank account
     */
    public function setUtama(int $id): RedirectResponse
    {
        $rekening = RekeningPetani::where('id_rekening', $id)
            ->where('id_petani', Auth::id())
            ->firstOrFail();

        $petaniId = Auth::id();

        DB::beginTransaction();
        try {
            // Unset all primary
            RekeningPetani::where('id_petani', $petaniId)
                ->where('is_utama', true)
                ->update(['is_utama' => false]);

            // Set this as primary
            $rekening->update(['is_utama' => true]);

            DB::commit();

            return back()->with('success', 'Rekening ' . $rekening->nama_bank . ' dijadikan rekening utama.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
