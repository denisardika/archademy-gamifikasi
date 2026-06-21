<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materi_dibaca', function (Blueprint $table) {
            $table->id();
            
            // Jembatan Relasi: Menghubungkan Siswa dan Materi yang dibaca
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('materi_id')->constrained('materis')->onDelete('cascade');
            
            $table->timestamp('created_at')->useCurrent();

            // Optimasi Database Tingkat Tinggi: Mencegah duplikasi klaim poin di database
            $table->unique(['user_id', 'materi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materi_dibaca');
    }
};