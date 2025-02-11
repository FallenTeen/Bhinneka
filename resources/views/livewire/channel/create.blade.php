<div class="px-12 mt-12 w-full">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Channel') }}
        </h2>
    </x-slot>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="w-full grid grid-cols-2 gap-4">
        <div class="bg-white p-6 rounded-lg shadow col-span-2">
            <h3 class="text-lg font-bold mb-3">Informasi Channel</h3>
            <div class="grid grid-cols-1 lg:grid-cols-4  gap-8">
                <div class="col-span-1">
                    <div class="col-span-1 flex flex-col">
                        @if ($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}"
                                class=" w-full h-76 object-cover rounded-full aspect-square" alt="Preview Avatar">
                        @else
                            <label for="dropzone-file"
                                class="flex flex-col items-center justify-center w-76 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 aspect-square">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                            class="font-semibold">Klik</span> untuk upload avatar</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG atau GIF (MAX.
                                        800x400px)</p>
                                </div>
                                <input id="dropzone-file" type="file" class="hidden" wire:model="avatar" />
                            </label>
                            @error('avatar') <span class="text-red-500">{{ $message }}</span> @enderror
                        @endif
                    </div>

                </div>

                <div class="col-span-1 lg:col-span-3 flex flex-col justify-center">
                    <h1 class="font-bold text-4xl">Detail Channel</h1>
                    <h2 class="mb-4">Masukkan detail utama channel</h2>
                    <div class="mb-3">
                        <label class="block text-gray-700">Nama Channel</label>
                        <input type="text" wire:model="channel_name" class="w-full p-2 border rounded">
                        @error('channel_name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="block text-gray-700">Deskripsi</label>
                        <textarea wire:model="deskripsi" class="w-full p-2 border rounded"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="bg-white p-6 rounded-lg shadow col-span-1">
            <h3 class="text-lg font-bold mb-3">Tambahkan Link Eksternal</h3>
            <input type="text" wire:model="exlink.0" class="w-full p-2 border rounded mb-2" placeholder="Website">
            <input type="text" wire:model="exlink.1" class="w-full p-2 border rounded mb-2" placeholder="Instagram">
            <input type="text" wire:model="exlink.2" class="w-full p-2 border rounded mb-2" placeholder="YouTube">
        </div>

        <!-- Terms and Agreement -->
        <div class="flex flex-col gap-3">
            <h3 class="text-lg font-bold">Persyaratan</h3>
            <label class="flex items-center space-x-2">
                <input type="checkbox" wire:model="terms_agreement">
                <span class="text-gray-700 text-sm">
                    Saya menyetujui <a href="#" class="text-blue-500">Syarat dan Ketentuan</a>
                </span>
            </label>
            @error('terms_agreement') <span class="text-red-500">{{ $message }}</span> @enderror

            <!-- CAPTCHA -->
            <div class="mt-4">
                <label class="block text-gray-700">Verifikasi Captcha</label>
                <div class="flex items-center space-x-3">
                    <img src="{{ captcha_src() }}" class="border rounded">
                    <button type="button" wire:click="refreshCaptcha" class="text-blue-500">↻ Refresh</button>
                </div>
                <input type="text" wire:model="captcha" class="w-full p-2 border rounded mt-2">
                @error('captcha') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <button wire:click="save" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Buat Channel
            </button>
        </div>
    </div>
</div>

<!-- Include Flowbite JS -->
<script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>