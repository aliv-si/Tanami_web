<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoriStatus extends Model
{
    use HasFactory;

    protected $table = 'histori_status';
    protected $primaryKey = 'id_histori';

    const CREATED_AT = 'tgl_dibuat';
    const UPDATED_AT = null; // No updated_at column

    protected $fillable = [
        'id_pesanan',
        'status_lama',
        'status_baru',
        'id_pengubah',
        'alasan',
    ];

    protected $casts = [
        'tgl_dibuat' => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Pesanan yang histori statusnya dicatat
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * User yang mengubah status
     */
    public function pengubah(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengubah', 'id_pengguna');
    }
}
