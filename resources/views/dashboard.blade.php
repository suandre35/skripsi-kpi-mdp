<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }} - {{ Auth::user()->role }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- ======================= DASHBOARD HRD ======================= --}}
            @if(Auth::user()->role === 'HRD')
                
                {{-- 1. EMPAT KARTU UTAMA --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    {{-- Card 1: Total Karyawan --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Karyawan</p>
                                <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $totalKaryawan }}</h3>
                                <p class="text-xs text-blue-600 mt-2 font-medium">Karyawan Aktif</p>
                            </div>
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg dark:bg-blue-900/20 dark:text-blue-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Total Divisi --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Divisi</p>
                                <h3 class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mt-2">{{ $totalDivisi }}</h3>
                                <p class="text-xs text-indigo-600 mt-2 font-medium">Divisi Terdaftar</p>
                            </div>
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg dark:bg-indigo-900/20 dark:text-indigo-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Card 3: Total Penilaian DETAIL --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Penilaian Masuk</p>
                                <h3 class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">{{ $totalPenilaian }}</h3>
                                <p class="text-xs text-emerald-600 mt-2 font-medium">Total Penilaian Detail</p>
                            </div>
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg dark:bg-emerald-900/20 dark:text-emerald-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Card 4: Periode Aktif --}}
                    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-6 shadow-lg text-white relative overflow-hidden">
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div>
                                <p class="text-indigo-200 text-xs font-bold uppercase tracking-wider">Periode Aktif</p>
                                <h3 class="text-xl font-bold mt-1 truncate">
                                    {{ $periodeAktif->nama_periode ?? 'Tidak Ada' }}
                                </h3>
                            </div>
                            @if($periodeAktif)
                                @php
                                    $end = \Carbon\Carbon::parse($periodeAktif->tanggal_selesai);
                                    $daysLeft = \Carbon\Carbon::now()->diffInDays($end, false);
                                @endphp
                                <div class="mt-3">
                                    <div class="text-3xl font-bold">{{ max(0, round($daysLeft)) }} <span class="text-lg font-medium text-indigo-200">Hari</span></div>
                                    <p class="text-xs text-indigo-200 mt-1">Sisa waktu penilaian</p>
                                </div>
                            @else
                                <a href="{{ route('periode.create') }}" class="mt-3 inline-block bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded text-xs font-bold transition">
                                    + Buat Periode
                                </a>
                            @endif
                        </div>
                        {{-- Hiasan --}}
                        <div class="absolute right-0 bottom-0 -mb-6 -mr-6 opacity-20">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- 2. TABEL FEED PENILAIAN TERBARU (FULL WIDTH + PAGINATION) --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">Feed Penilaian Terbaru</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar formulir penilaian yang baru saja disubmit oleh Manajer.</p>
                        </div>
                        <a href="{{ route('penilaian.laporan') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua Laporan &rarr;</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Karyawan</th>
                                    <th scope="col" class="px-6 py-4">Divisi</th>
                                    <th scope="col" class="px-6 py-4">Dinilai Oleh</th>
                                    <th scope="col" class="px-6 py-4">Waktu Submit</th>
                                    <th scope="col" class="px-6 py-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($latestPenilaian as $penilaian)
                                <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 transition">
                                    {{-- Karyawan --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                                {{ substr($penilaian->karyawan->nama_lengkap ?? 'X', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $penilaian->karyawan->nama_lengkap ?? '-' }}</div>
                                                <div class="text-xs text-gray-500">NIK: {{ $penilaian->karyawan->nik ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    {{-- Divisi --}}
                                    <td class="px-6 py-4">
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                            {{ $penilaian->karyawan->divisi->nama_divisi ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- Penilai --}}
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $penilaian->penilai->name ?? 'System' }}
                                    </td>

                                    {{-- Waktu --}}
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $penilaian->created_at->format('d M Y, H:i') }} <br>
                                        <span class="text-xs text-gray-400">{{ $penilaian->created_at->diffForHumans() }}</span>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center text-green-600 bg-green-50 px-2 py-1 rounded-full border border-green-100 w-fit mx-auto">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="text-xs font-bold">Sukses</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                            <p>Belum ada data penilaian di periode ini.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION LINKS --}}
                    @if($latestPenilaian instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                            {{ $latestPenilaian->links() }}
                        </div>
                    @endif
                </div>

            {{-- ======================= DASHBOARD MANAJER ======================= --}}
            @elseif(Auth::user()->role === 'Manajer')
                
                {{-- KARTU INFO MANAJER --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                        <div class="relative z-10">
                            <p class="text-indigo-100 text-sm font-medium mb-1">Divisi Anda</p>
                            <h3 class="text-2xl font-bold">{{ $myDivisi->nama_divisi ?? 'Belum Ditentukan' }}</h3>
                            <div class="mt-6 flex items-center gap-4">
                                <div><span class="block text-3xl font-bold">{{ $stats['total_staff'] }}</span><span class="text-xs text-indigo-200">Total Anggota</span></div>
                                <div class="h-8 w-px bg-indigo-400/50"></div>
                                <div><span class="block text-3xl font-bold">{{ $stats['belum_dinilai'] }}</span><span class="text-xs text-indigo-200">Belum Dinilai</span></div>
                            </div>
                        </div>
                        <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-4 translate-y-4"><svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg></div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Periode Evaluasi</h4>
                        @if($periodeAktif)
                            <div class="mt-2">
                                <span class="text-xl font-bold text-gray-800 dark:text-white block">{{ $periodeAktif->nama_periode }}</span>
                                <div class="mt-2 flex items-center gap-2"><span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 animate-pulse">Sedang Berlangsung</span></div>
                                <p class="text-xs text-gray-500 mt-4">Deadline: <span class="font-medium text-red-500">{{ \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->format('d M Y') }}</span></p>
                            </div>
                        @else
                            <div class="mt-4 flex flex-col items-center justify-center text-center h-32 text-gray-400"><svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><p class="text-sm">Tidak ada periode aktif.</p></div>
                        @endif
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-center">
                        <h4 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-4">Penyelesaian Penilaian</h4>
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div><span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200 dark:bg-blue-900 dark:text-blue-300">Progress</span></div>
                                <div class="text-right"><span class="text-xs font-semibold inline-block text-blue-600 dark:text-blue-400">{{ $stats['progress'] }}%</span></div>
                            </div>
                            <div class="overflow-hidden h-4 mb-4 text-xs flex rounded bg-blue-100 dark:bg-gray-700"><div style="width:{{ $stats['progress'] }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500"></div></div>
                            <p class="text-xs text-center text-gray-500">{{ $stats['sudah_dinilai'] }} dari {{ $stats['total_staff'] }} karyawan selesai dinilai.</p>
                        </div>
                    </div>
                </div>

                {{-- TABEL ANGGOTA TIM --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Daftar Anggota Tim</h3>
                        <div class="flex gap-3 text-xs"><span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> Sudah Dinilai</span><span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-gray-300"></span> Belum</span></div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"><tr><th scope="col" class="px-6 py-4">Nama Karyawan</th><th scope="col" class="px-6 py-4 text-center">Status Periode Ini</th><th scope="col" class="px-6 py-4 text-right">Aksi</th></tr></thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($staffList as $staff)
                                <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 transition">
                                    <td class="px-6 py-4 flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold overflow-hidden">
                                            @if($staff->foto) <img src="{{ asset('storage/'.$staff->foto) }}" class="w-full h-full object-cover"> @else {{ substr($staff->nama, 0, 1) }} @endif
                                        </div>
                                        <div><div class="text-base font-semibold text-gray-900 dark:text-white">{{ $staff->nama }}</div><div class="text-xs text-gray-500">NIK: {{ $staff->nik }}</div></div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($staff->status_penilaian == 'Sudah')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Selesai</span>
                                            <div class="text-[10px] text-gray-400 mt-1">{{ \Carbon\Carbon::parse($staff->tanggal_dinilai)->format('d M H:i') }}</div>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($periodeAktif)
                                            @if($staff->status_penilaian == 'Sudah')
                                                <a href="{{ route('penilaian.index') }}" class="text-indigo-600 hover:text-indigo-900 dark:hover:text-indigo-400 text-sm font-medium mr-2 flex items-center justify-end gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> Lihat Detail</a>
                                            @else
                                                <a href="{{ route('penilaian.create', ['karyawan_id' => $staff->id_karyawan]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md shadow-blue-500/30"><svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Input Nilai</a>
                                            @endif
                                        @else
                                            <span class="text-xs text-gray-400 italic">Periode Tutup</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400"><p>Tidak ada anggota tim.</p></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            {{-- ======================= DASHBOARD KARYAWAN ======================= --}}
            @else
                {{-- (Kode Karyawan Sama) --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10"><svg class="w-32 h-32 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg></div>
                        <div class="relative z-10 flex items-center gap-6">
                            <div class="flex-shrink-0"><div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 p-1"><div class="w-full h-full rounded-full bg-white dark:bg-gray-800 overflow-hidden flex items-center justify-center">@if($karyawan && $karyawan->foto) <img src="{{ asset('storage/'.$karyawan->foto) }}" class="w-full h-full object-cover"> @else <span class="text-2xl font-bold text-blue-600">{{ substr(Auth::user()->name, 0, 1) }}</span> @endif</div></div></div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $karyawan->nama_lengkap ?? Auth::user()->name }}</h3>
                                <div class="flex flex-wrap gap-3 mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-1 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 00-2-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .883-.393 1.627-1 2.133m4-2.133c.607.506 1 1.25 1 2.133"></path></svg> {{ $karyawan->divisi->nama_divisi ?? 'Tanpa Divisi' }}</span>
                                    <span class="flex items-center gap-1 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 00-2-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .883-.393 1.627-1 2.133m4-2.133c.607.506 1 1.25 1 2.133"></path></svg> NIK: {{ $karyawan->nik ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br {{ $stats['status_periode_ini'] == 'Selesai' ? 'from-emerald-500 to-green-600' : 'from-orange-400 to-red-500' }} rounded-2xl p-6 text-white shadow-lg flex flex-col justify-center relative overflow-hidden">
                        <div class="relative z-10">
                            <p class="text-white/80 text-sm font-medium mb-1">Status Periode: {{ $periodeAktif->nama_periode ?? 'Nonaktif' }}</p>
                            @if(!$periodeAktif) <h3 class="text-2xl font-bold">Tidak Ada Jadwal</h3> @elseif($stats['status_periode_ini'] == 'Selesai') <h3 class="text-2xl font-bold">Sudah Dinilai</h3> @else <h3 class="text-2xl font-bold">Menunggu</h3> @endif
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700"><h3 class="text-lg font-bold text-gray-800 dark:text-white">Riwayat Penilaian Kinerja</h3></div>
                    <div class="overflow-x-auto"><table class="w-full text-sm text-left text-gray-500"><thead class="text-xs text-gray-700 uppercase bg-gray-50"><tr><th class="px-6 py-4">Periode</th><th class="px-6 py-4">Status</th></tr></thead><tbody>@foreach($riwayatPenilaian as $riwayat)<tr><td class="px-6 py-4">{{ $riwayat->periode->nama_periode }}</td><td class="px-6 py-4">Selesai</td></tr>@endforeach</tbody></table></div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>