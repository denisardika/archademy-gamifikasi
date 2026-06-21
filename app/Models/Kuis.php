<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    use HasFactory;

    protected $table = 'kuises';

    protected $fillable = [
        'materi_id',
        'pertanyaan',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'jawaban_benar'
    ];

    // Relasi balik ke materi
    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }
}