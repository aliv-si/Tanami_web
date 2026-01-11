<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Escrow extends Model
{
    use HasFactory;

    protected $table = 'escrow';
    protected $primaryKey = 'id_escrow';
    public $timestamps = false;

    // Status escrow constants
    const STATUS_DITAHAN = 'ditahan';
    const STATUS_DIKIRIM_KE_PETANI = 'dikirim_ke_petani';
    const STATUS_DIREFUND_KE_PEMBELI = 'direfund_ke_pembeli';

    protected $fillable = [
        'id_pesanan',
        'jumlah',
        'status_escrow',
        'tgl_ditahan',
        'tgl_kirim',
        'id_penerima',
        'catatan',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tgl_ditahan' => 'datetime',
        'tgl_kirim' => 'datetime',
        'tgl_dibuat' => 'datetime',
    ];

    // ==================== SCOPES ====================

    public function scopeDitahan($query)
    {
        return $query->where('status_escrow', self::STATUS_DITAHAN);
    }

    public function scopeDikirimKePetani($query)
    {
        return $query->where('status_escrow', self::STATUS_DIKIRIM_KE_PETANI);
    }

    public function scopeDirefundKePembeli($query)
    {
        return $query->where('status_escrow', self::STATUS_DIREFUND_KE_PEMBELI);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Kirim dana ke petani
     */
    public function kirimKePetani(int $idPetani, ?string $catatan = null): bool
    {
        $this->status_escrow = self::STATUS_DIKIRIM_KE_PETANI;
        $this->tgl_kirim = now();
        $this->id_penerima = $idPetani;
        $this->catatan = $catatan;
        return $this->save();
    }

    /**
     * Refund dana ke pembeli
     */
    public function refundKePembeli(int $idPembeli, ?string $catatan = null): bool
    {
        $this->status_escrow = self::STATUS_DIREFUND_KE_PEMBELI;
        $this->tgl_kirim = now();
        $this->id_penerima = $idPembeli;
        $this->catatan = $catatan;
        return $this->save();
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Pesanan yang terkait dengan escrow ini
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Penerima dana (petani atau pembeli)
     */
    public function penerima(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_penerima', 'id_pengguna');
    }
}
