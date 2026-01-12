<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UlasanController extends Controller
{
    /**
     * Show all reviews for petani's products
     */
    public function index(Request $request): View
    {
        $petaniId = Auth::id();

        // Get all product IDs for this petani
        $produkIds = Produk::where('id_petani', $petaniId)->pluck('id_produk');

        // ==================== RATING STATS ====================

        // Get rating distribution
        $distribution = Ulasan::whereIn('id_produk', $produkIds)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Fill missing ratings with 0
        $fullDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $fullDistribution[$i] = $distribution[$i] ?? 0;
        }

        // Calculate average and total
        $totalReviews = array_sum($fullDistribution);
        $weightedSum = 0;
        foreach ($fullDistribution as $rating => $count) {
            $weightedSum += $rating * $count;
        }
        $average = $totalReviews > 0 ? round($weightedSum / $totalReviews, 1) : 0;

        $ratingStats = [
            'average' => $average,
            'totalReviews' => $totalReviews,
            'distribution' => $fullDistribution,
        ];

        // ==================== REVIEWS LIST ====================

        $query = Ulasan::with(['produk', 'pengguna'])
            ->whereIn('id_produk', $produkIds);

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->input('rating'));
        }

        // Sort
        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('tgl_dibuat', 'asc');
        } elseif ($sort === 'tertinggi') {
            $query->orderBy('rating', 'desc');
        } else {
            $query->orderBy('tgl_dibuat', 'desc');
        }

        $reviewsList = $query->paginate(10)->withQueryString();

        // Transform to format expected by blade
        $reviews = $reviewsList->map(function ($ulasan) {
            $nama = $ulasan->pengguna->nama_lengkap ?? 'Anonim';
            return [
                'customerName' => $nama,
                'customerInitials' => strtoupper(substr($nama, 0, 2)),
                'rating' => $ulasan->rating,
                'date' => $ulasan->tgl_dibuat->format('d M Y'),
                'product' => [
                    'name' => $ulasan->produk->nama_produk ?? 'Produk tidak ditemukan',
                    'icon' => 'potted_plant',
                ],
                'comment' => $ulasan->komentar ?? '',
                'reply' => null, // Fitur balas ulasan bisa ditambahkan nanti
            ];
        });

        return view('petani.ulasan', compact('ratingStats', 'reviews', 'reviewsList'));
    }
}
