<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekeningPetani extends Model
{
    use HasFactory;

    protected $table = 'rekening_petani';
    protected $primaryKey = 'id_rekening';
    public $timestamps = false;

    protected $fillable = [
        'id_petani',
        'nama_bank',
        'no_rekening',
        'atas_nama',
        'is_utama',
    ];

    protected $casts = [
        'is_utama' => 'boolean',
        'tgl_dibuat' => 'datetime',
    ];

    // ==================== SCOPES ====================

    public function scopeUtama($query)
    {
        return $query->where('is_utama', true);
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Petani pemilik rekening
     */
    public function petani(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_petani', 'id_pengguna');
    }
}
