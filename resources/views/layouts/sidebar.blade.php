<aside 
    class="flex flex-col h-screen border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 transition-all duration-300 ease-in-out z-50 flex-shrink-0 absolute lg:relative"
    :class="{
        'translate-x-0': sidebarOpen,
        '-translate-x-full': !sidebarOpen,
        'lg:translate-x-0': true,
        'w-72': isSidebarExpanded,
        'w-20': !isSidebarExpanded
    }"
>
    
    {{-- ================= HEADER SIDEBAR (LOGO) ================= --}}
    {{-- Flex-shrink-0 agar header tidak mengecil saat discroll --}}
    <div class="flex items-center h-16 border-b border-gray-100 dark:border-gray-800 transition-all duration-300 flex-shrink-0 relative"
         :class="isSidebarExpanded ? 'px-6 justify-between' : 'px-0 justify-center'">
        
        {{-- Logo Area --}}
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden whitespace-nowrap">
            {{-- Logo Icon --}}
            <div class="w-9 h-9 min-w-[2.25rem] rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            
            {{-- Logo Text (Hilang saat collapse) --}}
            <div x-show="isSidebarExpanded" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-x-2"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 class="flex flex-col">
                <span class="font-bold text-lg tracking-tight text-gray-800 dark:text-white leading-tight">KPI SYSTEM</span>
                <span class="text-[10px] font-medium text-gray-400 uppercase tracking-widest">Enterprise</span>
            </div>
        </a>

        {{-- TOMBOL TOGGLE DESKTOP (POSISI DIPERBAIKI) --}}
        {{-- Absolute di luar container, tapi karena parent tidak overflow-hidden, dia akan muncul --}}
        <button @click="toggleSidebar()" 
                class="hidden lg:flex absolute -right-3 top-14 items-center justify-center w-6 h-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-gray-500 hover:text-blue-600 hover:border-blue-500 shadow-sm transition-all duration-200 transform z-50 cursor-pointer"
                :class="isSidebarExpanded ? 'rotate-0' : 'rotate-180'">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        {{-- Tombol Close (Mobile Only) --}}
        <button @click.stop="sidebarOpen = false" class="block lg:hidden absolute right-4 text-gray-500 hover:text-red-500 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    
    {{-- ================= MENU LINKS (SCROLLABLE AREA) ================= --}}
    {{-- Overflow ditaruh di sini agar tombol toggle di atas tidak ikut terpotong --}}
    <div class="flex-1 overflow-y-auto overflow-x-hidden no-scrollbar py-4 hover:overflow-y-auto">
        
        <nav class="space-y-1 transition-all duration-300" :class="isSidebarExpanded ? 'px-4' : 'px-2'"> 
            
            @php
                $activeClass = 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 font-semibold';
                $inactiveClass = 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-blue-600';
                $iconActive = 'text-blue-600 dark:text-blue-400';
                $iconInactive = 'text-gray-400 group-hover:text-blue-600';
            @endphp

            {{-- === MENU UTAMA === --}}
            <div class="mb-4">
                <div x-show="isSidebarExpanded" class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider transition-opacity duration-300">
                    Menu Utama
                </div>
                {{-- Divider saat collapsed --}}
                <div x-show="!isSidebarExpanded" class="h-px bg-gray-100 dark:bg-gray-800 mx-2 mb-2"></div>

                <a href="{{ route('dashboard') }}" 
                   class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}"
                   :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'"
                   title="Dashboard">
                    
                    <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('dashboard') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    
                    <span x-show="isSidebarExpanded" class="whitespace-nowrap transition-opacity duration-200">Dashboard</span>
                    
                    {{-- Tooltip Hover saat Collapsed --}}
                    <div x-show="!isSidebarExpanded" class="absolute left-12 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50 whitespace-nowrap shadow-lg">
                        Dashboard
                    </div>
                </a>
            </div>

            @if(Auth::user()->role == 'HRD')
                {{-- === MASTER ORGANISASI === --}}
                <div class="mb-4">
                    <div x-show="isSidebarExpanded" class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider transition-opacity duration-300">Master Organisasi</div>
                    <div x-show="!isSidebarExpanded" class="h-px bg-gray-100 dark:bg-gray-800 mx-2 mb-2"></div>

                    <a href="{{ route('users.index') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('users.*') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('users.*') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Manajemen User</span>
                    </a>

                    <a href="{{ route('divisi.index') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('divisi.*') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('divisi.*') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Data Divisi</span>
                    </a>

                    <a href="{{ route('karyawan.index') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('karyawan.*') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('karyawan.*') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Data Karyawan</span>
                    </a>
                </div>

                {{-- === MASTER KPI === --}}
                <div class="mb-4">
                    <div x-show="isSidebarExpanded" class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider transition-opacity duration-300">Master KPI</div>
                    <div x-show="!isSidebarExpanded" class="h-px bg-gray-100 dark:bg-gray-800 mx-2 mb-2"></div>

                    <a href="{{ route('kategori.index') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('kategori.*') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('kategori.*') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Kategori KPI</span>
                    </a>

                    <a href="{{ route('indikator.index') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('indikator.*') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('indikator.*') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Indikator KPI</span>
                    </a>
                    
                    <a href="{{ route('bobot.index') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('bobot.*') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('bobot.*') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Bobot KPI</span>
                    </a>

                    <a href="{{ route('target.index') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('target.*') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('target.*') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Target KPI</span>
                    </a>

                    <a href="{{ route('periode.index') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('periode.*') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('periode.*') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Periode Evaluasi</span>
                    </a>
                </div>

                {{-- === LAPORAN & ANALISA === --}}
                <div class="mb-4">
                    <div x-show="isSidebarExpanded" class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider transition-opacity duration-300">Laporan & Analisa</div>
                    <div x-show="!isSidebarExpanded" class="h-px bg-gray-100 dark:bg-gray-800 mx-2 mb-2"></div>

                    <a href="{{ route('admin.laporan.index') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('admin.laporan.*') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('admin.laporan.*') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Laporan Evaluasi</span>
                    </a>

                    <a href="{{ route('admin.ranking.index') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('admin.ranking.*') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('admin.ranking.*') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Ranking Kinerja</span>
                    </a>
                </div>

                {{-- === KEAMANAN & AUDIT === --}}
                <div class="mb-4">
                    <div x-show="isSidebarExpanded" class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider transition-opacity duration-300">Keamanan & Audit</div>
                    <div x-show="!isSidebarExpanded" class="h-px bg-gray-100 dark:bg-gray-800 mx-2 mb-2"></div>

                    <a href="{{ route('keamanan.riwayat') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('keamanan.riwayat') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('keamanan.riwayat') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Riwayat Penilaian</span>
                    </a>

                    <a href="{{ route('keamanan.aktivitas') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('keamanan.aktivitas') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('keamanan.aktivitas') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Aktivitas User</span>
                    </a>
                </div>
            @endif

            @if(Auth::user()->role == 'Manajer')
                <div class="mb-4">
                    <div x-show="isSidebarExpanded" class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider transition-opacity duration-300">Aktivitas</div>
                    <div x-show="!isSidebarExpanded" class="h-px bg-gray-100 dark:bg-gray-800 mx-2 mb-2"></div>

                    <a href="{{ route('penilaian.index') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('penilaian.index') || request()->routeIs('penilaian.create') || request()->routeIs('penilaian.edit') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('penilaian.index') || request()->routeIs('penilaian.create') || request()->routeIs('penilaian.edit') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Input Log Harian</span>
                    </a>
                </div>

                <div class="mb-4">
                    <div x-show="isSidebarExpanded" class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider transition-opacity duration-300">Laporan Tim</div>
                    <div x-show="!isSidebarExpanded" class="h-px bg-gray-100 dark:bg-gray-800 mx-2 mb-2"></div>
                    
                    <a href="{{ route('penilaian.laporan') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('penilaian.laporan') || request()->routeIs('penilaian.detailLaporan') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('penilaian.laporan') || request()->routeIs('penilaian.detailLaporan') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Rapor Kinerja Tim</span>
                    </a>
                </div>
            @endif

            @if(Auth::user()->role == 'Karyawan')
                <div class="mb-4">
                    <div x-show="isSidebarExpanded" class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider transition-opacity duration-300">Menu Saya</div>
                    <div x-show="!isSidebarExpanded" class="h-px bg-gray-100 dark:bg-gray-800 mx-2 mb-2"></div>
                    
                    <a href="{{ route('karyawan.rapor') }}" class="group relative flex items-center gap-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1 {{ request()->routeIs('karyawan.rapor') ? $activeClass : $inactiveClass }}" :class="isSidebarExpanded ? 'px-3 justify-start' : 'px-0 justify-center h-10 w-10 mx-auto'">
                        <svg class="w-5 h-5 min-w-[1.25rem] transition-colors {{ request()->routeIs('karyawan.rapor') ? $iconActive : $iconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2-2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        <span x-show="isSidebarExpanded" class="whitespace-nowrap">Rapor Saya</span>
                    </a>
                </div>
            @endif

        </nav>
    </div>
</aside>