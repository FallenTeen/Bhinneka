<div class="w-full bg-white dark:bg-gray-800 rounded-xl p-4 md:p-6 shadow-lg">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <span class="text-xl font-bold text-gray-800 dark:text-gray-200">Job Openings</span>
        <div class="flex items-center gap-4">
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search positions..."
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 pr-10">
                <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" wire:model.live="showClosed"
                    class="rounded border-gray-300 text-ungumain focus:ring-ungumain">
                <span class="text-sm text-gray-600 dark:text-gray-400">Show closed</span>
            </label>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($posts as $post)
            <div x-data="{ expanded: false }"
                class="border dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex flex-col sm:flex-row justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $post->title }}
                            </h3>
                            <span
                                class="px-2 py-1 rounded text-xs font-medium
                                    {{ $post->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </div>
                        <div
                            class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-600 dark:text-gray-400">
                            <span class="flex items-center gap-1">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $post->position }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $post->location }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $post->employment_type }}
                            </span>
                        </div>
                    </div>
                    <button @click="expanded = !expanded"
                        class="text-ungumain hover:text-ungumain/80 transition-colors text-sm font-medium">
                        View Details
                    </button>
                </div>

                <div x-show="expanded" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform -translate-y-2" class="mt-4 space-y-4">
                    <div class="prose dark:prose-invert max-w-none">
                        <p>{{ $post->description }}</p>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Required Skills:</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->required_skills as $skill)
                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-full text-sm">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-900 dark:text-gray-100">Salary Range:</span>
                            <p class="text-gray-600 dark:text-gray-400">{{ $post->formatted_salary_range }}</p>
                        </div>
                        @if($post->deadline)
                            <div>
                                <span class="font-medium text-gray-900 dark:text-gray-100">Application Deadline:</span>
                                <p class="text-gray-600 dark:text-gray-400">{{ $post->deadline->format('d M Y') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t dark:border-gray-700">
                        <a href="mailto:{{ $post->contact_email }}"
                            class="inline-flex items-center gap-2 text-ungumain hover:text-ungumain/80 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Apply Now
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 text-gray-500">
                Tidak ada pembukaan
            </div>
        @endforelse

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</div>