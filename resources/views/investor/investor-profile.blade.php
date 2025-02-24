<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Investor Profile') }}
            </h2>
        </div>
    </x-slot>

    @php
        $investor = Auth::user()->investors->first();
    @endphp

    @if ($investor && $investor->verified)
        <div class="w-full p-4 md:p-8">
            <!-- Profile Information Card -->
            <div x-data="{ showEdit: false }" 
                class="w-full bg-white dark:bg-gray-800 rounded-xl p-4 md:p-6 shadow-lg">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-xl font-bold text-gray-800 dark:text-gray-200">Company Profile</span>
                    <a href="{{ route('investor.profile') }}"
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                        class="relative rounded-lg px-4 py-2 bg-ungumain text-white transition-all duration-300">
                        <div class="flex items-center gap-2" :class="{ 'translate-x-1': hover }">
                            <span class="font-medium">Edit Profile</span>
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="size-5 transition-transform duration-300"
                                :class="{ 'rotate-12': hover }"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                            </svg>
                        </div>
                    </a>
                </div>
                
                <div class="flex flex-col md:flex-row gap-6 px-4">
                    <div class="w-32 md:w-48">
                        <div class="aspect-square rounded-xl overflow-hidden ring-4 ring-ungumain/20">
                            <img src="{{ $investor->avatar ? asset('storage/' . $investor->avatar) : asset('storage/investor_avatars/default.png') }}"
                                alt="{{ $investor->company_name }}'s Logo" 
                                class="w-full h-full object-cover transition-all duration-300">
                        </div>
                        @if($investor->website)
                            <a href="{{ $investor->website }}" 
                                target="_blank"
                                class="mt-4 w-full flex items-center justify-center gap-2 text-sm text-ungumain hover:text-ungumain/80 transition-colors">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                Visit Website
                            </a>
                        @endif
                    </div>

                    <div class="flex-1 space-y-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $investor->company_name }}
                            </h1>
                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                <span class="px-3 py-1 rounded-full text-sm font-medium 
                                    {{ $investor->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($investor->status) }}
                                </span>
                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm font-medium">
                                    {{ $investor->investment_range }}
                                </span>
                            </div>
                        </div>

                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300">
                                {{ $investor->description }}
                            </p>
                        </div>

                        <div x-data="{ showAll: false }" class="space-y-3">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Investment Interests</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($investor->investment_interest as $interest)
                                    <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full text-sm">
                                        {{ $interest }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                @livewire('component.investor-posts', ['investorId' => $investor->id])
            </div>
        </div>
    @else
        <div x-data="{ bounce: false }" 
             x-init="setInterval(() => bounce = !bounce, 2000)"
             class="min-h-[50vh] flex items-center justify-center p-4">
            <div class="text-center max-w-lg bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg">
                <div class="mb-6">
                    <svg class="mx-auto h-16 w-16 text-gray-400 transition-transform duration-300"
                         :class="{ 'transform translate-y-2': bounce }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    Menunggu Verifikasi
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Silakan tunggu hingga profil investor Anda diverifikasi oleh admin untuk mengakses fitur ini.
                </p>
            </div>
        </div>
    @endif
</x-app-layout>