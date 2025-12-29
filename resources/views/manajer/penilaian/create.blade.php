<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Input Penilaian Baru') }}
            </h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('penilaian.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Log Aktivitas</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Input</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- ERROR HANDLING --}}
            @if(session('error'))
                <div class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <h3 class="text-lg font-medium">Gagal Menyimpan</h3>
                    </div>
                    <div class="mt-2 mb-4 text-sm">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 mb-4 text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800" role="alert">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <h3 class="text-lg font-medium">Periksa Inputan Anda</h3>
                    </div>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('penilaian.store') }}" method="POST">
                @csrf
                {{-- Periode disembunyikan (otomatis periode aktif) --}}
                <input type="hidden" name="id_periode" value="{{ $periodeAktif->id_periode }}">

                <div class="space-y-8">

                    {{-- CARD 1: PILIH KARYAWAN --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Pilih Karyawan
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pilih anggota tim yang ingin dinilai kinerjanya hari ini.</p>
                        </div>
                        
                        <div class="p-6 md:p-8">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Nama Anggota Tim</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <select name="id_karyawan" required class="pl-10 block w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm transition h-11">
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach($karyawans as $karyawan)
                                            <option value="{{ $karyawan->id_karyawan }}" {{ old('id_karyawan') == $karyawan->id_karyawan ? 'selected' : '' }}>
                                                {{ $karyawan->nama_lengkap }} - {{ $karyawan->nik }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: FORM INPUT NILAI --}}
                    @foreach($kategoris as $kategori)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                            
                            {{-- Header Kategori --}}
                            <div class="px-6 py-3 bg-gray-50/80 dark:bg-gray-700/80 border-b border-gray-200 dark:border-gray-600 flex items-center gap-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded border border-blue-200">KATEGORI</span>
                                <h4 class="font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wide text-sm">
                                    {{ $kategori->nama_kategori }}
                                </h4>
                            </div>

                            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($kategori->indikators as $indikator)
                                    @php
                                        $target = $indikator->target; 
                                        $nilaiTarget = $target ? number_format((float)$target->nilai_target, 0, ',', '.') : '0';
                                        $satuan = $target ? $target->jenis_target : '';
                                        
                                        // Helper untuk old values
                                        $fieldKey = "aktivitas." . $indikator->id_indikator;
                                    @endphp

                                    <div class="p-6 hover:bg-blue-50/30 dark:hover:bg-gray-700/30 transition duration-150 group">
                                        <div class="flex flex-col lg:flex-row gap-6 lg:items-center justify-between">
                                            
                                            {{-- BAGIAN KIRI: INFO INDIKATOR --}}
                                            <div class="lg:w-5/12">
                                                <h5 class="text-sm font-bold text-gray-900 dark:text-white mb-1 group-hover:text-blue-600 transition">
                                                    {{ $indikator->nama_indikator }}
                                                </h5>
                                                
                                                <div class="flex items-center gap-2 mt-2">
                                                    {{-- Badge Target --}}
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                                        Target: {{ $nilaiTarget }} {{ $satuan }}
                                                    </span>
                                                </div>

                                                @if($indikator->deskripsi)
                                                    <p class="text-xs text-gray-400 mt-2 italic">
                                                        {{ $indikator->deskripsi }}
                                                    </p>
                                                @endif
                                            </div>

                                            {{-- BAGIAN KANAN: INPUT FIELDS --}}
                                            <div class="lg:w-7/12 w-full">
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                    
                                                    {{-- Input Hasil --}}
                                                    <div>
                                                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">
                                                            Hasil / Realisasi
                                                        </label>
                                                        <div class="relative">
                                                            <input type="number" step="any" 
                                                                   name="aktivitas[{{ $indikator->id_indikator }}][nilai]" 
                                                                   value="{{ old($fieldKey . '.nilai') }}"
                                                                   placeholder="0"
                                                                   class="block w-full pl-3 pr-10 text-right font-bold text-lg rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-400 text-xs">{{ $satuan }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Input Catatan --}}
                                                    <div>
                                                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">
                                                            Catatan (Opsional)
                                                        </label>
                                                        <input type="text" 
                                                               name="aktivitas[{{ $indikator->id_indikator }}][catatan]" 
                                                               value="{{ old($fieldKey . '.catatan') }}"
                                                               placeholder="Keterangan..."
                                                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm text-sm h-[46px]">
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- FOOTER ACTION --}}
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('penilaian.index') }}" class="px-6 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition shadow-sm">
                            Batal
                        </a>
                        <button type="submit" class="flex items-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-bold rounded-xl text-sm px-8 py-3 shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Simpan Data Penilaian
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>