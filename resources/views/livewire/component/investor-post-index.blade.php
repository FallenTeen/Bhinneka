<div class="px-12 py-12">
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Post Investasi Anda</h2>
            <a href="{{ route('investor.post.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Post Baru
            </a>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Cari berdasarkan judul atau posisi..."
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <select wire:model.live.debounce.300ms="employmentFilter"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Jenis Pekerjaan</option>
                        <option value="Full-time">Full-time</option>
                        <option value="Part-time">Part-time</option>
                        <option value="Contract">Contract</option>
                        <option value="Internship">Internship</option>
                    </select>
                </div>
                <div>
                    <select wire:model.live.debounce.300ms="sortBy"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="latest">Terbaru</option>
                        <option value="deadline">Deadline Terdekat</option>
                        <option value="salary_high">Gaji Tertinggi</option>
                        <option value="salary_low">Gaji Terendah</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 {{ isset($posts) && $posts->count() > 1 ? 'lg:grid-cols-2' : '' }} gap-6">
        @forelse ($posts as $post)
            <div class="border rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition duration-200">
                <div class="flex justify-between items-start">
                    <div class="flex-grow">
                        <div class="flex items-center mb-2">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $post->title }}</h3>
                            @if($post->is_featured)
                                <span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Featured</span>
                            @endif
                        </div>
                        <div class="flex items-center text-gray-600 mb-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $post->position }} - {{ $post->location }}
                        </div>
                        <div class="flex items-center text-gray-600 mb-3">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $post->getFormattedSalaryRangeAttribute() }}
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <button wire:click="editPost({{ $post->id }})"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </button>
                        <button wire:click="deletePost({{ $post->id }})"
                            wire:confirm="Apakah Anda yakin ingin menghapus post ini?"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-gray-700 leading-relaxed">{{ Str::limit($post->description, 150) }}</p>
                </div>

                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach($post->required_skills as $skill)
                        <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-600">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Deadline: {{ $post->deadline->format('d M Y') }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $post->employment_type }}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada post</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat post investasi baru.</p>
            </div>
        @endforelse
    </div>
    <div class="mt-6">
        {{ $posts->links() }}
    </div>
    @if ($editingPost)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" x-data="{ show: true }"
            x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-lg bg-white"
                @click.away="$wire.set('editingPost', null)">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Edit Post</h3>
                    <form wire:submit.prevent="updatePost" class="space-y-6">
                        <input type="hidden" wire:model="editingPost.id">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                                <input type="text" wire:model.defer="editingPost.title" id="title"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                @error('editingPost.title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Posisi</label>
                                <input type="text" wire:model.defer="editingPost.position" id="position"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                @error('editingPost.position')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea wire:model.defer="editingPost.description" id="description" rows="4"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>
                                @error('editingPost.description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                                <input type="text" wire:model.defer="editingPost.location" id="location"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                @error('editingPost.location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="employment_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis
                                    Pekerjaan</label>
                                <select wire:model.defer="editingPost.employment_type" id="employment_type"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <option value="">Pilih jenis pekerjaan</option>
                                    <option value="Full-time">Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Contract">Contract</option>
                                    <option value="Internship">Internship</option>
                                    <option value="Freelance">Freelance</option>
                                </select>
                                @error('editingPost.employment_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Salary Range Fields --}}
                            <div>
                                <label for="salary_range_start" class="block text-sm font-medium text-gray-700 mb-1">Gaji
                                    Minimum</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" wire:model.defer="editingPost.salary_range_start"
                                        id="salary_range_start"
                                        class="w-full pl-12 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                        placeholder="0">
                                </div>
                                @error('editingPost.salary_range_start')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="salary_range_end" class="block text-sm font-medium text-gray-700 mb-1">Gaji
                                    Maximum</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" wire:model.defer="editingPost.salary_range_end"
                                        id="salary_range_end"
                                        class="w-full pl-12 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                        placeholder="0">
                                </div>
                                @error('editingPost.salary_range_end')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
                                <div class="flex gap-4">
                                    <input type="date" wire:model.defer="editingPost.deadline" id="deadline"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <button type="button" wire:click="closePost"
                                        wire:confirm="Apakah Anda yakin ingin menutup post ini?"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Tutup
                                    </button>
                                </div>
                                @error('editingPost.deadline')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                    Kontak</label>
                                <input type="email" wire:model.defer="editingPost.contact_email" id="contact_email"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                @error('editingPost.contact_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keahlian yang Dibutuhkan</label>
                                <div class="space-y-4">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($required_skills as $index => $skill)
                                            <div class="flex items-center bg-blue-50 px-3 py-1 rounded-full">
                                                <span class="text-blue-700 text-sm">{{ $skill }}</span>
                                                <button type="button" wire:click="removeSkill({{ $index }})"
                                                    class="ml-2 text-blue-400 hover:text-blue-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="flex gap-2">
                                        <div class="flex-grow">
                                            <input type="text" wire:model.defer="skill_search"
                                                wire:keydown.enter.prevent="addSkill" placeholder="Tambah keahlian baru..."
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        </div>
                                        <button type="button" wire:click="addSkill"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2 flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                <button type="button" wire:click="$set('editingPost', null)"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Batal
                                </button>

                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Perubahan
                                </button>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>