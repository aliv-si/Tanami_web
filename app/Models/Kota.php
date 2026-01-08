<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kota extends Model
{
    use HasFactory;

    protected $table = 'kota';
    protected $primaryKey = 'id_kota';
    public $timestamps = false;

    protected $fillable = [
        'nama_kota',
        'provinsi',
        'ongkir',
        'is_aktif',
    ];

    protected $casts = [
        'ongkir' => 'decimal:2',
        'is_aktif' => 'boolean',
        'tgl_dibuat' => 'datetime',
    ];

    // ==================== SCOPES ====================

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Pesanan yang dikirim ke kota ini
     */
    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_kota_tujuan', 'id_kota');
    }
}
