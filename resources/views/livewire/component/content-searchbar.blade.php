<form class="flex items-center max-w-lg mx-auto">
    <label class="sr-only" for="voice-search">Cari Judul, Channel...</label>
    <div class="relative w-full">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                class="w-4 h-4 text-gray-500 dark:text-gray-400">
                <path
                    d="M11.15 5.6h.01m3.337 1.913h.01m-6.979 0h.01M5.541 11h.01M15 15h2.706a1.957 1.957 0 0 0 1.883-1.325A9 9 0 1 0 2.043 11.89 9.1 9.1 0 0 0 7.2 19.1a8.62 8.62 0 0 0 3.769.9A2.013 2.013 0 0 0 13 18v-.857A2.034 2.034 0 0 1 15 15Z"
                    stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor"></path>
            </svg>
        </div>
        <input wire:model.live.debounce.500ms="search" placeholder="Cari Judul, Channel..."
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-ungumain focus:border-ungumain block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-ungumain dark:focus:border-ungumain"
            id="voice-search" type="text" />
    </div>
</form>