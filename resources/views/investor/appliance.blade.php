<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Appliance') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center h-screen">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-red-600 dark:text-red-400 mb-4">Under Maintenance</h1>
            <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">Kami sedang melakukan pemeliharaan. Mohon coba lagi nanti.</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kami akan segera kembali.</p>
        </div>
    </div>
</x-app-layout>