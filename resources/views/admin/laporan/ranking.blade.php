<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between no-print">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Perbandingan Kinerja (Ranking)') }}
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
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Ranking</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12 print:p-0 print:m-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 print:max-w-none print:px-0">

            {{-- HEADER KHUSUS CETAK --}}
            <div class="hidden print-show text-center border-b-2 border-black pb-4 mb-6">
                <h1 class="text-2xl font-bold uppercase tracking-wide">Laporan Peringkat Kinerja Pegawai</h1>
                <div class="flex justify-center gap-4 text-sm mt-2">
                    <p>Periode: <strong>{{ $selectedPeriode ? $periodes->where('id_periode', $selectedPeriode)->first()->nama_periode : 'Semua Periode' }}</strong></p>
                    <p>|</p>
                    <p>Divisi: <strong>{{ $selectedDivisi ? $divisis->where('id_divisi', $selectedDivisi)->first()->nama_divisi : 'Semua Divisi' }}</strong></p>
                </div>
                <p class="text-xs text-gray-500 mt-1">Dicetak pada: {{ date('d F Y H:i') }}</p>
            </div>

            {{-- VISUAL PODIUM (Hanya Tampil di Halaman 1 & Tidak diprint) --}}
            @if($ranking->currentPage() == 1 && $ranking->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end mb-8 no-print">
                {{-- JUARA 2 --}}
                @if(isset($ranking[1]))
                <div class="order-2 md:order-1 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex flex-col items-center transform hover:-translate-y-1 transition duration-300">
                    <div class="relative mb-3">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center border-4 border-white shadow-lg overflow-hidden">
                            @if(isset($ranking[1]['foto']) && Storage::disk('public')->exists($ranking[1]['foto']))
                                <img src="{{ asset('storage/' . $ranking[1]['foto']) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-2xl font-bold text-gray-400">2</span>
                            @endif
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-gray-200 text-gray-600 w-8 h-8 rounded-full flex items-center justify-center font-bold border-2 border-white">2</div>
                    </div>
                    <h3 class="font-bold text-gray-800 dark:text-white text-center text-lg">{{ $ranking[1]['nama'] }}</h3>
                    <div class="mt-3 text-3xl font-black text-gray-700 dark:text-gray-300">{{ number_format($ranking[1]['skor'], 1) }}</div>
                </div>
                @endif

                {{-- JUARA 1 --}}
                @if(isset($ranking[0]))
                <div class="order-1 md:order-2 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-t-4 border-yellow-400 p-8 flex flex-col items-center transform scale-105 z-10">
                    <div class="relative mb-4">
                        <div class="w-24 h-24 rounded-full bg-yellow-50 flex items-center justify-center border-4 border-yellow-100 shadow-xl overflow-hidden">
                            @if(isset($ranking[0]['foto']) && Storage::disk('public')->exists($ranking[0]['foto']))
                                <img src="{{ asset('storage/' . $ranking[0]['foto']) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl font-bold text-yellow-600">1</span>
                            @endif
                        </div>
                        <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 bg-yellow-500 text-white text-[10px] font-bold px-3 py-0.5 rounded-full uppercase tracking-widest shadow-sm">Winner</div>
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white text-center">{{ $ranking[0]['nama'] }}</h3>
                    <div class="mt-3 text-5xl font-black text-gray-800 dark:text-gray-100">{{ number_format($ranking[0]['skor'], 1) }}</div>
                </div>
                @endif

                {{-- JUARA 3 --}}
                @if(isset($ranking[2]))
                <div class="order-3 md:order-3 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex flex-col items-center transform hover:-translate-y-1 transition duration-300">
                    <div class="relative mb-3">
                        <div class="w-16 h-16 rounded-full bg-orange-50 flex items-center justify-center border-4 border-white shadow-lg overflow-hidden">
                            @if(isset($ranking[2]['foto']) && Storage::disk('public')->exists($ranking[2]['foto']))
                                <img src="{{ asset('storage/' . $ranking[2]['foto']) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-2xl font-bold text-orange-400">3</span>
                            @endif
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-orange-200 text-orange-700 w-8 h-8 rounded-full flex items-center justify-center font-bold border-2 border-white">3</div>
                    </div>
                    <h3 class="font-bold text-gray-800 dark:text-white text-center text-lg">{{ $ranking[2]['nama'] }}</h3>
                    <div class="mt-3 text-3xl font-black text-gray-700 dark:text-gray-300">{{ number_format($ranking[2]['skor'], 1) }}</div>
                </div>
                @endif
            </div>
            @endif

            {{-- MAIN CARD --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700 print:shadow-none print:border-none">
                
                {{-- TOOLBAR (Filter & Button) --}}
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col lg:flex-row gap-4 justify-between items-center no-print bg-gray-50/50 dark:bg-gray-700/50">
                    <form method="GET" action="{{ route('admin.ranking.index') }}" class="w-full flex flex-col md:flex-row gap-4">
                        <div class="relative w-full md:w-64">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Periode</label>
                            <select name="id_periode" onchange="this.form.submit()" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:text-white cursor-pointer">
                                @foreach($periodes as $p)
                                    <option value="{{ $p->id_periode }}" {{ $selectedPeriode == $p->id_periode ? 'selected' : '' }}>
                                        {{ $p->nama_periode }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative w-full md:w-64">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Divisi</label>
                            <select name="id_divisi" onchange="this.form.submit()" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:text-white cursor-pointer">
                                <option value="">Semua Divisi</option>
                                @foreach($divisis as $d)
                                    <option value="{{ $d->id_divisi }}" {{ $selectedDivisi == $d->id_divisi ? 'selected' : '' }}>
                                        {{ $d->nama_divisi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <button onclick="window.print()" class="flex-shrink-0 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 flex items-center gap-2 shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 mt-6 md:mt-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak PDF
                    </button>
                </div>

                {{-- LEGEND STATUS KINERJA (Revisi) --}}
                <div class="px-6 py-4 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 flex flex-wrap gap-4 items-center justify-center sm:justify-start text-xs print:border-b print:border-black">
                    <span class="font-bold text-gray-500 uppercase tracking-wide mr-2 print:text-black">Keterangan:</span>
                    
                    {{-- Excellent --}}
                    <div class="flex items-center gap-1.5">
                        <span class="flex w-2.5 h-2.5 bg-blue-500 rounded-full ring-2 ring-blue-100 dark:ring-blue-900 print:ring-0 print:border print:border-black"></span>
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-300 print:text-black">Excellent (≥ 100)</span>
                    </div>
                    {{-- Sangat Baik --}}
                    <div class="flex items-center gap-1.5">
                        <span class="flex w-2.5 h-2.5 bg-green-500 rounded-full ring-2 ring-green-100 dark:ring-green-900 print:ring-0 print:border print:border-black"></span>
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-300 print:text-black">Sangat Baik (85-99)</span>
                    </div>
                    {{-- Baik --}}
                    <div class="flex items-center gap-1.5">
                        <span class="flex w-2.5 h-2.5 bg-yellow-400 rounded-full ring-2 ring-yellow-100 dark:ring-yellow-900 print:ring-0 print:border print:border-black"></span>
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-300 print:text-black">Baik (70-84)</span>
                    </div>
                    {{-- Kurang --}}
                    <div class="flex items-center gap-1.5">
                        <span class="flex w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-red-100 dark:ring-red-900 print:ring-0 print:border print:border-black"></span>
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-300 print:text-black">Kurang (< 70)</span>
                    </div>
                </div>

                {{-- TABEL DATA --}}
                <div class="relative overflow-x-auto print:overflow-visible">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 print:text-black">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-b dark:border-gray-700 print:bg-gray-200 print:text-black print:border-black">
                            <tr>
                                <th scope="col" class="px-6 py-4 w-16 text-center print:border print:border-black print:px-2">Rank</th>
                                <th scope="col" class="px-6 py-4 print:border print:border-black print:px-2">Nama Pegawai</th>
                                <th scope="col" class="px-6 py-4 print:border print:border-black print:px-2">Divisi</th>
                                <th scope="col" class="px-6 py-4 w-1/3 print:border print:border-black print:px-2">Total Skor</th>
                                <th scope="col" class="px-6 py-4 text-center print:border print:border-black print:px-2">Status Kinerja</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 print:divide-black">
                            @forelse($ranking as $index => $data)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition print:bg-transparent print:border-black">
                                
                                {{-- Kolom Rank --}}
                                <td class="px-6 py-4 text-center print:border print:border-black print:px-2">
                                    @php
                                        $absoluteRank = ($ranking->currentPage() - 1) * $ranking->perPage() + $loop->iteration;
                                    @endphp
                                    <span class="font-bold {{ $absoluteRank <= 3 ? 'text-blue-600 text-base' : 'text-gray-500' }} print:text-black">
                                        #{{ $absoluteRank }}
                                    </span>
                                </td>

                                {{-- Kolom Nama --}}
                                <td class="px-6 py-4 print:border print:border-black print:px-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 flex-shrink-0 print:hidden">
                                            @if(isset($data['foto']) && Storage::disk('public')->exists($data['foto']))
                                                <img class="w-10 h-10 rounded-full object-cover border border-gray-200 shadow-sm" 
                                                     src="{{ asset('storage/' . $data['foto']) }}" 
                                                     alt="{{ $data['nama'] }}">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600 dark:from-blue-900 dark:to-indigo-900 dark:text-blue-200 flex items-center justify-center text-sm font-bold border border-blue-200 dark:border-blue-800 shadow-sm">
                                                    {{ substr($data['nama'], 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="block font-bold text-gray-900 dark:text-white print:text-black">{{ $data['nama'] }}</span>
                                            <span class="text-xs text-gray-500 print:text-black">{{ $data['nik'] }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom Divisi --}}
                                <td class="px-6 py-4 print:border print:border-black print:px-2">
                                    <span class="text-gray-700 dark:text-gray-300 font-medium bg-gray-50 dark:bg-gray-700/50 px-2 py-1 rounded border border-gray-200 dark:border-gray-600 print:bg-transparent print:border-none print:p-0 print:text-black">
                                        {{ $data['divisi'] }}
                                    </span>
                                </td>

                                {{-- Kolom Progress Skor --}}
                                <td class="px-6 py-4 align-middle print:border print:border-black print:px-2">
                                    <div class="flex items-center gap-4">
                                        <span class="text-base font-black text-blue-600 dark:text-blue-400 w-12 text-right print:text-black print:w-auto">
                                            {{ number_format($data['skor'], 2) }}
                                        </span>
                                        {{-- Progress Bar (Hide on print to save ink, or keep simple) --}}
                                        <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-gray-700 overflow-hidden shadow-inner print:hidden">
                                            @php
                                                $width = min($data['skor'], 100);
                                                $colorClass = 'bg-blue-600'; 
                                                if($data['skor'] >= 100) $colorClass = 'bg-blue-500'; // Excellent
                                                elseif($data['skor'] >= 85) $colorClass = 'bg-green-500'; // Sangat Baik
                                                elseif($data['skor'] >= 70) $colorClass = 'bg-yellow-400'; // Baik
                                                else $colorClass = 'bg-red-500'; // Kurang
                                            @endphp
                                            <div class="{{ $colorClass }} h-3 rounded-full transition-all duration-1000 ease-out" style="width: {{ $width }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom Status Kinerja (Revisi) --}}
                                <td class="px-6 py-4 text-center print:border print:border-black print:px-2">
                                    @php
                                        $skor = $data['skor'];
                                        $statusLabel = '';
                                        $badgeClass = '';

                                        if ($skor >= 100) {
                                            $statusLabel = 'Excellent';
                                            $badgeClass = 'bg-blue-100 text-blue-700 border-blue-200';
                                        } elseif ($skor >= 85) {
                                            $statusLabel = 'Sangat Baik';
                                            $badgeClass = 'bg-green-100 text-green-700 border-green-200';
                                        } elseif ($skor >= 70) {
                                            $statusLabel = 'Baik';
                                            $badgeClass = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                                        } else {
                                            $statusLabel = 'Kurang';
                                            $badgeClass = 'bg-red-100 text-red-700 border-red-200';
                                        }
                                    @endphp
                                    
                                    {{-- Tampilan Layar: Badge --}}
                                    <div class="flex items-center justify-center print:hidden">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </div>
                                    {{-- Tampilan Cetak: Teks Biasa --}}
                                    <span class="hidden print:inline text-xs font-bold uppercase text-black">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400 border border-gray-200 print:border-black">
                                    Data tidak ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-b-2xl no-print">
                    {{ $ranking->links() }}
                </div>

            </div>
        </div>
    </div>
    
    {{-- CSS Khusus Cetak --}}
    <style>
        @media print {
            @page { margin: 1cm; size: A4; }
            body { background-color: white !important; font-family: sans-serif; -webkit-print-color-adjust: exact; margin: 0; padding: 0; }
            .no-print, header, nav, aside { display: none !important; }
            .print-show { display: block !important; }
            
            /* Reset Containers */
            .py-12 { padding: 0 !important; margin: 0 !important; }
            .max-w-7xl { max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
            .bg-white, .dark\:bg-gray-800 { background: transparent !important; box-shadow: none !important; border: none !important; }
            
            /* Table Styling */
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th, td { border: 1px solid #000 !important; padding: 6px 8px !important; font-size: 11px; color: black !important; }
            thead th { background-color: #f0f0f0 !important; font-weight: bold; text-transform: uppercase; }
            
            /* Text Visibility */
            .text-gray-500, .text-gray-900, .text-blue-600 { color: black !important; }
            
            /* Ensure Colors for Legend if needed */
            .bg-blue-500, .bg-green-500, .bg-yellow-400, .bg-red-500 { -webkit-print-color-adjust: exact; border: 1px solid #000; }
        }
    </style>
</x-app-layout>