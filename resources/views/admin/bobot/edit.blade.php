<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Edit Bobot KPI') }}
            </h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('bobot.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Bobot</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                {{-- HEADER CARD --}}
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Edit Bobot: <span class="font-bold text-blue-600">{{ $bobot->indikator->nama_indikator ?? 'Indikator' }}</span></h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Sesuaikan persentase prioritas indikator.</p>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    
                    {{-- Validasi Error --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <strong class="font-bold">Periksa Kembali Inputan Anda!</strong>
                            </div>
                            <ul class="list-disc list-inside text-sm ml-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 rounded-lg bg-red-100 border-l-4 border-red-500 text-red-700">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span class="font-bold">Validasi Gagal!</span>
                            </div>
                            <p class="mt-1 ml-8">{!! \Illuminate\Support\Str::markdown(session('error')) !!}</p>
                        </div>
                    @endif

                    <form action="{{ route('bobot.update', $bobot->id_bobot) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Method PUT untuk Update --}}
                        
                        <div class="space-y-8">
                            {{-- Pilih Indikator --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pilih Indikator <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="id_indikator" id="id_indikator" required class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 p-2.5">
                                        @foreach($indikators as $indikator)
                                            <option value="{{ $indikator->id_indikator }}" 
                                                data-targets='{{ json_encode($indikator->target_divisi) }}'
                                                {{ old('id_indikator', $bobot->id_indikator) == $indikator->id_indikator ? 'selected' : '' }}>
                                                {{ $indikator->nama_indikator }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                                {{-- Nilai Bobot --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nilai Bobot (%)</label>
                                    <input type="number" step="1" name="nilai_bobot" value="{{ old('nilai_bobot', $bobot->nilai_bobot) }}" required 
                                        class="pl-3 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>

                                {{-- Info Sisa Bobot --}}
                                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-5 border border-blue-100 dark:border-blue-800">
                                    <h4 class="text-sm font-bold text-blue-800 dark:text-blue-300 mb-3">Informasi Kuota Bobot Divisi</h4>
                                    <div id="divisi-info-container" class="space-y-3"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('bobot.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">Batal</a>
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg">Update Bobot</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT SAMA DENGAN CREATE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const divisiUsage = @json($divisiUsage); // Data usage EXCLUDE bobot ini
            const selectIndikator = document.getElementById('id_indikator');
            const infoContainer = document.getElementById('divisi-info-container');

            function updateInfo() {
                const selectedOption = selectIndikator.options[selectIndikator.selectedIndex];
                let targetDivisiIds = [];
                try { targetDivisiIds = JSON.parse(selectedOption.getAttribute('data-targets') || '[]'); } catch (e) { targetDivisiIds = []; }

                infoContainer.innerHTML = '';

                if (targetDivisiIds.length === 0) {
                    infoContainer.innerHTML = '<p class="text-xs text-gray-500 italic">Indikator umum / belum dipilih.</p>';
                    return;
                }

                targetDivisiIds.forEach(id => {
                    if (divisiUsage[id]) {
                        const data = divisiUsage[id];
                        // Sisa saat ini (sebelum bobot baru dimasukkan)
                        const sisa = data.sisa; 
                        
                        let colorClass = 'bg-blue-600';
                        if(sisa < 0) colorClass = 'bg-red-500';

                        const html = `
                            <div class="bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300">${data.nama}</span>
                                    <span class="text-xs font-bold text-blue-600">Sisa Kuota: ${sisa}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                                    <div class="${colorClass} h-1.5 rounded-full" style="width: ${Math.min(data.used, 100)}%"></div>
                                </div>
                                <div class="text-[10px] text-gray-400 mt-1 text-right">
                                    Terpakai oleh indikator lain: ${data.used}%
                                </div>
                            </div>
                        `;
                        infoContainer.insertAdjacentHTML('beforeend', html);
                    }
                });
            }

            selectIndikator.addEventListener('change', updateInfo);
            if(selectIndikator.value) updateInfo();
        });
    </script>
</x-app-layout>