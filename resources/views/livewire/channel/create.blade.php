<div class="px-12 mt-12 mb-12 w-full">
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
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
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


        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Tambahkan Link Eksternal</h3>
            <div class="space-y-4">
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700">Link Website</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span
                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-sm text-gray-500">
                            https://
                        </span>
                        <input type="text" wire:model="exlink.0" id="website"
                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border border-gray-300 focus:outline-none sm:text-sm"
                            placeholder="Masukkan URL Website">
                    </div>
                </div>
                <div>
                    <label for="instagramLink" class="block text-sm font-medium text-gray-700">Link Instagram</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span
                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-sm text-gray-500">
                            http://instagram.com/
                        </span>
                        <input type="text" wire:model="exlink.1" id="instagramLink"
                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border border-gray-300 focus:outline-none sm:text-sm"
                            placeholder="Masukkan URL Instagram">
                    </div>
                </div>
                <div>
                    <label for="youtubeChannelLink" class="block text-sm font-medium text-gray-700">Link YouTube
                        Channel</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span
                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-sm text-gray-500">
                            http://youtube.com/channel/
                        </span>
                        <input type="text" wire:model="exlink.2" id="youtubeChannelLink"
                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border border-gray-300 focus:outline-none sm:text-sm"
                            placeholder="Masukkan URL YouTube Channel">
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow space-y-4">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Upload Dokumen (PDF)</h3>

            <div>
                <label for="youtubeChannelLink" class="block text-sm font-medium text-gray-700">
                    Surat Permohonan Pengajuan Channel
                    <span class="text-red-500">*</span>
                </label>
                <div
                    class="mt-1 relative flex w-full flex-col gap-1 {{ $errors->has('document1') ? 'text-red-500' : 'text-gray-700' }}">
                    <input type="file" wire:model="document1" id="document1"
                        class="w-full overflow-clip rounded-md border {{ $errors->has('document1') ? 'border-red-500' : 'border-gray-300' }} bg-neutral-50/50 text-sm file:mr-4 file:border-none file:bg-neutral-50 file:px-4 file:py-2 file:font-medium file:text-neutral-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:bg-neutral-900/50 dark:file:bg-neutral-900 dark:file:text-white dark:focus-visible:outline-white" />
                    @error('document1')
                        <small class="pl-0.5">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div>
                <label for="youtubeChannelLink" class=" mt-1 block text-sm font-medium text-gray-700">
                    Surat Keterangan Lembaga
                    <span class="text-red-500">*</span>
                </label>
                <div
                    class="mt-1 relative flex w-full flex-col gap-1 {{ $errors->has('document2') ? 'text-red-500' : 'text-gray-700' }}">
                    <input type="file" wire:model="document2" id="document2"
                        class="w-full overflow-clip rounded-md border {{ $errors->has('document2') ? 'border-red-500' : 'border-gray-300' }} bg-neutral-50/50 text-sm file:mr-4 file:border-none file:bg-neutral-50 file:px-4 file:py-2 file:font-medium file:text-neutral-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:bg-neutral-900/50 dark:file:bg-neutral-900 dark:file:text-white dark:focus-visible:outline-white" />
                    @error('document2')
                        <small class="pl-0.5">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div>
                <div>
                    <label for="youtubeChannelLink" class="mt-1 block text-sm font-medium text-gray-700">
                        Formulir Pendaftaran
                        <span class="text-red-500">*</span>
                        <a href="#" class="pl-2 ">
                            -
                        </a>
                        <a href="#" class="pl-2 text-blue-600 hover:underline font-medium">
                            download di sini
                        </a>

                    </label>
                </div>
                <div
                    class="mt-1 relative flex w-full flex-col gap-1 {{ $errors->has('document3') ? 'text-red-500' : 'text-gray-700' }}">
                    <input type="file" wire:model="document3" id="document3"
                        class="w-full overflow-clip rounded-md border {{ $errors->has('document3') ? 'border-red-500' : 'border-gray-300' }} bg-neutral-50/50 text-sm file:mr-4 file:border-none file:bg-neutral-50 file:px-4 file:py-2 file:font-medium file:text-neutral-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:bg-neutral-900/50 dark:file:bg-neutral-900 dark:file:text-white dark:focus-visible:outline-white" />
                    @error('document3')
                        <small class="pl-0.5">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>


        <div class="flex flex-col col-span-2 gap-6 p-6 bg-white rounded-lg shadow-md"
            x-data="{ openTermsModal: false, openPrivacyModal: false, openCommunityModal: false, openFaqModal: false }">
            <div class="flex flex-col md:flex-row items-start gap-8">
                <div class="w-full md:w-1/2">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Persyaratan</h3>
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" wire:model="terms_agreement"
                            class="form-checkbox h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="text-sm text-gray-700">
                            Saya menyetujui <a href="#" class="text-blue-600 hover:underline"
                                @click.prevent="openTermsModal = true">Syarat dan Ketentuan</a>
                        </span>
                    </label>
                    @error('terms_agreement') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="w-full md:w-1/2">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Verifikasi Captcha</h3>
                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <div class="flex-1">
                            <input type="text" wire:model="captcha"
                                class="w-full p-3 border rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm"
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
                class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 transition-colors duration-300 font-semibold">
                Buat Channel
            </button>

            {{-- Modal Syarat dan Ketentuan --}}
            <div x-show="openTermsModal" class="fixed inset-0 overflow-y-auto flex items-center justify-center z-50">
                <div class="fixed inset-0 bg-black opacity-50" @click="openTermsModal = false"></div>
                <div class="bg-white rounded-lg p-6 w-full max-w-2xl relative" @click.away="openTermsModal = false">
                    <h3 class="text-xl font-semibold mb-4">Syarat dan Ketentuan</h3>
                    <div class="overflow-y-auto max-h-96">
                        <p>Lorem ipsum dolor sit amet...</p>
                    </div>
                    <button @click="openTermsModal = false"
                        class="mt-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Tutup</button>
                </div>
            </div>

            {{-- Modal Kebijakan Privasi --}}
            <div x-show="openPrivacyModal" class="fixed inset-0 overflow-y-auto flex items-center justify-center z-50">
                <div class="fixed inset-0 bg-black opacity-50" @click="openPrivacyModal = false"></div>
                <div class="bg-white rounded-lg p-6 w-full max-w-2xl relative" @click.away="openPrivacyModal = false">
                    <h3 class="text-xl font-semibold mb-4">Kebijakan Privasi</h3>
                    <div class="overflow-y-auto max-h-96">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                    </div>
                    <button @click="openPrivacyModal = false"
                        class="mt-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Tutup</button>
                </div>
            </div>

            {{-- Modal Pedoman Komunitas --}}
            <div x-show="openCommunityModal"
                class="fixed inset-0 overflow-y-auto flex items-center justify-center z-50">
                <div class="fixed inset-0 bg-black opacity-50" @click="openCommunityModal = false"></div>
                <div class="bg-white rounded-lg p-6 w-full max-w-2xl relative" @click.away="openCommunityModal = false">
                    <h3 class="text-xl font-semibold mb-4">Pedoman Komunitas</h3>
                    <div class="overflow-y-auto max-h-96">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                    </div>
                    <button @click="openCommunityModal = false"
                        class="mt-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Tutup</button>
                </div>
            </div>

            {{-- Modal FAQ --}}
            <div x-show="openFaqModal" class="fixed inset-0 overflow-y-auto flex items-center justify-center z-50">
                <div class="fixed inset-0 bg-black opacity-50" @click="openFaqModal = false"></div>
                <div class="bg-white rounded-lg p-6 w-full max-w-2xl relative" @click.away="openFaqModal = false">
                    <h3 class="text-xl font-semibold mb-4">FAQ</h3>
                    <div class="overflow-y-auto max-h-96">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                    </div>
                    <button @click="openFaqModal = false"
                        class="mt-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Tutup</button>
                </div>
            </div>

            {{-- Tambahkan link untuk membuka modal lainnya --}}
            <div class="flex justify-center mt-4 space-x-4">
                <a href="#" class="text-blue-600 hover:underline text-sm"
                    @click.prevent="openPrivacyModal = true">Kebijakan Privasi</a>
                <a href="#" class="text-blue-600 hover:underline text-sm"
                    @click.prevent="openCommunityModal = true">Pedoman Komunitas</a>
                <a href="#" class="text-blue-600 hover:underline text-sm" @click.prevent="openFaqModal = true">FAQ</a>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>