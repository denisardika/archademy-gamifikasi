<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-900 leading-tight">
                {{ __('Manajemen Modul Pembelajaran') }}
            </h2>
            <a href="{{ route('guru.materi.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black px-4 py-2 rounded-xl transition shadow-sm flex items-center gap-1.5">
                ➕ Tambah Modul Baru
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-bold shadow-sm">
                    ✨ {{ session('success') }}
                </div>
            @endif

            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <div class="overflow-x-auto rounded-xl border border-slate-200/60">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs font-bold text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3.5">Judul Modul</th>
                                <th class="px-6 py-3.5">Slug URL</th>
                                <th class="px-6 py-3.5 text-center">Reward Hadiah</th>
                                <th class="px-6 py-3.5 text-center">Total Soal</th>
                                <th class="px-6 py-3.5 text-center">Aksi Kendali</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($materis as $mat)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-4 font-extrabold text-slate-900">{{ $mat->judul }}</td>
                                    <td class="px-6 py-4 text-slate-400 font-mono text-xs">/materi/{{ $mat->slug }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 text-xs font-black rounded-lg">
                                            💎 +{{ $mat->xp_reward }} XP
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-700">
                                        {{ $mat->kuis_count }} Soal
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('guru.materi.edit', $mat->id) }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-700 text-xs font-bold rounded-lg transition">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('guru.materi.destroy', $mat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-700 text-xs font-bold rounded-lg transition">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-medium">Belum ada data materi. Silakan klik tombol Tambah Modul Baru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <a href="{{ route('guru.dashboard') }}" class="inline-block text-sm font-bold text-slate-500 hover:text-slate-800 transition">
                ⬅️ Kembali ke Dashboard Utama
            </a>

        </div>
    </div>
</x-app-layout>