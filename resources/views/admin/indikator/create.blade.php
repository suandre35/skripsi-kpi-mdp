<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Indikator KPI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Error Validasi --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('indikator.store') }}" method="POST">
                        @csrf
                        
                        {{-- Kategori --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Kategori KPI</label>
                            <select name="id_kategori" required class="w-full rounded-md border-gray-300 dark:bg-gray-900">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nama Indikator --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Nama Indikator</label>
                            <input type="text" name="nama_indikator" required class="w-full rounded-md border-gray-300 dark:bg-gray-900" placeholder="Contoh: Kecepatan Respon">
                        </div>

                        {{-- Target Divisi (CHECKBOX) --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2 text-blue-600 font-bold">Target Divisi (Wajib Pilih Minimal Satu)</label>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 border rounded-md grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($divisis as $divisi)
                                    <label class="inline-flex items-center cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 p-1 rounded">
                                        <input type="checkbox" name="target_divisi[]" value="{{ $divisi->id_divisi }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                        <span class="ml-2 text-gray-700 dark:text-gray-200">{{ $divisi->nama_divisi }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-500 mt-1">*Indikator ini hanya akan muncul pada formulir penilaian divisi yang dicentang.</p>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" class="w-full rounded-md border-gray-300 dark:bg-gray-900"></textarea>
                        </div>

                        {{-- Satuan --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Satuan Pengukuran (Opsional)</label>
                            <input type="text" name="satuan_pengukuran" class="w-full rounded-md border-gray-300 dark:bg-gray-900" placeholder="Contoh: %, Hari, Pcs">
                        </div>

                        {{-- Tombol --}}
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan Indikator</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>