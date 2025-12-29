<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Edit Indikator KPI') }}
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
                            <a href="{{ route('indikator.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Indikator</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                {{-- HEADER CARD --}}
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Edit Indikator: <span class="font-bold text-blue-600">{{ $indikator->nama_indikator }}</span></h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Sesuaikan target dan parameter indikator.</p>
                    </div>
                    {{-- Status Badge --}}
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $indikator->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $indikator->status }}
                    </span>
                </div>

                <div class="p-6 md:p-8">
                    
                    {{-- Validasi Error --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <strong class="font-bold">Periksa Kembali Inputan Anda!</strong>
                            </div>
                            <ul class="list-disc list-inside text-sm ml-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('indikator.update', $indikator->id_indikator) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- PENTING: Untuk Update --}}
                        
                        <div class="space-y-8">
                            
                            {{-- SECTION 1: KLASIFIKASI & NAMA --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">1. Klasifikasi & Nama</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    
                                    {{-- Kategori --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Kategori KPI <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                            </div>
                                            <select name="id_kategori" required class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                                <option value="">-- Pilih Kategori --</option>
                                                @foreach($kategoris as $kategori)
                                                    <option value="{{ $kategori->id_kategori }}" 
                                                        {{ old('id_kategori', $indikator->id_kategori) == $kategori->id_kategori ? 'selected' : '' }}>
                                                        {{ $kategori->nama_kategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Nama Indikator --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Indikator <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <input type="text" name="nama_indikator" value="{{ old('nama_indikator', $indikator->nama_indikator) }}" required 
                                                class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 2: TARGET & DETAIL --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">2. Target Divisi & Detail</h4>
                                
                                {{-- Target Divisi (GRID CHECKBOX) --}}
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                        Target Divisi <span class="text-red-500">*</span> 
                                        <span class="text-xs font-normal text-gray-500 ml-1">(Centang untuk mengaktifkan pada divisi tersebut)</span>
                                    </label>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                        @foreach($divisis as $divisi)
                                        <label class="relative flex items-start p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer transition-colors duration-200">
                                            <div class="flex items-center h-5">
                                                {{-- LOGIKA PENTING: Cek array dari old input (jika error) ATAU data database --}}
                                                <input type="checkbox" name="target_divisi[]" value="{{ $divisi->id_divisi }}" 
                                                    {{ in_array($divisi->id_divisi, old('target_divisi', $indikator->target_divisi ?? [])) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <span class="font-medium text-gray-900 dark:text-gray-300">{{ $divisi->nama_divisi }}</span>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Satuan --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Satuan Pengukuran</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                                            </div>
                                            <input type="text" name="satuan_pengukuran" value="{{ old('satuan_pengukuran', $indikator->satuan_pengukuran) }}" placeholder="Contoh: %, Hari"
                                                class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                        <div class="relative">
                                            <select name="status" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                                <option value="Aktif" {{ old('status', $indikator->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Nonaktif" {{ old('status', $indikator->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Deskripsi --}}
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Deskripsi Detail</label>
                                        <textarea name="deskripsi" rows="3" 
                                            class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">{{ old('deskripsi', $indikator->deskripsi) }}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- FOOTER BUTTONS --}}
                        <div class="flex items-center justify-end gap-3 mt-10 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('indikator.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 transition duration-200">
                                Batal
                            </a>
                            <button type="submit" class="flex items-center justify-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition transform hover:-translate-y-0.5 shadow-lg shadow-blue-500/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Update Indikator
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>