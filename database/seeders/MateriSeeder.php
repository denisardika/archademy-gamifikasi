<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materi;

class MateriSeeder extends Seeder
{
    public function run(): void
    {
        // Modul 1: Topologi Jaringan (ID: 1)
        Materi::create([
            'judul' => 'Topologi Jaringan Komputer',
            'slug' => 'topologi-jaringan-komputer',
            'konten' => '<h3>1. Pengantar Topologi</h3><p>Topologi jaringan adalah cetak biru geometris yang menjelaskan bagaimana simpul-simpul (node) seperti komputer, server, dan perangkat jaringan saling terhubung satu sama lain. Pemilihan topologi berdampak langsung pada biaya, performa, dan skalabilitas jaringan.</p><h3>2. Jenis-Jenis Topologi Utama</h3><ul><li><strong>Topologi Bus:</strong> Menggunakan satu kabel pusat (backbone). Sangat hemat kabel, namun jika kabel pusat putus, seluruh jaringan akan lumpuh total.</li><li><strong>Topologi Star:</strong> Setiap perangkat terhubung langsung ke switch/hub pusat. Jika satu kabel workstation putus, komputer lain tidak terganggu. Ini adalah topologi yang paling banyak digunakan saat ini.</li><li><strong>Topologi Mesh:</strong> Setiap node terhubung ke setiap node lainnya. Memiliki keandalan (redundancy) sangat tinggi, namun sangat boros kabel dan sulit dikonfigurasi.</li></ul>',
            'xp_reward' => 20
        ]);

        // Modul 2: IP Addressing & Subnetting (ID: 2)
        Materi::create([
            'judul' => 'IP Addressing dan Dasar Subnetting',
            'slug' => 'ip-addressing-dan-dasar-subnetting',
            'konten' => '<h3>1. Apa itu IP Address?</h3><p>Internet Protocol (IP) Address adalah identitas numerik unik yang diberikan kepada setiap perangkat yang terhubung ke jaringan komputer berbasis TCP/IP. IP v4 terdiri dari 32 bit yang dibagi menjadi 4 oktet.</p><h3>2. Kelas-Kelas IPv4</h3><ul><li><strong>Kelas A:</strong> Range 1 - 126 (Untuk jaringan skala sangat besar).</li><li><strong>Kelas B:</strong> Range 128 - 191 (Untuk jaringan skala menengah).</li><li><strong>Kelas C:</strong> Range 192 - 223 (Untuk jaringan skala kecil / lokal seperti LAN).</li></ul><h3>3. Konsep Subnetting</h3><p>Subnetting adalah teknik memecah satu jaringan besar (network) menjadi beberapa jaringan yang lebih kecil (subnet). Tujuannya adalah untuk menghemat alokasi IP Address, mengurangi lalu lintas broadcast, dan meningkatkan keamanan jaringan.</p>',
            'xp_reward' => 30
        ]);

        // Modul 3: Routing Fundamental (ID: 3)
        Materi::create([
            'judul' => 'Routing Fundamental & Dinamis',
            'slug' => 'routing-fundamental-dan-dinamis',
            'konten' => '<h3>1. Pengertian Routing</h3><p>Routing adalah proses meneruskan paket data dari satu jaringan ke jaringan lainnya melalui perangkat bernama Router. Router menggunakan tabel routing untuk menentukan jalur terbaik (best path) menuju destinasi.</p><h3>2. Jenis-Jenis Routing</h3><ul><li><strong>Static Routing:</strong> Tabel routing dikonfigurasi secara manual oleh administrator. Sangat aman dan hemat perangkat keras, namun tidak praktis untuk jaringan skala besar.</li><li><strong>Dynamic Routing:</strong> Router saling bertukar informasi routing secara otomatis menggunakan protokol tertentu jika ada perubahan topologi.</li></ul><h3>3. Protokol Routing Dinamis Populer</h3><p>Beberapa protokol dynamic routing yang sering digunakan antara lain OSPF (Open Shortest Path First) untuk skala internal, dan BGP (Border Gateway Protocol) yang menjadi tulang punggung internet global.</p>',
            'xp_reward' => 40
        ]);
    }
}