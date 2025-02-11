<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Channel') }}
        </h2>
        <h2 class="text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ucfirst(optional(Auth::user()->channels->first())->channel_name ?? 'No Channel') }}
        </h2>

    </x-slot>
    <div class="w-full p-8 rounded-lg grid grid-cols-2 gap-8">
        <div class="w-full bg-white p-6 flex flex-col col-span-2 shadow-lg">
            <div class="w-full flex justify-between">
                <span class="text-lg font-bold mb-3">Channel Information</span>
                <div>Tombol Hapus,dkk</div>
            </div>
            <div class="w-full flex">
                <div class="lg:w-24">
                    @if(optional(Auth::user()->channels->first())->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->channels->first()->avatar) }}"
                            class="w-full aspect-auto rounded-full" alt="">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" class="rounded-circle"
                            width="100">
                    @endif
                </div>
                <div class="w-grow px-8">
                    <div class="flex flex-col">
                        <span class="text-3xl font-bold">{{Auth::user()->channels->first()->channel_name}}</span>
                        <span class="">{{Auth::user()->channels->first()->deskripsi}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full bg-white p-6 flex col-span-2 shadow-lg">
            <div class="w-full flex justify-between">
                <span class="text-lg font-bold mb-3">Content</span>
                <div>Tombol Add Content</div>
            </div>
        </div>
    </div>

</x-app-layout>