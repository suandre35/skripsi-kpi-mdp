<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between no-print">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Rapor Kinerja Individu') }}
            </h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">
                        <a href="{{ route('penilaian.laporan') }}">Rapor Tim</a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Detail</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tombol Kembali (No Print) --}}
            <div class="mb-6 flex justify-between items-center no-print">
                <a href="{{ route('penilaian.laporan') }}" class="flex items-center gap-2 text-gray-600 hover:text-blue-600 font-medium transition duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
                <button onclick="window.print()" class="flex items-center gap-2 bg-gray-800 hover:bg-gray-700 dark:bg-white dark:text-gray-800 dark:hover:bg-gray-200 text-white font-bold py-2 px-4 rounded-lg shadow transition transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Laporan
                </button>
            </div>

            {{-- KARTU RAPOR UTAMA --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 print-border">
                
                {{-- HEADER LAPORAN --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-white print-header">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div>
                            <h4 class="text-blue-100 uppercase tracking-widest text-xs font-bold mb-1">Laporan Kinerja Karyawan</h4>
                            <h1 class="text-3xl font-bold">{{ $karyawan->nama_lengkap }}</h1>
                            <p class="text-blue-100 mt-1 opacity-90">{{ $karyawan->nik }} | {{ $karyawan->divisi->nama_divisi }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20 text-center min-w-[150px]">
                            <p class="text-xs uppercase tracking-wide font-bold opacity-80">Total Skor</p>
                            <p class="text-4xl font-black mt-1">{{ number_format($dataRapor['total_skor_akhir'], 2) }}</p>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center gap-2 text-sm font-medium bg-white/10 w-fit px-3 py-1 rounded-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Periode: {{ $periode->nama_periode }}
                    </div>
                </div>

                {{-- CONTENT DETAIL --}}
                <div class="p-8">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Rincian Penilaian
                    </h3>

                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Indikator KPI</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Target</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Realisasi</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Capaian</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bobot</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider bg-gray-100 dark:bg-gray-700">Skor</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($dataRapor['detail'] as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    {{-- Indikator --}}
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $item['indikator'] }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $item['kategori'] }}</div>
                                    </td>
                                    
                                    {{-- Target --}}
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <span class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                                            {{ number_format($item['target'], 0, ',', '.') }} <span class="text-xs text-gray-500">{{ $item['satuan'] }}</span>
                                        </span>
                                    </td>

                                    {{-- Realisasi --}}
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <span class="text-sm font-bold text-blue-600 dark:text-blue-400">
                                            {{ number_format($item['realisasi'], 0, ',', '.') }}
                                        </span>
                                    </td>

                                    {{-- Capaian --}}
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        @php
                                            $capaian = $item['pencapaian'];
                                            $badgeClass = $capaian >= 100 ? 'bg-green-100 text-green-800 border-green-200' :
                                                         ($capaian >= 80 ? 'bg-blue-100 text-blue-800 border-blue-200' :
                                                         ($capaian >= 50 ? 'bg-yellow-100 text-yellow-800 border-yellow-200' : 'bg-red-100 text-red-800 border-red-200'));
                                        @endphp
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badgeClass }}">
                                            {{ number_format($capaian, 1) }}%
                                        </span>
                                    </td>

                                    {{-- Bobot --}}
                                    <td class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        {{ $item['bobot'] }}%
                                    </td>

                                    {{-- Skor --}}
                                    <td class="px-6 py-4 text-center font-bold text-sm bg-gray-50 dark:bg-gray-700/30 text-gray-900 dark:text-white">
                                        {{ number_format($item['skor'], 2) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 italic">
                                        Belum ada data penilaian yang masuk untuk periode ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-gray-100 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 font-bold">
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-right text-gray-700 dark:text-gray-300 uppercase text-xs tracking-wider">Total Skor Akhir</td>
                                    <td class="px-6 py-4 text-center text-lg text-blue-700 dark:text-blue-300">
                                        {{ number_format($dataRapor['total_skor_akhir'], 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- FOOTER TANDA TANGAN (Hanya Muncul Saat Print) --}}
                    <div class="hidden print-show mt-16 pt-8">
                        <div class="flex justify-between text-center">
                            <div class="w-1/3">
                                <p class="mb-20">Karyawan,</p>
                                <p class="font-bold underline">{{ $karyawan->nama_lengkap }}</p>
                            </div>
                            <div class="w-1/3">
                                <p class="mb-20">Mengetahui (Manajer),</p>
                                <p class="font-bold underline">......................................</p>
                            </div>
                        </div>
                        <div class="mt-8 text-center text-xs text-gray-400">
                            Dicetak dari KPI System pada {{ date('d F Y H:i') }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- STYLE KHUSUS CETAK --}}
            <style>
                @media print {
                    @page { margin: 0; size: A4; }
                    body { margin: 1.6cm; background: white; color: black; -webkit-print-color-adjust: exact; }
                    .no-print, header, nav, aside { display: none !important; }
                    .print-show { display: block !important; }
                    
                    /* Reset Shadow & Background */
                    .bg-white, .dark\:bg-gray-800 { background: white !important; color: black !important; }
                    .shadow-xl, .shadow { box-shadow: none !important; }
                    .border { border-color: #ddd !important; }
                    
                    /* Header Gradient fix for print */
                    .print-header { 
                        background: #f3f4f6 !important; 
                        color: black !important; 
                        border-bottom: 2px solid #000;
                        padding: 20px !important;
                    }
                    .print-header h1, .print-header h4, .print-header p { color: black !important; opacity: 1 !important; }
                    
                    /* Table Styling */
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #000 !important; padding: 8px !important; font-size: 12px; }
                    th { background-color: #f3f4f6 !important; font-weight: bold; }
                    
                    /* Badge Colors Force Print */
                    .bg-green-100 { background-color: #dcfce7 !important; border: 1px solid #000; }
                    .bg-blue-100 { background-color: #dbeafe !important; border: 1px solid #000; }
                    .bg-yellow-100 { background-color: #fef9c3 !important; border: 1px solid #000; }
                    .bg-red-100 { background-color: #fee2e2 !important; border: 1px solid #000; }
                }
            </style>

        </div>
    </div>
</x-app-layout>