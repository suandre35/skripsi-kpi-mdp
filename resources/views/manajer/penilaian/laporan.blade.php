<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Rapor Kinerja Tim') }}
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
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Rapor Kinerja</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- INFO DIVISI CARD --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-6 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold opacity-90">Divisi</h3>
                    <h2 class="text-3xl font-bold">{{ $manajer->divisi->nama_divisi ?? 'Tanpa Divisi' }}</h2>
                </div>
                <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                {{-- TOOLBAR (FILTER & SEARCH) --}}
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50">
                    <form method="GET" action="{{ route('penilaian.laporan') }}">
                        <div class="flex flex-col md:flex-row justify-between items-end gap-4">
                            
                            {{-- LEFT: Filter Group --}}
                            <div class="w-full md:w-2/3 flex flex-col md:flex-row gap-4">
                                
                                {{-- 1. Filter Periode --}}
                                <div class="w-full md:w-1/3">
                                    <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Periode Evaluasi</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <select name="id_periode" onchange="this.form.submit()" class="pl-10 w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 transition shadow-sm cursor-pointer">
                                            @foreach($periodes as $p)
                                                <option value="{{ $p->id_periode }}" {{ $selectedPeriode == $p->id_periode ? 'selected' : '' }}>
                                                    {{ $p->nama_periode }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- 2. Search Bar --}}
                                <div class="w-full md:w-2/3">
                                    <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Cari Anggota Tim</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIK..." 
                                            class="pl-10 w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 transition shadow-sm">
                                        
                                        {{-- Tombol Cari Absolut di Kanan Input --}}
                                        <button type="submit" class="absolute inset-y-0 right-0 px-4 text-sm font-medium text-white bg-blue-600 rounded-r-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition">
                                            Cari
                                        </button>
                                    </div>
                                </div>

                            </div>

                            {{-- RIGHT: Info Total --}}
                            <div class="hidden md:block text-right">
                                <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Total Anggota</p>
                                <p class="text-2xl font-extrabold text-gray-800 dark:text-white">{{ $karyawans->count() }} <span class="text-sm font-normal text-gray-500">Orang</span></p>
                            </div>

                        </div>
                        
                        {{-- Tombol Reset jika sedang mencari --}}
                        @if(request('search'))
                            <div class="mt-2">
                                <a href="{{ route('penilaian.laporan', ['id_periode' => request('id_periode')]) }}" class="text-sm text-red-500 hover:text-red-700 underline">
                                    &times; Reset Pencarian
                                </a>
                            </div>
                        @endif
                    </form>
                </div>

                {{-- TABEL ANGGOTA TIM --}}
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-4 rounded-tl-lg">Anggota Tim</th>
                                <th class="px-6 py-4">Total Skor Kinerja</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($karyawans as $k)
                                @php
                                    $skor = $k->skor_saat_ini;
                                    $width = min($skor, 100); 
                                    
                                    if($skor >= 100) {
                                        $colorClass = 'bg-blue-600';
                                        $textClass = 'text-blue-600';
                                        $statusLabel = 'Excellent';
                                        $statusBadge = 'bg-blue-100 text-blue-800 border-blue-200';
                                    } elseif($skor >= 85) {
                                        $colorClass = 'bg-green-500';
                                        $textClass = 'text-green-600';
                                        $statusLabel = 'Baik Sekali';
                                        $statusBadge = 'bg-green-100 text-green-800 border-green-200';
                                    } elseif($skor >= 70) {
                                        $colorClass = 'bg-yellow-400';
                                        $textClass = 'text-yellow-600';
                                        $statusLabel = 'Cukup';
                                        $statusBadge = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                                    } else {
                                        $colorClass = 'bg-red-500';
                                        $textClass = 'text-red-600';
                                        $statusLabel = 'Kurang';
                                        $statusBadge = 'bg-red-100 text-red-800 border-red-200';
                                    }
                                @endphp

                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                    {{-- Kolom Karyawan --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-gray-600 dark:text-gray-300 font-bold text-sm">
                                                {{ substr($k->nama_lengkap, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $k->nama_lengkap }}</div>
                                                <div class="text-xs text-gray-500">NIK: {{ $k->nik }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom Progress Skor --}}
                                    <td class="px-6 py-4 w-1/3 align-middle">
                                        <div class="flex justify-between mb-1">
                                            <span class="text-base font-bold {{ $textClass }}">
                                                {{ number_format($skor, 2) }}
                                            </span>
                                            <span class="text-xs font-medium text-gray-400">Target: 100</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                                            <div class="{{ $colorClass }} h-2.5 rounded-full transition-all duration-1000 ease-out" style="width: {{ $width }}%"></div>
                                        </div>
                                    </td>

                                    {{-- Kolom Status --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $statusBadge }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('penilaian.detailLaporan', $k->id_karyawan) }}" 
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600 hover:border-blue-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Rapor Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            <p class="text-lg font-medium">Data tidak ditemukan.</p>
                                            <p class="text-sm text-gray-400">Coba ubah periode atau kata kunci pencarian.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>