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
        Schema::create('item_pesanan', function (Blueprint $table) {
            $table->id('id_item');
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_petani')->comment('Denormalized untuk laporan');
            $table->integer('jumlah');
            $table->decimal('harga_snapshot', 10, 2)->comment('Harga saat checkout');
            $table->decimal('subtotal', 10, 2);
            $table->timestamp('tgl_dibuat')->useCurrent();

            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('pesanan')
                ->onDelete('cascade');

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produk')
                ->onDelete('restrict');

            $table->foreign('id_petani')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('restrict');

            $table->index('id_pesanan', 'idx_pesanan');
            $table->index('id_petani', 'idx_petani');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pesanan');
    }
};
