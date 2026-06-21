<x-app-layout>
    <div class="container mx-auto px-4 py-8 max-w-5xl space-y-8">
        <div>
            <a href="{{ route('guru.materi.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition flex items-center gap-1">
                ➔ Kembali ke Manajemen Modul
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 text-emerald-700 rounded-xl font-bold text-sm border border-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-black text-slate-800">✍️ Edit Modul Pembelajaran</h2>
                <p class="text-sm text-slate-500">Perbarui isi konten materi utama dan penyesuaian hadiah XP siswa.</p>
            </div>

            <form action="{{ route('guru.materi.update', $materi->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Judul Modul</label>
                    <input type="text" name="judul" value="{{ old('judul', $materi->judul) }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-800 font-medium" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Hadiah Klaim (XP Reward)</label>
                    <div class="relative max-w-xs">
                        <input type="number" name="xp_reward" value="{{ old('xp_reward', $materi->xp_reward) }}" class="w-full pl-4 pr-16 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-800 font-black" min="0" required>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 font-bold text-indigo-600 text-sm">XP</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Isi Konten Modul</label>
                    <textarea name="konten" rows="6" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-800 font-medium leading-relaxed" required>{{ old('konten', $materi->konten) }}</textarea>
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-slate-100">
                    <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 font-bold text-sm shadow-md transition">
                        💾 Simpan Perubahan Materi
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 space-y-6">
            <div>
                <h2 class="text-2xl font-black text-slate-800">📝 Tambah Soal Kuis Baru</h2>
                <p class="text-sm text-slate-500 mb-4">Gunakan form ini untuk menambah soal ke-3, ke-4, dan seterusnya.</p>
                
                <form action="{{ route('guru.kuis.store', $materi->id) }}" method="POST" class="bg-slate-50 p-6 rounded-2xl border border-slate-200/60 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Pertanyaan Soal</label>
                        <input type="text" name="pertanyaan" placeholder="Ketik pertanyaan di sini..." class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm" required>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Pilihan A</label>
                            <input type="text" name="opsi_a" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Pilihan B</label>
                            <input type="text" name="opsi_b" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Pilihan C</label>
                            <input type="text" name="opsi_c" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Pilihan D</label>
                            <input type="text" name="opsi_d" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm" required>
                        </div>
                    </div>
                    <div class="max-w-xs">
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Kunci Jawaban Benar</label>
                        <select name="jawaban_benar" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm font-bold text-slate-700" required>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 font-bold text-sm transition shadow-sm">
                        ➕ Submit Soal Kuis Baru
                    </button>
                </form>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-4">📋 Daftar Pertanyaan Aktif Saat Ini</h3>
                <div class="space-y-4">
                    @forelse($materi->kuis as $index => $soal)
                        <div class="p-6 rounded-2xl border border-slate-200/60 bg-white shadow-sm space-y-3">
                            <div class="flex items-start justify-between gap-4">
                                <h4 class="font-bold text-slate-800">Soal {{ $index + 1 }}: {{ $soal->pertanyaan }}</h4>
                                <form action="{{ route('guru.kuis.destroy', $soal->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 text-xs bg-rose-500 text-white font-bold rounded-lg hover:bg-rose-600 transition">❌ Hapus Soal</button>
                                </form>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-slate-600 pl-2 font-medium">
                                <div class="{{ $soal->jawaban_benar == 'A' ? 'text-emerald-600 font-bold' : '' }}">A. {{ $soal->opsi_a }}</div>
                                <div class="{{ $soal->jawaban_benar == 'B' ? 'text-emerald-600 font-bold' : '' }}">B. {{ $soal->opsi_b }}</div>
                                <div class="{{ $soal->jawaban_benar == 'C' ? 'text-emerald-600 font-bold' : '' }}">C. {{ $soal->opsi_c }}</div>
                                <div class="{{ $soal->jawaban_benar == 'D' ? 'text-emerald-600 font-bold' : '' }}">D. {{ $soal->opsi_d }}</div>
                            </div>
                            <div class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-md inline-block">
                                🎯 Kunci Jawaban: {{ $soal->jawaban_benar }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-6">Belum ada kuis. Tambahkan kuis melalui form di atas.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>