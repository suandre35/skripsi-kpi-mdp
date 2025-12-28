<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Input Log Aktivitas Harian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. TAMPILKAN PESAN ERROR DARI CONTROLLER (Try-Catch) --}}
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- 2. TAMPILKAN ERROR VALIDASI FORM --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <strong>Perhatian! Ada input yang kurang pas:</strong>
                    <ul class="mt-1 list-disc list-inside">
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
                        <input type="hidden" name="id_periode" value="{{ $periodeAktif->id_periode }}">
                        
                        {{-- IDENTITAS --}}
                        <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg border border-blue-100 mb-6">
                            <h3 class="font-bold text-blue-800 dark:text-blue-200 mb-4 border-b pb-2">Identitas Pekerjaan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Pilih Karyawan</label>
                                    <select name="id_karyawan" required class="w-full rounded-md border-gray-300 dark:bg-gray-900 focus:ring-blue-500">
                                        <option value="">-- Pilih Nama Karyawan --</option>
                                        @foreach($karyawans as $karyawan)
                                            <option value="{{ $karyawan->id_karyawan }}" 
                                                {{ old('id_karyawan') == $karyawan->id_karyawan ? 'selected' : '' }}>
                                                {{ $karyawan->nama_lengkap }} - {{ $karyawan->nik }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Tanggal Pengerjaan</label>
                                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required 
                                           class="w-full rounded-md border-gray-300 dark:bg-gray-900 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        {{-- DAFTAR INPUT --}}
                        <h3 class="text-lg font-bold mb-2">Daftar Aktivitas</h3>
                        
                        <div class="space-y-8">
                            @foreach($kategoris as $kategori)
                                <div class="border rounded-lg overflow-hidden shadow-sm">
                                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 border-b font-bold">
                                        📂 {{ $kategori->nama_kategori }}
                                    </div>
                                    <div class="p-4 grid gap-4 bg-white dark:bg-gray-800">
                                        @foreach($kategori->indikators as $indikator)
                                            @php
                                                $target = $indikator->target; 
                                                $nilaiTarget = $target ? number_format((float)$target->nilai_target, 0, ',', '.') : '0';
                                                $satuan = $target ? $target->jenis_target : 'Satuan';
                                                
                                                // AGAR INPUTAN TIDAK HILANG SAAT ERROR:
                                                $oldNilai = old("aktivitas.{$indikator->id_indikator}.nilai");
                                                $oldCatatan = old("aktivitas.{$indikator->id_indikator}.catatan");
                                            @endphp

                                            <div class="flex flex-col md:flex-row gap-4 p-4 border rounded-md hover:bg-gray-50 transition">
                                                <div class="md:w-5/12">
                                                    <div class="font-bold">{{ $indikator->nama_indikator }}</div>
                                                    <div class="text-xs font-bold text-green-700 bg-green-100 px-2 py-1 rounded w-fit mt-1">
                                                        Target: {{ $nilaiTarget }} {{ $satuan }}
                                                    </div>
                                                </div>
                                                <div class="md:w-7/12 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-xs font-bold text-gray-500 mb-1">Hasil ({{ $satuan }})</label>
                                                        {{-- Perhatikan value="{{ $oldNilai }}" --}}
                                                        <input type="number" step="any" 
                                                               name="aktivitas[{{ $indikator->id_indikator }}][nilai]" 
                                                               value="{{ $oldNilai }}"
                                                               placeholder="0"
                                                               class="w-full text-right font-bold rounded-md border-gray-300 dark:bg-gray-900">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-bold text-gray-500 mb-1">Catatan</label>
                                                        <input type="text" 
                                                               name="aktivitas[{{ $indikator->id_indikator }}][catatan]" 
                                                               value="{{ $oldCatatan }}"
                                                               placeholder="Keterangan..."
                                                               class="w-full rounded-md border-gray-300 dark:bg-gray-900">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md">
                                💾 Simpan Log Aktivitas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>