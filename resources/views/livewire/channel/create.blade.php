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
        <!-- Main Channel Info -->
        <div class="bg-white p-6 rounded-lg shadow col-span-2">
            <h3 class="text-lg font-bold mb-3">Informasi Channel</h3>

            <div class="mb-3">
                <label class="block text-gray-700">Avatar</label>
                <input type="file" wire:model="avatar" class="w-full p-2 border rounded">
                @error('avatar') <span class="text-red-500">{{ $message }}</span> @enderror

                @if ($avatar)
                    <img src="{{ $avatar->temporaryUrl() }}" class="mt-2 w-24 h-24 rounded-full">
                @endif
            </div>


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