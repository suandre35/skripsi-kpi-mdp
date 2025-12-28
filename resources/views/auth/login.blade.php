<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'KPI System') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <div class="min-h-screen flex">
        
        <div class="hidden lg:flex w-1/2 relative items-center justify-center bg-gray-900 overflow-hidden">
            
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1600" 
                 alt="Office Background" 
                 class="absolute inset-0 w-full h-full object-cover opacity-40">
            
            <div class="absolute inset-0 bg-gradient-to-tr from-blue-900/90 to-purple-900/80"></div>

            <div class="relative z-10 p-12 text-white max-w-lg">
                <div class="mb-6">
                    <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-500/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h2 class="text-4xl font-extrabold tracking-tight mb-4">MDP KPI SYSTEM</h2>
                    <p class="text-blue-100 text-lg leading-relaxed">
                        Kelola kinerja tim, pantau pencapaian target, dan evaluasi hasil secara transparan dan akurat dalam satu platform terintegrasi.
                    </p>
                </div>
                
                <div class="border-l-4 border-blue-400 pl-4 mt-8">
                    <p class="italic text-gray-300">"Data-driven decisions lead to better performance."</p>
                </div>
            </div>

            <div class="absolute -bottom-24 -left-24 w-64 h-64 rounded-full bg-blue-600 blur-[100px] opacity-50"></div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50 dark:bg-gray-900">
            <div class="w-full max-w-md bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
                
                <div class="text-center mb-10">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Selamat Datang Kembali! 👋</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Masuk ke akun Anda untuk melanjutkan.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Perusahaan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-400" 
                                placeholder="nama@perusahaan.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-gray-400"
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 cursor-pointer" name="remember">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-bold text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg shadow-blue-500/30 transition duration-200 transform hover:-translate-y-0.5">
                        Masuk ke Dashboard &rarr;
                    </button>
                    
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Belum punya akun? <span class="text-gray-400">Hubungi HRD.</span>
                        </p>
                    </div>
                </form>
            </div>
            
            <p class="absolute bottom-6 text-xs text-gray-400">
                &copy; {{ date('Y') }} KPI System Enterprise.
            </p>
        </div>
    </div>

</body>
</html>