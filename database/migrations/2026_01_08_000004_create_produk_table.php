<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->unsignedBigInteger('id_petani');
            $table->unsignedBigInteger('id_kategori');
            $table->string('nama_produk', 100);
            $table->string('slug_produk', 100)->unique();
            $table->decimal('harga', 10, 2);
            $table->integer('stok')->default(0);
            $table->integer('stok_direserve')->default(0);
            $table->string('satuan', 20)->comment('kg, pcs, ikat, dll');
            $table->text('deskripsi')->nullable();
            $table->string('foto', 255)->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamp('tgl_dibuat')->useCurrent();
            $table->timestamp('tgl_update')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_petani')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('cascade');

            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategori')
                ->onDelete('restrict');

            $table->index('id_petani', 'idx_petani');
            $table->index('id_kategori', 'idx_kategori');
            $table->index('is_aktif', 'idx_aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
