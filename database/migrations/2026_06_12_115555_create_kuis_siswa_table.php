<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuis_siswa', function (Blueprint $table) {
            $table->id();
            
            // Relasi ganda: Siapa siswanya dan materi kuis apa yang dikerjakan
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('materi_id')->constrained('materis')->onDelete('cascade');
            
            $table->integer('jawaban_benar_count'); // Berapa soal yang dijawab benar
            $table->boolean('lulus');              // True = Lulus KKM, False = Remedial
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuis_siswa');
    }
};