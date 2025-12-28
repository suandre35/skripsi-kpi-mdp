<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Rapor Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tombol Kembali --}}
            <div class="mb-4 no-print"> {{-- Tambahkan class no-print disini --}}
                <a href="{{ route('admin.monitoring.index') }}" class="text-gray-600 hover:text-gray-900 font-bold">
                    &larr; Kembali ke Dashboard Monitoring
                </a>
            </div>

            {{-- HEADER INFO --}}
            <div class="bg-white shadow sm:rounded-lg mb-6 p-6 flex justify-between items-center">
                {{-- ... (Isi Header Info Tetap Sama) ... --}}
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
                        {{-- ... (Isi Tabel Tetap Sama) ... --}}
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

            {{-- 🟢 MULAI KODINGAN BARU DISINI (SETELAH DIV TABEL DITUTUP) 🟢 --}}
            
            <div class="mt-6 flex justify-end no-print">
                <button onclick="window.print()" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded shadow-lg flex items-center gap-2 transform hover:scale-105 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Unduh / Cetak Lapor
                </button>
            </div>

            <style>
                @media print {
                    /* Sembunyikan tombol, header, sidebar, dan navigasi saat nge-print */
                    .no-print, header, aside, nav { display: none !important; }
                    
                    /* Reset warna background dan text */
                    body { background-color: white; color: black; }
                    .bg-white { background-color: white !important; }
                    
                    /* Hilangkan bayangan box */
                    .shadow, .shadow-sm, .shadow-lg { box-shadow: none !important; }
                    
                    /* Pastikan layout full width */
                    .max-w-7xl { max-width: 100% !important; margin: 0; padding: 0; }
                    
                    /* Pastikan tabel tercetak rapi */
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #000 !important; padding: 8px; }
                }
            </style>
            {{-- 🔴 SELESAI KODINGAN BARU 🔴 --}}

        </div>
    </div>
</x-app-layout>