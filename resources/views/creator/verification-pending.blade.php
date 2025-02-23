<x-app-layout>
    <div class="flex justify-center items-center h-screen">
        <div class="max-w-3xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-500 mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2
                        class="text-3xl text-center font-semibold text-gray-800 mb-4 xs:text-2xl sm:text-2xl md:text-2xl">
                        Verifikasi Channel Tertunda
                    </h2>
                    <p class="text-lg text-gray-600 text-center mb-6 xs:text-base sm:text-base md:text-base">
                        Channel Anda
                        "{{ Auth::check() && Auth::user()->channels->isNotEmpty() ? Auth::user()->channels->first()->channel_name : 'Channel Anda' }}"
                        sedang menunggu verifikasi oleh admin.
                        Anda akan dapat mengakses fitur pembuat setelah diverifikasi.
                    </p>
                    <p class="text-sm text-gray-500 text-center mb-4">
                        Verifikasi channel biasanya memakan waktu 1-2 hari kerja. Kami akan memberitahu Anda melalui
                        email jika channel Anda sudah diverifikasi.
                    </p>
                    <div
                        class="bg-yellow-100 border border-yellow-200 rounded-md p-4 text-sm text-yellow-700 xs:text-xs sm:text-xs md:text-xs">
                        <p>
                            <strong>Tips:</strong> Pastikan semua informasi channel Anda akurat selama menunggu proses
                            verifikasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>