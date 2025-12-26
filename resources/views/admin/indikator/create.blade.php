<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Indikator Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form action="{{ route('indikator.store') }}" method="POST">
                        @csrf
                        
                        {{-- Pilih Kategori --}}
                        <div class="mb-4">
                            <label for="id_kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Kategori</label>
                            <select name="id_kategori" id="id_kategori" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">-- Pilih Kategori KPI --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nama Indikator --}}
                        <div class="mb-4">
                            <label for="nama_indikator" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Indikator</label>
                            <input type="text" name="nama_indikator" id="nama_indikator" required placeholder="Contoh: Kedisiplinan / Target Penjualan"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        {{-- Satuan Pengukuran --}}
                        <div class="mb-4">
                            <label for="satuan_pengukuran" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Satuan Pengukuran (Opsional)</label>
                            <input type="text" name="satuan_pengukuran" id="satuan_pengukuran" placeholder="Contoh: Persen (%), Poin, Rupiah"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="flex justify-end">
                            <a href="{{ route('indikator.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>