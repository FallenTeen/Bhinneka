<div class="bg-gray-100 py-4 sm:py-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-4 sm:p-6 bg-gradient-to-r from-ungumain to-indigo-600">
                <h1 class="text-2xl sm:text-3xl font-bold text-white">Postingan Investor</h1>
                <p class="text-blue-100 mt-1 text-sm sm:text-base">Cari peluang tepat untukmu
                </p>
            </div>

            <!-- Search and Filters -->
            <div class="p-4 bg-gray-50 border-b space-y-3 sm:space-y-0 sm:flex sm:flex-wrap sm:items-center sm:gap-4">
                <div class="sm:flex-1 sm:min-w-[250px]">
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Cari berdasarkan judul, posisi dan tempat..."
                        class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex items-center gap-2">
                    <label class="text-gray-700 text-sm sm:text-base">Status:</label>
                    <select wire:model.live="filterStatus"
                        class="border rounded-lg px-2 sm:px-3 py-2 text-sm sm:text-base focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <label class="text-gray-700 text-sm sm:text-base">Tampilkan</label>
                    <select wire:model.live="perPage"
                        class="border rounded-lg px-2 sm:px-3 py-2 text-sm sm:text-base focus:ring-blue-500 focus:border-blue-500">
                        <option>5</option>
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                @if ($posts->isEmpty())
                    <div class="text-center py-8 sm:py-12">
                        <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-base sm:text-lg font-medium text-gray-900">Tidak ada postingan yang sesuai</h3>
                        <p class="mt-1 text-xs sm:text-sm text-gray-500">Cobalah untuk menyesuaikan pencarian.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        @foreach ($posts as $post)
                            <div
                                class="bg-white rounded-lg border shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                                <div class="p-3 sm:p-4 border-b bg-gray-50">
                                    <div class="flex justify-between items-start">
                                        <h2 class="text-lg sm:text-xl font-bold text-gray-800 truncate">
                                            {{ $post->title }}
                                        </h2>
                                        <span class="px-2 py-1 rounded-full text-xs font-medium 
                                                    @if($post->status === 'Open')
                                                        bg-green-100 text-green-800
                                                    @elseif($post->status === 'Closed')
                                                        bg-red-100 text-red-800
                                                    @elseif($post->status === 'Pending')
                                                        bg-yellow-100 text-yellow-800
                                                    @else
                                                        bg-blue-100 text-blue-800
                                                    @endif
                                                ">
                                            {{ $post->status }}
                                        </span>
                                    </div>
                                    <p class="text-sm sm:text-base text-gray-600 mt-1">{{ $post->position }}</p>
                                </div>

                                <div class="p-3 sm:p-4">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="text-sm sm:text-base text-gray-700 truncate">{{ $post->location }}</span>
                                    </div>

                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span
                                            class="text-sm sm:text-base text-gray-700 font-medium">{{ $post->formatted_salary_range }}</span>
                                    </div>

                                    @if($post->required_skills && count($post->required_skills) > 0)
                                        <div class="mt-3">
                                            <p class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">Kemampuan yang dibutuhkan</p>
                                            <div class="flex flex-wrap gap-1 sm:gap-2">
                                                @foreach($post->required_skills as $skill)
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="px-3 sm:px-4 py-3 bg-gray-50 border-t flex gap-2">
                                    <a href="{{ route('investor.post.show', $post->id) }}"
                                        class="flex-1 inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 text-xs sm:text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Lihat Detail
                                    </a>
                                    <a href="mailto:{{ $post->contact_email }}"
                                        class="flex-1 inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-xs sm:text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Kirim Email
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>