<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Target KPI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('target.update', $target->id_target) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Pilih Indikator --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Indikator</label>
                            <select name="id_indikator" required class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Indikator --</option>
                                @foreach($indikators as $indikator)
                                    <option value="{{ $indikator->id_indikator }}" 
                                        {{ $indikator->id_indikator == old('id_indikator', $target->id_indikator) ? 'selected' : '' }}>
                                        {{ $indikator->nama_indikator }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nilai Target (Angka) --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nilai Target (Angka)</label>
                            <input type="number" step="any" name="nilai_target" 
                                value="{{ old('nilai_target', $target->nilai_target) }}" required
                                class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Masukkan hanya angka (Desimal gunakan titik)</p>
                        </div>

                        {{-- Jenis Target --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Satuan / Jenis Target</label>
                            <input type="text" name="jenis_target" 
                                value="{{ old('jenis_target', $target->jenis_target) }}" placeholder="Contoh: Rupiah, Unit"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select name="status" class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="Aktif" {{ $target->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ $target->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('target.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Target</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>