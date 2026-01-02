<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Tambah User Baru') }}
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
                            <a href="{{ route('users.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">User</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Buat Baru</span>
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
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Formulir Pendaftaran</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lengkapi data di bawah ini untuk menambahkan user baru ke dalam sistem.</p>
                </div>

                <div class="p-6 md:p-8">
                    
                    {{-- Alert Error Global (Opsional, tetap bagus jika ada error tak terduga) --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-bold text-sm">Terdapat kesalahan pada inputan Anda.</span>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-8">
                            
                            {{-- SECTION 1: IDENTITAS USER --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">1. Identitas User</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    
                                    {{-- Nama --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso"
                                                class="pl-10 block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:text-white
                                                {{ $errors->has('name') 
                                                    ? 'border-red-500 focus:ring-red-500 focus:border-red-500 dark:border-red-500' 
                                                    : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600' }}">
                                        </div>
                                        {{-- Custom Error Message --}}
                                        @error('name')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@perusahaan.com"
                                                class="pl-10 block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:text-white
                                                {{ $errors->has('email') 
                                                    ? 'border-red-500 focus:ring-red-500 focus:border-red-500 dark:border-red-500' 
                                                    : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600' }}">
                                        </div>
                                        {{-- Custom Error Message --}}
                                        @error('email')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 2: KEAMANAN --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">2. Keamanan Akun</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Password --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            </div>
                                            <input type="password" name="password" placeholder="Minimal 8 karakter"
                                                class="pl-10 block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:text-white
                                                {{ $errors->has('password') 
                                                    ? 'border-red-500 focus:ring-red-500 focus:border-red-500 dark:border-red-500' 
                                                    : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600' }}">
                                        </div>
                                        {{-- Custom Error Message --}}
                                        @error('password')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- Konfirmasi Password --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <input type="password" name="password_confirmation" placeholder="Ulangi password"
                                                class="pl-10 block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 3: HAK AKSES --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">3. Peran & Status</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Role --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Role (Jabatan) <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select name="role" 
                                                class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:text-white
                                                {{ $errors->has('role') 
                                                    ? 'border-red-500 focus:ring-red-500 focus:border-red-500 dark:border-red-500' 
                                                    : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600' }}">
                                                <option value="Karyawan" {{ old('role') == 'Karyawan' ? 'selected' : '' }}>Karyawan (Staff Biasa)</option>
                                                <option value="Manajer" {{ old('role') == 'Manajer' ? 'selected' : '' }}>Manajer (Kepala Divisi)</option>
                                            </select>
                                        </div>
                                        @error('role')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Menentukan fitur apa saja yang bisa diakses user.</p>
                                    </div>

                                    {{-- Status --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status Akun</label>
                                        <div class="relative">
                                            <select name="status" 
                                                class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:text-white
                                                {{ $errors->has('status') 
                                                    ? 'border-red-500 focus:ring-red-500 focus:border-red-500 dark:border-red-500' 
                                                    : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600' }}">
                                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                        @error('status')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">User nonaktif tidak akan bisa login ke sistem.</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- FOOTER BUTTONS --}}
                        <div class="flex items-center justify-end gap-3 mt-10 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('users.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 transition duration-200">
                                Batal
                            </a>
                            <button type="submit" class="flex items-center justify-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition transform hover:-translate-y-0.5 shadow-lg shadow-blue-500/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Data User
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>