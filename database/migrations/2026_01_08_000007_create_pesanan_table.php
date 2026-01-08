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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->unsignedBigInteger('id_pembeli');
            $table->unsignedBigInteger('id_kota_tujuan');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('ongkir', 10, 2);
            $table->decimal('diskon', 10, 2)->default(0);
            $table->decimal('total_bayar', 10, 2);
            $table->enum('status_pesanan', [
                'pending',
                'menunggu_verifikasi',
                'dibayar',
                'diproses',
                'dikirim',
                'terkirim',
                'selesai',
                'dibatalkan',
                'minta_refund',
                'direfund'
            ])->default('pending');
            $table->string('bukti_bayar', 255)->nullable();
            $table->timestamp('tgl_verifikasi')->nullable();
            $table->unsignedBigInteger('id_verifikator')->nullable()->comment('ID petani/admin yang verifikasi');
            $table->text('alasan_tolak')->nullable();
            $table->string('no_resi', 100)->nullable();
            $table->timestamp('batas_bayar')->nullable()->comment('24 jam dari checkout');
            $table->text('catatan')->nullable();
            $table->timestamp('tgl_dibuat')->useCurrent();
            $table->timestamp('tgl_update')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('tgl_selesai')->nullable()->comment('Waktu pembeli konfirmasi selesai');
            $table->unsignedBigInteger('id_konfirmasi')->nullable()->comment('ID pembeli yang konfirmasi');
            $table->timestamp('tgl_selesai_otomatis')->nullable()->comment('Auto-complete setelah 3 hari');
            $table->text('alasan_batal')->nullable();
            $table->timestamp('tgl_dibatalkan')->nullable();

            $table->foreign('id_pembeli')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('restrict');

            $table->foreign('id_kota_tujuan')
                ->references('id_kota')
                ->on('kota')
                ->onDelete('restrict');

            $table->foreign('id_verifikator')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('set null');

            $table->foreign('id_konfirmasi')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('set null');

            $table->index(['id_pembeli', 'status_pesanan'], 'idx_pembeli_status');
            $table->index('batas_bayar', 'idx_batas_bayar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
