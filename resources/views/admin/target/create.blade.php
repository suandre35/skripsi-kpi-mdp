<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Target KPI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('target.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Indikator</label>
                            <select name="id_indikator" required class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Indikator --</option>
                                @foreach($indikators as $indikator)
                                    <option value="{{ $indikator->id_indikator }}">{{ $indikator->nama_indikator }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Input Angka (Type Number) --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nilai Target (Angka)</label>
                            <input type="number" step="any" name="nilai_target" required placeholder="Contoh: 5000000"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Masukkan hanya angka tanpa titik/koma (Contoh: 1000000)</p>
                        </div>

                        {{-- Input Satuan --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Satuan / Jenis Target</label>
                            <input type="text" name="jenis_target" placeholder="Contoh: Rupiah, Unit, Dokumen, Kali"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('target.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan Target</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>