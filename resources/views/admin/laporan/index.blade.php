<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Monitoring Realisasi KPI (Global)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- FILTER BAR --}}
                    <form method="GET" action="{{ route('admin.monitoring.index') }}" class="mb-8 bg-gray-50 p-4 rounded-lg border flex flex-col md:flex-row gap-4 items-end">
                        <div class="w-full md:w-1/3">
                            <label class="block text-sm font-bold mb-1">Pilih Periode</label>
                            <select name="id_periode" class="w-full rounded border-gray-300">
                                @foreach($periodes as $p)
                                    <option value="{{ $p->id_periode }}" {{ $selectedPeriode == $p->id_periode ? 'selected' : '' }}>
                                        {{ $p->nama_periode }} ({{ $p->status }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-1/3">
                            <label class="block text-sm font-bold mb-1">Filter Divisi</label>
                            <select name="id_divisi" class="w-full rounded border-gray-300">
                                <option value="">-- Semua Divisi --</option>
                                @foreach($divisis as $d)
                                    <option value="{{ $d->id_divisi }}" {{ $selectedDivisi == $d->id_divisi ? 'selected' : '' }}>
                                        {{ $d->nama_divisi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-1/3">
                            <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded w-full hover:bg-blue-700">
                                Filter Data
                            </button>
                        </div>
                    </form>

                    {{-- TABEL MONITORING --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Karyawan</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Divisi</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Progress Skor</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($karyawans as $k)
                                    @php
                                        // Logic Warna Progress Bar
                                        $skor = $k->skor_saat_ini;
                                        $width = min($skor, 100); // Max width 100%
                                        $colorClass = 'bg-red-500';
                                        if($skor >= 50) $colorClass = 'bg-yellow-400';
                                        if($skor >= 80) $colorClass = 'bg-green-500';
                                        if($skor >= 100) $colorClass = 'bg-blue-600';
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-800">{{ $k->nama_lengkap }}</div>
                                            <div class="text-xs text-gray-500">{{ $k->nik }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $k->divisi->nama_divisi }}
                                        </td>
                                        <td class="px-6 py-4 w-1/3">
                                            <div class="flex justify-between mb-1">
                                                <span class="text-xs font-medium {{ $skor >= 100 ? 'text-blue-700' : 'text-gray-700' }}">
                                                    Skor: {{ number_format($skor, 2) }}
                                                </span>
                                                <span class="text-xs font-medium text-gray-500">Target: 100</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                                <div class="{{ $colorClass }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $width }}%"></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('admin.monitoring.show', ['karyawan' => $k->id_karyawan, 'periode' => $selectedPeriode]) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 text-sm font-bold border border-indigo-200 px-3 py-1 rounded hover:bg-indigo-50">
                                                👁 Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data karyawan sesuai filter.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>