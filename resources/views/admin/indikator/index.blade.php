<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Indikator KPI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <a href="{{ route('indikator.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">+ Tambah Indikator</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Indikator</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Target Divisi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Satuan</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($indikators as $indikator)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">
                                        {{ $indikator->kategori->nama_kategori ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold">{{ $indikator->nama_indikator }}</div>
                                        <div class="text-xs text-gray-500">{{ $indikator->deskripsi }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @if(!empty($indikator->target_divisi))
                                                @foreach($indikator->target_divisi as $idDiv)
                                                    {{-- Mapping ID ke Nama Divisi menggunakan variabel $allDivisi dari Controller --}}
                                                    <span class="px-2 py-0.5 text-xs bg-blue-100 text-blue-800 rounded border border-blue-200">
                                                        {{ $allDivisi[$idDiv] ?? 'Divisi ID:'.$idDiv }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-xs text-red-500 italic">Belum diset</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $indikator->satuan_pengukuran ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $indikator->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $indikator->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('indikator.edit', $indikator->id_indikator) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>