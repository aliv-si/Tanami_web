<?php

namespace App\Http\Controllers;

use App\Models\ItemPesanan;
use App\Models\Pesanan;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    /**
     * Store a review for a product from completed order
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_pesanan' => ['required', 'exists:pesanan,id_pesanan'],
            'id_produk' => ['required', 'exists:produk,id_produk'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'komentar' => ['nullable', 'string', 'max:1000'],
        ], [
            'rating.required' => 'Rating wajib dipilih.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
        ]);

        $userId = Auth::id();
        $pesananId = $validated['id_pesanan'];
        $produkId = $validated['id_produk'];

        // Verify order belongs to this user
        $pesanan = Pesanan::where('id_pesanan', $pesananId)
            ->where('id_pembeli', $userId)
            ->first();

        if (!$pesanan) {
            return back()->with('error', 'Pesanan tidak ditemukan.');
        }

        // Verify order is completed
        if ($pesanan->status_pesanan !== Pesanan::STATUS_SELESAI) {
            return back()->with('error', 'Ulasan hanya bisa diberikan untuk pesanan yang sudah selesai.');
        }

        // Verify product is in this order
        $itemExists = ItemPesanan::where('id_pesanan', $pesananId)
            ->where('id_produk', $produkId)
            ->exists();

        if (!$itemExists) {
            return back()->with('error', 'Produk tidak ditemukan dalam pesanan ini.');
        }

        // Check if already reviewed this product for this order
        $existingReview = Ulasan::where('id_pesanan', $pesananId)
            ->where('id_produk', $produkId)
            ->where('id_pengguna', $userId)
            ->exists();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        // Create the review
        Ulasan::create([
            'id_produk' => $produkId,
            'id_pengguna' => $userId,
            'id_pesanan' => $pesananId,
            'rating' => $validated['rating'],
            'komentar' => $validated['komentar'] ?? null,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }

    /**
     * Show reviews for a specific product (public)
     */
    public function showProductReviews(int $productId)
    {
        $reviews = Ulasan::with(['pengguna:id_pengguna,nama_lengkap'])
            ->where('id_produk', $productId)
            ->orderBy('tgl_dibuat', 'desc')
            ->paginate(10);

        $stats = Ulasan::where('id_produk', $productId)
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total')
            ->first();

        return response()->json([
            'average' => $stats->avg_rating ? round($stats->avg_rating, 1) : 0,
            'total' => $stats->total,
            'reviews' => $reviews,
        ]);
    }
}
