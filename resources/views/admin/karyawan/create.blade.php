<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Tambah Karyawan Baru') }}
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
                            <a href="{{ route('karyawan.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Karyawan</a>
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
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                {{-- HEADER CARD --}}
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Formulir Data Karyawan</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lengkapi biodata dan hubungkan dengan akun user.</p>
                </div>

                <div class="p-6 md:p-8">
                    
                    {{-- Alert Error Global --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-bold text-sm">Terdapat kesalahan pada inputan Anda.</span>
                            </div>
                        </div>
                    @endif

                    {{-- FORM START --}}
                    <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        
                        <div class="space-y-8">
                            
                            {{-- SECTION 1: AKUN & POSISI --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">1. Akun & Posisi</h4>
                                
                                {{-- Pilih Akun User --}}
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pilih Akun User (Login) <span class="text-red-500">*</span></label>
                                    <select name="id_user" class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 cursor-pointer dark:bg-gray-700 dark:text-white
                                        {{ $errors->has('id_user') ? 'border-red-500 text-red-900 focus:ring-red-500 dark:border-red-500' : 'border-gray-300 focus:ring-blue-500 dark:border-gray-600' }}">
                                        <option value="">-- Pilih Akun yang Tersedia --</option>
                                        @if(isset($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }}) - {{ $user->role }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('id_user')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1 font-medium animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Hanya menampilkan user yang belum terdaftar sebagai karyawan.</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- NIK --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">NIK <span class="text-red-500">*</span></label>
                                        <input type="text" name="nik" value="{{ old('nik') }}" placeholder="Contoh: HRD-001"
                                            class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:text-white
                                            {{ $errors->has('nik') ? 'border-red-500 text-red-900 placeholder-red-300 focus:ring-red-500 dark:border-red-500' : 'border-gray-300 focus:ring-blue-500 dark:border-gray-600' }}">
                                        @error('nik')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1 font-medium animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Divisi (SEKARANG WAJIB) --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Divisi (Posisi) <span class="text-red-500">*</span></label>
                                        <select name="id_divisi" class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 cursor-pointer dark:bg-gray-700 dark:text-white
                                            {{ $errors->has('id_divisi') ? 'border-red-500 text-red-900 focus:ring-red-500 dark:border-red-500' : 'border-gray-300 focus:ring-blue-500 dark:border-gray-600' }}">
                                            <option value="">-- Pilih Divisi --</option>
                                            @if(isset($divisis))
                                                @foreach($divisis as $divisi)
                                                    <option value="{{ $divisi->id_divisi }}" {{ old('id_divisi') == $divisi->id_divisi ? 'selected' : '' }}>
                                                        {{ $divisi->nama_divisi }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('id_divisi')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1 font-medium animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 2: DATA PRIBADI --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">2. Data Pribadi & Kontak</h4>
                                
                                {{-- Nama Lengkap --}}
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                        class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:text-white
                                        {{ $errors->has('nama_lengkap') ? 'border-red-500 text-red-900 focus:ring-red-500 dark:border-red-500' : 'border-gray-300 focus:ring-blue-500 dark:border-gray-600' }}">
                                    @error('nama_lengkap')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1 font-medium animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    {{-- Tempat Lahir --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Jakarta"
                                            class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:text-white
                                            {{ $errors->has('tempat_lahir') ? 'border-red-500 text-red-900 placeholder-red-300 focus:ring-red-500 dark:border-red-500' : 'border-gray-300 focus:ring-blue-500 dark:border-gray-600' }}">
                                        @error('tempat_lahir')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1 font-medium animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    {{-- Tanggal Lahir --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                            class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:text-white
                                            {{ $errors->has('tanggal_lahir') ? 'border-red-500 text-red-900 focus:ring-red-500 dark:border-red-500' : 'border-gray-300 focus:ring-blue-500 dark:border-gray-600' }}">
                                        @error('tanggal_lahir')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1 font-medium animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    {{-- Jenis Kelamin --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                                        <select name="jenis_kelamin" class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 cursor-pointer dark:bg-gray-700 dark:text-white
                                            {{ $errors->has('jenis_kelamin') ? 'border-red-500 text-red-900 focus:ring-red-500 dark:border-red-500' : 'border-gray-300 focus:ring-blue-500 dark:border-gray-600' }}">
                                            <option value="">-- Pilih --</option>
                                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1 font-medium animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email Pribadi (Kontak) <span class="text-red-500">*</span></label>
                                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@pribadi.com"
                                            class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:text-white
                                            {{ $errors->has('email') ? 'border-red-500 text-red-900 placeholder-red-300 focus:ring-red-500 dark:border-red-500' : 'border-gray-300 focus:ring-blue-500 dark:border-gray-600' }}">
                                        @error('email')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1 font-medium animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    {{-- No Telepon --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">No. Telepon / HP <span class="text-red-500">*</span></label>
                                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" placeholder="0812xxxx"
                                            class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:text-white
                                            {{ $errors->has('no_telepon') ? 'border-red-500 text-red-900 placeholder-red-300 focus:ring-red-500 dark:border-red-500' : 'border-gray-300 focus:ring-blue-500 dark:border-gray-600' }}">
                                        @error('no_telepon')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1 font-medium animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Foto Profil --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Foto Profil (3x4)</label>
                                        <input type="file" name="foto" accept="image/*"
                                            class="block w-full text-sm text-gray-900 border rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:placeholder-gray-400
                                            {{ $errors->has('foto') ? 'border-red-500 dark:border-red-500' : 'border-gray-300 dark:border-gray-600' }}">
                                        <p class="mt-1 text-xs text-gray-500">Maks. 2MB (JPG, JPEG, PNG)</p>
                                        @error('foto')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1 font-medium animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Alamat (SEKARANG WAJIB) --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                    <textarea name="alamat" rows="3"
                                        class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:text-white
                                        {{ $errors->has('alamat') ? 'border-red-500 text-red-900 focus:ring-red-500 dark:border-red-500' : 'border-gray-300 focus:ring-blue-500 dark:border-gray-600' }}">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1 font-medium animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- SECTION 3: STATUS KEPEGAWAIAN --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">3. Status Kepegawaian</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Tanggal Masuk --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Masuk <span class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}"
                                            class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 dark:bg-gray-700 dark:text-white
                                            {{ $errors->has('tanggal_masuk') ? 'border-red-500 text-red-900 focus:ring-red-500 dark:border-red-500' : 'border-gray-300 focus:ring-blue-500 dark:border-gray-600' }}">
                                        @error('tanggal_masuk')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1 font-medium animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Status --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status Karyawan <span class="text-red-500">*</span></label>
                                        <select name="status" class="block w-full rounded-lg shadow-sm sm:text-sm transition duration-150 cursor-pointer dark:bg-gray-700 dark:text-white
                                            {{ $errors->has('status') ? 'border-red-500 text-red-900 focus:ring-red-500 dark:border-red-500' : 'border-gray-300 focus:ring-blue-500 dark:border-gray-600' }}">
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                        @error('status')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1 font-medium animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- FOOTER BUTTONS --}}
                        <div class="flex items-center justify-end gap-3 mt-10 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('karyawan.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 transition duration-200">
                                Batal
                            </a>
                            <button type="submit" class="flex items-center justify-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition transform hover:-translate-y-0.5 shadow-lg shadow-blue-500/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Karyawan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>