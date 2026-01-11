<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ItemPesanan extends Model
{
    use HasFactory;

    protected $table = 'item_pesanan';
    protected $primaryKey = 'id_item';
    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'id_petani',
        'jumlah',
        'harga_snapshot',
        'subtotal',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga_snapshot' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tgl_dibuat' => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Pesanan yang memiliki item ini
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Produk yang dipesan
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    /**
     * Petani pemilik produk (denormalized)
     */
    public function petani(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_petani', 'id_pengguna');
    }

    /**
     * Ulasan untuk item ini (max 1)
     */
    public function ulasan(): HasOne
    {
        return $this->hasOne(Ulasan::class, 'id_item_pesanan', 'id_item');
    }
}
