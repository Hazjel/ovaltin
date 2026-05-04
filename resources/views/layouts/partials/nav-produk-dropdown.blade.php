<div class="relative inline-flex items-center px-1 pt-1" x-data="{ open: false }" @click.away="open = false">
    <button @click="open = !open" class="inline-flex items-center px-2 py-1 text-sm font-medium text-white/90 hover:text-white transition">
        Produk
        <svg class="ml-1 h-4 w-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="absolute top-full left-0 mt-3 w-72 rounded-2xl shadow-2xl bg-white border border-gray-100 overflow-hidden z-50"
         style="display: none;">
        <div class="p-3 space-y-2">
            <a href="{{ route('user.products.index') }}" class="block group">
                <div class="bg-gradient-to-br from-pink-50 to-pink-50 hover:from-pink-100 hover:to-pink-100 rounded-xl p-4 transition-all duration-200 border-2 border-transparent hover:border-pink-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-pink-600 rounded-lg flex items-center justify-center shadow-sm flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-gray-900 group-hover:text-pink-700 transition-colors">Daftar Produk</h3>
                            <p class="text-xs text-gray-600 mt-0.5">Lihat semua produk kami</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-pink-700 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
            <a href="{{ route('dashboard') }}#tentang-kami" class="block group">
                <div class="bg-gradient-to-br from-pink-50 to-pink-50 hover:from-pink-100 hover:to-pink-100 rounded-xl p-4 transition-all duration-200 border-2 border-transparent hover:border-pink-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-pink-500 rounded-lg flex items-center justify-center shadow-sm flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-gray-900 group-hover:text-pink-600 transition-colors">Pengenalan Produk</h3>
                            <p class="text-xs text-gray-600 mt-0.5">Tentang produk kami</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-pink-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
