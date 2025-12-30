<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Monitoring Penilaian') }}
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
            
            {{-- MAIN CARD --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                {{-- TOOLBAR: Filter & Search --}}
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50">
                    <form method="GET" action="{{ route('admin.monitoring.index') }}" class="flex flex-col lg:flex-row gap-4 justify-between items-center">
                        
                        {{-- Group Filter Kiri --}}
                        <div class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">
                            
                            {{-- Filter Periode --}}
                            <div class="relative w-full md:w-64">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <select name="id_periode" onchange="this.form.submit()" class="pl-10 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:text-white cursor-pointer shadow-sm">
                                    <option value="" disabled {{ is_null($selectedPeriode) ? 'selected' : '' }}>-- Pilih Periode --</option>
                                    @foreach($periodes as $p)
                                        <option value="{{ $p->id_periode }}" {{ $selectedPeriode == $p->id_periode ? 'selected' : '' }}>
                                            {{ $p->nama_periode }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filter Divisi --}}
                            <div class="relative w-full md:w-48">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <select name="id_divisi" onchange="this.form.submit()" class="pl-10 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:text-white cursor-pointer shadow-sm">
                                    <option value="">Semua Divisi</option>
                                    @foreach($divisis as $d)
                                        <option value="{{ $d->id_divisi }}" {{ $selectedDivisi == $d->id_divisi ? 'selected' : '' }}>
                                            {{ $d->nama_divisi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tombol Reset --}}
                            @if(request('id_divisi') || request('search'))
                                <a href="{{ route('admin.monitoring.index', ['id_periode' => $selectedPeriode]) }}" class="flex items-center justify-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-blue-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white shadow-sm transition">
                                    Reset
                                </a>
                            @endif
                        </div>

                        {{-- Search Kanan --}}
                        <div class="relative w-full lg:w-64">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white shadow-sm" placeholder="Cari karyawan / NIK..." onkeydown="if (event.key === 'Enter') this.form.submit()">
                        </div>

                    </form>
                </div>

                {{-- TABEL DATA --}}
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b dark:border-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 rounded-tl-lg">Karyawan</th>
                                <th scope="col" class="px-6 py-4">Divisi</th>
                                <th scope="col" class="px-6 py-4 w-1/3">Skor Saat Ini</th>
                                <th scope="col" class="px-6 py-4 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            {{-- LOOPING KARYAWAN --}}
                            @forelse($karyawans as $karyawan)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                
                                {{-- Kolom 1: Nama Karyawan --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        {{-- Avatar Inisial --}}
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600 dark:from-blue-900 dark:to-indigo-900 dark:text-blue-200 flex items-center justify-center text-sm font-bold border border-blue-200 dark:border-blue-800 shadow-sm">
                                            {{ substr($karyawan->nama_lengkap, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white">{{ $karyawan->nama_lengkap }}</div>
                                            <div class="text-xs text-gray-500 font-mono">{{ $karyawan->nik }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom 2: Divisi --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                                        <svg class="w-3 h-3 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        {{ $karyawan->divisi->nama_divisi ?? '-' }}
                                    </span>
                                </td>

                                {{-- Kolom 3: Progress Bar Skor --}}
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-bold text-gray-700 dark:text-gray-200 w-10 text-right">
                                            {{ number_format($karyawan->skor_saat_ini, 1) }}
                                        </span>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 shadow-inner overflow-hidden">
                                            @php
                                                $skor = $karyawan->skor_saat_ini;
                                                $width = min($skor, 100);
                                                
                                                // Warna Progress Bar
                                                $colorClass = 'bg-blue-600'; 
                                                if($skor < 60) $colorClass = 'bg-red-500';      // E & D
                                                elseif($skor < 75) $colorClass = 'bg-yellow-400'; // C
                                                elseif($skor >= 90) $colorClass = 'bg-green-500'; // A
                                            @endphp
                                            <div class="{{ $colorClass }} h-2.5 rounded-full transition-all duration-1000 ease-out" style="width: {{ $width }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom 4: Aksi --}}
                                <td class="px-6 py-4 text-center">
                                    @if($selectedPeriode)
                                        <a href="{{ route('admin.monitoring.show', ['karyawan' => $karyawan->id_karyawan, 'periode' => $selectedPeriode]) }}" 
                                           class="inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 shadow-md transition transform hover:-translate-y-0.5">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Detail Rapor
                                        </a>
                                    @else
                                        <button disabled class="inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500" title="Pilih periode terlebih dahulu">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                            Pilih Periode
                                        </button>
                                    @endif
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-full mb-3">
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        </div>
                                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">Tidak ada data karyawan.</p>
                                        <p class="text-sm">Coba sesuaikan filter atau pencarian Anda.</p>
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