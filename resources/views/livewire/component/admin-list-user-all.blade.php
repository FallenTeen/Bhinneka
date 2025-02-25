<div class="p-6 bg-gray-50">
<div class="fixed top-4 right-4 z-50 space-y-2">
        <template x-for="notification in notifications" :key="notification.id">
            <div 
                x-data="{ notifications: [] }"
                x-show="true" 
                x-transition:enter="transition ease-out duration-300" 
                x-transition:enter-start="opacity-0 transform translate-x-8"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform translate-x-8"
                :class="{
                    'bg-green-100 border-green-400 text-green-800': notification.type === 'success',
                    'bg-blue-100 border-blue-400 text-blue-800': notification.type === 'info',
                    'bg-red-100 border-red-400 text-red-800': notification.type === 'error'}"class="px-4 py-3 rounded border-l-4 shadow-md flex items-center">
                <div class="mr-3">
                    <svg x-show="notification.type === 'success'" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <svg x-show="notification.type === 'info'" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <svg x-show="notification.type === 'error'" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <span x-text="notification.message"></span>
            </div>
        </template>
    </div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            List Users
        </h1>
        <p class="text-gray-600 mt-1">List pengguna aktif</p>
    </div>
    <div
        class="flex flex-col md:flex-row justify-between gap-4 mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
        <div class="flex-1">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.500ms="search"
                    placeholder="Cari nama, email, channel, atau perusahaan..."
                    class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
            </div>
        </div>
        <div class="flex gap-4 items-center">
            <div class="flex items-center">
                <span class="text-sm text-gray-600 mr-2">Tampilkan:</span>
                <select wire:model.live="perPage"
                    class="border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>
    <div class="overflow-hidden bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <button wire:click="sortBy('user.name')"
                                class="flex items-center gap-1 hover:text-gray-700 transition-colors duration-200">
                                <span>Nama</span>
                                <span class="text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        @if ($sortField === 'user.name')
                                            @if ($sortAsc)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7"></path>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            @endif
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M7 14l5-5 5 5"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M7 10l5 5 5-5"></path>
                                        @endif
                                    </svg>
                                </span>
                            </button>
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <button wire:click="sortBy('user.email')"
                                class="flex items-center gap-1 hover:text-gray-700 transition-colors duration-200">
                                <span>Email</span>
                                <span class="text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        @if ($sortField === 'user.email')
                                            @if ($sortAsc)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7"></path>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            @endif
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M7 14l5-5 5 5"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M7 10l5 5 5-5"></path>
                                        @endif
                                    </svg>
                                </span>
                            </button>
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <button wire:click="sortBy('registration_type')"
                                class="flex items-center gap-1 hover:text-gray-700 transition-colors duration-200">
                                <span>Tipe</span>
                                <span class="text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        @if ($sortField === 'registration_type')
                                            @if ($sortAsc)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7"></path>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            @endif
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M7 14l5-5 5 5"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M7 10l5 5 5-5"></path>
                                        @endif
                                    </svg>
                                </span>
                            </button>
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <button wire:click="sortBy('created_at')"
                                class="flex items-center gap-1 hover:text-gray-700 transition-colors duration-200">
                                <span>Tanggal</span>
                                <span class="text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        @if ($sortField === 'created_at')
                                            @if ($sortAsc)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7"></path>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            @endif
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M7 14l5-5 5 5"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M7 10l5 5 5-5"></path>
                                        @endif
                                    </svg>
                                </span>
                            </button>
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dokumen
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($registrations as $registration)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $registration->user->name }}</div>
                            @if($registration->registration_type === 'Creator' && $registration->user->channels->count() > 0)
                                <div class="text-sm text-gray-500 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1 text-purple-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ $registration->user->channels->first()->channel_name }}
                                </div>
                            @elseif($registration->registration_type === 'Investor' && $registration->user->investors->count() > 0)
                                <div class="text-sm text-gray-500 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    {{ $registration->user->investors->first()->company_name }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ $registration->user->email }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $registration->registration_type === 'Creator' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $registration->registration_type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ $registration->created_at->format('d M Y H:i') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2 items-center">
                                @php
                                    $documentCount = 0;
                                    foreach (['document1_path', 'document2_path', 'document3_path'] as $doc) {
                                        if ($registration->$doc)
                                            $documentCount++;}
                                @endphp
                                <div class="bg-gray-100 px-2 py-1 rounded text-xs font-medium text-gray-600">
                                    {{ $documentCount }} dokumen</div>
                                @if($documentCount > 0)
                                    <button
                                        wire:click="$set('viewingRegistration', {{ $registration->id === $viewingRegistration ? 'null' : $registration->id }})"
                                        class="text-blue-600 hover:text-blue-800 text-xs flex items-center transition-colors duration-200">
                                        @if($viewingRegistration === $registration->id)
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                            Tutup dokumen
                                        @else
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            Lihat dokumen
                                        @endif
                                    </button>
                                @else
                                    <span class="text-xs text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                            </path>
                                        </svg>
                                        Tidak ada dokumen
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button wire:click="showDetails({{ $registration->id }})"
                                    class="flex items-center bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded text-xs transition-colors duration-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Lihat Profil
                                </button>
                            </div>
                        </td>
                    </tr>
                    @if($viewingRegistration === $registration->id)
                        <tr class="bg-gray-50">
                            <td colspan="8" class="px-6 py-4">
                                <div class="mb-3 pb-3 border-b border-gray-200">
                                                <h3 class="text-sm font-semibold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        Dokumen Pendukung
                                    </h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @php
                                        $documentsPath = $registration->registration_type === 'Creator' ? 'channel_documents' : 'investor_documents';
                                    @endphp

                                    @if($registration->document1_path)
                                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                                            <h4 class="font-medium mb-2 text-sm text-gray-700 flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                </path>
                                                </svg>
                                                {{ $registration->document1_name ?? ($registration->registration_type === 'Creator' ? 'ID Verification' : 'Company Registration Document') }}
                                            </h4>
                                            @php
                                                $extension = pathinfo($registration->document1_path, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                                $isPdf = strtolower($extension) === 'pdf';
                                            @endphp
                                            @if($isImage)
                                                <img src="{{ asset('storage/' . $documentsPath . '/' . basename($registration->document1_path)) }}"
                                                    alt="Document 1" class="w-full h-auto rounded border border-gray-200">
                                            @elseif($isPdf)
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <a href="{{ asset('storage/' . $documentsPath . '/' . basename($registration->document1_path)) }}"
                                                        target="_blank" class="mt-2 text-blue-600 hover:underline">
                                                        Lihat PDF
                                                    </a>
                                                </div>
                                            @else
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <a href="{{ asset('storage/' . $documentsPath . '/' . basename($registration->document1_path)) }}"
                                                        target="_blank" class="mt-2 text-blue-600 hover:underline">
                                                        Download File
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if($registration->document2_path)
                                        <div class="bg-white p-4 rounded-lg shadow">
                                            <h4 class="font-medium mb-2">
                                                {{ $registration->document2_name ?? ($registration->registration_type === 'Creator' ? 'Channel Verification' : 'Additional Document 1') }}
                                            </h4>
                                            @php
                                                $extension = pathinfo($registration->document2_path, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                                $isPdf = strtolower($extension) === 'pdf';
                                            @endphp

                                            @if($isImage)
                                                <img src="{{ asset('storage/' . $documentsPath . '/' . basename($registration->document2_path)) }}"
                                                    alt="Document 2" class="w-full h-auto rounded border border-gray-200">
                                            @elseif($isPdf)
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <a href="{{ asset('storage/' . $documentsPath . '/' . basename($registration->document2_path)) }}"
                                                        target="_blank" class="mt-2 text-blue-600 hover:underline">
                                                        Lihat PDF
                                                    </a>
                                                </div>
                                            @else
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <a href="{{ asset('storage/' . $documentsPath . '/' . basename($registration->document2_path)) }}"
                                                        target="_blank" class="mt-2 text-blue-600 hover:underline">
                                                        Download File
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if($registration->document3_path)
                                        <div class="bg-white p-4 rounded-lg shadow">
                                            <h4 class="font-medium mb-2">
                                                {{ $registration->document3_name ?? ($registration->registration_type === 'Creator' ? 'Additional Document' : 'Additional Document 2') }}
                                            </h4>
                                            @php
                                                $extension = pathinfo($registration->document3_path, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                                $isPdf = strtolower($extension) === 'pdf';
                                            @endphp

                                            @if($isImage)
                                                <img src="{{ asset('storage/' . $documentsPath . '/' . basename($registration->document3_path)) }}"
                                                    alt="Document 3" class="w-full h-auto rounded border border-gray-200">
                                            @elseif($isPdf)
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <a href="{{ asset('storage/' . $documentsPath . '/' . basename($registration->document3_path)) }}"
                                                        target="_blank" class="mt-2 text-blue-600 hover:underline">
                                                        Lihat PDF
                                                    </a>
                                                </div>
                                            @else
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <a href="{{ asset('storage/' . $documentsPath . '/' . basename($registration->document3_path)) }}"
                                                        target="_blank" class="mt-2 text-blue-600 hover:underline">
                                                        Download File
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endif
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengguna</h3>
                                <p class="mt-1 text-sm text-gray-500">Tidak ada pengguna aktif sekarang</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $registrations->links() }}
        </div>
        <!-- Registration Details Modal Opened -->
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center {{ $showModal ? '' : 'hidden' }}" wire:click.self="closeModal">
            <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto border border-gray-100">
                @if($selectedRegistration)
                <div class="p-6">
                    <!-- Header with -->
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                        <div class="flex items-center">
                            <h2 class="text-2xl font-bold text-gray-800">
                                {{ $selectedRegistration->user->name }}
                            </h2>
                            <span class="ml-3 px-3 py-1 text-xs font-medium rounded-full {{ $selectedRegistration->registration_type === 'Creator' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($selectedRegistration->registration_type) }}
                            </span>
                            <span class="ml-2 px-3 py-1 text-xs font-medium rounded-full 
                                {{ $selectedRegistration->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                    ($selectedRegistration->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($selectedRegistration->status) }}
                            </span>
                        </div>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-full hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- User infoss -->
                    <div class="grid grid-cols-1 gap-6 mb-8">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                                <h3 class="text-lg font-medium text-gray-800">User Information</h3>
                            </div>
                            <div class="p-4">
                                <div class="space-y-3 px-6">
                                    <div class="grid grid-cols-2">
                                        <span class="font-medium text-gray-600">Nama Pengguna</span>
                                        <span class="text-gray-800">{{ $selectedRegistration->user->name }}</span>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <span class="font-medium text-gray-600">Email Pengguna</span>
                                        <span class="text-gray-800">{{ $selectedRegistration->user->email }}</span>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <span class="font-medium text-gray-600">Tanggal Pengajuan</span>
                                        <span class="text-gray-800">{{ $selectedRegistration->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                                <h3 class="text-lg font-medium text-gray-800">
                                    Informasi {{ $selectedRegistration->registration_type === 'Creator' ? 'Creator' : 'Perusahaan' }} 
                                </h3>
                            </div>
                            <div class="p-4">
                                @if($selectedRegistration->registration_type === 'Creator' && $selectedRegistration->user->channels->count() > 0)
                                <div class="space-y-4 px-4">
                                    <div class="flex gap-6 items-center">
                                        <!-- Kiriii -->
                                        <div class="flex-shrink-0">
                                            <div class="relative">
                                                @if($selectedRegistration->user->channels->first()->avatar)
                                                    <img 
                                                        src="{{ asset('storage/' . $selectedRegistration->user->channels->first()->avatar) }}" 
                                                        class="h-32 w-32 rounded-full object-cover cursor-pointer border border-gray-300" 
                                                        alt="Channel Avatar"
                                                        wire:click="$set('showAvatarModal', true)"
                                                    >
                                                @else
                                                    <img 
                                                        src="{{ asset('storage/avatarsimages/default-avatar.png') }}" 
                                                        class="h-32 w-32 rounded-full object-cover cursor-pointer border border-gray-300"
                                                        alt="Default Avatar"
                                                        wire:click="$set('showAvatarModal', true)"
                                                    >
                                                @endif
                                                <div class="absolute -right-1 -bottom-1 bg-blue-500 hover:bg-blue-600 rounded-full p-1 text-white cursor-pointer" 
                                                    wire:click="$set('showAvatarModal', true)" 
                                                    title="View Full Image">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Kanannn -->
                                        <div class="flex-grow space-y-3 flex flex-col justify-center">
                                            <div class="flex items-center">
                                                <span class="font-medium text-gray-600 w-48">Nama Channel</span>
                                                <span class="text-gray-800 font-semibold">{{ $selectedRegistration->user->channels->first()->channel_name }}</span>
                                            </div>
                                            <div class="flex items-start">
                                                <span class="font-medium text-gray-600 w-48">Deskripsi</span>
                                                <div class="relative flex flex-col">
                                                    <span class="text-gray-800 line-clamp-3 max-w-xs cursor-pointer" 
                                                        wire:click="$set('showDescriptionModal', true)">
                                                        {{ $selectedRegistration->user->channels->first()->deskripsi }}
                                                    </span>
                                                    <button class="absolute -right-6 bottom-0 text-blue-500 hover:text-blue-700 focus:outline-none" 
                                                            wire:click="$set('showDescriptionModal', true)" 
                                                            title="Lihat Selengkapnya">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Bawahhh -->
                                    <div class="border-t pt-4 space-y-3">
                                        <div class="flex flex-col space-y-2">
                                            <span class="font-medium text-gray-600 w-32">Link External</span>
                                            @php
                                                $exlinks = json_decode($selectedRegistration->user->channels->first()->exlink, true);
                                                $linkLabels = ['Website', 'Instagram', 'YouTube Channel'];
                                            @endphp
                                            <div class="ml-4">
                                                @foreach($exlinks as $index => $link)
                                                    @if(!empty($link))
                                                        <div class="flex mb-1">
                                                            <span class="font-medium w-40">{{ $linkLabels[$index] ?? 'Link' }}</span>
                                                            <span class="text-gray-800">{{ $link }}</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Avatar Modal -->
                                @if($showAvatarModal)
                                <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                                            aria-hidden="true"
                                            wire:click="$set('showAvatarModal', false)"></div>

                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                                            <div class="bg-white p-6">
                                                <div class="flex justify-between items-start mb-4">
                                                    <h3 class="text-lg font-medium text-gray-900">
                                                        Channel Avatar
                                                    </h3>
                                                    <button type="button" class="text-gray-400 hover:text-gray-500" wire:click="$set('showAvatarModal', false)">
                                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="flex justify-center">
                                                    @if($selectedRegistration->user->channels->first()->avatar)
                                                        <img 
                                                            src="{{ asset('storage/' . $selectedRegistration->user->channels->first()->avatar) }}" 
                                                            class="max-h-96 max-w-full object-contain" 
                                                            alt="Channel Avatar">
                                                    @else
                                                        <img 
                                                            src="{{ asset('storage/avatarsimages/default-avatar.png') }}" 
                                                            class="max-h-96 max-w-full object-contain"
                                                            alt="Default Avatar">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Description Modal -->
                                @if($showDescriptionModal)
                                <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                                            aria-hidden="true"
                                            wire:click="$set('showDescriptionModal', false)"></div>

                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                            Deskripsi Channel
                                                        </h3>
                                                        <div class="mt-4 max-h-96 overflow-y-auto">
                                                            <p class="text-gray-800 whitespace-pre-line">
                                                                {{ $selectedRegistration->user->channels->first()->deskripsi }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button type="button" 
                                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                                        wire:click="$set('showDescriptionModal', false)">
                                                    Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @elseif($selectedRegistration->registration_type === 'Investor' && $selectedRegistration->user->investors->count() > 0)
                                    <div class="flex gap-6 items-center">
                                        <!-- Kiriii -->
                                        <div class="flex-shrink-0">
                                            <div class="relative">
                                                @if($selectedRegistration->user->investors->first()->avatar)
                                                <img src="{{ asset('storage/' . $selectedRegistration->user->investors->first()->avatar) }}"
                                                    class="h-32 w-32 rounded-full object-cover cursor-pointer border border-gray-300" alt="Company Logo"
                                                    wire:click="$set('showAvatarModal', true)">
                                                @else
                                                <img src="{{ asset('storage/investor_avatars/default-avatar.png') }}"
                                                    class="h-32 w-32 rounded-full object-cover cursor-pointer border border-gray-300"
                                                    alt="Default Company Logo" wire:click="$set('showAvatarModal', true)">
                                                @endif
                                                <div class="absolute -right-1 -bottom-1 bg-blue-500 hover:bg-blue-600 rounded-full p-1 text-white cursor-pointer"
                                                    wire:click="$set('showAvatarModal', true)" title="View Full Image">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Kanannn -->
                                        <div class="flex-grow space-y-3 flex flex-col justify-center">
                                            <div class="flex items-center">
                                                <span class="font-medium text-gray-600 w-48">Company:</span>
                                                <span class="text-gray-800 font-semibold">{{
                                                    $selectedRegistration->user->investors->first()->company_name }}</span>
                                            </div>
                                            <div class="flex items-start">
                                                <span class="font-medium text-gray-600 w-48">Description:</span>
                                                <div class="relative flex flex-col">
                                                    <span class="text-gray-800 line-clamp-3 max-w-xs cursor-pointer"
                                                        wire:click="$set('showDescriptionModal', true)">
                                                        {{ $selectedRegistration->user->investors->first()->description }}
                                                    </span>
                                                    <button class="absolute -right-6 bottom-0 text-blue-500 hover:text-blue-700 focus:outline-none"
                                                        wire:click="$set('showDescriptionModal', true)" title="View Full Description">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-t pt-4 space-y-3">
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-600 w-48">Alamat</span>
                                            <span class="text-gray-800">{{ $selectedRegistration->user->investors->first()->address }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-600 w-48">Investment Range</span>
                                            <span class="text-gray-800">
                                                Rp {{ number_format(explode('-', $selectedRegistration->user->investors->first()->investment_range)[0], 0, ',', '.') }}
                                                -
                                                Rp {{ number_format(explode('-', $selectedRegistration->user->investors->first()->investment_range)[1], 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-600 w-48">Website</span>
                                            <span class="text-gray-800">{{ $selectedRegistration->user->investors->first()->website }}</span>
                                        </div>
                                        @if(isset($selectedRegistration->user->investors->first()->investment_interest) &&
                                        is_array($selectedRegistration->user->investors->first()->investment_interest))
                                        <div class="flex flex-col space-y-2">
                                            <span class="font-medium text-gray-600">Minat</span>
                                            <div class="ml-4 flex flex-wrap gap-2">
                                                @foreach($selectedRegistration->user->investors->first()->investment_interest as $interest)
                                                <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">{{ $interest }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-gray-500 p-2">Tidak Ada informasi lain</p>
                                @endif
                                @if($showAvatarModal)
                                    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                                                wire:click="$set('showAvatarModal', false)"></div>

                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                            <div
                                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                                                <div class="bg-white p-6">
                                                    <div class="flex justify-between items-start mb-4">
                                                        <h3 class="text-lg font-medium text-gray-900">
                                                            Logo Perusahaan
                                                        </h3>
                                                        <button type="button" class="text-gray-400 hover:text-gray-500"
                                                            wire:click="$set('showAvatarModal', false)">
                                                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="flex justify-center">
                                                        @if($selectedRegistration->user->investors->first()->avatar)
                                                        <img src="{{ asset('storage/' . $selectedRegistration->user->investors->first()->avatar) }}"
                                                            class="max-h-96 max-w-full object-contain" alt="Company Logo">
                                                        @else
                                                        <img src="{{ asset('storage/investor_avatars/default-avatar.png') }}"
                                                            class="max-h-96 max-w-full object-contain" alt="Default Company Logo">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Description Modal -->
                                    @if($showDescriptionModal)
                                    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                                                wire:click="$set('showDescriptionModal', false)"></div>

                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                            <div
                                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                                Company Description
                                                            </h3>
                                                            <div class="mt-4 max-h-96 overflow-y-auto">
                                                                <p class="text-gray-800 whitespace-pre-line">
                                                                    {{ $selectedRegistration->user->investors->first()->description }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                    <button type="button"
                                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                                        wire:click="$set('showDescriptionModal', false)">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                            </div>
                        </div>
                    </div>

                    <!-- Dokumentttt -->
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-800">Dokumen Verifikasi</h3>
                            @php
                                $documentsPath = $selectedRegistration->registration_type === 'Creator' ? 'channel_documents' : 'investor_documents';
                                $documentCount = 0;
                                foreach (['document1_path', 'document2_path', 'document3_path'] as $doc) {
                                    if ($selectedRegistration->$doc)
                                        $documentCount++;
                                }
                            @endphp
                            <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">
                                {{ $documentCount }} document{{ $documentCount !== 1 ? 's' : '' }}
                            </span>
                        </div>

                        @if($documentCount > 0)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @if($selectedRegistration->document1_path)
                                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all hover:shadow-md">
                                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                                            <h4 class="font-medium text-gray-800 truncate">
                                                {{ $selectedRegistration->document1_name ?? ($selectedRegistration->registration_type === 'Creator' ? 'ID Verification' : 'Company Registration Document') }}
                                            </h4>
                                        </div>
                                        
                                        @php
                                            $extension = pathinfo($selectedRegistration->document1_path, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                            $isPdf = strtolower($extension) === 'pdf';
                                        @endphp

                                        <div class="aspect-w-16 aspect-h-9 bg-gray-50">
                                            @if($isImage)
                                                <img src="{{ asset('storage/' . $documentsPath . '/' . basename($selectedRegistration->document1_path)) }}"
                                                    alt="Document 1" class="object-cover w-full h-48">
                                            @elseif($isPdf)
                                                <div class="flex flex-col items-center justify-center h-48 bg-gray-50">
                                                    <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="mt-2 text-sm font-medium text-gray-600">PDF Document</span>
                                                </div>
                                            @else
                                                <div class="flex flex-col items-center justify-center h-48 bg-gray-50">
                                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="mt-2 text-sm font-medium text-gray-600">File Dokumen</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="p-4">
                                            <a href="{{ asset('storage/' . $documentsPath . '/' . basename($selectedRegistration->document1_path)) }}"
                                                target="_blank"
                                                class="flex items-center justify-center w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                {{ $isPdf ? 'View PDF' : 'View Document' }}
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                @if($selectedRegistration->document2_path)
                                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all hover:shadow-md">
                                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                                            <h4 class="font-medium text-gray-800 truncate">
                                                {{ $selectedRegistration->document2_name ?? ($selectedRegistration->registration_type === 'Creator' ? 'Channel Verification' : 'Business License') }}
                                            </h4>
                                        </div>
                                        
                                        @php
                                            $extension = pathinfo($selectedRegistration->document2_path, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                            $isPdf = strtolower($extension) === 'pdf';
                                        @endphp

                                        <div class="aspect-w-16 aspect-h-9 bg-gray-50">
                                            @if($isImage)
                                                <img src="{{ asset('storage/' . $documentsPath . '/' . basename($selectedRegistration->document2_path)) }}"
                                                    alt="Document 2" class="object-cover w-full h-48">
                                            @elseif($isPdf)
                                                <div class="flex flex-col items-center justify-center h-48 bg-gray-50">
                                                    <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="mt-2 text-sm font-medium text-gray-600">PDF Document</span>
                                                </div>
                                            @else
                                                <div class="flex flex-col items-center justify-center h-48 bg-gray-50">
                                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="mt-2 text-sm font-medium text-gray-600">File Dokumen</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="p-4">
                                            <a href="{{ asset('storage/' . $documentsPath . '/' . basename($selectedRegistration->document2_path)) }}"
                                                target="_blank"
                                                class="flex items-center justify-center w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                {{ $isPdf ? 'View PDF' : 'View Document' }}
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                @if($selectedRegistration->document3_path)
                                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all hover:shadow-md">
                                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                                            <h4 class="font-medium text-gray-800 truncate">
                                                {{ $selectedRegistration->document3_name ?? 'Additional Document' }}
                                            </h4>
                                        </div>
                                        
                                        @php
                                            $extension = pathinfo($selectedRegistration->document3_path, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                            $isPdf = strtolower($extension) === 'pdf';
                                        @endphp

                                        <div class="aspect-w-16 aspect-h-9 bg-gray-50">
                                            @if($isImage)
                                                <img src="{{ asset('storage/' . $documentsPath . '/' . basename($selectedRegistration->document3_path)) }}"
                                                    alt="Document 3" class="object-cover w-full h-48">
                                            @elseif($isPdf)
                                                <div class="flex flex-col items-center justify-center h-48 bg-gray-50">
                                                    <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="mt-2 text-sm font-medium text-gray-600">PDF Document</span>
                                                </div>
                                            @else
                                                <div class="flex flex-col items-center justify-center h-48 bg-gray-50">
                                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="mt-2 text-sm font-medium text-gray-600">File Dokumen</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="p-4">
                                            <a href="{{ asset('storage/' . $documentsPath . '/' . basename($selectedRegistration->document3_path)) }}"
                                                target="_blank"
                                                class="flex items-center justify-center w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                {{ $isPdf ? 'View PDF' : 'View Document' }}
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center bg-gray-50 p-8 rounded-xl border border-gray-100">
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p class="mt-4 text-gray-500 font-medium">Tidak ada dokumen</p>
                            </div>
                        @endif
                    </div>

                    <!-- Action buttons -->
                    <div class="flex flex-wrap justify-end gap-3 border-t border-gray-100 pt-4">
                        <button wire:click="closeModal"
                            class="flex items-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-4 rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Close
                        </button>
                    </div>
                </div>
                @endif
                
            </div>
        </div>
    </div>
</div>