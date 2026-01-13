<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';

    const CREATED_AT = 'tgl_daftar';
    const UPDATED_AT = 'tgl_update';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role_pengguna',
        'alamat',
        'no_hp',
        'foto',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
        'tgl_daftar' => 'datetime',
        'tgl_update' => 'datetime',
        'password' => 'hashed',
    ];

    // ==================== HELPER METHODS ====================

    public function isAdmin(): bool
    {
        return $this->role_pengguna === 'admin';
    }

    public function isPetani(): bool
    {
        return $this->role_pengguna === 'petani';
    }

    public function isPembeli(): bool
    {
        return $this->role_pengguna === 'pembeli';
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Produk yang dimiliki petani
     */
    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class, 'id_petani', 'id_pengguna');
    }

    /**
     * Pesanan yang dibuat pembeli
     */
    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_pembeli', 'id_pengguna');
    }

    /**
     * Ulasan yang ditulis pengguna
     */
    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Keranjang belanja pengguna
     */
    public function keranjang(): HasMany
    {
        return $this->hasMany(Keranjang::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Rekening bank petani
     */
    public function rekening(): HasMany
    {
        return $this->hasMany(RekeningPetani::class, 'id_petani', 'id_pengguna');
    }

    /**
     * Pemakaian kupon oleh pengguna
     */
    public function pemakaianKupon(): HasMany
    {
        return $this->hasMany(PemakaianKupon::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Pesanan yang diverifikasi (untuk petani/admin)
     */
    public function pesananDiverifikasi(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_verifikator', 'id_pengguna');
    }

    /**
     * Pesanan yang dikonfirmasi selesai
     */
    public function pesananDikonfirmasi(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_konfirmasi', 'id_pengguna');
    }

    /**
     * Escrow yang diterima (sebagai petani atau refund ke pembeli)
     */
    public function escrowDiterima(): HasMany
    {
        return $this->hasMany(Escrow::class, 'id_penerima', 'id_pengguna');
    }

    /**
     * Histori status yang diubah oleh pengguna ini
     */
    public function historiStatusDiubah(): HasMany
    {
        return $this->hasMany(HistoriStatus::class, 'id_pengubah', 'id_pengguna');
    }
}
