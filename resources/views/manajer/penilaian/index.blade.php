<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Log Aktivitas Tim') }}
            </h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Log Aktivitas</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- ALERT MESSAGES (Success/Error) --}}
            @if(session('success'))
                <div class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-200 dark:border-red-800" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ml-3 text-sm font-medium">{{ session('error') }}</div>
                </div>
            @endif

            {{-- MAIN CARD --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                {{-- TOOLBAR --}}
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Riwayat Input Aktivitas</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Monitoring kinerja harian anggota tim Anda.</p>
                        
                        {{-- PESAN STATUS PERIODE (Jika Ditutup) --}}
                        @if(!$isInputOpen)
                            <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                <span class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse"></span>
                                {{ $periodePesan }}
                            </div>
                        @endif
                    </div>

                    {{-- TOMBOL INPUT (DINAMIS) --}}
                    @if($isInputOpen)
                        {{-- JIKA BUKA: Tombol Biru Normal --}}
                        <a href="{{ route('penilaian.create') }}" class="flex items-center justify-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition transform hover:-translate-y-0.5 shadow-lg shadow-blue-500/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Input Penilaian Hari Ini
                        </a>
                    @else
                        {{-- JIKA TUTUP: Tombol Abu-abu Disabled --}}
                        <button disabled class="flex items-center justify-center gap-2 text-gray-400 bg-gray-100 border border-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500" title="{{ $periodePesan }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Penilaian Ditutup
                        </button>
                    @endif
                </div>

                {{-- TABLE --}}
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b dark:border-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 rounded-tl-lg">Waktu Input</th>
                                <th scope="col" class="px-6 py-4">Karyawan</th>
                                <th scope="col" class="px-6 py-4">Aktivitas (Indikator)</th>
                                <th scope="col" class="px-6 py-4">Hasil / Realisasi</th>
                                <th scope="col" class="px-6 py-4">Catatan</th>
                                <th scope="col" class="px-6 py-4 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($logs as $log)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                
                                {{-- KOLOM 1: WAKTU INPUT --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $log->created_at->format('d M Y') }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            Pukul {{ $log->created_at->format('H:i') }}
                                        </span>
                                    </div>
                                </td>
                                
                                {{-- KOLOM 2: KARYAWAN --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        {{-- Avatar --}}
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-sm text-sm">
                                            {{ substr($log->header->karyawan->nama_lengkap ?? 'X', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">
                                                {{ $log->header->karyawan->nama_lengkap ?? 'Dihapus' }}
                                            </div>
                                            <div class="text-xs text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded inline-block mt-1">
                                                NIK: {{ $log->header->karyawan->nik ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- KOLOM 3: INDIKATOR --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white mb-1">
                                        {{ $log->indikator->nama_indikator ?? '-' }}
                                    </div>
                                    <div class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded border border-blue-100 dark:border-blue-800">
                                        <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Target: {{ number_format($log->indikator->target->nilai_target ?? 0, 0, ',', '.') }} 
                                        {{ $log->indikator->target->jenis_target ?? '' }}
                                    </div>
                                </td>

                                {{-- KOLOM 4: HASIL --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">
                                            {{ number_format($log->nilai_input, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </td>

                                {{-- KOLOM 5: CATATAN --}}
                                <td class="px-6 py-4">
                                    @if($log->catatan)
                                        <div class="flex items-start gap-1">
                                            <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                            <span class="text-sm text-gray-600 dark:text-gray-300 italic line-clamp-2 max-w-xs" title="{{ $log->catatan }}">
                                                "{{ $log->catatan }}"
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">- Tidak ada catatan -</span>
                                    @endif
                                </td>

                                {{-- KOLOM 6: AKSI --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Tombol Edit/Hapus hanya jika periode aktif? Opsional, biasanya edit masih boleh dalam rentang tertentu --}}
                                        @if($isInputOpen)
                                            <a href="{{ route('penilaian.edit', $log->id_penilaianDetail) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg dark:text-indigo-400 dark:hover:bg-gray-700 transition" title="Edit Data">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            <form action="{{ route('penilaian.destroy', $log->id_penilaianDetail) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus log aktivitas ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-gray-700 transition" title="Hapus Log">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Terkunci</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        <p class="text-lg font-medium">Belum ada aktivitas yang diinput.</p>
                                        @if($isInputOpen)
                                            <p class="text-sm text-gray-400 mb-4">Mulai input penilaian kinerja harian tim Anda.</p>
                                            <a href="{{ route('penilaian.create') }}" class="text-blue-600 hover:underline text-sm font-bold">
                                                + Input Sekarang
                                            </a>
                                        @else
                                            <p class="text-sm text-red-400 font-medium">Periode input penilaian saat ini ditutup.</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-b-2xl">
                    {{ $logs->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>