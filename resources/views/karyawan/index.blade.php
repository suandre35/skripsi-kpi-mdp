<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rapor Kinerja Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- SECTION 1: HERO CARD (STATISTIK UTAMA) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 no-print">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <h3 class="text-gray-500 text-sm font-bold uppercase">Karyawan</h3>
                    <div class="text-xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $karyawan->nama_lengkap }}</div>
                    <div class="text-sm text-gray-500">{{ $karyawan->divisi->nama_divisi }}</div>
                    <div class="text-sm text-gray-500">{{ $karyawan->nik }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <h3 class="text-gray-500 text-sm font-bold uppercase">Periode Aktif</h3>
                    @if($periode)
                        <div class="text-xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $periode->nama_periode }}</div>
                        <div class="text-xs text-green-600 font-bold bg-green-100 inline-block px-2 py-1 rounded mt-2">Sedang Berjalan</div>
                    @else
                        <div class="text-gray-400 italic mt-2">Tidak ada periode aktif</div>
                    @endif
                </div>

                @php
                    $skor = $dataRapor['total_skor_akhir'];
                    $grade = $skor >= 90 ? 'A' : ($skor >= 80 ? 'B' : ($skor >= 70 ? 'C' : ($skor >= 60 ? 'D' : 'E')));
                    $color = $skor >= 80 ? 'text-green-600' : ($skor >= 60 ? 'text-yellow-600' : 'text-red-600');
                @endphp
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500 flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm font-bold uppercase">Total Skor</h3>
                        <div class="text-4xl font-black {{ $color }} mt-1">{{ number_format($skor, 2) }}</div>
                    </div>
                    <div class="text-center">
                        <span class="block text-xs text-gray-400">Grade</span>
                        <span class="text-3xl font-bold text-gray-700 dark:text-gray-200">{{ $grade }}</span>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: TABEL DETAIL --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-end mb-4">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Rincian Penilaian</h3>
                        
                        {{-- Tombol Cetak --}}
                        <button onclick="window.print()" class="no-print bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold py-2 px-4 rounded flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak PDF
                        </button>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Indikator</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Target</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Realisasi</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Capaian</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Skor</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($dataRapor['detail'] as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-sm text-gray-900 dark:text-gray-100">{{ $item['indikator'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $item['kategori'] }}</div>
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-gray-700 dark:text-gray-300">
                                    {{ number_format($item['target'], 0, ',', '.') }} {{ $item['satuan'] }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-blue-600">
                                    {{ number_format($item['realisasi'], 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm">
                                    <span class="px-2 py-1 rounded text-xs {{ $item['pencapaian'] >= 100 ? 'bg-green-100 text-green-800' : ($item['pencapaian'] >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ number_format($item['pencapaian'], 1) }}%
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-sm">
                                    {{ number_format($item['skor'], 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500 italic">Belum ada penilaian.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- STYLE CETAK --}}
            <style>
                @media print {
                    .no-print, header, aside, nav { display: none !important; }
                    body { background-color: white; color: black; }
                    .max-w-7xl { max-width: 100% !important; margin: 0; padding: 0; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #000 !important; padding: 8px; }
                    /* Tampilkan nama user saat diprint agar jelas punya siapa */
                    .print-header { display: block !important; margin-bottom: 20px; }
                }
            </style>
        </div>
    </div>
</x-app-layout>