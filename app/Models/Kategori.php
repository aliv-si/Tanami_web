<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori',
        'slug_kategori',
        'deskripsi',
    ];

    protected $casts = [
        'tgl_dibuat' => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Produk dalam kategori ini
     */
    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
    }
}
