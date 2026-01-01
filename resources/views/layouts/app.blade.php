<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KPI System') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
      x-data="{ 
          sidebarOpen: false, 
          isSidebarExpanded: localStorage.getItem('sidebarExpanded') === null ? true : localStorage.getItem('sidebarExpanded') === 'true',
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          
          toggleTheme() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
              if (this.darkMode) document.documentElement.classList.add('dark');
              else document.documentElement.classList.remove('dark');
          },
          
          toggleSidebar() {
              this.isSidebarExpanded = !this.isSidebarExpanded;
              localStorage.setItem('sidebarExpanded', this.isSidebarExpanded);
          }
      }"
      x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')); 
              if(darkMode) document.documentElement.classList.add('dark');"
>

    {{-- WRAPPER UTAMA: Flex Row agar Sidebar & Konten berdampingan --}}
    <div class="flex h-screen overflow-hidden">
        
        {{-- Sidebar Component --}}
        @include('layouts.sidebar')

        {{-- Main Content Wrapper --}}
        {{-- flex-1: Mengambil sisa ruang yang tersedia setelah sidebar --}}
        {{-- min-w-0: Mencegah flex item tumpah keluar layar --}}
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden transition-all duration-300 ease-in-out">
            
            {{-- Header/Navbar Component --}}
            @include('layouts.header')

            {{-- Page Content (Scrollable Area) --}}
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-6">
                {{ $slot }}
            </main>
        </div>
        
    </div>
</body>
</html>