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
        Schema::create('kupon', function (Blueprint $table) {
            $table->id('id_kupon');
            $table->string('kode_kupon', 20)->unique();
            $table->enum('tipe_diskon', ['nominal', 'persen']);
            $table->decimal('nominal_diskon', 10, 2)->nullable();
            $table->decimal('persen_diskon', 5, 2)->nullable();
            $table->decimal('min_belanja', 10, 2)->default(0);
            $table->integer('limit_total')->nullable();
            $table->integer('limit_per_user')->default(1);
            $table->timestamp('tgl_mulai');
            $table->timestamp('tgl_selesai');
            $table->boolean('is_aktif')->default(true);
            $table->timestamp('tgl_dibuat')->useCurrent();

            $table->index(['is_aktif', 'tgl_selesai'], 'idx_aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kupon');
    }
};
