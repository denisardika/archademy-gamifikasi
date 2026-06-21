<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\AdminMateriController;

// 1. Halaman Utama Terbuka (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// 2. Dashboard Utama Setelah Login (Auto-Redirect Berbasis Role)
Route::get('/dashboard', function () {
    // Pengondisian: Jika user yang masuk adalah guru, arahkan ke panel monitoring guru
    if (auth()->user()->role === 'guru') {
        return redirect()->route('guru.dashboard');
    }
    // Jika siswa, tampilkan dashboard utama siswa seperti biasa
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Grup Rute Fitur Belajar & Manajemen (Hanya Bisa Diakses Setelah Login)
Route::middleware('auth')->group(function () {
    
    // Rute Profil Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // FITUR GAMIFIKASI SISWA
    // ==========================================
    Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
    Route::get('/materi/{slug}', [MateriController::class, 'show'])->name('materi.show');
    Route::post('/materi/{id}/klaim', [MateriController::class, 'klaimPoin'])->name('materi.klaim');
    Route::post('/materi/{id}/kuis', [MateriController::class, 'submitKuis'])->name('materi.kuis');

    // ==========================================
    // PANEL MONITORING & CRUD GURU ADMIN
    // ==========================================
    Route::get('/guru/dashboard', [MateriController::class, 'monitorGuru'])->name('guru.dashboard');

    // Rute Otomatis (Resource) untuk meng-handle CRUD Materi oleh Guru
    Route::resource('/guru/materi', AdminMateriController::class)->names([
        'index'   => 'guru.materi.index',
        'create'  => 'guru.materi.create',
        'store'   => 'guru.materi.store',
        'edit'    => 'guru.materi.edit',
        'update'  => 'guru.materi.update',
        'destroy' => 'guru.materi.destroy',
    ]);

    // RUTE BARU: PENGELOLAAN SOAL KUIS OLEH GURU
    Route::post('/guru/materi/{materi}/kuis', [AdminMateriController::class, 'storeKuis'])->name('guru.kuis.store');
    Route::put('/guru/kuis/{id}', [AdminMateriController::class, 'updateKuis'])->name('guru.kuis.update');
    Route::delete('/guru/kuis/{id}', [AdminMateriController::class, 'destroyKuis'])->name('guru.kuis.destroy');
});

require __DIR__.'/auth.php';