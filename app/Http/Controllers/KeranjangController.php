<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KeranjangController extends Controller
{
    /**
     * Show cart page
     * - Load items dengan relasi produk.petani
     * - Group items by petani untuk display
     * - Hitung subtotal per item dan total keseluruhan
     */
    public function index(): View
    {
        $items = Keranjang::with(['produk.petani', 'produk.kategori'])
            ->where('id_pengguna', Auth::id())
            ->get();

        // Group items by petani
        $groupedItems = $items->groupBy(function ($item) {
            return $item->produk->id_petani;
        })->map(function ($group) {
            $petani = $group->first()->produk->petani;
            return [
                'petani' => $petani,
                'items' => $group,
                'subtotal' => $group->sum('subtotal'),
            ];
        });

        // Hitung total keseluruhan
        $total = $items->sum('subtotal');
        $jumlahItem = $items->sum('jumlah');

        return view('pembeli.keranjang', compact('groupedItems', 'total', 'jumlahItem'));
    }

    /**
     * Add to cart
     * - Validasi produk aktif dan stok tersedia
     * - Jika produk sudah ada di cart, tambah qty (bukan duplikat)
     * - Cek total qty tidak melebihi stok tersedia
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_produk' => 'required|integer|exists:produk,id_produk',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = Produk::aktif()->findOrFail($request->id_produk);
        $jumlahDiminta = $request->jumlah;

        // Cek apakah produk sudah ada di keranjang user
        $existingItem = Keranjang::where('id_pengguna', Auth::id())
            ->where('id_produk', $produk->id_produk)
            ->first();

        if ($existingItem) {
            // Produk sudah ada, tambah qty
            $totalJumlah = $existingItem->jumlah + $jumlahDiminta;

            // Cek stok tersedia untuk total jumlah
            if (!$produk->cekStok($totalJumlah)) {
                return back()->withErrors([
                    'stok' => "Stok tidak mencukupi. Tersedia: {$produk->stokTersedia()}, di keranjang: {$existingItem->jumlah}"
                ]);
            }

            $existingItem->update(['jumlah' => $totalJumlah]);

            return back()->with('success', 'Jumlah produk di keranjang berhasil ditambah');
        }

        // Produk belum ada, cek stok dan tambah baru
        if (!$produk->cekStok($jumlahDiminta)) {
            return back()->withErrors([
                'stok' => "Stok tidak mencukupi. Tersedia: {$produk->stokTersedia()}"
            ]);
        }

        Keranjang::create([
            'id_pengguna' => Auth::id(),
            'id_produk' => $produk->id_produk,
            'jumlah' => $jumlahDiminta,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    /**
     * Update cart item quantity
     * - Validasi ownership (item milik user yang login)
     * - Cek stok tersedia sebelum update
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $item = Keranjang::with('produk')
            ->where('id_pengguna', Auth::id())
            ->findOrFail($id);

        $jumlahBaru = $request->jumlah;

        // Cek stok tersedia
        if (!$item->produk->cekStok($jumlahBaru)) {
            return back()->withErrors([
                'stok' => "Stok tidak mencukupi. Tersedia: {$item->produk->stokTersedia()}"
            ]);
        }

        $item->update(['jumlah' => $jumlahBaru]);

        return back()->with('success', 'Jumlah berhasil diperbarui');
    }

    /**
     * Remove item from cart
     * - Validasi ownership (item milik user yang login)
     */
    public function destroy(int $id): RedirectResponse
    {
        $item = Keranjang::where('id_pengguna', Auth::id())
            ->findOrFail($id);

        $item->delete();

        return back()->with('success', 'Produk dihapus dari keranjang');
    }

    /**
     * Clear all items in cart
     * - Hapus semua item keranjang milik user yang login
     */
    public function clear(): RedirectResponse
    {
        Keranjang::where('id_pengguna', Auth::id())->delete();

        return redirect()->route('keranjang')
            ->with('success', 'Keranjang berhasil dikosongkan');
    }
}
