<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kesalahan Server - Sistem KPI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-200 antialiased h-screen flex flex-col items-center justify-center p-6">

    <div class="text-center max-w-xl mx-auto">
        <h1 class="text-9xl font-black text-gray-200 dark:text-gray-700 tracking-tighter">
            500
        </h1>

        <div class="relative -mt-12 px-6">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
                <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    {{-- Icon Petir/Listrik --}}
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    Terjadi Kesalahan Server
                </h2>
                
                <p class="text-gray-500 dark:text-gray-400 mb-6">
                    Sistem sedang mengalami gangguan teknis. Kami sedang bekerja untuk memperbaikinya. Silakan coba beberapa saat lagi.
                </p>

                <div class="flex justify-center">
                    <button onclick="window.location.reload()" class="px-5 py-2.5 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600 transition font-medium text-sm shadow-lg shadow-yellow-500/30">
                        Refresh Halaman
                    </button>
                </div>
            </div>
        </div>
        
        <p class="mt-8 text-xs text-gray-400 uppercase tracking-widest font-semibold">
            Sistem Informasi KPI © {{ date('Y') }}
        </p>
    </div>
</body>
</html>