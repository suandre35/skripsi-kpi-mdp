<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Aktivitas User (Log Sistem)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Log Login & Akses Sistem</h3>
                    
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Waktu</th>
                                    <th class="px-6 py-3">User</th>
                                    <th class="px-6 py-3">Role</th>
                                    <th class="px-6 py-3">Aktivitas</th>
                                    <th class="px-6 py-3">IP Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    {{-- Waktu --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $log->created_at->format('d M Y H:i:s') }}
                                    </td>
                                    
                                    {{-- Nama User --}}
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white">
                                            {{ $log->user->name ?? 'User Terhapus' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $log->user->email ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- Role --}}
                                    <td class="px-6 py-4">
                                        @php
                                            $role = $log->user->role ?? '-';
                                            $badgeClass = 'bg-gray-100 text-gray-800';
                                            
                                            if($role == 'HRD') $badgeClass = 'bg-purple-100 text-purple-800 border-purple-200';
                                            elseif($role == 'Manajer') $badgeClass = 'bg-blue-100 text-blue-800 border-blue-200';
                                            elseif($role == 'Karyawan') $badgeClass = 'bg-green-100 text-green-800 border-green-200';
                                        @endphp
                                        <span class="px-2.5 py-0.5 rounded text-xs font-medium border {{ $badgeClass }}">
                                            {{ $role }}
                                        </span>
                                    </td>

                                    {{-- Aktivitas & Deskripsi --}}
                                    <td class="px-6 py-4">
                                        {{-- PERBAIKAN: Menggunakan nama kolom bahasa Indonesia --}}
                                        <span class="font-bold {{ $log->aktivitas == 'Login' ? 'text-green-600' : 'text-blue-600' }}">
                                            {{ $log->aktivitas }}
                                        </span>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ $log->deskripsi }}
                                        </p>
                                    </td>

                                    {{-- IP Address --}}
                                    <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                        {{ $log->ip_address ?? '-' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>