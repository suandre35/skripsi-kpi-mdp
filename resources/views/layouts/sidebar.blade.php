<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="absolute left-0 top-0 z-50 flex h-screen w-64 flex-col overflow-y-hidden bg-white dark:bg-gray-800 duration-300 ease-linear lg:static lg:translate-x-0 border-r border-gray-200 dark:border-gray-700 shadow-lg lg:shadow-none">
    
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5 bg-blue-600 dark:bg-gray-900 text-white h-16">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-bold text-xl tracking-wider">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            KPI SYSTEM
        </a>
        <button @click.stop="sidebarOpen = !sidebarOpen" class="block lg:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <div class="flex flex-col overflow-y-auto duration-300 ease-linear">
        <nav class="mt-5 px-4 py-4 lg:mt-9 lg:px-6 space-y-2">
            
            <h3 class="mb-4 ml-4 text-xs font-bold uppercase text-gray-400">Menu Utama</h3>
            
            <a href="{{ route('dashboard') }}" 
               class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>


            @if(Auth::user()->role == 'HRD')

                <h3 class="mt-6 mb-4 ml-4 text-xs font-bold uppercase text-gray-400">Master Organisasi</h3>

                <a href="{{ route('users.index') }}" class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Manajemen User
                </a>

                <a href="{{ route('divisi.index') }}" class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('divisi.*') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Data Divisi
                </a>

                <a href="{{ route('karyawan.index') }}" class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('karyawan.*') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Data Karyawan
                </a>

                <h3 class="mt-6 mb-4 ml-4 text-xs font-bold uppercase text-gray-400">Master KPI</h3>

                <a href="{{ route('periode.index') }}" class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('periode.*') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Periode Evaluasi
                </a>

                <a href="{{ route('kategori.index') }}" class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('kategori.*') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Kategori KPI
                </a>

                <a href="{{ route('indikator.index') }}" class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('indikator.*') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Indikator KPI
                </a>
                
                <a href="{{ route('target.index') }}" class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('target.*') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Target KPI
                </a>

                <a href="{{ route('bobot.index') }}" class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('bobot.*') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                     Bobot KPI
                 </a>

                <h3 class="mt-6 mb-4 ml-4 text-xs font-bold uppercase text-gray-400">Laporan & Analisa</h3>

                {{-- 1. Monitoring Global --}}
                <a href="{{ route('admin.monitoring.index') }}" class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('admin.monitoring.*') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Monitoring Realisasi
                </a>

                {{-- 2. Ranking Kinerja (NEW) --}}
                <a href="{{ route('admin.ranking.index') }}" class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('admin.ranking.*') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    Ranking Kinerja
                </a>

            @endif


            @if(Auth::user()->role == 'Manajer')

                <h3 class="mt-6 mb-4 ml-4 text-xs font-bold uppercase text-gray-400">Aktivitas</h3>

                <a href="{{ route('penilaian.index') }}" class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('penilaian.index') || request()->routeIs('penilaian.create') || request()->routeIs('penilaian.edit') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Input Log Harian
                </a>

                <h3 class="mt-6 mb-4 ml-4 text-xs font-bold uppercase text-gray-400">Laporan Tim</h3>
                
                <a href="{{ route('penilaian.laporan') }}" class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('penilaian.laporan') || request()->routeIs('penilaian.detailLaporan') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    Rapor Kinerja Tim
                </a>

            @endif

            @if(Auth::user()->role == 'Karyawan')
                
                <h3 class="mt-6 mb-4 ml-4 text-xs font-bold uppercase text-gray-400">Menu Saya</h3>
                
                <a href="{{ route('karyawan.rapor') }}" class="group relative flex items-center gap-2.5 rounded-lg px-4 py-2 font-medium duration-300 ease-in-out {{ request()->routeIs('karyawan.rapor') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Rapor Saya
                </a>

            @endif

        </nav>
    </div>
</aside>