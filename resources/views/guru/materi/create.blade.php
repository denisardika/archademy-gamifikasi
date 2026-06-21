<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-900 leading-tight">
                {{ __('Tambah Modul Pembelajaran Baru') }}
            </h2>
            <a href="{{ route('guru.materi.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-800 transition">
                ⬅️ Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <form method="POST" action="{{ route('guru.materi.store') }}" class="space-y-6">
                    @csrf <div>
                        <label for="judul" class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Judul Modul Pembelajaran</label>
                        <input type="text" name="judul" id="judul" required placeholder="Contoh: Pengenalan Firewalls dan Keamanan Jaringan" 
                               class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 font-medium p-3">
                        @error('judul') <span class="text-xs text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="xp_reward" class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Hadiah Poin (XP Reward)</label>
                        <div class="relative rounded-xl shadow-sm">
                            <input type="number" name="xp_reward" id="xp_reward" required min="0" placeholder="50" 
                                   class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 font-black p-3 pr-12">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <span class="text-xs font-black text-slate-400">XP</span>
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1 font-medium">Tentukan total nilai poin yang akan didapatkan siswa setelah menyelesaikan materi ini.</p>
                        @error('xp_reward') <span class="text-xs text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="konten" class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Isi Konten Materi Lengkap</label>
                        <textarea name="konten" id="konten" rows="10" required placeholder="Tulis atau paste materi pembelajaran secara detail di sini..." 
                                  class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 font-medium p-3"></textarea>
                        @error('konten') <span class="text-xs text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black px-6 py-3 rounded-xl transition shadow-sm">
                            💾 Simpan & Terbitkan Modul
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>