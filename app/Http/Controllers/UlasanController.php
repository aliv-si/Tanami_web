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
     * Uses id_item_pesanan as per database schema
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_item_pesanan' => ['required', 'exists:item_pesanan,id_item'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'komentar' => ['nullable', 'string', 'max:1000'],
        ], [
            'rating.required' => 'Rating wajib dipilih.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
        ]);

        $userId = Auth::id();
        $itemId = $validated['id_item_pesanan'];

        // Find the item and verify ownership
        $item = ItemPesanan::with('pesanan')->find($itemId);

        if (!$item || $item->pesanan->id_pembeli !== $userId) {
            return back()->with('error', 'Item pesanan tidak ditemukan.');
        }

        // Verify order is completed
        if ($item->pesanan->status_pesanan !== Pesanan::STATUS_SELESAI) {
            return back()->with('error', 'Ulasan hanya bisa diberikan untuk pesanan yang sudah selesai.');
        }

        // Check if already reviewed this item
        $existingReview = Ulasan::where('id_item_pesanan', $itemId)->exists();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        // Create the review
        Ulasan::create([
            'id_item_pesanan' => $itemId,
            'id_pengguna' => $userId,
            'id_produk' => $item->id_produk,
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
