<x-app-layout>

    <div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-gray-900 dark:to-gray-800 relative overflow-hidden">
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAzNGgxMnYxMkgzNnoiLz48cGF0aCBkPSJNMTIgMTJoMTJ2MTJIMTJ6IiBmaWxsPSJjdXJyZW50Q29sb3IiIG9wYWNpdHk9Ii4xNSIvPjwvZz48L3N2Zz4=')] [mask-image:linear-gradient(0deg,white,transparent)]"></div>
        </div>

        <div class="relative z-10 py-12 px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="max-w-7xl mx-auto text-center mb-12" x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)">
                <h1 class="text-5xl font-extrabold mb-6" x-show="show" x-transition>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600 animate-pulse">
                        Selamat Datang, {{ Auth::user()->name }}!
                    </span>
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                   Bergabung sebagai bagian dari kami sekarang!
                </p>
            </div>

            <!-- Main Cards -->
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 px-4">
                <!-- Investor Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-blue-700">
                                Menjadi Investor
                            </h2>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            Jadilah pendukung kreatifitas dan bakat para pegiat teknologi!
                        </p>
                        <a href="{{ route('user.investor.create') }}" class="block">
                            <button class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transform transition-all duration-300">
                                Daftar Sebagai Investor
                            </button>
                        </a>
                    </div>
                    <div class="h-2 bg-gradient-to-r from-blue-500 to-blue-700" :class="{ 'animate-pulse': hover }"></div>
                </div>

                <!-- Channel Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M13 12a1 1 0 11-2 0 1 1 0 012 0z"></path>
                            </svg>
                            <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-green-500 to-green-700">
                                Buat Channel
                            </h2>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                           Tunjukan kreativitas dan bakat yang kamu punya!
                        </p>
                        <a href="{{ route('user.channel.create') }}" class="block">
                            <button class="w-full bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transform transition-all duration-300">
                                Daftar Channel
                            </button>
                        </a>
                    </div>
                    <div class="h-2 bg-gradient-to-r from-green-500 to-green-700" :class="{ 'animate-pulse': hover }"></div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="max-w-7xl mx-auto mt-16 px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Security Feature -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md hover:shadow-lg transition-all duration-300" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Keamanan Terjamin</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">Data dan transaksimu dilindungi dengan keamanan yang kuat</p>
                    </div>

                    <!-- Management Feature -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md hover:shadow-lg transition-all duration-300" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Manajemen mudah</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">Dengan platform interaktif yang memungkinkan kamu untuk berinteraksi satu sama lain</p>
                    </div>

                    <!-- Updates Feature -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md hover:shadow-lg transition-all duration-300" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Easy Connect</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">Mempermudah kamu untuk berinteraksi dengan satu sama lain</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>