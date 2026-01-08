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
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id('id_ulasan');
            $table->unsignedBigInteger('id_item_pesanan')->unique();
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_produk')->comment('Denormalized');
            $table->integer('rating')->unsigned();
            $table->text('komentar')->nullable();
            $table->timestamp('tgl_dibuat')->useCurrent();

            $table->foreign('id_item_pesanan')
                ->references('id_item')
                ->on('item_pesanan')
                ->onDelete('cascade');

            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('cascade');

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produk')
                ->onDelete('cascade');

            $table->index('id_produk', 'idx_produk');
        });

        // Add check constraint for rating 1-5
        // Note: MySQL 8.0.16+ supports CHECK constraints
        // For Laravel, we'll use the model validation instead
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
