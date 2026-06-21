<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Archademy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-5xl mx-auto px-4 h-16 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🎓</span>
                <span class="font-black text-slate-900 tracking-tight">ARCHADEMY HUB</span>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs font-bold text-rose-600 hover:bg-rose-50 border border-rose-200 px-3 py-1.5 rounded-xl transition">
                    Keluar Aplikasi
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-10 space-y-8">
        
        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="space-y-2 text-center md:text-left">
                <span class="text-xs font-black tracking-widest text-indigo-600 uppercase bg-indigo-50 border border-indigo-100 px-2.5 py-1 rounded-md">Selamat Datang</span>
                <h1 class="text-2xl font-black text-slate-900">{{ Auth::user()->name }}</h1>
                <p class="text-sm text-slate-500">Email Terdaftar: {{ Auth::user()->email }}</p>
            </div>
            
            <div class="flex items-center gap-4 bg-slate-50 border border-slate-200 p-3 rounded-2xl shadow-inner w-full md:w-auto justify-center">
                <div class="text-center px-4">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Akumulasi Poin</span>
                    <span class="text-xl font-black text-amber-500">⭐ {{ Auth::user()->points }} XP</span>
                </div>
                <div class="w-px h-10 bg-slate-200"></div>
                <div class="text-center px-4">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Pangkat Kelas</span>
                    <span class="text-xl font-black text-indigo-600">🛡️ {{ Auth::user()->rank }}</span>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-indigo-900 to-slate-900 rounded-3xl p-8 text-white shadow-md flex flex-col sm:flex-row justify-between items-center gap-6">
            <div class="space-y-1 text-center sm:text-left">
                <h2 class="text-xl font-black tracking-tight">Sudah Siap Melanjutkan Kelas Jaringan?</h2>
                <p class="text-xs text-indigo-200">Akses semua modul bacaan, raih bonus XP, dan taklukkan semua kuis evaluasinya sekarang.</p>
            </div>
            <a href="{{ route('materi.index') }}" class="w-full sm:w-auto text-center bg-white hover:bg-indigo-50 text-indigo-900 font-black py-3.5 px-6 rounded-xl text-sm transition shadow-md whitespace-nowrap">
                Masuk Ruang Belajar ➔
            </a>
        </div>

    </div>

</body>
</html>