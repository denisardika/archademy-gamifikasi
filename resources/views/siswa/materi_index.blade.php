<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Belajar Archademy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🎓</span>
                <span class="font-black text-slate-900 tracking-tight">ARCHADEMY</span>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-xl text-sm font-bold shadow-inner">
                    <span class="text-amber-500">⭐ {{ Auth::user()->points }} XP</span>
                    <span class="text-slate-300">|</span>
                    <span class="text-indigo-600">🛡️ {{ Auth::user()->rank }}</span>
                </div>
                <a href="/dashboard" class="text-xs font-bold text-slate-500 hover:text-rose-600 transition border border-slate-200 px-3 py-1.5 rounded-xl hover:bg-slate-50">
                    Dashboard Utama
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-2xl font-black text-slate-900">Silakan Pilih Modul Belajarmu</h1>
            <p class="text-sm text-slate-500 mt-1">Kumpulkan poin sebanyak-banyaknya untuk menaikkan peringkat kompetensimu.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($materis as $materi)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="mb-4">
                            <span class="inline-block bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-black px-2.5 py-1 rounded-lg">
                                🎁 +{{ $materi->xp_reward }} XP Modul
                            </span>
                        </div>
                        <h3 class="text-lg font-extrabold text-slate-900 leading-snug mb-2">
                            {{ $materi->judul }}
                        </h3>
                        <p class="text-sm text-slate-600 line-clamp-3 leading-relaxed">
                            {!! strip_tags($materi->konten) !!}
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <a href="{{ route('materi.show', $materi->slug) }}" class="w-full text-center inline-flex justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-3 px-4 rounded-xl transition shadow-sm">
                            Buka & Pelajari Modul ➔
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>