<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Tidak Ditemukan - Sistem KPI</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-200 antialiased h-screen flex flex-col items-center justify-center p-6">

    <div class="text-center max-w-xl mx-auto">
        {{-- Ilustrasi Angka Besar --}}
        <h1 class="text-9xl font-black text-gray-200 dark:text-gray-700 tracking-tighter">
            404
        </h1>

        {{-- Pesan Utama --}}
        <div class="relative -mt-12 px-6">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    Halaman Tidak Ditemukan
                </h2>
                
                <p class="text-gray-500 dark:text-gray-400 mb-6">
                    Maaf, halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau sementara tidak tersedia.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    {{-- Tombol Back --}}
                    <button onclick="history.back()" class="px-5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium text-sm">
                        Kembali
                    </button>

                    {{-- Tombol Home --}}
                    <a href="{{ url('/') }}" class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium text-sm shadow-lg shadow-blue-500/30">
                        Ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>

        {{-- Footer Kecil --}}
        <p class="mt-8 text-xs text-gray-400 uppercase tracking-widest font-semibold">
            Sistem Informasi KPI © {{ date('Y') }}
        </p>
    </div>

</body>
</html>