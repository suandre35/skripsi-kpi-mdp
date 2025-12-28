<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Perbandingan Kinerja (Ranking)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Filter Periode --}}
                <form method="GET" action="{{ route('admin.ranking.index') }}" class="mb-6 flex gap-4 items-end">
                    <div class="w-full md:w-1/3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Periode Evaluasi</label>
                        <select name="id_periode" class="w-full rounded border-gray-300">
                            @foreach($periodes as $p)
                                <option value="{{ $p->id_periode }}" {{ $selectedPeriode == $p->id_periode ? 'selected' : '' }}>
                                    {{ $p->nama_periode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Filter</button>
                    
                    {{-- Tombol Cetak (Fitur 2) --}}
                    <button type="button" onclick="window.print()" class="bg-gray-800 text-white font-bold py-2 px-4 rounded hover:bg-gray-900 ml-auto">
                        🖨️ Cetak / PDF
                    </button>
                </form>

                {{-- Tabel Ranking --}}
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Peringkat</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama Karyawan</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Divisi</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Total Skor</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Grade</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($ranking as $index => $data)
                        <tr class="{{ $index < 3 ? 'bg-yellow-50' : '' }}">
                            <td class="px-6 py-4 text-center font-bold text-gray-500">
                                @if($index == 0) 🥇 @elseif($index == 1) 🥈 @elseif($index == 2) 🥉 @else #{{ $index + 1 }} @endif
                            </td>
                            <td class="px-6 py-4 font-bold">{{ $data['nama'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $data['divisi'] }}</td>
                            <td class="px-6 py-4 text-center text-blue-600 font-bold text-lg">{{ number_format($data['skor'], 2) }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full font-bold text-xs 
                                    {{ $data['grade'] == 'A' ? 'bg-green-100 text-green-800' : 
                                      ($data['grade'] == 'B' ? 'bg-blue-100 text-blue-800' : 
                                      ($data['grade'] == 'C' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ $data['grade'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    
    {{-- CSS Khusus Cetak agar Rapi --}}
    <style>
        @media print {
            body * { visibility: hidden; }
            .py-12, .py-12 * { visibility: visible; }
            .py-12 { position: absolute; left: 0; top: 0; width: 100%; }
            button, form { display: none !important; } 
        }
    </style>
</x-app-layout>