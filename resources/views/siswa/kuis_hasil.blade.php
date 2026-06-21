<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Evaluasi Kuis - Archademy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased py-10">

    <div class="max-w-3xl mx-auto px-4">
        
        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm text-center space-y-6 relative overflow-hidden">
            @if($lulus)
                <div class="absolute top-0 left-0 w-full h-2 bg-emerald-500"></div>
                <span class="text-6xl inline-block animate-bounce">🎉</span>
                <h1 class="text-3xl font-black text-slate-900">Selamat, Kamu Lulus KKM!</h1>
                <p class="text-sm text-slate-500 max-w-md mx-auto">Kamu berhasil memahami materi <span class="font-bold text-slate-800">"{{ $materi->judul }}"</span> dengan sangat baik.</p>
                @if($xpDiberikan > 0)
                    <div class="inline-block bg-amber-100 border border-amber-200 text-amber-800 font-black px-6 py-2.5 rounded-2xl text-sm shadow-sm animate-pulse">
                        ⭐ REWARD BONUS: +{{ $xpDiberikan }} XP DIKLAIM!
                    </div>
                @endif
            @else
                <div class="absolute top-0 left-0 w-full h-2 bg-rose-500"></div>
                <span class="text-6xl inline-block text-rose-500">🔄</span>
                <h1 class="text-3xl font-black text-slate-900">Yuk, Coba Lagi!</h1>
                <p class="text-sm text-slate-500 max-w-md mx-auto">Skormu belum mencapai batas kelulusan minimal KKM (70%). Jangan berkecil hati, pelajari kembali materinya.</p>
            @endif

            <div class="flex justify-center items-center gap-6 py-4">
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl w-28 shadow-inner">
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Skor</span>
                    <span class="text-3xl font-black {{ $lulus ? 'text-emerald-600' : 'text-rose-600' }}">{{ $skor }}</span>
                </div>
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl w-28 shadow-inner">
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Benar</span>
                    <span class="text-3xl font-black text-slate-800">{{ $jawabanBenarCount }} / {{ $totalSoal }}</span>
                </div>
            </div>
        </div>

        <div class="mt-8 space-y-4">
            <h2 class="text-lg font-black text-slate-900 px-1">Analisis Jawabanmu:</h2>
            
            @foreach($detailEvaluasi as $index => $item)
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-3">
                    <div class="flex justify-between items-start gap-4">
                        <p class="font-extrabold text-sm text-slate-900 leading-snug">
                            {{ $index + 1 }}. {{ $item['pertanyaan'] }}
                        </p>
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black tracking-wider uppercase {{ $item['is_correct'] ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                            {{ $item['is_correct'] ? 'Benar' : 'Salah' }}
                        </span>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-3 text-xs space-y-1.5 border border-slate-100 font-medium">
                        <div class="flex gap-1 items-center">
                            <span class="text-slate-400">Jawabanmu:</span> 
                            <span class="{{ $item['is_correct'] ? 'text-emerald-700 font-bold' : 'text-rose-700 font-bold' }}">
                                ({{ $item['opsi_user'] ?? '-' }}) {{ $item['teks_opsi_user'] }}
                            </span>
                        </div>
                        @if(!$item['is_correct'])
                            <div class="flex gap-1 items-center pt-1 border-t border-slate-200/60">
                                <span class="text-slate-400">Kunci Benar:</span>
                                <span class="text-emerald-700 font-bold">
                                    ({{ $item['opsi_benar'] }}) {{ $item['teks_opsi_benar'] }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('materi.show', $materi->slug) }}" class="text-center bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold py-3.5 px-6 rounded-xl text-sm transition shadow-sm">
                🔄 Ulangi Ujian / Baca Materi
            </a>
            <a href="{{ route('materi.index') }}" class="text-center bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-3.5 px-8 rounded-xl text-sm transition shadow-sm">
                Lanjut ke Modul Lain ➔
            </a>
        </div>

    </div>

</body>
</html>