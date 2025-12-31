<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }} - {{ Auth::user()->role }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- JIKA ROLE HRD --}}
            @if(Auth::user()->role === 'HRD')
                
                {{-- 1. KARTU STATISTIK --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    {{-- Total Karyawan --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-md transition">
                        <div class="relative z-10">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Karyawan</p>
                            <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['total_karyawan'] }}</h3>
                            <div class="mt-2 text-xs text-blue-600 dark:text-blue-400 font-medium">
                                Data Master Aktif
                            </div>
                        </div>
                        <div class="absolute right-4 top-4 p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>

                    {{-- Sudah Dinilai --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-md transition">
                        <div class="relative z-10">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sudah Dinilai</p>
                            <h3 class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">{{ $stats['sudah_dinilai'] }}</h3>
                            <div class="mt-2 text-xs text-emerald-600 font-medium">
                                Karyawan Selesai
                            </div>
                        </div>
                        <div class="absolute right-4 top-4 p-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>

                    {{-- Belum Dinilai --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-md transition">
                        <div class="relative z-10">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum Dinilai</p>
                            <h3 class="text-3xl font-bold text-orange-600 dark:text-orange-400 mt-2">{{ $stats['belum_dinilai'] }}</h3>
                            <div class="mt-2 text-xs text-orange-600 font-medium">
                                Menunggu Penilaian
                            </div>
                        </div>
                        <div class="absolute right-4 top-4 p-2 bg-orange-50 dark:bg-orange-900/20 rounded-lg text-orange-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>

                    {{-- Periode Aktif --}}
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 shadow-lg text-white relative overflow-hidden">
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Periode Aktif</p>
                                <h3 class="text-lg font-bold mt-1 truncate">
                                    {{ $periodeAktif->nama_periode ?? 'Tidak Ada' }}
                                </h3>
                            </div>
                            @if($periodeAktif)
                                @php
                                    $end = \Carbon\Carbon::parse($periodeAktif->tanggal_selesai);
                                    $daysLeft = \Carbon\Carbon::now()->diffInDays($end, false);
                                @endphp
                                <div class="mt-3">
                                    <div class="text-2xl font-bold">{{ max(0, round($daysLeft)) }} Hari</div>
                                    <p class="text-xs text-blue-200">Sisa waktu penilaian</p>
                                </div>
                            @else
                                <a href="{{ route('periode.create') }}" class="mt-3 inline-block bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded text-xs font-bold transition">
                                    + Buat Periode
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- 2. GRAFIK & LIST --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- Grafik Partisipasi --}}
                    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Progress Penilaian Per Divisi</h3>
                        <div class="relative h-72 w-full">
                            @if(empty($chartData['labels']))
                                <div class="flex items-center justify-center h-full text-gray-400 flex-col">
                                    <p>Belum ada data penilaian.</p>
                                </div>
                            @else
                                <canvas id="participationChart"></canvas>
                            @endif
                        </div>
                    </div>

                    {{-- List Penilaian Terbaru --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Penilaian Terbaru Masuk</h3>
                        <div class="space-y-4">
                            @forelse($stats['latest_assessments'] as $header)
                                <div class="flex items-start gap-3 pb-3 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                        {{ substr($header->karyawan->nama_lengkap ?? 'X', 0, 1) }}
                                    </div>
                                    <div class="flex-grow min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $header->karyawan->nama_lengkap ?? '-' }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Divisi: {{ $header->karyawan->divisi->nama_divisi ?? '-' }}
                                        </p>
                                        <p class="text-[10px] text-gray-400 mt-1">
                                            Dinilai oleh: {{ $header->penilai->name ?? 'System' }} <br>
                                            {{ $header->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500 text-sm">
                                    Belum ada data.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            @elseif(Auth::user()->role === 'Manajer')
                
                {{-- 1. INFO DIVISI & PROGRESS --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    {{-- Kartu Divisi Saya --}}
                    <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                        <div class="relative z-10">
                            <p class="text-indigo-100 text-sm font-medium mb-1">Divisi Anda</p>
                            <h3 class="text-2xl font-bold">{{ $myDivisi->nama_divisi ?? 'Belum Ditentukan' }}</h3>
                            
                            <div class="mt-6 flex items-center gap-4">
                                <div>
                                    <span class="block text-3xl font-bold">{{ $stats['total_staff'] }}</span>
                                    <span class="text-xs text-indigo-200">Total Anggota</span>
                                </div>
                                <div class="h-8 w-px bg-indigo-400/50"></div>
                                <div>
                                    <span class="block text-3xl font-bold">{{ $stats['belum_dinilai'] }}</span>
                                    <span class="text-xs text-indigo-200">Belum Dinilai</span>
                                </div>
                            </div>
                        </div>
                        {{-- Hiasan --}}
                        <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-4 translate-y-4">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                        </div>
                    </div>

                    {{-- Kartu Status Periode --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Periode Evaluasi</h4>
                        @if($periodeAktif)
                            <div class="mt-2">
                                <span class="text-xl font-bold text-gray-800 dark:text-white block">{{ $periodeAktif->nama_periode }}</span>
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 animate-pulse">
                                        Sedang Berlangsung
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-4">
                                    Deadline: <span class="font-medium text-red-500">{{ \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->format('d M Y') }}</span>
                                </p>
                            </div>
                        @else
                            <div class="mt-4 flex flex-col items-center justify-center text-center h-32 text-gray-400">
                                <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-sm">Tidak ada periode aktif.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Kartu Progress Bar --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-center">
                        <h4 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-16">Penyelesaian Penilaian</h4>
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                    <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200 dark:bg-blue-900 dark:text-blue-300">
                                        Progress
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-semibold inline-block text-blue-600 dark:text-blue-400">
                                        {{ $stats['progress'] }}%
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-4 mb-4 text-xs flex rounded bg-blue-100 dark:bg-gray-700">
                                <div style="width:{{ $stats['progress'] }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500"></div>
                            </div>
                            <p class="text-xs text-center text-gray-500">
                                {{ $stats['sudah_dinilai'] }} dari {{ $stats['total_staff'] }} karyawan selesai dinilai.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- 2. TABEL ANGGOTA TIM (ACTION LIST) --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Daftar Anggota Tim</h3>
                        {{-- Legend --}}
                        <div class="flex gap-3 text-xs">
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> Sudah Dinilai</span>
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-gray-300"></span> Belum</span>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nama Karyawan</th>
                                    <th scope="col" class="px-6 py-4 text-center">Status Periode Ini</th>
                                    <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($staffList as $staff)
                                <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 transition">
                                    
                                    {{-- Nama --}}
                                    <td class="px-6 py-4 flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold overflow-hidden">
                                            @if($staff->foto)
                                                <img src="{{ asset('storage/'.$staff->foto) }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr($staff->nama, 0, 1) }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $staff->nama }}</div>
                                            <div class="text-xs text-gray-500">NIK: {{ $staff->nik }}</div>
                                        </div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($staff->status_penilaian == 'Sudah')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Selesai
                                            </span>
                                            <div class="text-[10px] text-gray-400 mt-1">
                                                {{ \Carbon\Carbon::parse($staff->tanggal_dinilai)->format('d M H:i') }}
                                            </div>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Menunggu
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4 text-right">
                                        @if($periodeAktif)
                                            @if($staff->status_penilaian == 'Sudah')
                                                {{-- Tombol Edit (Kuning/Biru) --}}
                                                {{-- Nanti ganti route('penilaian.edit', ...) --}}
                                                <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:hover:text-indigo-400 text-sm font-medium mr-2">
                                                    Edit Nilai
                                                </a>
                                            @else
                                                {{-- Tombol Input (Hijau & Menonjol) --}}
                                                {{-- Nanti ganti route('penilaian.create', ['karyawan' => ...]) --}}
                                                <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md shadow-blue-500/30">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    Input Nilai
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-xs text-gray-400 italic">Periode Tutup</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            <p>Tidak ada anggota tim di divisi ini.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @else
                
                {{-- 1. HEADER PROFIL & STATUS --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    {{-- Kartu Profil (2 Kolom) --}}
                    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <svg class="w-32 h-32 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                        </div>
                        
                        <div class="relative z-10 flex items-center gap-6">
                            {{-- Foto Profil --}}
                            <div class="flex-shrink-0">
                                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 p-1">
                                    <div class="w-full h-full rounded-full bg-white dark:bg-gray-800 overflow-hidden flex items-center justify-center">
                                        @if($karyawan && $karyawan->foto)
                                            <img src="{{ asset('storage/'.$karyawan->foto) }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-2xl font-bold text-blue-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Info Teks --}}
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $karyawan->nama_lengkap ?? Auth::user()->name }}</h3>
                                <div class="flex flex-wrap gap-3 mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-1 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .883-.393 1.627-1 2.133m4-2.133c.607.506 1 1.25 1 2.133"></path></svg>
                                        {{ $karyawan->divisi->nama_divisi ?? 'Tanpa Divisi' }}
                                    </span>
                                    <span class="flex items-center gap-1 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .883-.393 1.627-1 2.133m4-2.133c.607.506 1 1.25 1 2.133"></path></svg>
                                        NIK: {{ $karyawan->nik ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kartu Status Periode Ini --}}
                    <div class="bg-gradient-to-br {{ $stats['status_periode_ini'] == 'Selesai' ? 'from-emerald-500 to-green-600' : 'from-orange-400 to-red-500' }} rounded-2xl p-6 text-white shadow-lg flex flex-col justify-center relative overflow-hidden">
                        <div class="relative z-10">
                            <p class="text-white/80 text-sm font-medium mb-1">Status Periode: {{ $periodeAktif->nama_periode ?? 'Nonaktif' }}</p>
                            
                            @if(!$periodeAktif)
                                <h3 class="text-2xl font-bold">Tidak Ada Jadwal</h3>
                                <p class="text-xs text-white/70 mt-2">Belum ada evaluasi yang dibuka.</p>
                            @elseif($stats['status_periode_ini'] == 'Selesai')
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold">Sudah Dinilai</h3>
                                        <p class="text-xs text-white/80">Oleh: {{ $stats['penilai'] }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold">Menunggu</h3>
                                        <p class="text-xs text-white/80">Penilaian belum masuk.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- 2. TABEL RIWAYAT --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Riwayat Penilaian Kinerja</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Periode</th>
                                    <th scope="col" class="px-6 py-4">Tanggal Dinilai</th>
                                    <th scope="col" class="px-6 py-4">Penilai</th>
                                    <th scope="col" class="px-6 py-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse($riwayatPenilaian as $riwayat)
                                <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $riwayat->periode->nama_periode ?? 'Periode Dihapus' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $riwayat->created_at->format('d F Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $riwayat->penilai->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                            Selesai
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <p>Belum ada riwayat penilaian.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @endif

        </div>
    </div>

    {{-- Script Chart.js --}}
    @if(Auth::user()->role === 'HRD')
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('participationChart');
            
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($chartData['labels']),
                        datasets: [{
                            label: 'Jumlah Karyawan Dinilai',
                            data: @json($chartData['data']),
                            backgroundColor: 'rgba(59, 130, 246, 0.6)', 
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1 } },
                            x: { grid: { display: false } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }
        });
    </script>
    @endpush
    @endif
</x-app-layout>