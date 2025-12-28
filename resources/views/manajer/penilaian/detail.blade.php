<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Rapor Anggota Tim') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tombol Kembali (Khusus Manajer) --}}
            <div class="mb-4 no-print">
                <a href="{{ route('penilaian.laporan') }}" class="text-gray-600 hover:text-gray-900 font-bold flex items-center gap-1">
                    &larr; Kembali ke Daftar Tim
                </a>
            </div>

            {{-- HEADER INFO --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-6 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $karyawan->nama_lengkap }}</h1>
                    <p class="text-gray-500 dark:text-gray-400">
                        NIK: {{ $karyawan->nik }} | Divisi: {{ $karyawan->divisi->nama_divisi }} 
                        <br>
                        Periode: <span class="font-semibold">{{ $periode->nama_periode }}</span>
                    </p>
                </div>
                <div class="text-right bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-100 dark:border-blue-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wider font-bold">Total Skor Akhir</p>
                    <p class="text-4xl font-black text-blue-600 dark:text-blue-400">{{ number_format($dataRapor['total_skor_akhir'], 2) }}</p>
                </div>
            </div>

            {{-- TABEL RINCIAN SKOR --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border dark:border-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Indikator Kinerja</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Target</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Realisasi</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Capaian (%)</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bobot</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Skor</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($dataRapor['detail'] as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-4 py-4">
                                        <div class="font-bold text-sm text-gray-900 dark:text-gray-100">{{ $item['indikator'] }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $item['kategori'] }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-center text-sm text-gray-700 dark:text-gray-300">
                                        {{ number_format($item['target'], 0, ',', '.') }} {{ $item['satuan'] }}
                                    </td>
                                    <td class="px-4 py-4 text-center text-sm font-bold text-blue-600 dark:text-blue-400">
                                        {{ number_format($item['realisasi'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 text-center text-sm">
                                        <span class="px-2 py-1 rounded text-xs font-bold
                                            {{ $item['pencapaian'] >= 100 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                              ($item['pencapaian'] >= 50 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                                              'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                            {{ number_format($item['pencapaian'], 1) }}%
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center text-sm text-gray-600 dark:text-gray-400">{{ $item['bobot'] }}%</td>
                                    <td class="px-4 py-4 text-center font-bold text-sm bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100">
                                        {{ number_format($item['skor'], 2) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400 italic">
                                        Belum ada data penilaian untuk periode ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- TOMBOL CETAK / DOWNLOAD --}}
            <div class="mt-6 flex justify-end no-print">
                <button onclick="window.print()" class="bg-gray-800 hover:bg-gray-700 dark:bg-white dark:text-gray-800 dark:hover:bg-gray-200 text-white font-bold py-2 px-6 rounded-lg shadow-lg flex items-center gap-2 transform hover:scale-105 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Unduh / Cetak Lapor
                </button>
            </div>

            {{-- STYLE KHUSUS CETAK --}}
            <style>
                @media print {
                    .no-print, header, aside, nav { display: none !important; }
                    body { background-color: white; color: black; -webkit-print-color-adjust: exact; }
                    .bg-white, .dark\:bg-gray-800 { background-color: white !important; color: black !important; }
                    .shadow, .shadow-sm, .shadow-lg { box-shadow: none !important; }
                    .max-w-7xl { max-width: 100% !important; margin: 0; padding: 0; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #000 !important; padding: 8px; color: black !important; }
                    .text-blue-600, .dark\:text-blue-400 { color: black !important; }
                    /* Paksa background warna grade tercetak */
                    .bg-green-100 { background-color: #dcfce7 !important; }
                    .bg-yellow-100 { background-color: #fef9c3 !important; }
                    .bg-red-100 { background-color: #fee2e2 !important; }
                }
            </style>

        </div>
    </div>
</x-app-layout>