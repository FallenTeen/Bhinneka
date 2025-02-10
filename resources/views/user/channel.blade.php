<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Channel') }}
        </h2>
        <h2 class="text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ucfirst(optional(Auth::user()->channels->first())->channel_name ?? 'No Channel') }}
        </h2>

    </x-slot>

</x-app-layout>