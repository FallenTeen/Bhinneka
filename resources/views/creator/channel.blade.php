<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Channel') }}
            </h2>
            <h2 class="text-xl text-gray-800 dark:text-gray-200 leading-tight font-medium">
                {{ ucfirst(optional(Auth::user()->channels->first())->channel_name ?? 'No Channel') }}
            </h2>
        </div>
    </x-slot>

    @php
        $channel = Auth::user()->channels->first();
    @endphp

    @if ($channel && $channel->verified)
        <div class="w-full p-4 md:p-8 grid gap-6 md:gap-8">
            <!-- Channel Information Card -->
            <div
                class="w-full bg-white dark:bg-gray-800 rounded-xl p-4 md:p-6 shadow-lg transition-all duration-300 hover:shadow-xl">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-xl font-bold text-gray-800 dark:text-gray-200">Channel Information</span>
                    <a href="{{ route('creator.channel') }}"
                        class="group relative overflow-hidden rounded-lg px-4 py-2 bg-ungumain text-white hover:bg-ungumain/90 transition-all duration-300 transform hover:scale-105">
                        <div class="flex items-center gap-2">
                            <span class="font-medium">Edit Info</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                            </svg>
                        </div>
                    </a>
                </div>

                <div class="flex flex-col md:flex-row items-start md:items-center gap-6 px-4">
                    <div class="w-32 md:w-48 aspect-square rounded-full overflow-hidden ring-4 ring-ungumain/20">
                        <img src="{{ asset($channel->avatar ? 'storage/' . $channel->avatar : 'storage/avatarsimages/default-avatar.png') }}"
                            alt="{{ $channel->channel_name }}'s Avatar"
                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                    </div>

                    <div class="flex-1 space-y-4">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $channel->channel_name }}
                            </h1>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 italic">
                                Bergabung pada {{ \Carbon\Carbon::parse($channel->created_at)->format('F Y') }}
                            </p>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $channel->deskripsi }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="w-full bg-white dark:bg-gray-800 rounded-xl p-4 md:p-6 shadow-lg">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <span class="text-xl font-bold text-gray-800 dark:text-gray-200">Content</span>
                    <a href="{{ route('creator.content.create') }}"
                        class="group relative overflow-hidden rounded-lg px-4 py-2 bg-ungumain text-white hover:bg-ungumain/90 transition-all duration-300 transform hover:scale-105">
                        <div class="flex items-center gap-2">
                            <span class="font-medium">Add Content</span>
                            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                    </a>
                </div>

                <div class="overflow-hidden">
                    @livewire('component.content-video-dashboard', ['slug' => $channel->slug, 'hidename' => true])
                </div>
            </div>
        </div>
    @else
        <div class="min-h-[50vh] flex items-center justify-center p-4">
            <div class="text-center max-w-lg bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg">
                <div class="mb-6">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    Menunggu Verifikasi
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Silakan tunggu hingga channel Anda diverifikasi oleh admin sebelum mengakses konten ini.
                </p>
            </div>
        </div>
    @endif
</x-app-layout>