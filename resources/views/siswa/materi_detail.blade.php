<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $materi->judul }} - Archademy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 h-16 flex justify-between items-center">
            <a href="{{ route('materi.index') }}" class="inline-flex items-center gap-1 text-sm font-extrabold text-indigo-600 hover:text-indigo-800 transition">
                ⬅ Kembali ke Kelas
            </a>
            <div class="bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-xl text-xs font-mono font-bold text-slate-600">
                Siswa: {{ Auth::user()->name }}
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8 space-y-6">
        
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold shadow-sm flex items-center gap-2">
                ✨ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 font-bold shadow-sm flex items-center gap-2">
                🚨 {{ session('error') }}
            </div>
        @endif
        @if(session('remedial'))
            <div class="p-4 rounded-xl bg-amber-50 border-l-4 border-amber-500 text-amber-900 font-medium shadow-sm">
                🔄 {{ session('remedial') }}
            </div>
        @endif

        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm">
            <h1 class="text-2xl font-black text-slate-900 mb-6 leading-tight">{{ $materi->judul }}</h1>
            
            <div class="text-slate-700 leading-relaxed space-y-4 text-[15px]">
                {!! $materi->konten !!}
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-center">
                @if(!$sudahBaca)
                    <form action="{{ route('materi.klaim', $materi->id) }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold py-3 px-8 rounded-xl transition shadow-sm uppercase tracking-wide text-xs">
                            ✔ Saya Sudah Selesai Membaca (+{{ $materi->xp_reward }} XP)
                        </button>
                    </form>
                @else
                    <button disabled class="w-full sm:w-auto bg-slate-100 text-slate-400 font-bold py-3 px-8 rounded-xl border border-slate-200 cursor-not-allowed shadow-inner text-xs">
                        🔒 Poin Membaca Berhasil Diklaim
                    </button>
                @endif
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="flex justify-between items-center pb-4 mb-6 border-b border-slate-100">
                <div>
                    <h2 class="text-xl font-black text-slate-900">📝 Kuis Evaluasi Modul</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Jawab semua soal dengan tepat.</p>
                </div>
                @if($statusKuis)
                    <span class="px-2.5 py-1 rounded-lg text-xs font-black border {{ $statusKuis->lulus ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                        {{ $statusKuis->lulus ? 'LULUS KKM' : 'REMEDIAL' }} ({{ $statusKuis->jawaban_benar_count }} Benar)
                    </span>
                @endif
            </div>

            @if($soalKuis->isEmpty())
                <div class="text-slate-400 text-center py-4 font-bold">Soal kuis belum dimasukkan oleh guru.</div>
            @else
                <form action="{{ route('materi.kuis', $materi->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @foreach($soalKuis as $index => $soal)
                        <div class="p-5 bg-slate-50 border border-slate-200 rounded-xl">
                            <p class="font-extrabold text-slate-900 text-sm mb-4">
                                {{ $index + 1 }}. {{ $soal->pertanyaan }}
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach(['A' => $soal->opsi_a, 'B' => $soal->opsi_b, 'C' => $soal->opsi_c, 'D' => $soal->opsi_d] as $key => $opsi)
                                    <label class="flex items-center p-3 bg-white border border-slate-200 rounded-lg cursor-pointer hover:bg-indigo-50 hover:border-indigo-400 transition">
                                        <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $key }}" required class="text-indigo-600 focus:ring-indigo-500 mr-2">
                                        <span class="text-xs text-slate-700">
                                            <strong class="text-indigo-600 font-mono">{{ $key }}.</strong> {{ $opsi }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-3 px-6 rounded-xl transition shadow-sm uppercase tracking-wide text-xs">
                            🚀 Kirim Jawaban Kuis
                        </button>
                    </div>
                </form>
            @endif
        </div>

    </div>

</body>
</html>