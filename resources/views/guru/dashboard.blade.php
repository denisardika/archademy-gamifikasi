<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-900 leading-tight tracking-tight">
                {{ __('Panel Monitoring Guru — Sistem Gamifikasi') }}
            </h2>
            <span class="bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-black px-3 py-1.5 rounded-xl uppercase tracking-wider">
                Akses: Guru Admin
            </span>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold">👥</div>
                    <div>
                        <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Siswa Dipantau</span>
                        <span class="text-2xl font-black text-slate-900">{{ $siswas->count() }} Siswa</span>
                    </div>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">📝</div>
                    <div>
                        <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kuis Dikoreksi Sistem</span>
                        <span class="text-2xl font-black text-slate-900">{{ $hasilKuis->count() }} Ambil</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-indigo-900 to-slate-900 rounded-2xl p-5 shadow-sm flex flex-col justify-center text-white space-y-1">
                    <span class="text-[10px] font-bold text-indigo-300 uppercase tracking-widest">Aksi Manajemen Data</span>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-black">Kelola Bank Soal & Materi</span>
                        <a href="{{ route('guru.materi.index') }}" class="bg-white text-indigo-950 font-black text-xs px-3 py-1.5 rounded-lg hover:bg-slate-100 transition shadow-sm inline-block text-center navigation-link">
                            Buka Kelola ➔
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    🥇 Papan Peringkat & Akumulasi Poin Siswa
                </h3>
                <div class="overflow-x-auto rounded-xl border border-slate-200/60">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs font-bold text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3.5">Nama Siswa</th>
                                <th class="px-6 py-3.5">Email Akun</th>
                                <th class="px-6 py-3.5">Pangkat Terkini</th>
                                <th class="px-6 py-3.5 text-center">Total Akumulasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($siswas as $siswa)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-4 font-extrabold text-slate-900">{{ $siswa->name }}</td>
                                    <td class="px-6 py-4 text-slate-500">{{ $siswa->email }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block px-3 py-1 bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-xl text-[11px] font-black tracking-wide">
                                            🛡️ {{ $siswa->rank }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-black text-emerald-600 text-base">{{ $siswa->points }} XP</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400 font-medium">Belum ada data siswa yang terdaftar di sistem database.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    📋 Rekap Log Aktivitas & Nilai Kuis Siswa
                </h3>
                <div class="overflow-x-auto rounded-xl border border-slate-200/60">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs font-bold text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3.5">Nama Lengkap</th>
                                <th class="px-6 py-3.5">Modul Jaringan</th>
                                <th class="px-6 py-3.5 text-center">Benar Kerja</th>
                                <th class="px-6 py-3.5 text-center">Status Kelulusan</th>
                                <th class="px-6 py-3.5">Waktu Submit</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($hasilKuis as $log)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $log->nama_siswa }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-600">{{ $log->nama_materi }}</td>
                                    <td class="px-6 py-4 text-center font-extrabold text-slate-800">{{ $log->jawaban_benar_count }} Soal</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block px-3 py-1 rounded-xl text-[10px] font-black tracking-wider uppercase {{ $log->lulus ? 'bg-emerald-50 border border-emerald-200 text-emerald-700' : 'bg-amber-50 border border-amber-200 text-amber-700' }}">
                                            {{ $log->lulus ? '🟢 LULUS KKM' : '🟡 REMEDIAL' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-400 font-medium">
                                        {{ isset($log->updated_at) ? \Carbon\Carbon::parse($log->updated_at)->diffForHumans() : 'Baru saja' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-medium">Belum ada rekam jejak pengumpulan kuis dari siswa manapun.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>