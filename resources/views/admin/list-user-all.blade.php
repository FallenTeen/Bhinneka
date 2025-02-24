<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List Semua Pengguna Terdaftar') }}
        </h2>
    </x-slot>

    <div class="py-12 px-12">
       @livewire('component.admin-list-user-all')
    </div>
</x-app-layout>
