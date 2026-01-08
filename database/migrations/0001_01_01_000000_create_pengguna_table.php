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
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->string('nama_lengkap', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255)->comment('Hash bcrypt');
            $table->enum('role_pengguna', ['admin', 'petani', 'pembeli']);
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamp('tgl_daftar')->useCurrent();
            $table->timestamp('tgl_update')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('pengguna');
    }
};
