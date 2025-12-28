<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Input Penilaian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Riwayat Input Aktivitas Tim</h3>
                        <a href="{{ route('penilaian.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                            + Input Penilaian Hari Ini
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Karyawan</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aktivitas (Indikator)</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Realisasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Catatan</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($logs as $log)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    {{-- Tanggal --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($log->tanggal)->format('d M Y') }}
                                    </td>
                                    
                                    {{-- Nama Karyawan --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-gray-800 dark:text-gray-200">
                                            {{ $log->header->karyawan->nama_lengkap ?? '-' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $log->header->karyawan->nik ?? '' }}
                                        </div>
                                    </td>

                                    {{-- Indikator --}}
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                            {{ $log->indikator->nama_indikator ?? '-' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            Target: {{ number_format($log->indikator->target->nilai_target ?? 0, 0, ',', '.') }} 
                                            {{ $log->indikator->target->jenis_target ?? '' }}
                                        </div>
                                    </td>

                                    {{-- Nilai Realisasi --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200">
                                            {{ number_format($log->nilai_input, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    {{-- Catatan --}}
                                    <td class="px-6 py-4 text-sm text-gray-500 italic">
                                        {{ $log->catatan ?? '-' }}
                                    </td>

                                    {{-- Aksi (Hapus Log Salah Input) --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex justify-center items-center space-x-3">
                                            
                                            {{-- TOMBOL EDIT --}}
                                            <a href="{{ route('penilaian.edit', $log->getKey()) }}" 
                                            class="text-blue-500 hover:text-blue-700 font-bold text-xs uppercase tracking-wide">
                                                Edit
                                            </a>

                                            <span class="text-gray-300">|</span>

                                            {{-- TOMBOL HAPUS --}}
                                            <form action="{{ route('penilaian.destroy', $log->getKey()) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus log aktivitas ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-wide">
                                                    Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                            <p>Belum ada aktivitas yang diinput pada periode ini.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $logs->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>