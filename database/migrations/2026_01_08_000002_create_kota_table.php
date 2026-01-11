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
        Schema::create('kota', function (Blueprint $table) {
            $table->id('id_kota');
            $table->string('nama_kota', 100)->unique();
            $table->string('provinsi', 100);
            $table->decimal('ongkir', 10, 2);
            $table->boolean('is_aktif')->default(true);
            $table->timestamp('tgl_dibuat')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kota');
    }
};
