<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Kuis;
use Illuminate\Support\Str;

class AdminMateriController extends Controller
{
    /**
     * 1. HALAMAN UTAMA MANAJEMEN MODUL
     */
    public function index()
    {
        if (auth()->user()->role !== 'guru') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        $materis = Materi::withCount('kuis')->get();
        return view('guru.materi.index', compact('materis'));
    }

    public function create() { return view('guru.materi.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'xp_reward' => 'required|integer|min:0',
        ]);

        Materi::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'konten' => $request->konten,
            'xp_reward' => $request->xp_reward,
        ]);

        return redirect()->route('guru.materi.index')->with('success', 'Modul baru berhasil diterbitkan!');
    }

    /**
     * 2. HALAMAN EDIT MATERI + DAFTAR KUIS
     */
    public function edit($id)
    {
        $materi = Materi::with('kuis')->findOrFail($id);
        return view('guru.materi.edit', compact('materi')); 
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);
        $materi->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'konten' => $request->konten,
            'xp_reward' => $request->xp_reward,
        ]);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        $materi->delete();
        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil dihapus!');
    }

    /**
     * ==========================================
     * ENGINES FITUR KUIS (TAMBAH, UPDATE, HAPUS)
     * ==========================================
     */

    /**
     * A. AKSI TAMBAH KUIS BARU
     */
    public function storeKuis(Request $request, $materiId)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawaban_benar' => 'required|string|max:1',
        ]);

        Kuis::create([
            'materi_id' => $materiId,
            'pertanyaan' => $request->pertanyaan,
            'opsi_a' => $request->opsi_a,
            'opsi_b' => $request->opsi_b,
            'opsi_c' => $request->opsi_c,
            'opsi_d' => $request->opsi_d,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return redirect()->back()->with('success', 'Soal kuis baru berhasil ditambahkan!');
    }

    /**
     * B. AKSI UPDATE KUIS
     */
    public function updateKuis(Request $request, $id)
    {
        $kuis = Kuis::findOrFail($id);
        $kuis->update($request->only(['pertanyaan', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'jawaban_benar']));

        return redirect()->back()->with('success', 'Soal kuis berhasil diperbarui!');
    }

    /**
     * C. AKSI HAPUS KUIS
     */
    public function destroyKuis($id)
    {
        $kuis = Kuis::findOrFail($id);
        $kuis->delete();

        return redirect()->back()->with('success', 'Soal kuis berhasil dihapus!');
    }
}