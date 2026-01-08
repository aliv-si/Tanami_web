<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';

    const CREATED_AT = 'tgl_dibuat';
    const UPDATED_AT = 'tgl_update';

    protected $fillable = [
        'id_pengguna',
        'id_produk',
        'jumlah',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tgl_dibuat' => 'datetime',
        'tgl_update' => 'datetime',
    ];

    // ==================== HELPER METHODS ====================

    /**
     * Hitung subtotal item keranjang
     */
    public function getSubtotalAttribute(): float
    {
        return $this->jumlah * $this->produk->harga;
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Pengguna pemilik keranjang
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Produk dalam keranjang
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
