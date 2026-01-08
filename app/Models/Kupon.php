<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kupon extends Model
{
    use HasFactory;

    protected $table = 'kupon';
    protected $primaryKey = 'id_kupon';
    public $timestamps = false;

    protected $fillable = [
        'kode_kupon',
        'tipe_diskon',
        'nominal_diskon',
        'persen_diskon',
        'min_belanja',
        'limit_total',
        'limit_per_user',
        'tgl_mulai',
        'tgl_selesai',
        'is_aktif',
    ];

    protected $casts = [
        'nominal_diskon' => 'decimal:2',
        'persen_diskon' => 'decimal:2',
        'min_belanja' => 'decimal:2',
        'is_aktif' => 'boolean',
        'tgl_mulai' => 'datetime',
        'tgl_selesai' => 'datetime',
        'tgl_dibuat' => 'datetime',
    ];

    // ==================== SCOPES ====================

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    public function scopeValid($query)
    {
        return $query->where('is_aktif', true)
            ->where('tgl_mulai', '<=', now())
            ->where('tgl_selesai', '>=', now());
    }

    // ==================== HELPER METHODS ====================

    /**
     * Cek apakah kupon masih valid
     */
    public function isValid(): bool
    {
        return $this->is_aktif
            && $this->tgl_mulai <= now()
            && $this->tgl_selesai >= now();
    }

    /**
     * Hitung diskon berdasarkan subtotal
     */
    public function hitungDiskon(float $subtotal): float
    {
        if ($subtotal < $this->min_belanja) {
            return 0;
        }

        if ($this->tipe_diskon === 'nominal') {
            return min($this->nominal_diskon, $subtotal);
        }

        // persen
        return $subtotal * ($this->persen_diskon / 100);
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Pemakaian kupon
     */
    public function pemakaian(): HasMany
    {
        return $this->hasMany(PemakaianKupon::class, 'id_kupon', 'id_kupon');
    }
}
