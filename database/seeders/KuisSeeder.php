<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kuis;

class KuisSeeder extends Seeder
{
    public function run(): void
    {
        // --- KUIS UNTUK MATERI 1 (Topologi Jaringan) ---
        Kuis::create([
            'materi_id' => 1,
            'pertanyaan' => 'Topologi jaringan yang menggunakan sebuah kabel pusat sebagai backbone adalah...',
            'opsi_a' => 'Topologi Star', 'opsi_b' => 'Topologi Mesh', 'opsi_c' => 'Topologi Bus', 'opsi_d' => 'Topologi Ring',
            'jawaban_benar' => 'C'
        ]);
        Kuis::create([
            'materi_id' => 1,
            'pertanyaan' => 'Jika pusat switch/hub pada Topologi Star rusak, apa yang terjadi pada jaringan?',
            'opsi_a' => 'Jaringan tetap berjalan normal', 'opsi_b' => 'Seluruh jaringan lumpuh total', 'opsi_c' => 'Hanya satu komputer yang mati', 'opsi_d' => 'Kecepatan internet bertambah',
            'jawaban_benar' => 'B'
        ]);

        // --- KUIS UNTUK MATERI 2 (IP Addressing & Subnetting) ---
        Kuis::create([
            'materi_id' => 2,
            'pertanyaan' => 'IP Address 192.168.1.1 termasuk ke dalam kategori IPv4 kelas...',
            'opsi_a' => 'Kelas A', 'opsi_b' => 'Kelas B', 'opsi_c' => 'Kelas C', 'opsi_d' => 'Kelas D',
            'jawaban_benar' => 'C'
        ]);
        Kuis::create([
            'materi_id' => 2,
            'pertanyaan' => 'Apa tujuan utama dari dilakukannya teknik Subnetting pada jaringan?',
            'opsi_a' => 'Memperpanjang kabel jaringan', 'opsi_b' => 'Mengecilkan ukuran fisik router', 'opsi_c' => 'Menghemat IP, mengurangi broadcast, dan efisiensi manajemen', 'opsi_d' => 'Mengubah IP publik menjadi IP privat',
            'jawaban_benar' => 'C'
        ]);

        // --- KUIS UNTUK MATERI 3 (Routing Fundamental) ---
        Kuis::create([
            'materi_id' => 3,
            'pertanyaan' => 'Perangkat jaringan yang bertugas menentukan jalur terbaik (best path) dan meneruskan paket antar jaringan yang berbeda adalah...',
            'opsi_a' => 'Switch Layer 2', 'opsi_b' => 'Router', 'opsi_c' => 'Access Point', 'opsi_d' => 'Hub',
            'jawaban_benar' => 'B'
        ]);
        Kuis::create([
            'materi_id' => 3,
            'pertanyaan' => 'Protokol routing dinamis yang sering digunakan untuk area internal jaringan skala besar berbasis link-state adalah...',
            'opsi_a' => 'Static Route', 'opsi_b' => 'OSPF', 'opsi_c' => 'BGP', 'opsi_d' => 'RIP',
            'jawaban_benar' => 'B'
        ]);
    }
}