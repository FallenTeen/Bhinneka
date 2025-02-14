<div class="xs:flex-col-reverse lg:flex gap-8 mt-16 px-8 lg:px-12 w-full">
    <div class="max-w-full my-12 relative lg:w-1/2">
        @if(!$isSubscribed && $contentVideos->is_exclusive && !$isOwner)
            <img src="{{ route('thumbnail', ['encodedUrl' => $thumb]) }}" alt="{{ $contentVideos->judul }}"
                class="w-full h-full object-cover rounded-lg">
            <div
                class="absolute inset-0 bg-black bg-opacity-50 hover:bg-opacity-75 duration-300 backdrop-blur-sm rounded-lg text-center flex items-center justify-center text-white">
                Subscribe to view</div>
        @else
            <div class="relative pb-[56.25%] h-0">
                <iframe src="{{ $contentVideos->url }}" title="{{ $contentVideos->judul }}"
                    class="absolute top-0 left-0 w-full h-full object-cover rounded-lg">
                </iframe>
            </div>

        @endif
    </div>
    <div class="max-w-full my-12 relative lg:w-1/2">
        <div class="w-full">
            <a href="{{ route('channel.show', $channel->slug) }}"
                class="hover:text-gray-700 lg:mx-8 mt-4 flex max-w-xs px-4 py-2 hover:shadow-2xl rounded-xl shadow-lg items-center gap-6">
                @if($channel->avatar)
                    <img src="{{ asset('storage/' . $channel->avatar) }}" class="w-16 aspect-square rounded-full"
                        alt="Channel Avatar">
                @else
                    <img src="{{ asset('storage/avatarsimages/default-avatar.png') }}" alt="Default Avatar"
                        class="w-full aspect-auto rounded-full">
                @endif
                <span class="font-bold">{{ $channel->channel_name }}</span>
            </a>
        </div>
        <div class="flex flex-col mt-12 lg:mx-8">
            <span class=" font-bold text-4xl">{{ $contentVideos->judul }}</span>
            <span class="text-sm text-gray-500 tracking-wider mt-4">DESKRIPSI</span>
            <span>{{ $contentVideos->deskripsi }}</span>
        </div>
    </div>
</div>