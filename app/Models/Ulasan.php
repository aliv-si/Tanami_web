<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan';
    protected $primaryKey = 'id_ulasan';
    public $timestamps = false;

    protected $fillable = [
        'id_item_pesanan',
        'id_pengguna',
        'id_produk',
        'rating',
        'komentar',
    ];

    protected $casts = [
        'rating' => 'integer',
        'tgl_dibuat' => 'datetime',
    ];

    // ==================== VALIDATION RULES ====================

    public static function rules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ];
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Item pesanan yang diulas
     */
    public function itemPesanan(): BelongsTo
    {
        return $this->belongsTo(ItemPesanan::class, 'id_item_pesanan', 'id_item');
    }

    /**
     * Pengguna yang menulis ulasan
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Produk yang diulas (denormalized)
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
