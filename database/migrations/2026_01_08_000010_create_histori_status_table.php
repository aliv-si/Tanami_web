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
        Schema::create('histori_status', function (Blueprint $table) {
            $table->id('id_histori');
            $table->unsignedBigInteger('id_pesanan');
            $table->string('status_lama', 50)->nullable();
            $table->string('status_baru', 50);
            $table->unsignedBigInteger('id_pengubah')->nullable()->comment('ID user yang ubah status');
            $table->text('alasan')->nullable();
            $table->timestamp('tgl_dibuat')->useCurrent();

            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('pesanan')
                ->onDelete('cascade');

            $table->foreign('id_pengubah')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('set null');

            $table->index('id_pesanan', 'idx_pesanan_histori');
            $table->index(['status_baru', 'tgl_dibuat'], 'idx_status_perubahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_status');
    }
};
