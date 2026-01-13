<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Show petani's products with search & filter
     */
    public function index(Request $request): View
    {
        $petaniId = Auth::id();

        $query = Produk::where('id_petani', $petaniId)
            ->with('kategori:id_kategori,nama_kategori');

        // Search by nama
        if ($request->filled('q')) {
            $query->where('nama_produk', 'like', '%' . $request->input('q') . '%');
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->input('kategori'));
        }

        // Filter by status
        if ($request->has('aktif')) {
            $query->where('is_aktif', $request->boolean('aktif'));
        }

        // Sort
        $sort = $request->input('sort', 'terbaru');
        switch ($sort) {
            case 'nama':
                $query->orderBy('nama_produk', 'asc');
                break;
            case 'harga':
                $query->orderBy('harga', 'asc');
                break;
            case 'stok_rendah':
                $query->orderByRaw('(stok - stok_direserve) ASC');
                break;
            case 'terbaru':
            default:
                $query->orderBy('tgl_dibuat', 'desc');
                break;
        }

        $produk = $query->paginate(10)->withQueryString();

        // Stats
        $stats = [
            'total' => Produk::where('id_petani', $petaniId)->count(),
            'aktif' => Produk::where('id_petani', $petaniId)->where('is_aktif', true)->count(),
            'nonaktif' => Produk::where('id_petani', $petaniId)->where('is_aktif', false)->count(),
            'stok_habis' => Produk::where('id_petani', $petaniId)
                ->whereRaw('stok <= stok_direserve')->count(),
        ];

        $kategoriList = Kategori::orderBy('nama_kategori')->get();

        return view('petani.produk.index', [
            'produk' => $produk,
            'stats' => $stats,
            'kategoriList' => $kategoriList,
            'currentSearch' => $request->input('q'),
            'currentKategori' => $request->input('kategori'),
            'currentSort' => $sort,
        ]);
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        $kategoriList = Kategori::orderBy('nama_kategori')->get();

        return view('petani.produk.form', [
            'produk' => null,
            'kategoriList' => $kategoriList,
            'isEdit' => false,
        ]);
    }

    /**
     * Store new product
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_produk' => ['required', 'string', 'max:150'],
            'id_kategori' => ['required', 'exists:kategori,id_kategori'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'is_aktif' => ['boolean'],
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max' => 'Nama produk maksimal 150 karakter.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.exists' => 'Kategori tidak valid.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.min' => 'Stok tidak boleh negatif.',
            'satuan.required' => 'Satuan wajib diisi.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 5MB.',
        ]);

        // Generate unique slug
        $slug = Str::slug($validated['nama_produk']);
        $originalSlug = $slug;
        $counter = 1;
        while (Produk::where('slug_produk', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle foto upload
        $fotoName = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoName = $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('produk', $fotoName, 'public');
        }

        $produk = Produk::create([
            'id_petani' => Auth::id(),
            'id_kategori' => $validated['id_kategori'],
            'nama_produk' => $validated['nama_produk'],
            'slug_produk' => $slug,
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'stok_direserve' => 0,
            'satuan' => $validated['satuan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'foto' => $fotoName,
            'is_aktif' => $request->boolean('is_aktif', true),
        ]);

        return redirect()->route('petani.produk')
            ->with('success', 'Produk "' . $produk->nama_produk . '" berhasil ditambahkan.');
    }

    /**
     * Show edit form
     */
    public function edit(int $id): View
    {
        $produk = Produk::where('id_produk', $id)
            ->where('id_petani', Auth::id())
            ->firstOrFail();

        $kategoriList = Kategori::orderBy('nama_kategori')->get();

        return view('petani.produk.form', [
            'produk' => $produk,
            'kategoriList' => $kategoriList,
            'isEdit' => true,
        ]);
    }

    /**
     * Update product
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $produk = Produk::where('id_produk', $id)
            ->where('id_petani', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'nama_produk' => ['required', 'string', 'max:150'],
            'id_kategori' => ['required', 'exists:kategori,id_kategori'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'is_aktif' => ['boolean'],
            'hapus_foto' => ['boolean'],
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'harga.required' => 'Harga wajib diisi.',
            'stok.required' => 'Stok wajib diisi.',
            'satuan.required' => 'Satuan wajib diisi.',
        ]);

        // Regenerate slug if nama changed
        if ($validated['nama_produk'] !== $produk->nama_produk) {
            $slug = Str::slug($validated['nama_produk']);
            $originalSlug = $slug;
            $counter = 1;
            while (Produk::where('slug_produk', $slug)->where('id_produk', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug_produk'] = $slug;
        }

        // Handle foto
        $fotoName = $produk->foto;

        // Delete foto if requested
        if ($request->boolean('hapus_foto') && $produk->foto) {
            Storage::disk('public')->delete('produk/' . $produk->foto);
            $fotoName = null;
        }

        // Upload new foto
        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($produk->foto) {
                Storage::disk('public')->delete('produk/' . $produk->foto);
            }

            $file = $request->file('foto');
            $slugForFile = $validated['slug_produk'] ?? $produk->slug_produk;
            $fotoName = $slugForFile . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('produk', $fotoName, 'public');
        }

        $produk->update([
            'id_kategori' => $validated['id_kategori'],
            'nama_produk' => $validated['nama_produk'],
            'slug_produk' => $validated['slug_produk'] ?? $produk->slug_produk,
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'satuan' => $validated['satuan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'foto' => $fotoName,
            'is_aktif' => $request->boolean('is_aktif', true),
        ]);

        return redirect()->route('petani.produk')
            ->with('success', 'Produk "' . $produk->nama_produk . '" berhasil diperbarui.');
    }

    /**
     * Delete product
     */
    public function destroy(int $id): RedirectResponse
    {
        $produk = Produk::where('id_produk', $id)
            ->where('id_petani', Auth::id())
            ->firstOrFail();

        // Check if there's reserved stock (active orders)
        if ($produk->stok_direserve > 0) {
            return back()->with('error', 'Produk tidak dapat dihapus karena masih ada pesanan aktif.');
        }

        // Delete foto if exists
        if ($produk->foto && Storage::disk('public')->exists('produk/' . $produk->foto)) {
            Storage::disk('public')->delete('produk/' . $produk->foto);
        }

        $namaProduk = $produk->nama_produk;
        $produk->delete();

        return redirect()->route('petani.produk')
            ->with('success', 'Produk "' . $namaProduk . '" berhasil dihapus.');
    }
}
