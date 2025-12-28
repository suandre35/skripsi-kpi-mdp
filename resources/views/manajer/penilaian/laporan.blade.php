<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rapor Kinerja Tim') }} - Divisi {{ $manajer->divisi->nama_divisi }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- FILTER PERIODE --}}
                    <form method="GET" action="{{ route('penilaian.laporan') }}" class="mb-6 flex gap-4 items-end">
                        <div class="w-full md:w-1/3">
                            <label class="block text-sm font-bold mb-1 text-gray-700 dark:text-gray-300">Pilih Periode</label>
                            <select name="id_periode" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                                @foreach($periodes as $p)
                                    <option value="{{ $p->id_periode }}" {{ $selectedPeriode == $p->id_periode ? 'selected' : '' }}>
                                        {{ $p->nama_periode }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 transition">
                            Lihat Data
                        </button>
                    </form>

                    {{-- TABEL ANGGOTA TIM --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border dark:border-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Nama Anggota</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">NIK</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Progress Skor</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($karyawans as $k)
                                    @php
                                        $skor = $k->skor_saat_ini;
                                        $width = min($skor, 100);
                                        $colorClass = 'bg-red-500';
                                        if($skor >= 60) $colorClass = 'bg-yellow-400';
                                        if($skor >= 80) $colorClass = 'bg-green-500';
                                        if($skor >= 100) $colorClass = 'bg-blue-600';
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-6 py-4 font-bold">{{ $k->nama_lengkap }}</td>
                                        <td class="px-6 py-4 text-sm">{{ $k->nik }}</td>
                                        <td class="px-6 py-4 w-1/3">
                                            <div class="flex justify-between mb-1">
                                                <span class="text-xs font-bold {{ $skor >= 80 ? 'text-green-600' : 'text-gray-600' }}">
                                                    {{ number_format($skor, 2) }}
                                                </span>
                                                <span class="text-xs text-gray-400">Target: 100</span>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                <div class="{{ $colorClass }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $width }}%"></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('penilaian.detailLaporan', $k->id_karyawan) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 font-bold text-sm border border-indigo-200 px-3 py-1 rounded hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition">
                                                📄 Lihat Rapor
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-6 text-center text-gray-500 italic">
                                            Belum ada anggota tim di divisi ini.
                                        </td>
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