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
        Schema::create('pemakaian_kupon', function (Blueprint $table) {
            $table->id('id_pemakaian');
            $table->unsignedBigInteger('id_kupon');
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_pesanan');
            $table->decimal('diskon_dipakai', 10, 2);
            $table->timestamp('tgl_pakai')->useCurrent();

            $table->foreign('id_kupon')
                ->references('id_kupon')
                ->on('kupon')
                ->onDelete('cascade');

            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('cascade');

            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('pesanan')
                ->onDelete('cascade');

            $table->index(['id_kupon', 'id_pengguna'], 'idx_kupon_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemakaian_kupon');
    }
};
