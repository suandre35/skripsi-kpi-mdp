<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Edit Log Aktivitas') }}
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
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Edit Data</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Validasi Error --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 flex items-center gap-3">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <strong class="font-bold">Gagal Menyimpan!</strong>
                        <ul class="list-disc list-inside text-sm mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('penilaian.update', $log->getKey()) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    
                    {{-- CARD 1: INFO KONTEKS (READ ONLY) --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50 flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Detail Pekerjaan
                            </h3>
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">Read Only</span>
                        </div>
                        
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Karyawan --}}
                                <div class="flex items-start gap-3">
                                    <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-blue-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-bold tracking-wide">Karyawan</p>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $log->header->karyawan->nama_lengkap }}</p>
                                        <p class="text-xs text-gray-500">{{ $log->header->karyawan->nik }}</p>
                                    </div>
                                </div>

                                {{-- Tanggal --}}
                                <div class="flex items-start gap-3">
                                    <div class="p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg text-purple-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-bold tracking-wide">Tanggal Log</p>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($log->tanggal)->format('d F Y') }}</p>
                                    </div>
                                </div>

                                {{-- Indikator & Target --}}
                                <div class="md:col-span-2 mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                        <div class="flex items-start gap-3">
                                            <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg text-green-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-bold tracking-wide">Aktivitas / Indikator</p>
                                                <p class="text-base font-bold text-gray-900 dark:text-white">{{ $log->indikator->nama_indikator }}</p>
                                            </div>
                                        </div>

                                        {{-- Info Target --}}
                                        <div class="bg-blue-50 dark:bg-blue-900/30 px-4 py-2 rounded-lg border border-blue-100 dark:border-blue-800">
                                            <p class="text-xs text-blue-600 dark:text-blue-300 font-bold uppercase">Target KPI</p>
                                            <p class="text-lg font-bold text-blue-800 dark:text-blue-100">
                                                {{ number_format($log->indikator->target->nilai_target ?? 0, 0, ',', '.') }} 
                                                <span class="text-sm font-medium">{{ $log->indikator->target->jenis_target ?? '' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: FORM EDIT --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Revisi Nilai & Catatan
                            </h3>
                        </div>

                        <div class="p-6 md:p-8">
                            <div class="space-y-6">
                                
                                {{-- Edit Nilai --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                        Realisasi / Hasil <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" step="any" name="nilai_input" 
                                               value="{{ old('nilai_input', $log->nilai_input) }}" required
                                               class="block w-full md:w-1/3 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 font-bold text-lg p-3 shadow-sm">
                                        
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none md:left-1/3 md:ml-4">
                                            <span class="text-gray-500 dark:text-gray-400 font-medium">{{ $log->indikator->target->jenis_target ?? '' }}</span>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500">Masukkan angka capaian yang sebenar-benarnya.</p>
                                </div>

                                {{-- Edit Catatan --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                        Catatan / Keterangan
                                    </label>
                                    <textarea name="catatan" rows="3" placeholder="Tambahkan keterangan revisi..."
                                              class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ old('catatan', $log->catatan) }}</textarea>
                                </div>

                            </div>

                            {{-- FOOTER BUTTONS --}}
                            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                                <a href="{{ route('penilaian.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 transition duration-200">
                                    Batal
                                </a>
                                <button type="submit" class="flex items-center justify-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition transform hover:-translate-y-0.5 shadow-lg shadow-blue-500/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>