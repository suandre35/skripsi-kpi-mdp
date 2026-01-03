<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Laporan Evaluasi') }}
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
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Laporan Divisi</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- INFO DIVISI CARD (Header Gradient) --}}
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-white">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-xs font-bold text-blue-100 uppercase tracking-widest mb-1">Divisi Anda</h3>
                        <h2 class="text-3xl md:text-4xl font-extrabold">{{ $manajer->divisi->nama_divisi ?? 'Tanpa Divisi' }}</h2>
                        <p class="mt-2 text-blue-100 text-sm max-w-xl">
                            Laporan rekapitulasi kinerja dan pencapaian target seluruh anggota tim pada periode evaluasi terpilih.
                        </p>
                    </div>
                    <div class="hidden md:flex items-center justify-center p-4 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/20 shadow-inner">
                        <svg class="w-12 h-12 text-white opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                </div>
                {{-- Dekorasi Circle --}}
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-blue-400 opacity-20 rounded-full blur-2xl"></div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                {{-- TOOLBAR (FILTER & SEARCH) --}}
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    <form method="GET" action="{{ route('penilaian.laporan') }}">
                        <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-6">
                            
                            {{-- LEFT: Filter Group --}}
                            <div class="flex flex-col md:flex-row gap-4 w-full xl:w-3/4">
                                
                                {{-- 1. Filter Periode --}}
                                <div class="w-full md:w-1/3">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Periode Evaluasi</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <select name="id_periode" onchange="this.form.submit()" class="pl-10 block w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm text-sm h-[42px] cursor-pointer font-medium">
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
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Cari Anggota Tim</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIK..." 
                                            class="pl-10 pr-20 block w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm text-sm h-[42px]">
                                        
                                        <button type="submit" class="absolute inset-y-0 right-0 px-4 text-white bg-blue-600 rounded-r-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition font-medium text-sm">
                                            Cari
                                        </button>
                                    </div>
                                </div>

                            </div>

                            {{-- RIGHT: Info Total (Desktop Only) --}}
                            <div class="hidden xl:block text-right">
                                <p class="text-xs text-gray-500 uppercase tracking-wide font-bold mb-1">Total Anggota</p>
                                <div class="flex items-baseline justify-end gap-2">
                                    <p class="text-4xl font-black text-gray-800 dark:text-white leading-none">{{ $karyawans->count() }}</p>
                                    <span class="text-sm font-medium text-gray-400">Orang</span>
                                </div>
                            </div>

                        </div>
                        
                        {{-- Tombol Reset --}}
                        @if(request('search'))
                            <div class="mt-4 flex justify-end xl:justify-start">
                                <a href="{{ route('penilaian.laporan', ['id_periode' => request('id_periode')]) }}" class="text-xs font-bold text-red-600 hover:text-red-800 flex items-center gap-1 bg-red-50 border border-red-100 px-3 py-1.5 rounded-full hover:bg-red-100 transition shadow-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Hapus Filter Pencarian
                                </a>
                            </div>
                        @endif
                    </form>
                </div>

                {{-- LEGEND INFO (BARU) --}}
                <div class="px-6 py-3 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 flex flex-wrap gap-4 items-center justify-center sm:justify-start text-xs">
                    <span class="font-bold text-gray-500 uppercase tracking-wide mr-2">Status Kinerja:</span>
                    
                    {{-- Excellent --}}
                    <div class="flex items-center gap-1.5">
                        <span class="flex w-2.5 h-2.5 bg-blue-600 rounded-full ring-2 ring-blue-100 dark:ring-blue-900"></span>
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Excellent (≥ 100)</span>
                    </div>
                    {{-- Sangat Baik --}}
                    <div class="flex items-center gap-1.5">
                        <span class="flex w-2.5 h-2.5 bg-emerald-500 rounded-full ring-2 ring-emerald-100 dark:ring-emerald-900"></span>
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Sangat Baik (85-99)</span>
                    </div>
                    {{-- Cukup --}}
                    <div class="flex items-center gap-1.5">
                        <span class="flex w-2.5 h-2.5 bg-yellow-400 rounded-full ring-2 ring-yellow-100 dark:ring-yellow-900"></span>
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Cukup (70-84)</span>
                    </div>
                    {{-- Perlu Perbaikan --}}
                    <div class="flex items-center gap-1.5">
                        <span class="flex w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-red-100 dark:ring-red-900"></span>
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Perlu Perbaikan (< 70)</span>
                    </div>
                </div>

                {{-- TABEL ANGGOTA TIM --}}
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b dark:border-gray-600">
                            <tr>
                                <th class="px-6 py-4 rounded-tl-lg font-bold tracking-wider">Anggota Tim</th>
                                <th class="px-6 py-4 w-1/3 font-bold tracking-wider">Pencapaian Skor KPI</th>
                                <th class="px-6 py-4 text-center font-bold tracking-wider">Status Kinerja</th>
                                <th class="px-6 py-4 text-center rounded-tr-lg font-bold tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($karyawans as $k)
                                @php
                                    $skor = $k->skor_saat_ini;
                                    $width = min($skor, 100); 
                                    
                                    // Logic Warna & Status
                                    if($skor >= 100) {
                                        $colorClass = 'bg-blue-600';
                                        $textClass = 'text-blue-600';
                                        $statusLabel = 'Excellent';
                                        $statusBadge = 'bg-blue-50 text-blue-700 border-blue-200 ring-1 ring-blue-700/10';
                                        $icon = '<svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
                                    } elseif($skor >= 85) {
                                        $colorClass = 'bg-emerald-500';
                                        $textClass = 'text-emerald-600';
                                        $statusLabel = 'Sangat Baik';
                                        $statusBadge = 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-1 ring-emerald-700/10';
                                        $icon = '<svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
                                    } elseif($skor >= 70) {
                                        $colorClass = 'bg-yellow-400';
                                        $textClass = 'text-yellow-600';
                                        $statusLabel = 'Cukup';
                                        $statusBadge = 'bg-yellow-50 text-yellow-700 border-yellow-200 ring-1 ring-yellow-600/20';
                                        $icon = '<svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>';
                                    } else {
                                        $colorClass = 'bg-red-500';
                                        $textClass = 'text-red-600';
                                        $statusLabel = 'Perlu Perbaikan';
                                        $statusBadge = 'bg-red-50 text-red-700 border-red-200 ring-1 ring-red-600/10';
                                        $icon = '<svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
                                    }
                                @endphp

                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                    {{-- Kolom Karyawan --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center text-gray-500 dark:text-gray-300 font-bold text-lg shadow-sm border border-gray-200 dark:border-gray-600 overflow-hidden">
                                                @if($k->foto)
                                                    <img src="{{ asset('storage/'.$k->foto) }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ substr($k->nama_lengkap, 0, 1) }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $k->nama_lengkap }}</div>
                                                <div class="text-xs text-gray-500 font-mono bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded inline-block mt-1 border border-gray-200 dark:border-gray-600">
                                                    NIK: {{ $k->nik }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom Progress Skor --}}
                                    <td class="px-6 py-4 align-middle">
                                        <div class="flex justify-between items-end mb-1">
                                            <span class="text-xl font-black {{ $textClass }}">
                                                {{ number_format($skor, 2) }}
                                            </span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Target: 100</span>
                                        </div>
                                        <div class="w-full bg-gray-100 dark:bg-gray-900 rounded-full h-3 overflow-hidden shadow-inner border border-gray-200 dark:border-gray-700">
                                            <div class="{{ $colorClass }} h-3 rounded-full transition-all duration-1000 ease-out shadow-sm relative group" style="width: {{ $width }}%">
                                                <div class="absolute inset-0 bg-white opacity-20 group-hover:opacity-30 transition-opacity"></div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom Status --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $statusBadge }}">
                                            {!! $icon !!}
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('penilaian.detailLaporan', $k->id_karyawan) }}" 
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition shadow-sm transform hover:-translate-y-0.5 group">
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-full mb-4">
                                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                            </div>
                                            <p class="text-lg font-bold text-gray-700 dark:text-gray-300">Data tidak ditemukan.</p>
                                            <p class="text-sm text-gray-500 mt-1">Coba ubah filter periode atau kata kunci pencarian.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- FOOTER / PAGINATION (Jika ada) --}}
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-b-2xl">
                    <p class="text-xs text-center text-gray-400">Menampilkan seluruh anggota tim aktif pada divisi {{ $manajer->divisi->nama_divisi ?? '-' }}.</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>