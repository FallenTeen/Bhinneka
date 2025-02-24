<div class="p-6 bg-gray-50">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Review Registrations</h1>
        <p class="text-gray-600">Manage and verify registration requests</p>
    </div>

    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6 bg-white p-4 rounded-lg shadow">
        <div class="flex-1">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari nama, email, channel, atau perusahaan..." 
                    class="pl-10 w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        <div class="flex gap-4">
            <select wire:model.live="perPage" class="border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="10">10 per halaman</option>
                <option value="25">25 per halaman</option>
                <option value="50">50 per halaman</option>
                <option value="100">100 per halaman</option>
            </select>
        </div>
    </div>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="sortBy('user.name')" class="flex items-center gap-1">
                            Nama
                            @if ($sortField === 'user.name')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    @if ($sortAsc)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    @endif
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="sortBy('user.email')" class="flex items-center gap-1">
                            Email
                            @if ($sortField === 'user.email')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    @if ($sortAsc)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    @endif
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="sortBy('registration_type')" class="flex items-center gap-1">
                            Tipe
                            @if ($sortField === 'registration_type')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    @if ($sortAsc)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    @endif
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="sortBy('status')" class="flex items-center gap-1">
                            Status
                            @if ($sortField === 'status')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    @if ($sortAsc)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    @endif
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="sortBy('created_at')" class="flex items-center gap-1">
                            Tanggal
                            @if ($sortField === 'created_at')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    @if ($sortAsc)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    @endif
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dokumen
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($registrations as $registration)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-gray-900">{{ $registration->user->name }}</div>
                        @if($registration->registration_type === 'Creator' && $registration->user->channels->count() > 0)
                            <div class="text-sm text-gray-500">
                                Channel: {{ $registration->user->channels->first()->channel_name }}
                            </div>
                        @elseif($registration->registration_type === 'Investor' && $registration->user->investors->count() > 0)
                            <div class="text-sm text-gray-500">
                                Company: {{ $registration->user->investors->first()->company_name }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $registration->user->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $registration->registration_type === 'Creator' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $registration->registration_type }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $registration->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($registration->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $registration->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex space-x-2">
                            @php
                                $documentCount = 0;
                                foreach(['document1_path', 'document2_path', 'document3_path'] as $doc) {
                                    if ($registration->$doc) $documentCount++;
                                }
                            @endphp
                            
                            <span class="text-xs text-gray-500">{{ $documentCount }} dokumen</span>
                            
                            @if($documentCount > 0)
                                <button wire:click="$set('viewingRegistration', {{ $registration->id === $viewingRegistration ? 'null' : $registration->id }})" class="text-blue-600 hover:text-blue-800 text-xs">
                                    @if($viewingRegistration === $registration->id)
                                        Tutup dokumen
                                    @else
                                        Lihat dokumen
                                    @endif
                                </button>
                            @else
                                <span class="text-xs text-gray-400">Tidak ada dokumen</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button wire:click="showDetails({{ $registration->id }})" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded text-xs">
                                Lihat Profil
                            </button>
                            @if($registration->status === 'pending')
                                <button wire:click="approveRegistration({{ $registration->id }})" class="bg-green-500 hover:bg-green-600 text-white py-1 px-2 rounded text-xs">
                                    Approve
                                </button>
                                <button wire:click="rejectRegistration({{ $registration->id }})" class="bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded text-xs">
                                    Reject
                                </button>
                            @else
                                <button wire:click="resetStatus({{ $registration->id }})" class="bg-gray-500 hover:bg-gray-600 text-white py-1 px-2 rounded text-xs">
                                    Reset Status
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @if($viewingRegistration === $registration->id)
                <tr class="bg-gray-50">
                    <td colspan="8" class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @php
                                $documentsPath = $registration->registration_type === 'Creator' ? 'channel_documents' : 'investor_documents';
                            @endphp
                            
                            @if($registration->document1_path)
                                <div class="bg-white p-4 rounded-lg shadow">
                                    <h4 class="font-medium mb-2">{{ $registration->document1_name ?? ($registration->registration_type === 'Creator' ? 'ID Verification' : 'Company Registration Document') }}</h4>
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
                                            <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <a href="{{ asset('storage/' . $documentsPath . '/' . basename($registration->document1_path)) }}" 
                                                target="_blank" class="mt-2 text-blue-600 hover:underline">
                                                Lihat PDF
                                            </a>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
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
                                    <h4 class="font-medium mb-2">{{ $registration->document2_name ?? ($registration->registration_type === 'Creator' ? 'Channel Verification' : 'Additional Document 1') }}</h4>
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
                                            <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <a href="{{ asset('storage/' . $documentsPath . '/' . basename($registration->document2_path)) }}" 
                                                target="_blank" class="mt-2 text-blue-600 hover:underline">
                                                Lihat PDF
                                            </a>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
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
                                    <h4 class="font-medium mb-2">{{ $registration->document3_name ?? ($registration->registration_type === 'Creator' ? 'Additional Document' : 'Additional Document 2') }}</h4>
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
                                            <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <a href="{{ asset('storage/' . $documentsPath . '/' . basename($registration->document3_path)) }}" 
                                                target="_blank" class="mt-2 text-blue-600 hover:underline">
                                                Lihat PDF
                                            </a>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
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
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada registrasi</h3>
                        <p class="mt-1 text-sm text-gray-500">Tidak ada pendaftaran yang perlu diverifikasi saat ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $registrations->links() }}
    </div>
    <!-- Registration Details Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center {{ $showModal ? '' : 'hidden' }}" wire:click.self="closeModal">
    <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto" x-on:click.away="$wire.closeModal()">
        @if($selectedRegistration)
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">
                    {{ $selectedRegistration->user->name }} 
                    <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $selectedRegistration->registration_type === 'Creator' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ ucfirst($selectedRegistration->registration_type) }}
                    </span>
                </h2>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-medium mb-2">User Information</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="mb-2"><span class="font-medium">Name:</span> {{ $selectedRegistration->user->name }}</p>
                        <p class="mb-2"><span class="font-medium">Email:</span> {{ $selectedRegistration->user->email }}</p>
                        <p class="mb-2"><span class="font-medium">Registration Date:</span> {{ $selectedRegistration->created_at->format('d M Y H:i') }}</p>
                        <p><span class="font-medium">Status:</span> 
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $selectedRegistration->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($selectedRegistration->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($selectedRegistration->status) }}
                            </span>
                        </p>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium mb-2">{{ $selectedRegistration->registration_type === 'Creator' ? 'Creator' : 'Company' }} Information</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        @if($selectedRegistration->registration_type === 'Creator' && $selectedRegistration->user->channels->count() > 0)
                            <p class="mb-2"><span class="font-medium">Channel Name:</span> {{ $selectedRegistration->user->channels->first()->channel_name }}</p>
                            <p class="mb-2"><span class="font-medium">Followers:</span> {{ number_format($selectedRegistration->user->channels->first()->followers_count) }}</p>
                            <p class="mb-2"><span class="font-medium">Platform:</span> {{ $selectedRegistration->user->channels->first()->platform }}</p>
                            <p><span class="font-medium">Verified:</span> {{ $selectedRegistration->user->channels->first()->verified ? 'Yes' : 'No' }}</p>
                        @elseif($selectedRegistration->registration_type === 'Investor' && $selectedRegistration->user->investors->count() > 0)
                            <p class="mb-2"><span class="font-medium">Company Name:</span> {{ $selectedRegistration->user->investors->first()->company_name }}</p>
                            <p class="mb-2"><span class="font-medium">Industry:</span> {{ $selectedRegistration->user->investors->first()->industry }}</p>
                            <p class="mb-2"><span class="font-medium">Location:</span> {{ $selectedRegistration->user->investors->first()->location }}</p>
                            <p><span class="font-medium">Verified:</span> {{ $selectedRegistration->user->investors->first()->verified ? 'Yes' : 'No' }}</p>
                        @else
                            <p class="text-gray-500">No additional information available</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <h3 class="text-lg font-medium mb-4">Verification Documents</h3>
                @php
                    $documentsPath = $selectedRegistration->registration_type === 'Creator' ? 'channel_documents' : 'investor_documents';
                    $documentCount = 0;
                    foreach(['document1_path', 'document2_path', 'document3_path'] as $doc) {
                        if ($selectedRegistration->$doc) $documentCount++;
                    }
                @endphp
                
                @if($documentCount > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @if($selectedRegistration->document1_path)
                            <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                                <h4 class="font-medium mb-3">{{ $selectedRegistration->document1_name ?? ($selectedRegistration->registration_type === 'Creator' ? 'ID Verification' : 'Company Registration Document') }}</h4>
                                @php
                                    $extension = pathinfo($selectedRegistration->document1_path, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                    $isPdf = strtolower($extension) === 'pdf';
                                @endphp
                                
                                <div class="aspect-w-16 aspect-h-9 mb-3">
                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $documentsPath . '/' . basename($selectedRegistration->document1_path)) }}" 
                                            alt="Document 1" class="w-full h-auto rounded object-cover">
                                    @elseif($isPdf)
                                        <div class="flex flex-col items-center justify-center h-40 bg-gray-100 rounded">
                                            <svg class="w-16 h-16 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="mt-2 text-sm">PDF Document</span>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center justify-center h-40 bg-gray-100 rounded">
                                            <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="mt-2 text-sm">Document File</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <a href="{{ asset('storage/' . $documentsPath . '/' . basename($selectedRegistration->document1_path)) }}" 
                                    target="_blank" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                                    {{ $isPdf ? 'View PDF' : 'View Document' }}
                                </a>
                            </div>
                        @endif
                        
                        @if($selectedRegistration->document2_path)
                            <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                                <h4 class="font-medium mb-3">{{ $selectedRegistration->document2_name ?? ($selectedRegistration->registration_type === 'Creator' ? 'Channel Verification' : 'Business License') }}</h4>
                                @php
                                    $extension = pathinfo($selectedRegistration->document2_path, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                    $isPdf = strtolower($extension) === 'pdf';
                                @endphp
                                
                                <div class="aspect-w-16 aspect-h-9 mb-3">
                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $documentsPath . '/' . basename($selectedRegistration->document2_path)) }}" 
                                            alt="Document 2" class="w-full h-auto rounded object-cover">
                                    @elseif($isPdf)
                                        <div class="flex flex-col items-center justify-center h-40 bg-gray-100 rounded">
                                            <svg class="w-16 h-16 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="mt-2 text-sm">PDF Document</span>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center justify-center h-40 bg-gray-100 rounded">
                                            <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="mt-2 text-sm">Document File</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <a href="{{ asset('storage/' . $documentsPath . '/' . basename($selectedRegistration->document2_path)) }}" 
                                    target="_blank" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                                    {{ $isPdf ? 'View PDF' : 'View Document' }}
                                </a>
                            </div>
                        @endif
                        
                        @if($selectedRegistration->document3_path)
                            <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                                <h4 class="font-medium mb-3">{{ $selectedRegistration->document3_name ?? 'Additional Document' }}</h4>
                                @php
                                    $extension = pathinfo($selectedRegistration->document3_path, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                    $isPdf = strtolower($extension) === 'pdf';
                                @endphp
                                
                                <div class="aspect-w-16 aspect-h-9 mb-3">
                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $documentsPath . '/' . basename($selectedRegistration->document3_path)) }}" 
                                            alt="Document 3" class="w-full h-auto rounded object-cover">
                                    @elseif($isPdf)
                                        <div class="flex flex-col items-center justify-center h-40 bg-gray-100 rounded">
                                            <svg class="w-16 h-16 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="mt-2 text-sm">PDF Document</span>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center justify-center h-40 bg-gray-100 rounded">
                                            <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="mt-2 text-sm">Document File</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <a href="{{ asset('storage/' . $documentsPath . '/' . basename($selectedRegistration->document3_path)) }}" 
                                    target="_blank" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                                    {{ $isPdf ? 'View PDF' : 'View Document' }}
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center bg-gray-50 p-8 rounded-lg">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-4 text-gray-600">No documents uploaded</p>
                    </div>
                @endif
            </div>
            
            <div class="flex justify-end space-x-3">
                <button wire:click="closeModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded">
                    Close
                </button>
                @if($selectedRegistration->status === 'pending')
                    <button wire:click="approveRegistration({{ $selectedRegistration->id }})" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
                        Approve Registration
                    </button>
                    <button wire:click="rejectRegistration({{ $selectedRegistration->id }})" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
                        Reject Registration
                    </button>
                @else
                    <button wire:click="resetStatus({{ $selectedRegistration->id }})" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded">
                        Reset to Pending
                    </button>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
</div>