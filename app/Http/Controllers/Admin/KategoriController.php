<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class KategoriController extends Controller
{
    /**
     * Show all categories
     */
    public function index(): View
    {
        $kategoriList = Kategori::withCount(['produk', 'produk as produk_aktif_count' => function ($query) {
            $query->where('is_aktif', true);
        }])
            ->orderBy('nama_kategori')
            ->get();

        return view('admin.master.kategori', [
            'kategoriList' => $kategoriList,
        ]);
    }

    /**
     * Store category
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:50', 'unique:kategori,nama_kategori'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
        ]);

        // Generate slug
        $slug = Str::slug($validated['nama_kategori']);
        $originalSlug = $slug;
        $counter = 1;
        while (Kategori::where('slug_kategori', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Kategori::create([
            'nama_kategori' => $validated['nama_kategori'],
            'slug_kategori' => $slug,
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        return back()->with('success', 'Kategori "' . $validated['nama_kategori'] . '" berhasil ditambahkan.');
    }

    /**
     * Update category
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:50', 'unique:kategori,nama_kategori,' . $id . ',id_kategori'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
        ]);

        // Regenerate slug if nama changed
        if ($validated['nama_kategori'] !== $kategori->nama_kategori) {
            $slug = Str::slug($validated['nama_kategori']);
            $originalSlug = $slug;
            $counter = 1;
            while (Kategori::where('slug_kategori', $slug)->where('id_kategori', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug_kategori'] = $slug;
        }

        $kategori->update($validated);

        return back()->with('success', 'Kategori "' . $kategori->nama_kategori . '" berhasil diperbarui.');
    }

    /**
     * Delete category
     */
    public function destroy(int $id): RedirectResponse
    {
        $kategori = Kategori::withCount('produk')->findOrFail($id);

        // Check if has products
        if ($kategori->produk_count > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki ' . $kategori->produk_count . ' produk.');
        }

        $namaKategori = $kategori->nama_kategori;
        $kategori->delete();

        return back()->with('success', 'Kategori "' . $namaKategori . '" berhasil dihapus.');
    }
}
