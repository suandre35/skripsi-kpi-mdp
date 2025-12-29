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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER CETAK (Hanya Muncul Saat Print) --}}
            <div class="hidden print-show text-center border-b-2 border-black pb-4 mb-6">
                <h1 class="text-2xl font-bold uppercase">Laporan Peringkat Kinerja</h1>
                <p class="text-sm">Dicetak pada: {{ date('d F Y') }}</p>
            </div>

            {{-- VISUAL PODIUM (TOP 3) - Tetap ada tapi didesain lebih clean --}}
            @if($ranking->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end mb-4 no-print">
                {{-- JUARA 2 --}}
                @if(isset($ranking[1]))
                <div class="order-2 md:order-1 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex flex-col items-center">
                    <div class="relative">
                        <div class="w-16 h-16 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-2xl font-bold mb-3 border-4 border-white shadow-sm">2</div>
                        <div class="absolute bottom-0 right-0 bg-gray-200 text-gray-600 text-xs font-bold px-1.5 rounded-full border border-white">#2</div>
                    </div>
                    <h3 class="font-bold text-gray-800 dark:text-white text-center">{{ $ranking[1]['nama'] }}</h3>
                    <p class="text-xs text-gray-500">{{ $ranking[1]['divisi'] }}</p>
                    <div class="mt-2 text-2xl font-bold text-gray-600">{{ number_format($ranking[1]['skor'], 1) }}</div>
                </div>
                @endif

                {{-- JUARA 1 --}}
                @if(isset($ranking[0]))
                <div class="order-1 md:order-2 bg-white dark:bg-gray-800 rounded-2xl shadow-md border-t-4 border-yellow-400 p-8 flex flex-col items-center transform scale-105 z-10">
                    <div class="relative">
                        <div class="w-20 h-20 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center text-4xl font-bold mb-4 border-4 border-yellow-100 shadow-sm">1</div>
                        <div class="absolute bottom-2 right-0 bg-yellow-400 text-white text-xs font-bold px-2 py-0.5 rounded-full border border-white">WINNER</div>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white text-center">{{ $ranking[0]['nama'] }}</h3>
                    <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider">{{ $ranking[0]['divisi'] }}</p>
                    <div class="mt-3 text-4xl font-black text-gray-800 dark:text-gray-100">{{ number_format($ranking[0]['skor'], 1) }}</div>
                </div>
                @endif

                {{-- JUARA 3 --}}
                @if(isset($ranking[2]))
                <div class="order-3 md:order-3 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex flex-col items-center">
                    <div class="relative">
                        <div class="w-16 h-16 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-2xl font-bold mb-3 border-4 border-white shadow-sm">3</div>
                        <div class="absolute bottom-0 right-0 bg-orange-200 text-orange-700 text-xs font-bold px-1.5 rounded-full border border-white">#3</div>
                    </div>
                    <h3 class="font-bold text-gray-800 dark:text-white text-center">{{ $ranking[2]['nama'] }}</h3>
                    <p class="text-xs text-gray-500">{{ $ranking[2]['divisi'] }}</p>
                    <div class="mt-2 text-2xl font-bold text-gray-600">{{ number_format($ranking[2]['skor'], 1) }}</div>
                </div>
                @endif
            </div>
            @endif

            {{-- MAIN CARD (Style mirip Screenshot) --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                {{-- TOOLBAR: Filter & Actions --}}
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col lg:flex-row gap-4 justify-between items-center no-print">
                    
                    {{-- Form Filter --}}
                    <form method="GET" action="{{ route('admin.ranking.index') }}" class="w-full flex flex-col md:flex-row gap-3">
                        
                        {{-- Filter Periode --}}
                        <div class="relative w-full md:w-64">
                            <select name="id_periode" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                @foreach($periodes as $p)
                                    <option value="{{ $p->id_periode }}" {{ $selectedPeriode == $p->id_periode ? 'selected' : '' }}>
                                        {{ $p->nama_periode }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Divisi --}}
                        <div class="relative w-full md:w-48">
                            <select name="id_divisi" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Semua Divisi</option>
                                @foreach($divisis as $d)
                                    <option value="{{ $d->id_divisi }}" {{ $selectedDivisi == $d->id_divisi ? 'selected' : '' }}>
                                        {{ $d->nama_divisi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </form>

                    {{-- Tombol Cetak (Biru seperti tombol "Tambah" di screenshot) --}}
                    <button onclick="window.print()" class="flex-shrink-0 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none flex items-center gap-2 shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak PDF
                    </button>
                </div>

                {{-- TABEL DATA --}}
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b dark:border-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 w-16 text-center">#</th>
                                <th scope="col" class="px-6 py-4">Karyawan</th>
                                <th scope="col" class="px-6 py-4">Divisi</th>
                                <th scope="col" class="px-6 py-4 w-1/3">Total Skor</th>
                                <th scope="col" class="px-6 py-4 text-center">Grade</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($ranking as $index => $data)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                
                                {{-- Kolom 1: Peringkat --}}
                                <td class="px-6 py-4 text-center">
                                    @if($index == 0) 
                                        <span class="text-xl">🥇</span> 
                                    @elseif($index == 1) 
                                        <span class="text-xl">🥈</span> 
                                    @elseif($index == 2) 
                                        <span class="text-xl">🥉</span> 
                                    @else 
                                        <span class="font-bold text-gray-400">{{ $index + 1 }}</span> 
                                    @endif
                                </td>

                                {{-- Kolom 2: Nama Karyawan --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        {{-- Avatar Inisial --}}
                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                            {{ substr($data['nama'], 0, 1) }}
                                        </div>
                                        <span class="font-bold text-gray-900 dark:text-white">{{ $data['nama'] }}</span>
                                    </div>
                                </td>

                                {{-- Kolom 3: Divisi --}}
                                <td class="px-6 py-4">
                                    <span class="text-gray-600 dark:text-gray-300">{{ $data['divisi'] }}</span>
                                </td>

                                {{-- Kolom 4: Progress Bar Skor (Mirip Screenshot) --}}
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-center gap-4">
                                        <span class="text-sm font-bold text-blue-600 dark:text-blue-400 w-12 text-right">
                                            {{ number_format($data['skor'], 1) }}
                                        </span>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                            @php
                                                $width = min($data['skor'], 100);
                                                $colorClass = 'bg-blue-600'; // Default Blue
                                                if($data['skor'] < 60) $colorClass = 'bg-red-500';
                                                elseif($data['skor'] < 80) $colorClass = 'bg-yellow-400';
                                                elseif($data['skor'] >= 100) $colorClass = 'bg-green-500';
                                            @endphp
                                            <div class="{{ $colorClass }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $width }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom 5: Grade (Pill Badge) --}}
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $grade = $data['grade'];
                                        // Warna dot status
                                        $dotColor = 'bg-gray-500';
                                        $textColor = 'text-gray-600';
                                        
                                        if($grade == 'A') { $dotColor = 'bg-green-500'; $textColor = 'text-green-600'; }
                                        elseif($grade == 'B') { $dotColor = 'bg-blue-500'; $textColor = 'text-blue-600'; }
                                        elseif($grade == 'C') { $dotColor = 'bg-yellow-400'; $textColor = 'text-yellow-600'; }
                                        elseif($grade == 'D' || $grade == 'E') { $dotColor = 'bg-red-500'; $textColor = 'text-red-600'; }
                                    @endphp
                                    
                                    {{-- Desain Badge seperti Status di Screenshot --}}
                                    <div class="flex items-center justify-center">
                                        <div class="h-2.5 w-2.5 rounded-full {{ $dotColor }} mr-2"></div>
                                        <span class="font-bold {{ $textColor }}">{{ $grade }}</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-base">Tidak ada data penilaian untuk periode ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    
    {{-- CSS Khusus Cetak agar Rapi --}}
    <style>
        @media print {
            body * { visibility: hidden; }
            .py-12, .py-12 * { visibility: visible; }
            .py-12 { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            .print-show { display: block !important; }
            
            /* Reset style untuk cetak hitam putih/clean */
            .bg-white, .dark\:bg-gray-800 { background-color: white !important; color: black !important; }
            .shadow-xl, .shadow-md, .shadow-sm { box-shadow: none !important; }
            
            /* Table Border */
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th, td { border: 1px solid #000 !important; padding: 8px; font-size: 12px; }
            th { background-color: #eee !important; font-weight: bold; }
        }
    </style>
</x-app-layout>