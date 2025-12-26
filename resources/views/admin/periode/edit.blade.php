<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Periode Evaluasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Tampilkan Error Validasi --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <strong class="font-bold">Periksa input Anda!</strong>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('periode.update', $periode->id_periode) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Nama Periode --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Periode</label>
                            <input type="text" name="nama_periode" value="{{ old('nama_periode', $periode->nama_periode) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm sm:text-sm">
                        </div>

                        {{-- Grid 3 Kolom untuk Tanggal --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu Mulai</label>
                                <input type="datetime-local" name="tanggal_mulai" 
                                    value="{{ old('tanggal_mulai', $periode->tanggal_mulai ? $periode->tanggal_mulai->format('Y-m-d\TH:i') : '') }}" 
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu Selesai</label>
                                <input type="datetime-local" name="tanggal_selesai" 
                                    value="{{ old('tanggal_selesai', $periode->tanggal_selesai ? $periode->tanggal_selesai->format('Y-m-d\TH:i') : '') }}" 
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu Pengumuman</label>
                                <input type="datetime-local" name="tanggal_pengumuman" 
                                    value="{{ old('tanggal_pengumuman', $periode->tanggal_pengumuman ? $periode->tanggal_pengumuman->format('Y-m-d\TH:i') : '') }}" 
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm sm:text-sm">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm sm:text-sm">
                                <option value="Nonaktif" {{ old('status', $periode->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="Aktif" {{ old('status', $periode->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">*Jika Anda memilih <strong>Aktif</strong>, periode aktif yang lain akan otomatis dinonaktifkan.</p>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex justify-end">
                            <a href="{{ route('periode.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>