<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Rapor Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <a href="{{ route('admin.monitoring.index') }}" class="text-gray-600 hover:text-gray-900 font-bold">
                &larr; Kembali ke Dashboard Monitoring
            </a>

            {{-- HEADER INFO --}}
            <div class="bg-white shadow sm:rounded-lg mb-6 p-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">{{ $karyawan->nama_lengkap }}</h1>
                    <p class="text-gray-500">{{ $karyawan->divisi->nama_divisi }} | Periode: {{ $periode->nama_periode }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Skor Saat Ini</p>
                    <p class="text-4xl font-bold text-blue-600">{{ number_format($dataRapor['total_skor_akhir'], 2) }}</p>
                </div>
            </div>

            {{-- TABEL RINCIAN --}}
            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold uppercase">Indikator</th>
                                <th class="px-4 py-3 text-center text-xs font-bold uppercase">Target</th>
                                <th class="px-4 py-3 text-center text-xs font-bold uppercase">Realisasi (Log)</th>
                                <th class="px-4 py-3 text-center text-xs font-bold uppercase">Capaian (%)</th>
                                <th class="px-4 py-3 text-center text-xs font-bold uppercase">Bobot</th>
                                <th class="px-4 py-3 text-center text-xs font-bold uppercase">Skor Kontribusi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($dataRapor['detail'] as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-sm">{{ $item['indikator'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $item['kategori'] }}</div>
                                </td>
                                <td class="px-4 py-3 text-center text-sm">
                                    {{ number_format($item['target'], 0, ',', '.') }} {{ $item['satuan'] }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-blue-600">
                                    {{ number_format($item['realisasi'], 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm">
                                    <span class="px-2 py-1 rounded {{ $item['pencapaian'] >= 100 ? 'bg-green-100 text-green-800' : ($item['pencapaian'] >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ number_format($item['pencapaian'], 1) }}%
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-sm">{{ $item['bobot'] }}%</td>
                                <td class="px-4 py-3 text-center font-bold text-sm bg-gray-50">
                                    {{ number_format($item['skor'], 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>