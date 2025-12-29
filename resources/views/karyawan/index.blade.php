<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between no-print">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Rapor Kinerja Saya') }}
            </h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Rapor Individu</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tombol Cetak (No Print) --}}
            <div class="mb-6 flex justify-end items-center no-print">
                <button onclick="window.print()" class="flex items-center gap-2 bg-gray-800 hover:bg-gray-700 dark:bg-white dark:text-gray-800 dark:hover:bg-gray-200 text-white font-bold py-2.5 px-5 rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Unduh / Cetak Laporan
                </button>
            </div>

            {{-- KARTU RAPOR UTAMA --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 print-border">
                
                {{-- HEADER LAPORAN (Gradient Blue) --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-white print-header">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div>
                            <h4 class="text-blue-100 uppercase tracking-widest text-xs font-bold mb-1">Laporan Kinerja Karyawan</h4>
                            <h1 class="text-3xl font-extrabold tracking-tight">{{ $karyawan->nama_lengkap }}</h1>
                            <p class="text-blue-100 mt-1 opacity-90 text-sm md:text-base">
                                NIK: {{ $karyawan->nik }} <span class="mx-2">•</span> {{ $karyawan->divisi->nama_divisi }}
                            </p>
                        </div>
                        
                        {{-- Score Box --}}
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20 text-center min-w-[140px] shadow-lg">
                            <p class="text-xs uppercase tracking-wide font-bold opacity-80 mb-1">Total Skor</p>
                            <p class="text-4xl font-black">
                                {{ isset($dataRapor['total_skor_akhir']) ? number_format($dataRapor['total_skor_akhir'], 2) : '0.00' }}
                            </p>
                        </div>
                    </div>
                    
                    {{-- Periode Badge --}}
                    <div class="mt-6 inline-flex items-center gap-2 px-3 py-1 bg-white/20 rounded-full text-sm font-medium backdrop-blur-sm border border-white/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        @if($periode)
                            Periode Evaluasi: {{ $periode->nama_periode }}
                        @else
                            <span class="italic text-yellow-200">Tidak Ada Periode Aktif</span>
                        @endif
                    </div>
                </div>

                {{-- CONTENT DETAIL --}}
                <div class="p-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-700">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Rincian Pencapaian KPI
                    </h3>

                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 rounded-xl">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Indikator</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Target</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Realisasi</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Capaian</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bobot</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider bg-gray-100 dark:bg-gray-700">Skor</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($dataRapor['detail'] ?? [] as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                    {{-- Indikator --}}
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $item['indikator'] }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full inline-block"></span>
                                            {{ $item['kategori'] }}
                                        </div>
                                    </td>
                                    
                                    {{-- Target --}}
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <span class="text-sm text-gray-700 dark:text-gray-300 font-medium bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
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
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">
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
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <p>Belum ada data penilaian yang masuk untuk periode ini.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 font-bold">
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-right text-gray-700 dark:text-gray-300 uppercase text-xs tracking-wider">Total Skor Akhir</td>
                                    <td class="px-6 py-4 text-center text-xl text-blue-700 dark:text-blue-300 font-extrabold">
                                        {{ isset($dataRapor['total_skor_akhir']) ? number_format($dataRapor['total_skor_akhir'], 2) : '0.00' }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- FOOTER TANDA TANGAN (Hanya Muncul Saat Print) --}}
                    <div class="hidden print-show mt-20 pt-10 border-t border-black">
                        <div class="flex justify-between text-center">
                            <div class="w-1/3">
                                <p class="mb-24 text-sm font-bold">Karyawan,</p>
                                <p class="font-bold underline">{{ $karyawan->nama_lengkap }}</p>
                                <p class="text-xs mt-1">NIK: {{ $karyawan->nik }}</p>
                            </div>
                            <div class="w-1/3">
                                <p class="mb-24 text-sm font-bold">Mengetahui (Manajer),</p>
                                <p class="font-bold underline">_______________________</p>
                                <p class="text-xs mt-1">Kepala Divisi</p>
                            </div>
                        </div>
                        <div class="mt-12 text-center text-[10px] text-gray-500 uppercase tracking-widest">
                            Dicetak otomatis dari Sistem KPI pada {{ date('d F Y H:i') }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- STYLE KHUSUS CETAK --}}
            <style>
                @media print {
                    @page { margin: 0; size: A4; }
                    body { margin: 1.5cm; background: white; color: black; -webkit-print-color-adjust: exact; font-family: sans-serif; }
                    
                    /* Hide elements */
                    .no-print, header, nav, aside { display: none !important; }
                    .print-show { display: block !important; }
                    
                    /* Reset Container & Shadows */
                    .max-w-5xl { max-width: 100% !important; margin: 0; padding: 0; }
                    .shadow-xl, .shadow-lg, .shadow { box-shadow: none !important; }
                    .bg-white, .dark\:bg-gray-800 { background: white !important; color: black !important; }
                    .border { border-color: #000 !important; }
                    .rounded-xl, .rounded-2xl { border-radius: 0 !important; }
                    
                    /* Header Styling for Print */
                    .print-header { 
                        background: #f0f0f0 !important; 
                        color: black !important; 
                        border-bottom: 2px solid #000;
                        padding: 20px !important;
                        margin-bottom: 20px;
                    }
                    .print-header h1, .print-header h4, .print-header p { color: black !important; opacity: 1 !important; }
                    .print-header .border-white\/20 { border: 2px solid #000 !important; }
                    
                    /* Table Styling */
                    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                    th, td { border: 1px solid #000 !important; padding: 8px !important; font-size: 11px; }
                    th { background-color: #e5e5e5 !important; font-weight: bold; text-transform: uppercase; }
                    
                    /* Force Badge Colors to Grayscale/Simple Border */
                    .bg-green-100, .bg-blue-100, .bg-yellow-100, .bg-red-100 { 
                        background-color: white !important; 
                        border: 1px solid #000 !important; 
                        color: black !important;
                    }
                }
            </style>

        </div>
    </div>
</x-app-layout>