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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // 👥 SISTEM MULTI-ROLE (POV GURU & SISWA)
            $table->string('role')->default('siswa'); // Nilai bisa: 'siswa' atau 'guru'
            
            // 🎯 SISTEM GAMIFIKASI UTAMA SISWA
            $table->integer('points')->default(0);        // Total XP keseluruhan
            $table->integer('materi_points')->default(0); // Poin hasil membaca
            $table->integer('kuis_points')->default(0);   // Poin hasil kuis
            $table->string('rank')->default('Pemula');     // Pangkat kompetensi siswa
            
            $table->rememberToken();
            $table->timestamps();
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};