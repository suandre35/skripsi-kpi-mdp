<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Indikator KPI') }}
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
                    <form action="{{ route('indikator.update', $indikator->id_indikator) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Kategori --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Kategori KPI</label>
                            <select name="id_kategori" required class="w-full rounded-md border-gray-300 dark:bg-gray-900">
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ $indikator->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nama Indikator --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Nama Indikator</label>
                            <input type="text" name="nama_indikator" value="{{ $indikator->nama_indikator }}" required class="w-full rounded-md border-gray-300 dark:bg-gray-900">
                        </div>

                        {{-- Target Divisi (CHECKBOX & CHECKED LOGIC) --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2 text-blue-600 font-bold">Target Divisi</label>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 border rounded-md grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($divisis as $divisi)
                                    <label class="inline-flex items-center cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 p-1 rounded">
                                        <input type="checkbox" name="target_divisi[]" value="{{ $divisi->id_divisi }}" 
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                            {{-- Cek: Apakah ID Divisi ini ada di dalam array target_divisi indikator? --}}
                                            {{ in_array($divisi->id_divisi, $indikator->target_divisi ?? []) ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700 dark:text-gray-200">{{ $divisi->nama_divisi }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Deskripsi</label>
                            <textarea name="deskripsi" class="w-full rounded-md border-gray-300 dark:bg-gray-900">{{ $indikator->deskripsi }}</textarea>
                        </div>

                        {{-- Satuan --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Satuan Pengukuran</label>
                            <input type="text" name="satuan_pengukuran" value="{{ $indikator->satuan_pengukuran }}" class="w-full rounded-md border-gray-300 dark:bg-gray-900">
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Status</label>
                            <select name="status" class="w-full rounded-md border-gray-300 dark:bg-gray-900">
                                <option value="Aktif" {{ $indikator->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ $indikator->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex justify-end">
                            <a href="{{ route('indikator.index') }}" class="mr-3 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Indikator</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>