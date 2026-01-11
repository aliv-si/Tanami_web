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
        Schema::create('rekening_petani', function (Blueprint $table) {
            $table->id('id_rekening');
            $table->unsignedBigInteger('id_petani');
            $table->string('nama_bank', 50);
            $table->string('no_rekening', 30);
            $table->string('atas_nama', 100);
            $table->boolean('is_utama')->default(false);
            $table->timestamp('tgl_dibuat')->useCurrent();

            $table->foreign('id_petani')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('cascade');

            $table->index('id_petani', 'idx_petani');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening_petani');
    }
};
