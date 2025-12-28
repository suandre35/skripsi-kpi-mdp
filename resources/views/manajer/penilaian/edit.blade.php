<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Penilaian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('penilaian.update', $log->getKey()) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- INFO PEKERJAAN (READ ONLY) --}}
                        <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-200">
                            <h3 class="font-bold text-lg mb-2 text-gray-700 dark:text-gray-300">Detail Pekerjaan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="block text-gray-500">Karyawan:</span>
                                    <span class="font-bold">{{ $log->header->karyawan->nama_lengkap }}</span>
                                </div>
                                <div>
                                    <span class="block text-gray-500">Tanggal:</span>
                                    <span class="font-bold">{{ \Carbon\Carbon::parse($log->tanggal)->format('d F Y') }}</span>
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <span class="block text-gray-500">Aktivitas / Indikator:</span>
                                    <span class="font-bold text-blue-600">{{ $log->indikator->nama_indikator }}</span>
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded ml-2">
                                        Target: {{ number_format($log->indikator->target->nilai_target ?? 0, 0, ',', '.') }} 
                                        {{ $log->indikator->target->jenis_target ?? '' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- FORM EDIT --}}
                        <div class="space-y-4">
                            
                            {{-- Edit Nilai --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
                                    Realisasi / Hasil ({{ $log->indikator->target->jenis_target ?? 'Satuan' }})
                                </label>
                                <input type="number" step="any" name="nilai_input" 
                                       value="{{ old('nilai_input', $log->nilai_input) }}" required
                                       class="w-full md:w-1/2 rounded-md border-gray-300 dark:bg-gray-900 focus:ring-blue-500 font-bold text-lg">
                            </div>

                            {{-- Edit Catatan --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
                                    Catatan
                                </label>
                                <textarea name="catatan" rows="3"
                                          class="w-full rounded-md border-gray-300 dark:bg-gray-900 focus:ring-blue-500">{{ old('catatan', $log->catatan) }}</textarea>
                            </div>

                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="flex justify-end mt-8 border-t pt-4">
                            <a href="{{ route('penilaian.index') }}" class="mr-3 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>