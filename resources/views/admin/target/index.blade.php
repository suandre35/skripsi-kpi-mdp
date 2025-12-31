<x-app-layout>
    {{-- DEFINISI STATE ALPINE.JS UNTUK MODAL --}}
    <div x-data="{ showDeleteModal: false, deleteUrl: '' }">

        <x-slot name="header">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Daftar Target KPI') }}
                </h2>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">
                            Master KPI
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Target</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
                {{-- ALERT SUCCESS --}}
                @if(session('success'))
                    <div class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
                    </div>
                @endif

                {{-- ALERT ERROR --}}
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
                    
                    {{-- TOOLBAR (SEARCH & FILTERS) --}}
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
                            
                            {{-- KIRI: Search & Filter Group --}}
                            <form method="GET" action="{{ route('target.index') }}" class="flex flex-col md:flex-row gap-3 w-full xl:w-auto">
                                
                                {{-- 1. Search Bar --}}
                                <div class="relative w-full md:w-48">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}" 
                                        class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                        placeholder="Cari indikator..." onkeydown="if (event.key === 'Enter') this.form.submit()">
                                </div>

                                {{-- 2. Filter Divisi --}}
                                <div class="relative">
                                    <select name="divisi" onchange="this.form.submit()" class="block w-full md:w-48 pl-3 pr-10 py-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white cursor-pointer">
                                        <option value="">Semua Divisi</option>
                                        @foreach($divisis as $divisi)
                                            <option value="{{ $divisi->id_divisi }}" {{ request('divisi') == $divisi->id_divisi ? 'selected' : '' }}>
                                                {{ $divisi->nama_divisi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- 3. Filter Kategori --}}
                                <div class="relative">
                                    <select name="kategori" onchange="this.form.submit()" class="block w-full md:w-48 pl-3 pr-10 py-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white cursor-pointer">
                                        <option value="">Semua Kategori</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id_kategori }}" {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Tombol Reset --}}
                                @if(request('search') || request('kategori') || request('status') || request('divisi'))
                                <a href="{{ route('target.index') }}" class="flex items-center justify-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700">
                                    Reset
                                </a>
                                @endif
                            </form>

                            {{-- KANAN: Tombol Tambah --}}
                            <div class="flex-shrink-0">
                                <a href="{{ route('target.create') }}" class="flex items-center justify-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition transform hover:-translate-y-0.5 shadow-lg shadow-blue-500/30 w-full xl:w-auto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Target
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-4 rounded-tl-lg">Indikator</th>
                                    <th scope="col" class="px-6 py-4">Nilai Target</th>
                                    <th scope="col" class="px-6 py-4">Satuan / Jenis</th>
                                    <th scope="col" class="px-6 py-4 text-center rounded-tr-lg">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($targets as $index => $target)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                    
                                    {{-- KOLOM 1: INDIKATOR --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 mt-1 w-8 h-8 rounded bg-blue-50 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                                {{-- Icon Chart --}}
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                            </div>
                                            <div>
                                                {{-- Nama Indikator --}}
                                                <div class="font-bold text-gray-900 dark:text-white">{{ $target->indikator->nama_indikator ?? '-' }}</div>
                                                {{-- Nama Kategori --}}
                                                <div class="text-xs text-gray-500 mt-0.5 inline-flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                                    {{ $target->indikator->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- KOLOM 2: NILAI TARGET --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-lg font-bold text-emerald-600 dark:text-emerald-400">
                                            {{ number_format($target->nilai_target, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-gray-400">Poin/Nilai</div>
                                    </td>

                                    {{-- KOLOM 3: SATUAN --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                                            {{ $target->jenis_target ?? 'Umum' }}
                                        </span>
                                    </td>

                                    {{-- KOLOM 4: AKSI --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('target.edit', $target->id_target) }}" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-lg transition-colors duration-200" title="Edit Target">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            {{-- TOMBOL HAPUS DENGAN MODAL --}}
                                            <button @click="showDeleteModal = true; deleteUrl = '{{ route('target.destroy', $target->id_target) }}'"
                                                    class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-lg transition-colors duration-200" 
                                                    title="Hapus Target">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                            <p class="text-lg font-medium">Data target tidak ditemukan.</p>
                                            <p class="text-sm">Silakan tambah target baru.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-b-2xl">
                        {{ $targets->links() }}
                    </div>

                </div>
            </div>
        </div>

        {{-- COMPONENT MODAL DELETE --}}
        <x-modal-delete />
        
    </div>
</x-app-layout>