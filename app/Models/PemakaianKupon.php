<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemakaianKupon extends Model
{
    use HasFactory;

    protected $table = 'pemakaian_kupon';
    protected $primaryKey = 'id_pemakaian';
    public $timestamps = false;

    protected $fillable = [
        'id_kupon',
        'id_pengguna',
        'id_pesanan',
        'diskon_dipakai',
    ];

    protected $casts = [
        'diskon_dipakai' => 'decimal:2',
        'tgl_pakai' => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Kupon yang dipakai
     */
    public function kupon(): BelongsTo
    {
        return $this->belongsTo(Kupon::class, 'id_kupon', 'id_kupon');
    }

    /**
     * Pengguna yang memakai kupon
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Pesanan yang menggunakan kupon
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
