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
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Laporan</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                {{-- TOOLBAR: Filter & Search --}}
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-col lg:flex-row gap-6 justify-between items-end lg:items-center">
                        
                        {{-- Filter Section (Kiri) --}}
                        <div class="flex flex-col md:flex-row gap-4 w-full lg:w-5/6">
                            
                            {{-- 1. Filter Periode --}}
                            <div class="w-full md:w-56">
                                <label class="block mb-2 text-xs font-bold text-gray-500 uppercase tracking-wide">Periode</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <select name="id_periode" onchange="this.form.submit()" class="pl-10 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm cursor-pointer">
                                        <option value="" disabled {{ is_null($selectedPeriode) ? 'selected' : '' }}>-- Pilih --</option>
                                        @foreach($periodes as $p)
                                            <option value="{{ $p->id_periode }}" {{ $selectedPeriode == $p->id_periode ? 'selected' : '' }}>
                                                {{ $p->nama_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- 2. Filter Divisi (DIKEMBALIKAN) --}}
                            <div class="w-full md:w-48">
                                <label class="block mb-2 text-xs font-bold text-gray-500 uppercase tracking-wide">Divisi</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <select name="id_divisi" onchange="this.form.submit()" class="pl-10 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm cursor-pointer">
                                        <option value="">Semua Divisi</option>
                                        @foreach($divisis as $d)
                                            <option value="{{ $d->id_divisi }}" {{ $selectedDivisi == $d->id_divisi ? 'selected' : '' }}>
                                                {{ $d->nama_divisi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- 3. Pencarian --}}
                            <div class="w-full md:flex-1">
                                <label class="block mb-2 text-xs font-bold text-gray-500 uppercase tracking-wide">Cari Anggota</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                    <div class="flex">
                                        <input type="text" name="search" value="{{ request('search') }}" class="rounded-none rounded-l-lg bg-white border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 pl-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Nama atau NIK...">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-r-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- 4. Reset Button (Jika ada filter aktif) --}}
                            @if(request('id_divisi') || request('search'))
                                <div class="w-full md:w-auto flex items-end">
                                    <a href="{{ route('admin.laporan.index', ['id_periode' => $selectedPeriode]) }}" class="w-full md:w-auto h-[42px] flex items-center justify-center px-4 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-red-600 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white transition shadow-sm" title="Reset Filter">
                                        <svg class="w-4 h-4 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        <span class="md:inline">Reset</span>
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- Total Count (Kanan) --}}
                        <div class="text-right hidden lg:block">
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Total Anggota</span>
                            <span class="text-2xl font-bold text-gray-800 dark:text-white">
                                {{ $karyawans->total() ?? 0 }} <span class="text-sm font-medium text-gray-500">Orang</span>
                            </span>
                        </div>

                    </form>
                </div>

                {{-- LEGEND STATUS KINERJA --}}
                <div class="px-6 py-3 bg-gray-50/50 dark:bg-gray-700/30 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-6">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Keterangan:</span>
                    
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center gap-1.5">
                            <span class="flex w-2.5 h-2.5 bg-blue-500 rounded-full ring-2 ring-blue-100 dark:ring-blue-900"></span>
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Excellent (≥ 100)</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="flex w-2.5 h-2.5 bg-green-500 rounded-full ring-2 ring-green-100 dark:ring-green-900"></span>
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Sangat Baik (85-99)</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="flex w-2.5 h-2.5 bg-yellow-400 rounded-full ring-2 ring-yellow-100 dark:ring-yellow-900"></span>
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Baik (70-84)</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="flex w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-red-100 dark:ring-red-900"></span>
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Kurang (< 70)</span>
                        </div>
                    </div>
                </div>

                {{-- TABEL DATA --}}
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs font-bold text-gray-500 uppercase bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-4">Anggota Tim</th>
                                <th scope="col" class="px-6 py-4 w-1/3">Pencapaian Skor KPI</th>
                                <th scope="col" class="px-6 py-4 text-center">Status Kinerja</th>
                                <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($karyawans as $karyawan)
                                @php
                                    $skor = $karyawan->skor_saat_ini;
                                    $width = min($skor, 100);
                                    
                                    if ($skor >= 100) {
                                        $statusLabel = 'Excellent';
                                        $statusClass = 'bg-blue-50 text-blue-700 border border-blue-200 ring-1 ring-blue-100'; 
                                        $barColor = 'bg-blue-500';
                                        $textColor = 'text-blue-600';
                                        $icon = 'Verified';
                                    } elseif ($skor >= 85) {
                                        $statusLabel = 'Sangat Baik';
                                        $statusClass = 'bg-green-50 text-green-700 border border-green-200 ring-1 ring-green-100'; 
                                        $barColor = 'bg-green-500';
                                        $textColor = 'text-green-600';
                                        $icon = 'Check';
                                    } elseif ($skor >= 70) {
                                        $statusLabel = 'Baik';
                                        $statusClass = 'bg-yellow-50 text-yellow-700 border border-yellow-200 ring-1 ring-yellow-100'; 
                                        $barColor = 'bg-yellow-400';
                                        $textColor = 'text-yellow-600';
                                        $icon = 'Minus';
                                    } else {
                                        $statusLabel = 'Kurang';
                                        $statusClass = 'bg-red-50 text-red-700 border border-red-200 ring-1 ring-red-100'; 
                                        $barColor = 'bg-red-500';
                                        $textColor = 'text-red-600';
                                        $icon = 'Exclamation';
                                    }
                                @endphp

                            <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700/50 transition duration-150">
                                
                                {{-- 1. Anggota Tim --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0 w-12 h-12">
                                            @if($karyawan->foto && Storage::disk('public')->exists($karyawan->foto))
                                                <img class="w-12 h-12 rounded-full object-cover border border-gray-100 shadow-sm" 
                                                     src="{{ asset('storage/' . $karyawan->foto) }}" 
                                                     alt="{{ $karyawan->nama_lengkap }}">
                                            @else
                                                <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-lg font-bold border border-gray-200">
                                                    {{ substr($karyawan->nama_lengkap, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-base font-bold text-gray-900 dark:text-white mb-1">{{ $karyawan->nama_lengkap }}</div>
                                            {{-- Menampilkan Divisi di bawah Nama jika filter Divisi tidak aktif --}}
                                            <div class="flex flex-col gap-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200 font-mono tracking-wide w-fit">
                                                    NIK: {{ $karyawan->nik }}
                                                </span>
                                                <span class="text-xs text-gray-500 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                    {{ $karyawan->divisi->nama_divisi ?? '-' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- 2. Pencapaian Skor KPI --}}
                                <td class="px-6 py-5 align-middle">
                                    <div class="w-full max-w-xs">
                                        <div class="flex justify-between items-end mb-2">
                                            <span class="text-xl font-extrabold {{ $textColor }}">
                                                {{ number_format($skor, 2) }}
                                            </span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                                Target: 100
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-100 rounded-full h-2.5 dark:bg-gray-700 overflow-hidden">
                                            <div class="{{ $barColor }} h-2.5 rounded-full transition-all duration-1000 ease-out" style="width: {{ $width }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                {{-- 3. Status Kinerja --}}
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold shadow-sm {{ $statusClass }}">
                                        @if($icon == 'Verified')
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        @elseif($icon == 'Check')
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        @endif
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                {{-- 4. Aksi --}}
                                <td class="px-6 py-5 text-center">
                                    @if($selectedPeriode)
                                        <a href="{{ route('admin.laporan.show', ['karyawan' => $karyawan->id_karyawan, 'periode' => $selectedPeriode]) }}" 
                                           class="inline-flex items-center px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-blue-600 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition shadow-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Lihat Detail
                                        </a>
                                    @else
                                        <button disabled class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed">
                                            Pilih Periode
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tidak ada data ditemukan</h3>
                                        <p class="text-gray-500 mt-1 max-w-sm">Coba ubah filter periode atau kata kunci pencarian Anda.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-b-2xl">
                    {{ $karyawans->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>