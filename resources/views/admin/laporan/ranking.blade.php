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

            {{-- HEADER CETAK --}}
            <div class="hidden print-show text-center border-b-2 border-black pb-4 mb-6">
                <h1 class="text-2xl font-bold uppercase">Laporan Peringkat Kinerja Pegawai</h1>
                <p class="text-sm">Dicetak pada: {{ date('d F Y') }}</p>
            </div>

            {{-- VISUAL PODIUM (Hanya Tampil di Halaman 1) --}}
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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                {{-- TOOLBAR --}}
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col lg:flex-row gap-4 justify-between items-center no-print bg-gray-50/50 dark:bg-gray-700/50">
                    <form method="GET" action="{{ route('admin.ranking.index') }}" class="w-full flex flex-col md:flex-row gap-4">
                        <div class="relative w-full md:w-64">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Periode</label>
                            <select name="id_periode" onchange="this.form.submit()" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                @foreach($periodes as $p)
                                    <option value="{{ $p->id_periode }}" {{ $selectedPeriode == $p->id_periode ? 'selected' : '' }}>
                                        {{ $p->nama_periode }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative w-full md:w-64">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Divisi</label>
                            <select name="id_divisi" onchange="this.form.submit()" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
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

                {{-- LEGEND --}}
                <div class="px-6 py-4 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 flex flex-wrap gap-4 items-center justify-center sm:justify-start text-xs">
                    <span class="font-bold text-gray-500 uppercase tracking-wide mr-2">Grade:</span>
                    
                    {{-- Grade SS --}}
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-pink-100 text-pink-700 border border-pink-200">SS</span> 
                        <span>(> 120)</span>
                    </div>

                    {{-- Grade S --}}
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-700 border border-purple-200">S</span> 
                        <span>(100-120)</span>
                    </div>

                    {{-- Grade A --}}
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 border border-green-200">A</span> 
                        <span>(90-100)</span>
                    </div>
                    
                    {{-- Grade B --}}
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-700 border border-blue-200">B</span> 
                        <span>(80-89)</span>
                    </div>

                    {{-- Grade C --}}
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">C</span> 
                        <span>(70-79)</span>
                    </div>

                    {{-- Grade D --}}
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-orange-100 text-orange-700 border border-orange-200">D</span> 
                        <span>(60-69)</span>
                    </div>

                    {{-- Grade E --}}
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700 border border-red-200">E</span> 
                        <span>(< 60)</span>
                    </div>
                </div>

                {{-- TABEL DATA --}}
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-b dark:border-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 w-16 text-center">Rank</th>
                                <th scope="col" class="px-6 py-4">Nama Pegawai</th>
                                <th scope="col" class="px-6 py-4">Divisi</th>
                                <th scope="col" class="px-6 py-4 w-1/3">Total Skor</th>
                                <th scope="col" class="px-6 py-4 text-center">Grade</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($ranking as $index => $data)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                
                                {{-- Kolom Rank --}}
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $absoluteRank = ($ranking->currentPage() - 1) * $ranking->perPage() + $loop->iteration;
                                    @endphp
                                    @if($absoluteRank == 1) <span class="text-2xl">🥇</span> 
                                    @elseif($absoluteRank == 2) <span class="text-2xl">🥈</span> 
                                    @elseif($absoluteRank == 3) <span class="text-2xl">🥉</span> 
                                    @else <span class="font-bold text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-md">{{ $absoluteRank }}</span> 
                                    @endif
                                </td>

                                {{-- Kolom Nama --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 flex-shrink-0">
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
                                            <span class="block font-bold text-gray-900 dark:text-white">{{ $data['nama'] }}</span>
                                            <span class="text-xs text-gray-500">{{ $data['nik'] }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom Divisi --}}
                                <td class="px-6 py-4">
                                    <span class="text-gray-700 dark:text-gray-300 font-medium bg-gray-50 dark:bg-gray-700/50 px-2 py-1 rounded border border-gray-200 dark:border-gray-600">
                                        {{ $data['divisi'] }}
                                    </span>
                                </td>

                                {{-- Kolom Progress --}}
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-center gap-4">
                                        <span class="text-base font-black text-blue-600 dark:text-blue-400 w-12 text-right">
                                            {{ number_format($data['skor'], 1) }}
                                        </span>
                                        <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-gray-700 overflow-hidden shadow-inner">
                                            @php
                                                $width = min($data['skor'], 100);
                                                if($data['skor'] > 100) $width = 100; // Cap width visual at 100%

                                                $colorClass = 'bg-blue-600'; 
                                                if($data['skor'] > 120) $colorClass = 'bg-pink-500'; // SS
                                                elseif($data['skor'] >= 100) $colorClass = 'bg-purple-600'; // S
                                                elseif($data['skor'] >= 90) $colorClass = 'bg-green-500'; // A
                                                elseif($data['skor'] < 60) $colorClass = 'bg-red-500';
                                                elseif($data['skor'] < 70) $colorClass = 'bg-orange-500';
                                                elseif($data['skor'] < 80) $colorClass = 'bg-yellow-400';
                                            @endphp
                                            <div class="{{ $colorClass }} h-3 rounded-full transition-all duration-1000 ease-out" style="width: {{ $width }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom Grade --}}
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $grade = $data['grade'];
                                        $badgeClass = 'bg-gray-100 text-gray-600 border-gray-200';
                                        
                                        if($grade == 'SS') $badgeClass = 'bg-pink-100 text-pink-700 border-pink-200';
                                        elseif($grade == 'S') $badgeClass = 'bg-purple-100 text-purple-700 border-purple-200';
                                        elseif($grade == 'A') $badgeClass = 'bg-green-100 text-green-700 border-green-200';
                                        elseif($grade == 'B') $badgeClass = 'bg-blue-100 text-blue-700 border-blue-200';
                                        elseif($grade == 'C') $badgeClass = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                                        elseif($grade == 'D') $badgeClass = 'bg-orange-100 text-orange-700 border-orange-200';
                                        elseif($grade == 'E') $badgeClass = 'bg-red-100 text-red-700 border-red-200';
                                    @endphp
                                    <div class="flex items-center justify-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">
                                            {{ $grade }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">
                                    Data tidak ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-b-2xl">
                    {{ $ranking->links() }}
                </div>

            </div>
        </div>
    </div>
    
    {{-- CSS Khusus Cetak --}}
    <style>
        @media print {
            @page { margin: 1cm; size: A4; }
            body { background-color: white !important; font-family: sans-serif; -webkit-print-color-adjust: exact; }
            .no-print, header, nav, aside { display: none !important; }
            .print-show { display: block !important; }
            .py-12 { padding: 0 !important; margin: 0 !important; }
            .max-w-7xl { max-width: 100% !important; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th, td { border: 1px solid #000 !important; padding: 8px !important; font-size: 11px; }
            th { background-color: #f3f3f3 !important; font-weight: bold; }
            .w-full.bg-gray-200 { border: 1px solid #000; background: white !important; }
            .h-2\.5, .h-3 { height: 10px !important; }
            .bg-green-500, .bg-blue-600, .bg-yellow-400, .bg-red-500, .bg-purple-600, .bg-pink-500, .bg-orange-500 { -webkit-print-color-adjust: exact; }
        }
    </style>
</x-app-layout>