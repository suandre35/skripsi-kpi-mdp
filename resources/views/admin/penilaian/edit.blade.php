<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Penilaian Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Form Update --}}
                    <form action="{{ route('penilaian.update', $penilaian->id_penilaianHeader) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Info Karyawan (Read Only) --}}
                        <div class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 rounded shadow-sm">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-lg">{{ $penilaian->karyawan->nama_lengkap }} ({{ $penilaian->karyawan->nik }})</p>
                                    <p class="text-sm">Periode: {{ $penilaian->periode->nama_periode }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs uppercase font-bold text-gray-500">Total Skor Saat Ini</p>
                                    <p class="text-2xl font-bold">{{ $penilaian->total_nilai }}</p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-600">

                        {{-- Loop Kategori & Indikator --}}
                        @foreach($kategoris as $kategori)
                            <div class="mb-8 border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                                <div class="bg-gray-100 dark:bg-gray-700 px-4 py-2 border-b border-gray-200 dark:border-gray-600">
                                    <h4 class="font-bold text-gray-800 dark:text-gray-200">{{ $kategori->nama_kategori }}</h4>
                                </div>

                                <table class="w-full text-left bg-white dark:bg-gray-800">
                                    <thead class="bg-gray-50 dark:bg-gray-900 text-xs uppercase text-gray-500">
                                        <tr>
                                            <th class="px-4 py-2 w-1/2">Indikator</th>
                                            <th class="px-4 py-2 w-1/6 text-center">Bobot</th>
                                            <th class="px-4 py-2 w-1/3">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                        @foreach($kategori->indikators as $indikator)
                                            @php
                                                $bobotModel = $indikator->bobot->where('status', 'Aktif')->first();
                                                $nilaiBobot = $bobotModel ? $bobotModel->nilai_bobot : 0;
                                                
                                                // Ambil nilai lama dari array controller ($nilaiLama)
                                                // Gunakan operator null coalescing (??) agar tidak error jika data baru ditambah
                                                $val = $nilaiLama[$indikator->id_indikator] ?? 0;
                                            @endphp
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <p class="font-medium">{{ $indikator->nama_indikator }}</p>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="text-xs font-bold text-gray-500 bg-gray-200 px-2 py-1 rounded">
                                                        {{ $nilaiBobot }}%
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="number" 
                                                           name="nilai[{{ $indikator->id_indikator }}]" 
                                                           value="{{ $val }}"
                                                           min="0" max="100" required
                                                           class="w-full rounded-md border-gray-300 dark:bg-gray-900 focus:ring-blue-500 focus:border-blue-500">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach

                        <div class="flex justify-end mt-8">
                            <a href="{{ route('penilaian.index') }}" class="mr-3 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow">
                                Update Hasil Penilaian
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>