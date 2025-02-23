<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Channel') }}
        </h2>
        <h2 class="text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ucfirst(optional(Auth::user()->channels->first())->channel_name ?? 'No Channel') }}
        </h2>
    </x-slot>

    @php
        $channel = Auth::user()->channels->first();
    @endphp

    @if ($channel && $channel->verified)
        <div class="w-full p-8 rounded-lg grid grid-cols-2 gap-8">
            <div class="w-full bg-white p-6 flex flex-col col-span-2 shadow-lg">
                <div class="w-full flex justify-between">
                    <span class="text-lg font-bold mb-3">Channel Information</span>
                    <a href="{{ route('creator.channel') }}"
                        class="rounded-lg relative w-36 h-10 cursor-pointer flex items-center border border-ungumain bg-ungumain group hover:bg-ungumain active:bg-ungumain active:border-ungumain">
                        <span
                            class="text-gray-200 font-semibold mx-4 transform group-hover:translate-x-20 transition-all duration-300">
                            Edit Info
                        </span>
                        <span
                            class="text-white absolute right-0 h-full w-10 rounded-lg bg-ungumain flex items-center justify-center transform group-hover:translate-x-0 group-hover:w-full transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </span>
                    </a>
                </div>
                <div class="w-full flex items-center px-8">
                    <div class="w-1/6 overflow-hidden">
                        <img src="{{ asset($channel->avatar ? 'storage/' . $channel->avatar : 'storage/avatarsimages/default-avatar.png') }}"
                            alt="Avatar" class="w-full h-full object-cover rounded-full aspect-square ">
                    </div>

                    <div class="w-5/6 px-8">
                        <div class="flex flex-col">
                            <span class="text-3xl font-bold">{{ $channel->channel_name }}</span>
                            <h3 class="mt-2 font-semibold opacity-55 text-sm italic tracking-tight">
                                Bergabung pada
                                {{ \Carbon\Carbon::parse($channel->created_at)->format('F Y') }}
                            </h3>
                            <span class="">{{ $channel->deskripsi }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full bg-white p-6 flex col-span-2 shadow-lg">
                <div class="w-full">
                    <div class="w-full flex justify-between">
                        <span class="text-lg font-bold mb-3">Content</span>
                        <a href="{{ route('creator.content.create') }}"
                            class="rounded-lg relative w-36 h-10 cursor-pointer flex items-center border border-ungumain bg-ungumain group hover:bg-ungumain active:bg-ungumain active:border-ungumain">
                            <span
                                class="text-gray-200 font-semibold  mx-4 transform group-hover:translate-x-20 transition-all duration-300">
                                Add Item
                            </span>
                            <span
                                class="absolute right-0 h-full w-10 rounded-lg bg-ungumain flex items-center justify-center transform group-hover:translate-x-0 group-hover:w-full transition-all duration-300">
                                <svg class="svg w-8 text-white" fill="none" height="24" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                    width="24" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="12" x2="12" y1="5" y2="19"></line>
                                    <line x1="5" x2="19" y1="12" y2="12"></line>
                                </svg>
                            </span>
                        </a>
                    </div>
                    @livewire('component.content-video-dashboard', ['slug' => $channel->slug, 'hidename' => true])
                </div>
            </div>

        </div>
    @else
        <div class="flex items-center justify-center h-96">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-4">Menunggu Verifikasi oleh Admin</h2>
                <p class="text-gray-500">Silakan tunggu hingga channel Anda diverifikasi oleh admin sebelum mengakses konten
                    ini.</p>
            </div>
        </div>
    @endif

</x-app-layout>