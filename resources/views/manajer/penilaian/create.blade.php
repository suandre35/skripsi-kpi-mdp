<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Input Penilaian Harian') }}
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
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Input Baru</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. ERROR DARI CONTROLLER (Try-Catch) --}}
            @if(session('error'))
                <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 flex items-center gap-3">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <strong class="font-bold">Gagal Menyimpan!</strong>
                        <span class="block text-sm">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- 2. ERROR VALIDASI FORM --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-300">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <strong class="font-bold">Periksa Inputan Anda:</strong>
                    </div>
                    <ul class="list-disc list-inside text-sm ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('penilaian.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_periode" value="{{ $periodeAktif->id_periode }}">

                <div class="space-y-6">

                    {{-- SECTION 1: IDENTITAS PEKERJAAN --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Identitas Pekerjaan
                            </h3>
                        </div>
                        <div class="p-6 md:p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Pilih Karyawan --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pilih Karyawan <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <select name="id_karyawan" required class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                            <option value="">-- Pilih Anggota Tim --</option>
                                            @foreach($karyawans as $karyawan)
                                                <option value="{{ $karyawan->id_karyawan }}" {{ old('id_karyawan') == $karyawan->id_karyawan ? 'selected' : '' }}>
                                                    {{ $karyawan->nama_lengkap }} ({{ $karyawan->nik }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Tanggal --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Pengerjaan <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required 
                                               class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: DAFTAR AKTIVITAS (KPI) --}}
                    @foreach($kategoris as $kategori)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                            
                            {{-- Header Kategori --}}
                            <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                <h4 class="font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wide text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    {{ $kategori->nama_kategori }}
                                </h4>
                            </div>

                            {{-- List Indikator --}}
                            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($kategori->indikators as $indikator)
                                    @php
                                        $target = $indikator->target; 
                                        $nilaiTarget = $target ? number_format((float)$target->nilai_target, 0, ',', '.') : '0';
                                        $satuan = $target ? $target->jenis_target : '';
                                        
                                        // Ambil old value jika validasi gagal
                                        $oldNilai = old("aktivitas.{$indikator->id_indikator}.nilai");
                                        $oldCatatan = old("aktivitas.{$indikator->id_indikator}.catatan");
                                    @endphp

                                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                        <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">
                                            
                                            {{-- Info Indikator --}}
                                            <div class="md:w-5/12">
                                                <h5 class="text-sm font-bold text-gray-900 dark:text-white mb-1">
                                                    {{ $indikator->nama_indikator }}
                                                </h5>
                                                
                                                {{-- Badge Target --}}
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                                    Target: {{ $nilaiTarget }} {{ $satuan }}
                                                </span>

                                                @if($indikator->deskripsi)
                                                    <p class="text-xs text-gray-500 mt-2 line-clamp-1" title="{{ $indikator->deskripsi }}">
                                                        {{ $indikator->deskripsi }}
                                                    </p>
                                                @endif
                                            </div>

                                            {{-- Form Input --}}
                                            <div class="md:w-7/12 w-full">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    
                                                    {{-- Input Hasil --}}
                                                    <div>
                                                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1">Hasil ({{ $satuan ?? 'Angka' }})</label>
                                                        <input type="number" step="any" 
                                                               name="aktivitas[{{ $indikator->id_indikator }}][nilai]" 
                                                               value="{{ $oldNilai }}"
                                                               placeholder="0"
                                                               class="block w-full text-right font-bold rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm">
                                                    </div>

                                                    {{-- Input Catatan --}}
                                                    <div>
                                                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1">Catatan (Opsional)</label>
                                                        <input type="text" 
                                                               name="aktivitas[{{ $indikator->id_indikator }}][catatan]" 
                                                               value="{{ $oldCatatan }}"
                                                               placeholder="Keterangan singkat..."
                                                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm">
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- FOOTER BUTTONS --}}
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('penilaian.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" class="flex items-center justify-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition transform hover:-translate-y-0.5 shadow-lg shadow-blue-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Log Harian
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>