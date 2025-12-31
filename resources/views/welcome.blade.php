<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'MDP KPI System') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 selection:bg-blue-500 selection:text-white">

        <div class="relative min-h-screen flex flex-col justify-between overflow-hidden">
            
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
                <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-blue-400/20 rounded-full blur-[100px] animate-pulse"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-[100px]"></div>
            </div>

            <nav class="relative z-10 w-full px-6 py-6 md:px-12 flex justify-between items-center">
                <div class="flex items-center gap-2 font-black text-2xl tracking-tighter text-blue-600 dark:text-blue-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    MDP KPI SYSTEM
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="hidden md:block font-semibold text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white transition">Log in</a>
                        @endauth
                    @endif
                </div>
            </nav>

            <main class="relative z-10 flex-grow flex items-center py-12 lg:py-20">
                <div class="max-w-7xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    
                    <div class="text-center lg:text-left mt-8 lg:mt-0">
                        <div class="inline-block px-4 py-1.5 mb-6 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 text-xs font-bold uppercase tracking-wide border border-blue-200 dark:border-blue-800">
                            🚀 Performance Management System v1.0
                        </div>
                        <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight mb-6 leading-tight">
                            Track Performance, <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Achieve Goals.</span>
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                            Sistem KPI modern untuk memantau kinerja karyawan secara real-time. Kelola target, input aktivitas harian, dan evaluasi hasil dalam satu platform terintegrasi.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('login') }}" class="px-8 py-4 rounded-xl bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold text-lg hover:scale-105 transition transform shadow-xl">
                                Masuk Aplikasi &rarr;
                            </a>
                        </div>
                    </div>

                    <div class="relative hidden lg:block">
                        <div class="relative z-20 bg-white/70 dark:bg-gray-800/60 backdrop-blur-xl border border-white/20 dark:border-gray-700 p-6 rounded-2xl shadow-2xl transform rotate-[-2deg] hover:rotate-0 transition duration-500">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                </div>
                                <div class="h-2 w-20 bg-gray-200 dark:bg-gray-600 rounded-full"></div>
                            </div>
                            <div class="flex items-end justify-between gap-2 h-32 mb-4">
                                <div class="w-1/6 bg-blue-100 dark:bg-blue-900/30 h-[40%] rounded-t-md"></div>
                                <div class="w-1/6 bg-blue-200 dark:bg-blue-800/40 h-[60%] rounded-t-md"></div>
                                <div class="w-1/6 bg-blue-300 dark:bg-blue-700/50 h-[30%] rounded-t-md"></div>
                                <div class="w-1/6 bg-blue-400 dark:bg-blue-600/60 h-[80%] rounded-t-md"></div>
                                <div class="w-1/6 bg-blue-500 dark:bg-blue-500/70 h-[50%] rounded-t-md"></div>
                                <div class="w-1/6 bg-blue-600 dark:bg-blue-400 h-[90%] rounded-t-md shadow-lg shadow-blue-500/50"></div>
                            </div>
                            <div class="space-y-3">
                                <div class="h-3 w-full bg-gray-100 dark:bg-gray-700 rounded-full"></div>
                                <div class="h-3 w-3/4 bg-gray-100 dark:bg-gray-700 rounded-full"></div>
                            </div>
                        </div>

                        <div class="absolute -bottom-6 -right-6 z-30 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 animate-bounce">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 font-bold">Target Achieved</div>
                                    <div class="text-lg font-bold text-gray-800 dark:text-gray-100">100%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>

            <section id="features" class="relative z-10 py-12 border-t border-gray-200 dark:border-gray-800 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm">
                <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                    <div class="p-6 rounded-2xl hover:bg-white dark:hover:bg-gray-800 transition duration-300">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-lg flex items-center justify-center mb-4 mx-auto md:mx-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2">Real-time Monitoring</h3>
                        <p class="text-gray-500 text-sm">Pantau aktivitas tim dan progress KPI secara langsung melalui dashboard interaktif.</p>
                    </div>
                    <div class="p-6 rounded-2xl hover:bg-white dark:hover:bg-gray-800 transition duration-300">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 rounded-lg flex items-center justify-center mb-4 mx-auto md:mx-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2">Data Driven</h3>
                        <p class="text-gray-500 text-sm">Keputusan berbasis data akurat dari rekapitulasi nilai harian dan bulanan.</p>
                    </div>
                    <div class="p-6 rounded-2xl hover:bg-white dark:hover:bg-gray-800 transition duration-300">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 rounded-lg flex items-center justify-center mb-4 mx-auto md:mx-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2">Fair & Transparent</h3>
                        <p class="text-gray-500 text-sm">Sistem penilaian yang transparan antara Manajer dan Karyawan sesuai standar perusahaan.</p>
                    </div>
                </div>
            </section>

            <footer class="py-6 text-center text-sm text-gray-400 dark:text-gray-600 relative z-10">
                &copy; {{ date('Y') }} KPI System by Djali Suandre. All rights reserved.
            </footer>

        </div>
    </body>
</html>