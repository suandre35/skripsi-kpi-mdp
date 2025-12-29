<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Monitoring KPI Global') }}
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
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Monitoring</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- CARD FILTER --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white">Filter & Pencarian</h3>
                    </div>
                    
                    {{-- Tombol Reset --}}
                    @if(request('id_divisi') || request('search'))
                        {{-- PERBAIKAN DI SINI: Menggunakan route yang benar --}}
                        <a href="{{ route('admin.monitoring.index') }}" class="text-sm text-red-500 hover:text-red-700 font-medium underline">
                            Reset Filter
                        </a>
                    @endif
                </div>

                {{-- FORM PENCARIAN & FILTER --}}
                {{-- PERBAIKAN DI SINI: Menggunakan route yang benar --}}
                <form method="GET" action="{{ route('admin.monitoring.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        
                        {{-- 1. Search Bar --}}
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Cari Karyawan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau NIK..." 
                                    class="pl-10 w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm transition sm:text-sm">
                            </div>
                        </div>

                        {{-- 2. Select Periode --}}
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Periode</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <select name="id_periode" onchange="this.form.submit()" class="pl-10 w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm transition sm:text-sm">
                                    @foreach($periodes as $p)
                                        <option value="{{ $p->id_periode }}" {{ $selectedPeriode == $p->id_periode ? 'selected' : '' }}>
                                            {{ $p->nama_periode }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- 3. Select Divisi --}}
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Divisi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <select name="id_divisi" onchange="this.form.submit()" class="pl-10 w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm transition sm:text-sm">
                                    <option value="">Semua Divisi</option>
                                    @foreach($divisis as $d)
                                        <option value="{{ $d->id_divisi }}" {{ $selectedDivisi == $d->id_divisi ? 'selected' : '' }}>
                                            {{ $d->nama_divisi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- 4. Tombol Submit --}}
                        <div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 h-[42px]">
                                Tampilkan
                            </button>
                        </div>

                    </div>
                </form>
            </div>

            {{-- TABEL RESULT --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                {{-- Header Tabel --}}
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Hasil Realisasi KPI</h3>
                        <p class="text-sm text-gray-500">Skor real-time berdasarkan log aktivitas.</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 rounded-full text-xs font-bold border border-blue-200 dark:border-blue-800">
                        {{ count($karyawans) }} Data Ditemukan
                    </span>
                </div>

                <div class="relative overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Karyawan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Divisi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Progress Skor</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($karyawans as $k)
                                @php
                                    $skor = $k->skor_saat_ini;
                                    $width = min($skor, 100); 
                                    
                                    // Logic Warna Modern
                                    if($skor >= 100) {
                                        $colorClass = 'bg-blue-600';
                                        $textClass = 'text-blue-600';
                                    } elseif($skor >= 85) {
                                        $colorClass = 'bg-green-500';
                                        $textClass = 'text-green-600';
                                    } elseif($skor >= 70) {
                                        $colorClass = 'bg-yellow-400';
                                        $textClass = 'text-yellow-600';
                                    } else {
                                        $colorClass = 'bg-red-500';
                                        $textClass = 'text-red-600';
                                    }
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                    
                                    {{-- Kolom Karyawan --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-200 font-bold shadow-sm">
                                                {{ substr($k->nama_lengkap, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 dark:text-white">{{ $k->nama_lengkap }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">NIK: {{ $k->nik }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom Divisi --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                            {{ $k->divisi->nama_divisi }}
                                        </span>
                                    </td>

                                    {{-- Kolom Progress --}}
                                    <td class="px-6 py-4 w-1/3 align-middle">
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-bold {{ $textClass }}">
                                                {{ number_format($skor, 2) }}
                                            </span>
                                            <span class="text-xs font-medium text-gray-400">Target: 100</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden shadow-inner">
                                            <div class="{{ $colorClass }} h-2.5 rounded-full transition-all duration-1000 ease-out relative" style="width: {{ $width }}%"></div>
                                        </div>
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="px-6 py-4 text-center">
                                        {{-- PERBAIKAN DI SINI JUGA: Menggunakan route yang benar --}}
                                        <a href="{{ route('admin.monitoring.show', ['karyawan' => $k->id_karyawan, 'periode' => $selectedPeriode]) }}" 
                                           class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-blue-600 hover:border-blue-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                            <p class="text-lg font-medium">Data tidak ditemukan.</p>
                                            <p class="text-sm">Coba sesuaikan filter atau kata kunci pencarian.</p>
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