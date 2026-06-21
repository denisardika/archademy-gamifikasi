<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Kuis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    /**
     * Menampilkan daftar semua materi (Dashboard Belajar)
     */
    public function index()
    {
        $materis = Materi::all();
        return view('siswa.materi_index', compact('materis'));
    }

    /**
     * Menampilkan halaman isi materi spesifik & cek status klaim/kuis
     */
    public function show($slug)
    {
        $materi = Materi::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        // Cek apakah siswa sudah pernah membaca materi ini sebelumnya
        $sudahBaca = DB::table('materi_dibaca')
            ->where('user_id', $user->id)
            ->where('materi_id', $materi->id)
            ->exists();

        // Cek apakah siswa sudah lulus kuis untuk materi ini
        $statusKuis = DB::table('kuis_siswa')
            ->where('user_id', $user->id)
            ->where('materi_id', $materi->id)
            ->first();

        // Ambil kumpulan soal kuis yang terikat dengan materi ini
        $soalKuis = Kuis::where('materi_id', $materi->id)->get();

        return view('siswa.materi_detail', compact('materi', 'sudahBaca', 'statusKuis', 'soalKuis'));
    }

    /**
     * Fitur Gamifikasi 1: Klaim Poin Membaca (+20 XP) dengan Proteksi Ganda
     */
    public function klaimPoin(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);
        $user = Auth::user();

        // PROTEKSI LOCKS (Anti-Cheat): Mencegah klik ganda berulang untuk manipulasi poin
        $sudahKlaim = DB::table('materi_dibaca')
            ->where('user_id', $user->id)
            ->where('materi_id', $materi->id)
            ->exists();

        if (!$sudahKlaim) {
            DB::transaction(function () use ($user, $materi) {
                // 1. Catat log membaca agar tidak bisa klaim lagi
                DB::table('materi_dibaca')->insert([
                    'user_id' => $user->id,
                    'materi_id' => $materi->id,
                    'created_at' => now()
                ]);

                // 2. Suntikkan poin ke akun siswa
                $user->increment('points', $materi->xp_reward);
                $user->increment('materi_points', $materi->xp_reward);
                
                // 3. Update tingkatan rank secara dinamis
                $this->updateRank($user);
            });

            return redirect()->back()->with('success', 'Selamat! Kamu berhasil mendapatkan +' . $materi->xp_reward . ' XP karena telah membaca modul ini.');
        }

        return redirect()->back()->with('error', 'Kamu sudah mengklaim poin untuk materi ini sebelumnya.');
    }

    /**
     * Fitur Gamifikasi 2: Engine Koreksi Kuis Otomatis & Halaman Detail Hasil Evaluasi
     */
    public function submitKuis(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);
        $soalKuis = Kuis::where('materi_id', $materi->id)->get();
        $user = Auth::user();

        if ($soalKuis->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada soal kuis ketersediaan untuk materi ini.');
        }

        $jawabanSiswa = $request->input('jawaban', []);
        $benarCount = 0;
        $detailEvaluasi = [];

        // Cocokkan jawaban siswa dengan kunci jawaban di database sekaligus buat log analisis
        foreach ($soalKuis as $soal) {
            $jawabanUser = $jawabanSiswa[$soal->id] ?? null;
            $isCorrect = ($jawabanUser !== null && $jawabanUser == $soal->jawaban_benar);
            
            if ($isCorrect) {
                $benarCount++;
            }

            // Merekam detail jawaban siswa untuk ditampilkan di halaman hasil kuis
            $detailEvaluasi[] = [
                'pertanyaan' => $soal->pertanyaan,
                'opsi_user' => $jawabanUser,
                'opsi_benar' => $soal->jawaban_benar,
                'teks_opsi_user' => $soal->{'opsi_' . strtolower($jawabanUser ?? '')} ?? 'Tidak Dijawab',
                'teks_opsi_benar' => $soal->{'opsi_' . strtolower($soal->jawaban_benar)},
                'is_correct' => $isCorrect
            ];
        }

        // Syarat kelulusan KKM asli: Benar semua
        $totalSoal = $soalKuis->count();
        $lulus = ($benarCount == $totalSoal) ? true : false; 
        $skor = $totalSoal > 0 ? round(($benarCount / $totalSoal) * 100) : 0;

        // Cek status pengerjaan kuis versi sebelumnya untuk proteksi eksploitasi poin
        $sudahLulusSebelumnya = DB::table('kuis_siswa')
            ->where('user_id', $user->id)
            ->where('materi_id', $materi->id)
            ->where('lulus', true)
            ->exists();

        // Simpan atau update rekam jejak kuis siswa ke database
        DB::table('kuis_siswa')->updateOrInsert(
            ['user_id' => $user->id, 'materi_id' => $materi->id],
            [
                'jawaban_benar_count' => $benarCount,
                'lulus' => $lulus,
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        $xpDiberikan = 0;
        // Jika lulus kuis dan baru pertama kali, berikan hadiah poin sesuai aturan dasarmu
        if ($lulus && !$sudahLulusSebelumnya) {
            $xpDiberikan = 30;
            $user->increment('points', $xpDiberikan);
            $user->increment('kuis_points', $xpDiberikan);
            $this->updateRank($user);
        }

        // SINKRONISASI VARIABEL UNTUK BLADE
        $jawabanBenarCount = $benarCount;

        // Melempar data komplit ke view hasil evaluasi
        return view('siswa.kuis_hasil', compact(
            'materi', 
            'skor', 
            'lulus', 
            'benarCount', 
            'jawabanBenarCount',
            'totalSoal', 
            'detailEvaluasi', 
            'xpDiberikan'
        ));
    }

    /**
     * Sistem Otomatisasi Kenaikan Pangkat (Leveling Engine)
     */
    private function updateRank($user)
    {
        $totalPoin = $user->points;

        if ($totalPoin >= 100) {
            $user->rank = 'Network Master';
        } elseif ($totalPoin >= 50) {
            $user->rank = 'Teknisi Senior';
        } elseif ($totalPoin >= 20) {
            $user->rank = 'Network Junior';
        } else {
            $user->rank = 'Pemula';
        }

        $user->save();
    }

    /**
     * Dashboard Khusus Guru: Memantau Peringkat & Hasil Kuis Siswa
     */
    public function monitorGuru()
    {
        // Proteksi Keamanan: Hanya user dengan role 'guru' yang boleh masuk
        if (auth()->user()->role !== 'guru') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Ambil data semua user yang rolenya 'siswa' diurutkan dari poin tertinggi (Leaderboard)
        $siswas = \App\Models\User::where('role', 'siswa')
            ->orderBy('points', 'desc')
            ->get();

        // Ambil semua log hasil kuis siswa untuk ditampilkan di tabel monitoring (SINKRONISASI SELESAI)
        $hasilKuis = DB::table('kuis_siswa')
            ->join('users', 'kuis_siswa.user_id', '=', 'users.id')
            ->join('materis', 'kuis_siswa.materi_id', '=', 'materis.id')
            ->select(
                'users.name as nama_siswa', 
                'materis.judul as nama_materi', 
                'kuis_siswa.jawaban_benar_count', 
                'kuis_siswa.lulus', 
                'kuis_siswa.updated_at' // Kolom ini sekarang aktif dipanggil
            )
            ->orderBy('kuis_siswa.updated_at', 'desc')
            ->get();

        return view('guru.dashboard', compact('siswas', 'hasilKuis'));
    }
}