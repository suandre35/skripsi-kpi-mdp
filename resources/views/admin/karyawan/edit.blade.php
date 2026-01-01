<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Edit Data Karyawan') }}
            </h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">
                        Master Organisasi
                    </li>
                    <li class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">
                        <a href="{{ route('karyawan.index') }}">Karyawan</a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Edit Profil</span>
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
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Edit Data: <span class="font-bold text-blue-600">{{ $karyawan->nama_lengkap }}</span></h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Perbarui informasi lengkap karyawan.</p>
                    </div>
                    {{-- Status Badge --}}
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $karyawan->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $karyawan->status ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <div class="p-6 md:p-8">
                    
                    {{-- ERROR DISPLAY --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <strong class="font-bold">Periksa Inputan Anda!</strong>
                            </div>
                            <ul class="list-disc list-inside text-sm ml-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('karyawan.update', $karyawan->id_karyawan) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-8">
                            
                            {{-- 1. AKUN & POSISI --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">1. Akun & Posisi</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    
                                    {{-- Pilih User --}}
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Akun User (Login) <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                            <select name="id_user" required class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                                <option value="">-- Pilih Akun --</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id_user }}" 
                                                        {{ $user->id_user == old('id_user', $karyawan->id_user) ? 'selected' : '' }}>
                                                        {{ $user->name }} ({{ $user->email }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Menampilkan user yang belum terhubung atau user milik karyawan ini.</p>
                                    </div>
                                    
                                    {{-- NIK --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">NIK <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 00-2-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                            </div>
                                            <input type="text" name="nik" value="{{ old('nik', $karyawan->nik) }}" required 
                                                class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                        </div>
                                    </div>

                                    {{-- Divisi --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Divisi (Posisi)</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            </div>
                                            <select name="id_divisi" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                                <option value="">-- Pilih Divisi --</option>
                                                @foreach($divisis as $divisi)
                                                    <option value="{{ $divisi->id_divisi }}" {{ old('id_divisi', $karyawan->id_divisi) == $divisi->id_divisi ? 'selected' : '' }}>
                                                        {{ $divisi->nama_divisi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 2. DATA PRIBADI --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">2. Data Pribadi & Kontak</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    
                                    {{-- Nama Lengkap --}}
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}" required 
                                            class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                    </div>

                                    {{-- Tempat Lahir --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $karyawan->tempat_lahir) }}" required 
                                            class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                    </div>

                                    {{-- Tanggal Lahir --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir) }}" required 
                                            class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                    </div>

                                    {{-- Jenis Kelamin --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                                        <select name="jenis_kelamin" required class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                            <option value="">-- Pilih --</option>
                                            <option value="L" {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>

                                    {{-- Email Pribadi --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email Pribadi (Kontak) <span class="text-red-500">*</span></label>
                                        <input type="email" name="email" value="{{ old('email', $karyawan->email) }}" required 
                                            class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                    </div>

                                    {{-- No Telepon --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">No. Telepon / HP <span class="text-red-500">*</span></label>
                                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $karyawan->no_telepon) }}" required 
                                            class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                    </div>

                                    {{-- Alamat --}}
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Alamat Lengkap</label>
                                        <textarea name="alamat" rows="3" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">{{ old('alamat', $karyawan->alamat) }}</textarea>
                                    </div>

                                    {{-- Foto Diri (Dengan Preview) --}}
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Update Foto Diri (3x4) - <span class="text-gray-500 font-normal">Biarkan kosong jika tidak ingin mengubah</span></label>
                                        
                                        <div class="flex flex-col md:flex-row gap-6 items-start">
                                            {{-- Preview Foto Lama --}}
                                            <div class="flex-shrink-0">
                                                <p class="text-xs text-gray-500 mb-2 font-bold uppercase">Foto Saat Ini:</p>
                                                @if($karyawan->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($karyawan->foto))
                                                    <div class="w-32 h-40 rounded-lg overflow-hidden border border-gray-300 shadow-sm">
                                                        <img src="{{ asset('storage/' . $karyawan->foto) }}" alt="Foto Karyawan" class="w-full h-full object-cover">
                                                    </div>
                                                @else
                                                    <div class="w-32 h-40 rounded-lg bg-gray-100 border border-gray-300 flex items-center justify-center text-gray-400">
                                                        <span class="text-xs">Belum ada foto</span>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Input Upload --}}
                                            <div class="flex-grow w-full">
                                                <input type="file" name="foto" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Format: JPG, JPEG, PNG. Maksimal ukuran file: 2MB.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 3. STATUS KEPEGAWAIAN --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">3. Status Kepegawaian</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    
                                    {{-- Tanggal Masuk --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Masuk <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk) }}" required 
                                                class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status Karyawan</label>
                                        <div class="relative">
                                            <select name="status" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                                <option value="1" {{ old('status', $karyawan->status) == true ? 'selected' : '' }}>Aktif</option>
                                                <option value="0" {{ old('status', $karyawan->status) == false ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
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
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Update Karyawan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>