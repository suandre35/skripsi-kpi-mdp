<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Ditolak - Sistem KPI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-200 antialiased h-screen flex flex-col items-center justify-center p-6">

    <div class="text-center max-w-xl mx-auto">
        <h1 class="text-9xl font-black text-gray-200 dark:text-gray-700 tracking-tighter">
            403
        </h1>

        <div class="relative -mt-12 px-6">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
                <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    {{-- Icon Gembok --}}
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    Akses Ditolak
                </h2>
                
                <p class="text-gray-500 dark:text-gray-400 mb-6">
                    Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi Administrator jika ini adalah kesalahan.
                </p>

                <div class="flex justify-center">
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-lg bg-red-600 text-white hover:bg-red-700 transition font-medium text-sm shadow-lg shadow-red-500/30">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <p class="mt-8 text-xs text-gray-400 uppercase tracking-widest font-semibold">
            Sistem Informasi KPI © {{ date('Y') }}
        </p>
    </div>
</body>
</html>