<div class="bg-gray-100 py-6 min-h-screen">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-4">
            <a href="{{ route('allinvestor') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke semua postingan
            </a>
        </div>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-4 sm:p-6 md:p-8 bg-gradient-to-r from-ungumain to-indigo-600">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $post->title }}</h1>
                        <p class="text-blue-100 mt-1 text-base sm:text-lg">{{ $post->position }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium 
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
                </div>
            </div>
            <div class="p-4 sm:p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 space-y-6">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Lowongan</h2>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                                <div class="flex">
                                    <div class="w-1/3 text-sm text-gray-500">Lokasi</div>
                                    <div class="w-2/3 text-gray-800">{{ $post->location }}</div>
                                </div>
                                <div class="flex">
                                    <div class="w-1/3 text-sm text-gray-500">Salary Range</div>
                                    <div class="w-2/3 text-gray-800 font-medium">{{ $post->formatted_salary_range }}
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="w-1/3 text-sm text-gray-500">Tanggal Diposting</div>
                                    <div class="w-2/3 text-gray-800">{{ $post->created_at->format('M d, Y') }}</div>
                                </div>
                                @if($post->application_deadline)
                                    <div class="flex">
                                        <div class="w-1/3 text-sm text-gray-500">Tanggal penerimaan</div>
                                        <div class="w-2/3 text-gray-800">
                                            {{ \Carbon\Carbon::parse($post->application_deadline)->format('M d, Y') }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Deskripsi</h2>
                            <div class="prose max-w-none">
                                {!! $post->description !!}
                            </div>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Kemampuan yang dibutuhkan</h2>
                            @if($post->required_skills && count($post->required_skills) > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($post->required_skills as $skill)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">Tidak ada skill spesisifk yang dibutuhkan</p>
                            @endif
                        </div>

                        @if($post->additional_info)
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi tambahan</h2>
                                <div class="prose max-w-none">
                                    {!! $post->additional_info !!}
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="space-y-6">
                        @if($investorProfile)
                            <div class="bg-gray-50 rounded-lg p-4 border">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Tentang
                                    {{ $investorProfile->company_name }}
                                </h3>
                                <div class="flex items-center mb-3">
                                    @if($investorProfile->avatar)
                                        <img src="{{ $investorProfile->avatar ? asset('storage/' . $investorProfile->avatar) : asset('storage/investor_avatars/default.png') }}"
                                            alt="{{ $investorProfile->company_name }}'s Logo"
                                            class="w-32 h-32 object-cover transition-all duration-300 rounded-full">
                                    @else
                                        <div class="w-32 h-32 rounded-full bg-indigo-200 flex items-center justify-center mr-3">
                                            <span
                                                class="text-indigo-700 font-bold text-lg">{{ substr($investorProfile->company_name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <h4 class="font-medium">{{ $investorProfile->company_name }}</h4>
                                        @if($investorProfile->verified)
                                            <span class="inline-flex items-center text-xs text-green-800">
                                                <svg class="w-4 h-4 mr-1 text-green-600" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414-1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Verified Investor
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mb-3">{{ Str::limit($investorProfile->description, 150) }}
                                </p>

                                @if($investorProfile->website)
                                    <a href="{{ $investorProfile->website }}" target="_blank"
                                        class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Visit Website
                                    </a>
                                @endif

                                @if($investorProfile->address)
                                    <p class="text-sm text-gray-600 mb-3">
                                        <strong>Alamat:</strong> {{ $investorProfile->address }}
                                    </p>
                                @endif

                                @if($investorProfile->investment_range)
                                                        @php
                                                            $ranges = explode('-', $investorProfile->investment_range);
                                                            if (count($ranges) == 2) {
                                                                $start = 'Rp ' . number_format($ranges[0], 0, ',', '.');
                                                                $end = 'Rp ' . number_format($ranges[1], 0, ',', '.');
                                                                $formattedRange = $start . ' - ' . $end;
                                                            } else {
                                                                $formattedRange = $investorProfile->investment_range;
                                                            }
                                                        @endphp
                                                        <p class="text-sm text-gray-600 mb-3">
                                                            <strong>Rentang Investasi:</strong> {{ $formattedRange }}
                                                        </p>
                                @endif

                                @if($investorProfile->investment_interest && count($investorProfile->investment_interest) > 0)
                                    <p class="text-sm text-gray-600 mb-3">
                                        <strong>Minat Investasi:</strong>
                                        @foreach($investorProfile->investment_interest as $interest)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">{{ $interest }}</span>
                                        @endforeach
                                    </p>
                                @endif

                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border w-full mt-12">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Tertarik untuk bergabung?</h3>
                                <a href="mailto:{{ $post->contact_email }}"
                                    class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Apply Now
                                    <svg class="ml-2 -mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                                <p class="mt-2 text-sm text-gray-500">Email: {{ $post->contact_email }}</p>
                            </div>
                        @endif
                        @if(count($relatedPosts) > 0)
                            <div class="bg-gray-50 rounded-lg p-4 border">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Lowongan lain</h3>
                                <div class="space-y-3">
                                    @foreach($relatedPosts as $related)
                                        <a href="{{ route('investor.post.show', $related->id) }}"
                                            class="block p-3 bg-white rounded border hover:shadow-sm">
                                            <h4 class="font-medium text-gray-800">{{ $related->title }}</h4>
                                            <div class="text-sm text-gray-600 mt-1">{{ $related->position }}</div>
                                            <div class="text-xs text-gray-500 mt-1">{{ $related->location }}</div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>