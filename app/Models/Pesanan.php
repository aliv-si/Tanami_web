<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';

    const CREATED_AT = 'tgl_dibuat';
    const UPDATED_AT = 'tgl_update';

    // Status pesanan constants
    const STATUS_PENDING = 'pending';
    const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';
    const STATUS_DIBAYAR = 'dibayar';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_DIKIRIM = 'dikirim';
    const STATUS_TERKIRIM = 'terkirim';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DIBATALKAN = 'dibatalkan';
    const STATUS_MINTA_REFUND = 'minta_refund';
    const STATUS_DIREFUND = 'direfund';

    protected $fillable = [
        'id_pembeli',
        'id_kota_tujuan',
        'subtotal',
        'ongkir',
        'diskon',
        'total_bayar',
        'status_pesanan',
        'bukti_bayar',
        'tgl_verifikasi',
        'id_verifikator',
        'alasan_tolak',
        'no_resi',
        'batas_bayar',
        'catatan',
        'tgl_selesai',
        'id_konfirmasi',
        'tgl_selesai_otomatis',
        'alasan_batal',
        'tgl_dibatalkan',
        'alasan_refund',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'ongkir' => 'decimal:2',
        'diskon' => 'decimal:2',
        'total_bayar' => 'decimal:2',
        'tgl_verifikasi' => 'datetime',
        'batas_bayar' => 'datetime',
        'tgl_dibuat' => 'datetime',
        'tgl_update' => 'datetime',
        'tgl_selesai' => 'datetime',
        'tgl_selesai_otomatis' => 'datetime',
        'tgl_dibatalkan' => 'datetime',
    ];

    // ==================== SCOPES ====================

    public function scopePending($query)
    {
        return $query->where('status_pesanan', self::STATUS_PENDING);
    }

    public function scopeMenungguVerifikasi($query)
    {
        return $query->where('status_pesanan', self::STATUS_MENUNGGU_VERIFIKASI);
    }

    public function scopeAktif($query)
    {
        return $query->whereNotIn('status_pesanan', [
            self::STATUS_DIBATALKAN,
            self::STATUS_SELESAI,
            self::STATUS_DIREFUND,
        ]);
    }

    public function scopeTimeout($query)
    {
        return $query->where('status_pesanan', self::STATUS_PENDING)
            ->where('batas_bayar', '<', now())
            ->whereNull('bukti_bayar');
    }

    public function scopeSiapAutoComplete($query)
    {
        return $query->where('status_pesanan', self::STATUS_TERKIRIM)
            ->where('tgl_update', '<', now()->subDays(3));
    }

    // ==================== HELPER METHODS ====================

    /**
     * Cek apakah pesanan sudah timeout (24 jam)
     */
    public function isTimeout(): bool
    {
        return $this->status_pesanan === self::STATUS_PENDING
            && $this->batas_bayar < now()
            && empty($this->bukti_bayar);
    }

    /**
     * Cek apakah bisa di-cancel
     */
    public function bisaDibatalkan(): bool
    {
        return in_array($this->status_pesanan, [
            self::STATUS_PENDING,
            self::STATUS_MENUNGGU_VERIFIKASI,
        ]);
    }

    /**
     * Cek apakah bisa upload bukti bayar
     */
    public function bisaUploadBukti(): bool
    {
        return $this->status_pesanan === self::STATUS_PENDING
            && $this->batas_bayar > now();
    }

    /**
     * Cek apakah bisa diverifikasi
     */
    public function bisaDiverifikasi(): bool
    {
        return $this->status_pesanan === self::STATUS_MENUNGGU_VERIFIKASI;
    }

    /**
     * Cek apakah bisa dikonfirmasi selesai oleh pembeli
     */
    public function bisaDikonfirmasi(): bool
    {
        return $this->status_pesanan === self::STATUS_TERKIRIM;
    }

    /**
     * Cek apakah bisa request refund
     */
    public function bisaRefund(): bool
    {
        return $this->status_pesanan === self::STATUS_TERKIRIM;
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Pembeli yang membuat pesanan
     */
    public function pembeli(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pembeli', 'id_pengguna');
    }

    /**
     * Kota tujuan pengiriman
     */
    public function kota(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'id_kota_tujuan', 'id_kota');
    }

    /**
     * Verifikator (petani/admin yang verifikasi pembayaran)
     */
    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_verifikator', 'id_pengguna');
    }

    /**
     * Pembeli yang konfirmasi penerimaan
     */
    public function konfirmator(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_konfirmasi', 'id_pengguna');
    }

    /**
     * Item-item dalam pesanan
     */
    public function items(): HasMany
    {
        return $this->hasMany(ItemPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Escrow untuk pesanan ini
     */
    public function escrow(): HasOne
    {
        return $this->hasOne(Escrow::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Histori perubahan status
     */
    public function historiStatus(): HasMany
    {
        return $this->hasMany(HistoriStatus::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Pemakaian kupon untuk pesanan ini
     */
    public function pemakaianKupon(): HasOne
    {
        return $this->hasOne(PemakaianKupon::class, 'id_pesanan', 'id_pesanan');
    }
}
