<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuises', function (Blueprint $table) {
            $table->id();
            
            // Relasi murni: Menghubungkan soal kuis ke materi spesifik
            $table->foreignId('materi_id')->constrained('materis')->onDelete('cascade');
            
            $table->text('pertanyaan');
            $table->string('opsi_a');
            $table->string('opsi_b');
            $table->string('opsi_c');
            $table->string('opsi_d');
            $table->char('jawaban_benar', 1); // Menyimpan value: 'A', 'B', 'C', atau 'D'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuises');
    }
};