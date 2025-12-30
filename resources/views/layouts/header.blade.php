<header class="sticky top-0 z-40 flex w-full bg-white drop-shadow-1 dark:bg-gray-800 dark:drop-shadow-none border-b border-gray-200 dark:border-gray-700 h-16">
    <div class="flex flex-grow items-center justify-between px-4 py-4 shadow-2 md:px-6 2xl:px-11">
        
        {{-- HAMBURGER MENU (MOBILE) --}}
        <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
            <button @click.stop="sidebarOpen = !sidebarOpen" 
                    class="z-50 block rounded-sm border border-stroke bg-white p-1.5 shadow-sm dark:border-strokedark dark:bg-boxdark lg:hidden">
                <span class="relative block h-5.5 w-5.5 cursor-pointer">
                    <svg class="w-6 h-6 text-gray-700 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </span>
            </button>
        </div>

        {{-- HEADER TITLE --}}
        <div class="hidden sm:block">
            @if (isset($header))
                <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-white">
                    {{ $header }}
                </h2>
            @endif
        </div>

        {{-- RIGHT SIDE ICONS & PROFILE --}}
        <div class="flex items-center gap-3 sm:gap-6"> 
            
            {{-- THEME TOGGLE --}}
            <button @click="toggleTheme()" class="relative flex h-8.5 w-8.5 items-center justify-center rounded-full border-[0.5px] border-gray-200 bg-gray-100 text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                <span x-show="darkMode" class="absolute">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </span>
                <span x-show="!darkMode" class="absolute">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </span>
            </button>
            
            <span class="h-8 w-[1px] bg-gray-200 dark:bg-gray-700"></span>

            {{-- PROFILE DROPDOWN --}}
            <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                <a class="flex items-center gap-4 cursor-pointer" href="#" @click.prevent="dropdownOpen = !dropdownOpen">
                    
                    {{-- 1. DATA USER --}}
                    @php
                        $user = Auth::user();
                        $karyawan = $user->karyawan ?? null; 
                        $foto = $karyawan->foto ?? null;
                        $nama = $user->name;
                    @endphp

                    {{-- 2. TEXT NAMA & EMAIL --}}
                    <span class="hidden text-right lg:block">
                        <span class="block text-sm font-medium text-black dark:text-white">{{ $nama }}</span>
                        <span class="block text-xs text-gray-500 font-medium">{{ $user->email }}</span>
                    </span>

                    {{-- 3. LOGIKA FOTO PROFIL / INISIAL --}}
                    @if($foto && Storage::disk('public')->exists($foto))
                        {{-- JIKA ADA FOTO --}}
                        <img class="h-10 w-10 rounded-full object-cover border border-gray-200 dark:border-gray-600 shadow-sm" 
                             src="{{ asset('storage/' . $foto) }}" 
                             alt="{{ $nama }}">
                    @else
                        {{-- JIKA TIDAK ADA FOTO (Pakai Inisial Gradient Biru) --}}
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600 border border-blue-200 flex items-center justify-center font-bold text-sm shadow-sm">
                            {{ substr($nama, 0, 1) }}
                        </div>
                    @endif
                    
                    {{-- ARROW ICON --}}
                    <svg :class="dropdownOpen && 'rotate-180'" class="hidden fill-current sm:block w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>

                {{-- DROPDOWN CONTENT --}}
                <div x-show="dropdownOpen" 
                     class="absolute right-0 mt-4 w-48 rounded border border-gray-200 bg-white py-2 shadow-card dark:border-gray-700 dark:bg-gray-800 z-50"
                     style="display: none;"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
                    
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3.5 px-6 py-2 text-sm font-medium duration-300 ease-in-out hover:text-blue-600 lg:text-base text-gray-700 dark:text-gray-200">
                        Profile
                    </a>
                    <hr class="border-gray-200 dark:border-gray-700 my-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3.5 px-6 py-2 text-sm font-medium duration-300 ease-in-out hover:text-red-600 lg:text-base text-gray-700 dark:text-gray-200">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>