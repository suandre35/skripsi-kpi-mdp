<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Tambah Bobot KPI') }}
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
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Buat Baru</span>
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
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Formulir Bobot KPI</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tentukan besaran pengaruh indikator terhadap penilaian.</p>
                </div>

                <div class="p-6 md:p-8">
                    
                    {{-- Validasi Error --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <strong class="font-bold">Terjadi Kesalahan!</strong>
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

                    <form action="{{ route('bobot.store') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6">
                            
                            {{-- Pilih Indikator --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pilih Indikator <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    </div>
                                    <select name="id_indikator" required class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                        <option value="">-- Pilih Indikator KPI --</option>
                                        @foreach($indikators as $indikator)
                                            <option value="{{ $indikator->id_indikator }}" {{ old('id_indikator') == $indikator->id_indikator ? 'selected' : '' }}>
                                                {{ $indikator->nama_indikator }} ({{ $indikator->kategori->nama_kategori ?? 'Umum' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @if($indikators->isEmpty())
                                    <p class="mt-2 text-xs text-red-500">*Belum ada indikator tersedia.</p>
                                @endif
                            </div>

                            {{-- Grid Nilai & Info Sisa Bobot --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                                
                                {{-- KIRI: Input Nilai --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nilai Bobot (%) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                                        </div>
                                        <input type="number" step="1" name="nilai_bobot" id="nilai_bobot" value="{{ old('nilai_bobot') }}" required placeholder="Contoh: 15"
                                            class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm transition duration-150">
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500">Pastikan total bobot per divisi tidak melebihi 100%.</p>
                                </div>

                                {{-- KANAN: Info Sisa Bobot (Dinamis) --}}
                                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-5 border border-blue-100 dark:border-blue-800">
                                    <h4 class="text-sm font-bold text-blue-800 dark:text-blue-300 mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Informasi Kuota Bobot Divisi
                                    </h4>
                                    
                                    {{-- Container untuk list dinamis --}}
                                    <div id="divisi-info-container" class="space-y-3">
                                        <p class="text-xs text-gray-500 italic">Pilih indikator terlebih dahulu untuk melihat sisa kuota divisi terkait.</p>
                                    </div>
                                </div>

                            </div>

                        </div>

                        {{-- Footer Buttons --}}
                        <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('bobot.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Batal</a>
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium shadow-lg shadow-blue-500/30">Simpan Bobot</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari Controller (Penggunaan Bobot per Divisi)
            const divisiUsage = @json($divisiUsage); 
            
            const selectIndikator = document.getElementById('id_indikator');
            const infoContainer = document.getElementById('divisi-info-container');

            function updateInfo() {
                const selectedOption = selectIndikator.options[selectIndikator.selectedIndex];
                
                // Ambil data targets (array ID Divisi) dari atribut data-targets
                let targetDivisiIds = [];
                try {
                    targetDivisiIds = JSON.parse(selectedOption.getAttribute('data-targets') || '[]');
                } catch (e) {
                    targetDivisiIds = [];
                }

                infoContainer.innerHTML = ''; // Reset konten

                if (targetDivisiIds.length === 0) {
                    infoContainer.innerHTML = '<p class="text-xs text-gray-500 italic">Indikator ini tidak terikat khusus pada divisi manapun (Umum) atau belum dipilih.</p>';
                    return;
                }

                targetDivisiIds.forEach(id => {
                    // Cek data usage dari variabel PHP yg di-pass ke JS
                    if (divisiUsage[id]) {
                        const data = divisiUsage[id];
                        const sisa = data.sisa;
                        
                        // Tentukan warna progress bar
                        let colorClass = 'bg-blue-600';
                        if(sisa < 0) colorClass = 'bg-red-500'; // Over limit
                        else if(sisa < 20) colorClass = 'bg-yellow-400'; // Warning

                        const html = `
                            <div class="bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300">${data.nama}</span>
                                    <span class="text-xs font-bold ${sisa < 0 ? 'text-red-600' : 'text-blue-600'}">Sisa: ${sisa}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                                    <div class="${colorClass} h-1.5 rounded-full" style="width: ${Math.min(data.used, 100)}%"></div>
                                </div>
                                <div class="text-[10px] text-gray-400 mt-1 text-right">Terpakai: ${data.used}%</div>
                            </div>
                        `;
                        infoContainer.insertAdjacentHTML('beforeend', html);
                    }
                });
            }

            // Listen event change
            selectIndikator.addEventListener('change', updateInfo);

            // Jalankan sekali saat load (jika old input ada)
            if(selectIndikator.value) {
                updateInfo();
            }
        });
    </script>
</x-app-layout>