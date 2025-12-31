{{-- FILE: resources/views/components/modal-delete.blade.php --}}

<div x-show="showDeleteModal" 
     style="display: none;"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-black bg-opacity-50 backdrop-blur-sm"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    
    <div class="relative w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6 border border-gray-100 dark:border-gray-700"
         @click.away="showDeleteModal = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <div class="flex flex-col items-center text-center">
            {{-- Icon Warning --}}
            <div class="p-3 mb-4 rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>

            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Konfirmasi Hapus</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6 text-sm">
                Apakah Anda yakin ingin menghapus data ini? <br>
                Tindakan ini <strong>tidak dapat dibatalkan</strong>.
            </p>

            <div class="flex items-center gap-3 w-full">
                {{-- Tombol Batal --}}
                <button @click="showDeleteModal = false" type="button"
                        class="w-full px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-600 transition">
                    Batal
                </button>
                
                {{-- Form Delete Actual --}}
                <form :action="deleteUrl" method="POST" class="w-full">
                    @csrf @method('DELETE')
                    <button type="submit" 
                            class="w-full px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 transition shadow-lg shadow-red-500/30">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>