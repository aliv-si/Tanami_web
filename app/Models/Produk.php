<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    const CREATED_AT = 'tgl_dibuat';
    const UPDATED_AT = 'tgl_update';

    protected $fillable = [
        'id_petani',
        'id_kategori',
        'nama_produk',
        'slug_produk',
        'harga',
        'stok',
        'stok_direserve',
        'satuan',
        'deskripsi',
        'foto',
        'is_aktif',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
        'stok_direserve' => 'integer',
        'is_aktif' => 'boolean',
        'tgl_dibuat' => 'datetime',
        'tgl_update' => 'datetime',
    ];

    // ==================== SCOPES ====================

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    public function scopeTersedia($query)
    {
        return $query->where('is_aktif', true)
            ->whereRaw('stok > stok_direserve');
    }

    // ==================== HELPER METHODS ====================

    /**
     * Stok yang tersedia (belum di-reserve)
     */
    public function stokTersedia(): int
    {
        return max(0, $this->stok - $this->stok_direserve);
    }

    /**
     * Cek apakah stok tersedia untuk jumlah tertentu
     */
    public function cekStok(int $jumlah): bool
    {
        return $this->stokTersedia() >= $jumlah;
    }

    /**
     * Reserve stok untuk checkout
     */
    public function reserveStok(int $jumlah): bool
    {
        if (!$this->cekStok($jumlah)) {
            return false;
        }

        $this->stok_direserve += $jumlah;
        return $this->save();
    }

    /**
     * Release reserved stok (cancel/timeout)
     */
    public function releaseStok(int $jumlah): bool
    {
        $this->stok_direserve = max(0, $this->stok_direserve - $jumlah);
        return $this->save();
    }

    /**
     * Kurangi stok aktual (setelah pembayaran diverifikasi)
     */
    public function kurangiStok(int $jumlah): bool
    {
        $this->stok -= $jumlah;
        $this->stok_direserve = max(0, $this->stok_direserve - $jumlah);
        return $this->save();
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Petani pemilik produk
     */
    public function petani(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_petani', 'id_pengguna');
    }

    /**
     * Kategori produk
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Item pesanan yang berisi produk ini
     */
    public function itemPesanan(): HasMany
    {
        return $this->hasMany(ItemPesanan::class, 'id_produk', 'id_produk');
    }

    /**
     * Keranjang yang berisi produk ini
     */
    public function keranjang(): HasMany
    {
        return $this->hasMany(Keranjang::class, 'id_produk', 'id_produk');
    }

    /**
     * Ulasan untuk produk ini
     */
    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'id_produk', 'id_produk');
    }

    /**
     * Rata-rata rating produk
     */
    public function getRataRatingAttribute(): float
    {
        return $this->ulasan()->avg('rating') ?? 0;
    }
}
