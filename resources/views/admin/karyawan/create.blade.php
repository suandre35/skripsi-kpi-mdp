<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Tambah Karyawan Baru') }}
            </h2>
            {{-- Breadcrumb (Sama seperti sebelumnya) --}}
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Formulir Data Karyawan</h3>
                </div>

                <div class="p-6 md:p-8">
                    {{-- Error Display (Sama seperti sebelumnya) --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 text-red-800 rounded-lg">
                            <strong>Periksa Inputan Anda!</strong>
                            <ul class="list-disc ml-5 text-sm">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form with enctype for file upload --}}
                    <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="space-y-8">
                            
                            {{-- 1. AKUN & POSISI --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b pb-2">1. Akun & Posisi</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Pilih User --}}
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-bold mb-2">Pilih Akun User <span class="text-red-500">*</span></label>
                                        <select name="id_user" required class="w-full rounded-lg border-gray-300">
                                            <option value="">-- Pilih Akun --</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id_user }}">{{ $user->name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    {{-- NIK --}}
                                    <div>
                                        <label class="block text-sm font-bold mb-2">NIK <span class="text-red-500">*</span></label>
                                        <input type="text" name="nik" value="{{ old('nik') }}" required class="w-full rounded-lg border-gray-300">
                                    </div>

                                    {{-- Divisi --}}
                                    <div>
                                        <label class="block text-sm font-bold mb-2">Divisi</label>
                                        <select name="id_divisi" class="w-full rounded-lg border-gray-300">
                                            <option value="">-- Pilih Divisi --</option>
                                            @foreach($divisis as $divisi)
                                                <option value="{{ $divisi->id_divisi }}">{{ $divisi->nama_divisi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- 2. DATA PRIBADI (BARU) --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b pb-2">2. Data Pribadi</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    
                                    {{-- Nama Lengkap --}}
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-bold mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full rounded-lg border-gray-300">
                                    </div>

                                    {{-- Jenis Kelamin --}}
                                    <div>
                                        <label class="block text-sm font-bold mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                                        <select name="jenis_kelamin" required class="w-full rounded-lg border-gray-300">
                                            <option value="">-- Pilih --</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>

                                    {{-- Tanggal Lahir --}}
                                    <div>
                                        <label class="block text-sm font-bold mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full rounded-lg border-gray-300">
                                    </div>

                                    {{-- Alamat --}}
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-bold mb-2">Alamat Lengkap</label>
                                        <textarea name="alamat" rows="3" class="w-full rounded-lg border-gray-300">{{ old('alamat') }}</textarea>
                                    </div>

                                    {{-- Foto Profil --}}
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-bold mb-2">Foto Diri (3x4)</label>
                                        <input type="file" name="foto" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 bg-gray-50 text-sm">
                                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maks: 2MB.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- 3. STATUS KEPEGAWAIAN --}}
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-4 border-b pb-2">3. Status Kepegawaian</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-bold mb-2">Tanggal Masuk <span class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required class="w-full rounded-lg border-gray-300">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-2">Status</label>
                                        <select name="status_karyawan" class="w-full rounded-lg border-gray-300">
                                            <option value="Aktif">Aktif</option>
                                            <option value="Nonaktif">Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- BUTTONS --}}
                        <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                            <a href="{{ route('karyawan.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>