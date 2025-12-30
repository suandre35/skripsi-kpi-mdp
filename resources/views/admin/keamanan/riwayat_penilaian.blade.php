<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Riwayat Penilaian (Audit Log)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Log Aktivitas Penilaian</h3>
                    
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Waktu</th>
                                    <th class="px-6 py-3">Penilai (Manajer)</th>
                                    <th class="px-6 py-3">Dinilai (Karyawan)</th>
                                    <th class="px-6 py-3">Indikator</th>
                                    <th class="px-6 py-3">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat as $log)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    {{-- Waktu --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $log->created_at->format('d M Y H:i') }}
                                    </td>
                                    
                                    {{-- Penilai --}}
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $log->header->penilai->name ?? 'User Terhapus' }}
                                    </td>

                                    {{-- Karyawan Dinilai --}}
                                    <td class="px-6 py-4">
                                        {{ $log->header->karyawan->nama_lengkap ?? '-' }}
                                        <div class="text-xs text-gray-500">
                                            {{ $log->header->karyawan->nik ?? '' }}
                                        </div>
                                    </td>

                                    {{-- Indikator --}}
                                    <td class="px-6 py-4">
                                        {{ $log->indikator->nama_indikator ?? '-' }}
                                    </td>

                                    {{-- Nilai --}}
                                    <td class="px-6 py-4 font-bold text-blue-600">
                                        {{ number_format($log->nilai_input, 2) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada riwayat penilaian.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $riwayat->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>