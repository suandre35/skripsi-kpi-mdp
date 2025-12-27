<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Input Penilaian Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tampilkan Error Validasi Global (Jika ada) --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Ada kesalahan input!</strong>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form action="{{ route('penilaian.store') }}" method="POST">
                        @csrf
                        
                        {{-- Hidden Input ID Periode (Diambil dari Controller) --}}
                        <input type="hidden" name="id_periode" value="{{ $periodeAktif->id_periode }}">
                        
                        {{-- Bagian Atas: Info Periode & Pilih Karyawan --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Periode Evaluasi (Aktif)</label>
                                <input type="text" value="{{ $periodeAktif->nama_periode }}" readonly 
                                    class="w-full bg-gray-200 text-gray-600 border-gray-300 rounded-md shadow-sm cursor-not-allowed">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Pilih Karyawan</label>
                                <select name="id_karyawan" required class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Pilih Karyawan --</option>
                                    @foreach($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id_karyawan }}" {{ old('id_karyawan') == $karyawan->id_karyawan ? 'selected' : '' }}>
                                            {{ $karyawan->nama_lengkap }} - {{ $karyawan->nik }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($karyawans->isEmpty())
                                    <p class="text-xs text-red-500 mt-2 font-semibold">
                                        *Semua karyawan aktif sudah dinilai untuk periode ini.
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-600 my-6"></div>

                        {{-- Bagian Tabel Input Skor --}}
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Formulir Penilaian</h3>
                        
                        @foreach($kategoris as $kategori)
                            <div class="mb-8 border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                                {{-- Header Kategori --}}
                                <div class="bg-blue-50 dark:bg-gray-700 px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                                    <h4 class="font-bold text-blue-800 dark:text-blue-200 text-md flex items-center">
                                        📁 {{ $kategori->nama_kategori }}
                                        <span class="ml-2 text-xs font-normal text-gray-500 dark:text-gray-400">
                                            ({{ $kategori->deskripsi }})
                                        </span>
                                    </h4>
                                </div>

                                <table class="w-full text-left bg-white dark:bg-gray-800">
                                    <thead class="bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400 text-xs uppercase">
                                        <tr>
                                            <th class="px-4 py-3 w-1/2">Indikator Kinerja</th>
                                            <th class="px-4 py-3 w-1/6 text-center">Bobot</th>
                                            <th class="px-4 py-3 w-1/3">Nilai (0 - 100)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                        @foreach($kategori->indikators as $indikator)
                                            @php
                                                // Ambil bobot aktif (sesuai struktur DB Anda)
                                                // Asumsi relasi di model IndikatorKpi adalah hasMany('bobot')
                                                $bobotModel = $indikator->bobot->where('status', 'Aktif')->first();
                                                $nilaiBobot = $bobotModel ? $bobotModel->nilai_bobot : 0;
                                            @endphp
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="px-4 py-3">
                                                    <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $indikator->nama_indikator }}</p>
                                                    @if($indikator->deskripsi)
                                                        <p class="text-xs text-gray-500 mt-1">{{ $indikator->deskripsi }}</p>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-blue-100 bg-blue-600 rounded">
                                                        {{ $nilaiBobot }}%
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{-- Input Name Array: nilai[id_indikator] --}}
                                                    <input type="number" 
                                                           name="nilai[{{ $indikator->id_indikator }}]" 
                                                           value="{{ old('nilai.'.$indikator->id_indikator) }}"
                                                           min="0" max="100" required
                                                           placeholder="0-100"
                                                           class="w-full rounded-md border-gray-300 dark:bg-gray-900 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach

                        {{-- Tombol Simpan --}}
                        <div class="flex justify-end mt-8">
                            <a href="{{ route('penilaian.index') }}" class="mr-3 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow">
                                Batal
                            </a>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition hover:scale-105">
                                Simpan Penilaian ✅
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>