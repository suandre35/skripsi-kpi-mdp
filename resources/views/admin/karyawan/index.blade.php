<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Data Karyawan') }}
            </h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">
                        Master Organisasi
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Karyawan</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- ALERT MESSAGES --}}
            @if(session('success'))
                <div class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
                </div>
            @endif

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
                
                {{-- TOOLBAR --}}
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        
                        {{-- FILTER FORM --}}
                        <form method="GET" action="{{ route('karyawan.index') }}" class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">
                            
                            {{-- Search --}}
                            <div class="relative w-full md:w-64">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Cari NIK / Nama..." onkeydown="if (event.key === 'Enter') this.form.submit()">
                            </div>

                            {{-- Filter Divisi --}}
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

                            {{-- Filter Status --}}
                            <div class="relative">
                                <select name="status" onchange="this.form.submit()" class="block w-full md:w-40 pl-3 pr-10 py-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white cursor-pointer">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>

                            @if(request('search') || request('divisi') || request('status'))
                            <a href="{{ route('karyawan.index') }}" class="flex items-center justify-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700">
                                Reset
                            </a>
                            @endif
                        </form>

                        {{-- TOMBOL TAMBAH --}}
                        <div class="flex-shrink-0">
                            <a href="{{ route('karyawan.create') }}" class="flex items-center justify-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition transform hover:-translate-y-0.5 shadow-lg shadow-blue-500/30 w-full lg:w-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Karyawan
                            </a>
                        </div>
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-4 rounded-tl-lg">Profil Karyawan</th>
                                <th scope="col" class="px-6 py-4">Data Pribadi & Kontak</th>
                                <th scope="col" class="px-6 py-4">Divisi & Akun Login</th>
                                <th scope="col" class="px-6 py-4">Status</th>
                                <th scope="col" class="px-6 py-4 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($karyawans as $karyawan)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                
                                {{-- KOLOM 1: PROFIL --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 w-12 h-12 rounded-full overflow-hidden border border-gray-200 dark:border-gray-600">
                                            @if($karyawan->foto && Storage::disk('public')->exists($karyawan->foto))
                                                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $karyawan->foto) }}" alt="Foto">
                                            @else
                                                <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 text-xs font-bold">
                                                    {{ substr($karyawan->nama_lengkap, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $karyawan->nama_lengkap }}</div>
                                            <div class="text-xs text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded inline-block mt-1">
                                                NIK: {{ $karyawan->nik }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- KOLOM 2: DATA PRIBADI (UPDATE) --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                                        <div class="flex items-center gap-2" title="Tempat, Tanggal Lahir">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path></svg>
                                            <span>
                                                {{ $karyawan->tempat_lahir }}, {{ \Carbon\Carbon::parse($karyawan->tanggal_lahir)->format('d M Y') }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center gap-2" title="Kontak & Email">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            <span class="truncate max-w-[150px]">{{ $karyawan->no_telepon }}</span>
                                        </div>

                                        <div class="flex items-center gap-2" title="Email Pribadi">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            <span class="truncate max-w-[150px] text-xs">{{ $karyawan->email }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- KOLOM 3: DIVISI & AKUN --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="font-bold text-gray-900 dark:text-white mb-1">
                                            {{ $karyawan->divisi->nama_divisi ?? 'Tanpa Divisi' }}
                                        </div>
                                        <div class="flex items-center gap-1.5 text-xs text-gray-500 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded border border-blue-100 dark:border-blue-800 w-fit">
                                            <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            {{ $karyawan->user->email ?? 'No User' }}
                                        </div>
                                    </div>
                                </td>

                                {{-- KOLOM 4: STATUS --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full mr-2 {{ $karyawan->status ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}"></div>
                                        <span class="text-sm font-medium {{ $karyawan->status ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $karyawan->status ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- KOLOM 5: AKSI --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('karyawan.edit', $karyawan->id_karyawan) }}" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-lg transition-colors duration-200" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <p class="text-lg font-medium">Data karyawan tidak ditemukan.</p>
                                        <p class="text-sm">Silakan tambah karyawan baru.</p>
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