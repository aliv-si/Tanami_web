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
        Schema::create('escrow', function (Blueprint $table) {
            $table->id('id_escrow');
            $table->unsignedBigInteger('id_pesanan')->unique();
            $table->decimal('jumlah', 10, 2);
            $table->enum('status_escrow', ['ditahan', 'dikirim_ke_petani', 'direfund_ke_pembeli'])->default('ditahan');
            $table->timestamp('tgl_ditahan')->nullable();
            $table->timestamp('tgl_kirim')->nullable();
            $table->unsignedBigInteger('id_penerima')->nullable()->comment('ID petani atau pembeli penerima dana');
            $table->text('catatan')->nullable();
            $table->timestamp('tgl_dibuat')->useCurrent();

            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('pesanan')
                ->onDelete('restrict');

            $table->foreign('id_penerima')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('set null');

            $table->index('id_pesanan', 'idx_pesanan_escrow');
            $table->index('status_escrow', 'idx_status_escrow');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escrow');
    }
};
