<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang benar di database
    protected $table = 'materis';

    // Proteksi Mass Assignment standar industri
    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'xp_reward'
    ];

    /**
     * Relasi HasMany: Satu materi memiliki banyak kuis/soal evaluasi
     * Menghubungkan model Materi dengan model Kuis
     */
    public function kuis()
    {
        return $this->hasMany(Kuis::class);
    }
}