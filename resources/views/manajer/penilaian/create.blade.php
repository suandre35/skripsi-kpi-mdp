<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Input Penilaian Baru') }}
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
                            <a href="{{ route('penilaian.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Log Aktivitas</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-100">Input</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12" x-data="penilaianHandler()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- ERROR HANDLING GLOBAL --}}
            @if ($errors->any())
                <div class="p-4 mb-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <strong class="font-bold text-sm">Periksa Inputan Anda!</strong>
                    </div>
                    <ul class="list-disc list-inside text-xs ml-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ERROR SESSION (Logic Controller) --}}
            @if(session('error'))
                <div class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <h3 class="text-lg font-medium">Gagal Menyimpan</h3>
                    </div>
                    <div class="mt-2 mb-4 text-sm">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            {{-- FORM START: Novalidate added --}}
            <form action="{{ route('penilaian.store') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="id_periode" value="{{ $periodeAktif->id_periode }}">

                <div class="space-y-6">

                    {{-- CARD 1: PILIH KARYAWAN --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                1. Pilih Karyawan
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Nama Anggota Tim <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="id_karyawan" 
                                    class="block w-full rounded-lg shadow-sm h-11 transition duration-150 dark:bg-gray-900 dark:text-white
                                    {{ $errors->has('id_karyawan') 
                                        ? 'border-red-500 text-red-900 focus:ring-red-500 focus:border-red-500 dark:border-red-500 dark:text-red-400' 
                                        : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600' }}">
                                    <option value="">-- Pilih Karyawan --</option>
                                    @foreach($karyawans as $k)
                                        <option value="{{ $k->id_karyawan }}" 
                                            {{ (old('id_karyawan') == $k->id_karyawan || (isset($selectedKaryawanId) && $selectedKaryawanId == $k->id_karyawan)) ? 'selected' : '' }}>
                                            {{ $k->nama_lengkap }} ({{ $k->nik }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('id_karyawan')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400 font-medium flex items-center gap-1 animate-pulse">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- CARD 2: PILIH INDIKATOR --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                2. Pilih Aktivitas / Indikator
                            </h3>
                        </div>

                        <div class="p-6">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Indikator Kinerja <span class="text-red-500">*</span></label>
                            <select name="id_indikator" x-model="selectedId" @change="updateInfo()" 
                                class="block w-full rounded-lg shadow-sm h-11 transition duration-150 dark:bg-gray-900 dark:text-white
                                {{ $errors->has('id_indikator') 
                                    ? 'border-red-500 text-red-900 focus:ring-red-500 focus:border-red-500 dark:border-red-500 dark:text-red-400' 
                                    : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600' }}">
                                <option value="">-- Pilih Indikator yang dinilai --</option>
                                @foreach($kategoris as $kategori)
                                    <optgroup label="{{ $kategori->nama_kategori }}">
                                        @foreach($kategori->indikators as $indikator)
                                            <option value="{{ $indikator->id_indikator }}"
                                                data-target="{{ $indikator->target->nilai_target ?? 0 }}"
                                                data-satuan="{{ $indikator->target->jenis_target ?? '-' }}"
                                                data-deskripsi="{{ $indikator->deskripsi ?? '' }}"
                                                {{ old('id_indikator') == $indikator->id_indikator ? 'selected' : '' }}>
                                                {{ $indikator->nama_indikator }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('id_indikator')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400 font-medium flex items-center gap-1 animate-pulse">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror

                            {{-- INFO TARGET DYNAMIC --}}
                            <div x-show="selectedId" x-transition class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800 flex flex-col sm:flex-row justify-between items-center gap-4">
                                <div>
                                    <span class="text-xs font-bold text-blue-500 uppercase tracking-wide">Target KPI</span>
                                    <div class="text-lg font-black text-gray-800 dark:text-white">
                                        <span x-text="target"></span> <span x-text="satuan" class="text-sm font-medium text-gray-500"></span>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-300 italic text-right max-w-md">
                                    <span x-text="deskripsi"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 3: INPUT NILAI --}}
                    <div x-show="selectedId" x-transition class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/50">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                3. Hasil Penilaian
                            </h3>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Input Nilai --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Realisasi / Hasil <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="number" step="any" name="nilai_input" value="{{ old('nilai_input') }}" placeholder="0"
                                            class="block w-full pl-4 pr-12 text-right font-bold text-2xl rounded-lg shadow-sm h-14 transition duration-150 dark:bg-gray-900 dark:text-white
                                            {{ $errors->has('nilai_input') 
                                                ? 'border-red-500 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 dark:border-red-500 dark:text-red-400' 
                                                : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600' }}">
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-bold" x-text="satuan"></span>
                                        </div>
                                    </div>
                                    @error('nilai_input')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400 font-medium flex items-center gap-1 animate-pulse">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Input Catatan --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Catatan (Opsional)</label>
                                    <textarea name="catatan" rows="2" placeholder="Berikan keterangan tambahan jika perlu..."
                                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ old('catatan') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER ACTION --}}
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/30 flex justify-end gap-3">
                            <a href="{{ route('penilaian.index') }}" class="px-5 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 transition shadow-sm">
                                Batal
                            </a>
                            <button type="submit" class="flex items-center gap-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-bold rounded-lg text-sm px-6 py-2.5 shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Data
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        function penilaianHandler() {
            return {
                selectedId: '{{ old("id_indikator") }}', // Mempertahankan state jika terjadi error
                target: '-',
                satuan: '',
                deskripsi: '-',
                
                init() {
                    // Jika ada old input, jalankan updateInfo saat halaman dimuat
                    if(this.selectedId) {
                        // Delay sedikit agar DOM select siap
                        setTimeout(() => { this.updateInfo(); }, 100);
                    }
                },

                updateInfo() {
                    const select = document.querySelector('select[name="id_indikator"]');
                    const option = select.options[select.selectedIndex];
                    
                    if(option && option.value) {
                        this.target = option.dataset.target;
                        this.satuan = option.dataset.satuan;
                        this.deskripsi = option.dataset.deskripsi;
                    } else {
                        this.target = '-';
                        this.satuan = '';
                        this.deskripsi = '-';
                    }
                }
            }
        }
    </script>
</x-app-layout>