<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');            // Contoh: Topologi Jaringan, Subnetting IPv4
            $table->string('slug')->unique();   // Contoh: topologi-jaringan, subnetting-ipv4
            $table->text('konten');             // Isi text materi pembelajaran yang panjang
            $table->integer('xp_reward')->default(20); // Jumlah XP yang didapat setelah membaca
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};