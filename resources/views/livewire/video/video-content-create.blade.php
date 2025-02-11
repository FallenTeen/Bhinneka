<div class="px-12 mt-12 w-full">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Video') }}
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form wire:submit.prevent="save" method="POST">
            @csrf
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" id="judul" wire:model="judul"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('judul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4" style="display: none;">
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                <input type="text" id="slug" wire:model="slug"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" wire:model="deskripsi"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    rows="4"></textarea>
                @error('deskripsi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="url" class="block text-sm font-medium text-gray-700">URL Video Google Drive</label>
                <input type="url" id="url" wire:model="url"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <div class="flex items-center space-x-3">
                    <label class="group flex items-center cursor-pointer">
                        <input class="hidden peer" type="checkbox" wire:model="is_exclusive" />

                        <span
                            class="relative w-8 h-8 flex justify-center items-center bg-gray-100 border-2 border-gray-400 rounded-md shadow-md transition-all duration-500 peer-checked:border-blue-500 peer-checked:bg-blue-500 peer-hover:scale-105">
                            <span
                                class="absolute inset-0 bg-gradient-to-br from-white/30 to-white/10 opacity-0 peer-checked:opacity-100 rounded-md transition-all duration-500 peer-checked:animate-pulse"></span>

                            <svg fill="currentColor" viewBox="0 0 20 20"
                                class="hidden w-5 h-5 text-white peer-checked:block transition-transform duration-500 transform scale-50 peer-checked:scale-100"
                                xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"
                                    fill-rule="evenodd"></path>
                            </svg>
                        </span>

                        <span
                            class="ml-3 text-gray-700 group-hover:text-blue-500 font-medium transition-colors duration-300">
                            Eksklusif
                        </span>
                    </label>
                </div>

            </div>

            <button type="submit"
                class="w-full bg-ungumain text-white py-2 px-4 rounded-lg hover:bg-ungumain focus:outline-none">Tambah
                Video</button>
        </form>
    </div>
</div>