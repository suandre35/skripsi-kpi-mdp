<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Data Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('karyawan.store') }}" method="POST">
                        @csrf
                        
                        {{-- Pilih User (Hanya yang belum jadi karyawan) --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Pilih Akun User (Wajib)</label>
                            <select name="id_user" required class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900">
                                <option value="">-- Pilih Akun --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @if($users->isEmpty())
                                <p class="text-xs text-red-500 mt-1">*Semua user aktif sudah terdaftar sebagai karyawan. Buat user baru dulu!</p>
                            @endif
                        </div>

                        {{-- NIK --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Nomor Induk Karyawan (NIK)</label>
                            <input type="text" name="nik" value="{{ old('nik') }}" required class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900">
                        </div>

                        {{-- Nama Lengkap --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900">
                        </div>

                        {{-- Divisi --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Divisi (Posisi)</label>
                            <select name="id_divisi" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900">
                                <option value="">-- Tidak Ada / Belum Masuk Divisi --</option>
                                @foreach($divisis as $divisi)
                                    <option value="{{ $divisi->id_divisi }}" {{ old('id_divisi') == $divisi->id_divisi ? 'selected' : '' }}>
                                        {{ $divisi->nama_divisi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal Masuk --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900">
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Status Karyawan</label>
                            <select name="status_karyawan" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900">
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>