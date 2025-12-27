<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Penilaian KPI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Sukses/Error --}}
            @if(session('success')) 
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ session('success') }}
                </div> 
            @endif
            @if(session('error')) 
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    {{ session('error') }}
                </div> 
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Daftar Hasil Evaluasi</h3>
                        <a href="{{ route('penilaian.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded shadow">
                            + Input Penilaian Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">Periode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">Nama Karyawan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">Tanggal Input</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-300">Penilai</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium uppercase text-gray-500 dark:text-gray-300">Total Skor</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium uppercase text-gray-500 dark:text-gray-300">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($penilaians as $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $p->periode->nama_periode }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $p->karyawan->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-500">{{ $p->karyawan->nik }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($p->tanggal_penilaian)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $p->penilai->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        {{-- Logika Warna Skor --}}
                                        @php
                                            $skor = $p->total_nilai;
                                            $badgeClass = 'bg-red-100 text-red-800 border-red-200'; // Default Merah (Buruk)
                                            if($skor >= 85) {
                                                $badgeClass = 'bg-green-100 text-green-800 border-green-200'; // Bagus Sekali
                                            } elseif($skor >= 70) {
                                                $badgeClass = 'bg-blue-100 text-blue-800 border-blue-200'; // Baik
                                            } elseif($skor >= 50) {
                                                $badgeClass = 'bg-yellow-100 text-yellow-800 border-yellow-200'; // Cukup
                                            }
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-sm font-bold border {{ $badgeClass }}">
                                            {{ $skor }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('penilaian.edit', $p->id_penilaianHeader) }}" class="text-indigo-600 hover:text-indigo-900 font-bold bg-indigo-50 px-3 py-1 rounded-md">
                                            Edit Nilai
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                        Belum ada data penilaian. Klik tombol "Input Penilaian Baru" untuk memulai.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>