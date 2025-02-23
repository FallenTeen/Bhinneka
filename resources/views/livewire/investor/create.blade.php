<div class="px-12 mt-12 mb-12 w-full">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Sebagai Investor') }}
        </h2>
    </x-slot>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="w-full grid grid-cols-2 gap-4">
        <!-- Profil Investor -->
        <div class="bg-white p-6 rounded-lg shadow col-span-2">
            <h3 class="text-lg font-bold mb-3">Informasi Investor</h3>
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Avatar Upload -->
                <div class="col-span-1">
                    <div class="col-span-1 flex flex-col">
                        @if ($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}"
                                class="w-full h-76 object-cover rounded-full aspect-square" alt="Preview Avatar">
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
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-semibold">Klik</span> untuk upload logo perusahaan
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        SVG, PNG, JPG atau GIF (MAX. 800x400px)
                                    </p>
                                </div>
                                <input id="dropzone-file" type="file" class="hidden" wire:model="avatar" />
                            </label>
                            @error('avatar') <span class="text-red-500">{{ $message }}</span> @enderror
                        @endif
                    </div>
                </div>

                <!-- Detail Investor -->
                <div class="col-span-1 lg:col-span-3 flex flex-col justify-center">
                    <h1 class="font-bold text-4xl">Detail Investor</h1>
                    <h2 class="mb-4">Masukkan informasi perusahaan Anda</h2>

                    <div class="mb-3">
                        <label class="block text-gray-700">Nama Perusahaan</label>
                        <input type="text" wire:model="company_name" class="w-full p-2 border rounded">
                        @error('company_name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block text-gray-700">Deskripsi</label>
                        <textarea wire:model="description" class="w-full p-2 border rounded"
                            placeholder="Jelaskan tentang perusahaan Anda..."></textarea>
                        @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-2 bg-white rounded-xl shadow-lg p-8 mb-6">
            <h3 class="text-lg font-bold mb-3">Upload Dokumen</h3>
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Range Investasi</label>
                    <select wire:model="investment_range"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option value="">Pilih range investasi</option>
                        <option value="10000000-50000000">Rp 10.000.000 - Rp 50.000.000</option>
                        <option value="50000000-100000000">Rp 50.000.000 - Rp 100.000.000</option>
                        <option value="100000000-500000000">Rp 100.000.000 - Rp 500.000.000</option>
                        <option value="500000000-1000000000">Rp 500.000.000 - Rp 1.000.000.000</option>
                        <option value="1000000000+">Di atas Rp 1.000.000.000</option>
                    </select>
                    @error('investment_range') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-4">Minat Investasi</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <label class="cursor-pointer">
                            <input type="checkbox" wire:click="toggleInterest('education')" class="hidden">
                            <div
                                class="p-4 rounded-lg border-2 transition-all duration-200 hover:border-blue-200
                {{ in_array('education', $investment_interest ?? []) ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                <div class="flex items-center justify-center">
                                    <svg class="w-6 h-6 {{ in_array('education', $investment_interest ?? []) ? 'text-blue-500' : 'text-gray-400' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    <span class="ml-2">Edukasi</span>
                                </div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="checkbox" wire:click="toggleInterest('entertainment')" class="hidden">
                            <div
                                class="p-4 rounded-lg border-2 transition-all duration-200 hover:border-blue-200
                {{ in_array('entertainment', $investment_interest ?? []) ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                <div class="flex items-center justify-center">
                                    <svg class="w-6 h-6 {{ in_array('entertainment', $investment_interest ?? []) ? 'text-blue-500' : 'text-gray-400' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    <span class="ml-2">Hiburan</span>
                                </div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="checkbox" wire:click="toggleInterest('technology')" class="hidden">
                            <div
                                class="p-4 rounded-lg border-2 transition-all duration-200 hover:border-blue-200
                {{ in_array('technology', $investment_interest ?? []) ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                <div class="flex items-center justify-center">
                                    <svg class="w-6 h-6 {{ in_array('technology', $investment_interest ?? []) ? 'text-blue-500' : 'text-gray-400' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="ml-2">Teknologi</span>
                                </div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="checkbox" wire:click="toggleInterest('lifestyle')" class="hidden">
                            <div
                                class="p-4 rounded-lg border-2 transition-all duration-200 hover:border-blue-200
                {{ in_array('lifestyle', $investment_interest ?? []) ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                <div class="flex items-center justify-center">
                                    <svg class="w-6 h-6 {{ in_array('lifestyle', $investment_interest ?? []) ? 'text-blue-500' : 'text-gray-400' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z">
                                        </path>
                                    </svg>
                                    <span class="ml-2">Gaya Hidup</span>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('investment_interest') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                </path>
                            </svg>
                        </div>
                        <input type="url" wire:model="website"
                            class="w-full pl-10 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            placeholder="https://www.example.com">
                    </div>
                    @error('website') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Upload Dokumen -->
        <div class="bg-white p-6 rounded-lg shadow col-span-2">
            <h3 class="text-lg font-bold mb-3">Upload Dokumen</h3>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">
                    Dokumen Perusahaan
                    <span class="text-red-500">*</span>
                </label>
                <input type="file" wire:model="document1" class="w-full p-2 border rounded" accept=".pdf">
                <p class="text-sm text-gray-500 mt-1">Upload dokumen dalam format PDF (maks. 5MB)</p>
                @error('document1') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Verifikasi dan Persetujuan -->
        <div class="bg-white p-6 rounded-lg shadow col-span-2">
            <div class="flex flex-col md:flex-row items-start gap-8">
                <div class="w-full md:w-1/2">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Persyaratan</h3>
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" wire:model="terms_agreement" class="form-checkbox h-5 w-5 text-blue-600">
                        <span class="text-sm text-gray-700">
                            Saya menyetujui <a href="#" class="text-blue-600 hover:underline">Syarat dan Ketentuan</a>
                        </span>
                    </label>
                    @error('terms_agreement') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="w-full md:w-1/2">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Verifikasi Captcha</h3>
                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <div class="flex-1">
                            <input type="text" wire:model="captcha" class="w-full p-3 border rounded-md"
                                placeholder="Masukkan Captcha">
                            @error('captcha') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex items-center space-x-3">
                            <img src="{{ captcha_src() }}" class="border rounded-md">
                            <button type="button" wire:click="refreshCaptcha"
                                class="text-blue-600 hover:underline text-sm">↻ Refresh</button>
                        </div>
                    </div>
                </div>
            </div>

            <button wire:click="save"
                class="w-full mt-6 bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 transition-colors duration-300 font-semibold">
                Daftar Sebagai Investor
            </button>
        </div>
    </div>
</div>