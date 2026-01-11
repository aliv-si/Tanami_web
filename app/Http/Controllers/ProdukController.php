<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Show katalog page with filter, search, and pagination
     * 
     * Query Parameters:
     * - q: search keyword (nama produk)
     * - kategori: filter by kategori slug
     * - sort: terbaru|termurah|termahal|terlaris
     * - min_harga: minimum price filter
     * - max_harga: maximum price filter
     */
    public function katalog(Request $request): View
    {
        $query = Produk::query()
            ->tersedia() // Hanya produk aktif dengan stok tersedia
            ->with(['kategori', 'petani', 'ulasan']);

        // Search by nama produk
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('slug_kategori', $request->input('kategori'));
            });
        }

        // Filter by price range
        if ($request->filled('min_harga')) {
            $query->where('harga', '>=', $request->input('min_harga'));
        }
        if ($request->filled('max_harga')) {
            $query->where('harga', '<=', $request->input('max_harga'));
        }

        // Sorting
        $sort = $request->input('sort', 'terbaru');
        switch ($sort) {
            case 'termurah':
                $query->orderBy('harga', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga', 'desc');
                break;
            case 'terlaris':
                $query->withCount('itemPesanan')
                      ->orderBy('item_pesanan_count', 'desc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('tgl_dibuat', 'desc');
                break;
        }

        // Pagination (12 per page)
        $produk = $query->paginate(12)->withQueryString();

        // Get all categories for filter sidebar
        $kategoriList = Kategori::withCount(['produk' => function ($q) {
            $q->tersedia();
        }])->get();

        // Get price range for filter
        $hargaRange = Produk::tersedia()->selectRaw('MIN(harga) as min, MAX(harga) as max')->first();

        return view('pages.katalog', [
            'produk' => $produk,
            'kategoriList' => $kategoriList,
            'hargaRange' => $hargaRange,
            'currentSort' => $sort,
            'currentSearch' => $request->input('q'),
            'currentKategori' => $request->input('kategori'),
            'currentMinHarga' => $request->input('min_harga'),
            'currentMaxHarga' => $request->input('max_harga'),
        ]);
    }

    /**
     * Show product detail page
     */
    public function show(string $slug): View
    {
        $produk = Produk::where('slug_produk', $slug)
            ->aktif()
            ->with(['kategori', 'petani', 'ulasan.pengguna'])
            ->firstOrFail();

        // Calculate rating stats
        $ratingStats = [
            'rata_rata' => $produk->ulasan->avg('rating') ?? 0,
            'total' => $produk->ulasan->count(),
            'distribusi' => [
                5 => $produk->ulasan->where('rating', 5)->count(),
                4 => $produk->ulasan->where('rating', 4)->count(),
                3 => $produk->ulasan->where('rating', 3)->count(),
                2 => $produk->ulasan->where('rating', 2)->count(),
                1 => $produk->ulasan->where('rating', 1)->count(),
            ],
        ];

        // Get related products (same category, exclude current)
        $produkTerkait = Produk::where('id_kategori', $produk->id_kategori)
            ->where('id_produk', '!=', $produk->id_produk)
            ->tersedia()
            ->with('kategori')
            ->limit(4)
            ->get();

        // Get other products from same petani
        $produkPetani = Produk::where('id_petani', $produk->id_petani)
            ->where('id_produk', '!=', $produk->id_produk)
            ->tersedia()
            ->limit(4)
            ->get();

        return view('pages.produk-detail', [
            'produk' => $produk,
            'ratingStats' => $ratingStats,
            'produkTerkait' => $produkTerkait,
            'produkPetani' => $produkPetani,
        ]);
    }

    /**
     * Show products by category
     */
    public function byKategori(Request $request, string $slug): View
    {
        $kategori = Kategori::where('slug_kategori', $slug)->firstOrFail();

        $query = Produk::where('id_kategori', $kategori->id_kategori)
            ->tersedia()
            ->with(['petani', 'ulasan']);

        // Search within category
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where('nama_produk', 'like', "%{$search}%");
        }

        // Sorting
        $sort = $request->input('sort', 'terbaru');
        switch ($sort) {
            case 'termurah':
                $query->orderBy('harga', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga', 'desc');
                break;
            case 'terlaris':
                $query->withCount('itemPesanan')
                      ->orderBy('item_pesanan_count', 'desc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('tgl_dibuat', 'desc');
                break;
        }

        $produk = $query->paginate(12)->withQueryString();

        // All categories for sidebar navigation
        $kategoriList = Kategori::withCount(['produk' => function ($q) {
            $q->tersedia();
        }])->get();

        return view('pages.kategori', [
            'kategori' => $kategori,
            'produk' => $produk,
            'kategoriList' => $kategoriList,
            'currentSort' => $sort,
            'currentSearch' => $request->input('q'),
        ]);
    }
}
