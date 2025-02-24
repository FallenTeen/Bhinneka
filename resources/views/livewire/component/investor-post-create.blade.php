<div class="max-w-2xl mx-auto p-4">
    <form wire:submit="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Judul Post</label>
            <input type="text" wire:model="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea wire:model="description" rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Posisi</label>
            <input type="text" wire:model="position" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('position') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Lokasi</label>
            <input type="text" wire:model="location" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Tipe Pekerjaan</label>
            <select wire:model="employment_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Pilih Tipe Pekerjaan</option>
                <option value="full-time">Full Time</option>
                <option value="part-time">Part Time</option>
                <option value="contract">Kontrak</option>
                <option value="freelance">Freelance</option>
            </select>
            @error('employment_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Keahlian yang Dibutuhkan</label>
            <div class="flex gap-2 mb-2">
                <div class="relative w-full">
                    <input type="text" wire:model.live="skill_search" placeholder="Cari keahlian..."
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">

                    @if(!empty($filteredSkills))
                        <div class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg border">
                            <ul class="py-1 max-h-60 overflow-auto">
                                @foreach($filteredSkills as $skillData)
                                    <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer flex justify-between items-center"
                                        wire:click="addSkill('{{ $skillData['skill'] }}')">
                                        <span>{{ $skillData['skill'] }}</span>
                                        <span class="text-xs text-gray-500">{{ $skillData['category'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Kategori Keahlian</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($available_skills as $category => $skills)
                                <div class="border rounded-lg p-3">
                                    <h5 class="font-medium text-gray-800 mb-2">{{ $category }}</h5>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($skills as $skill)
                                                            <button type="button" wire:click="addSkill('{{ $skill }}')" class="px-2 py-1 text-sm rounded-full 
                                                                                                                   {{ in_array($skill, $required_skills)
                                            ? 'bg-blue-500 text-white'
                                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                                                {{ $skill }}
                                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Keahlian Terpilih</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($required_skills as $index => $skill)
                        <span class="bg-blue-100 px-2 py-1 rounded-full text-sm flex items-center">
                            {{ $skill }}
                            <button type="button" wire:click="removeSkill({{ $index }})"
                                class="ml-2 text-red-500">&times;</button>
                        </span>
                    @endforeach
                </div>
            </div>
            @error('required_skills') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Gaji Minimal</label>
                <input type="number" wire:model="salary_range_start"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('salary_range_start') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Gaji Maksimal</label>
                <input type="number" wire:model="salary_range_end"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('salary_range_end') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Deadline</label>
            <input type="date" wire:model="deadline" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('deadline') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email Kontak</label>
            <input type="email" wire:model="contact_email"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('contact_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('investor.post.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                Buat Post
            </button>
        </div>
    </form>
</div>