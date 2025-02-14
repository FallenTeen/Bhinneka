<div class="gap-8 px-8 my-4">
    @if ($search)
        <h3 class="text-2xl font-semibold mb-4">Channel</h3>

        @if (count($channels) > 0)
            <div class="grid grid-cols-3 gap-4">
                @foreach ($channels as $channel)
                    <a href="{{ route('channel.show', $channel->slug) }}" class="hover:scale-105 hover:shadow-2xl p-4 border rounded-lg shadow-md flex items-center space-x-4 duration-300">
                        <img src="{{ asset('storage/' . $channel->avatar) }}" alt="Channel Avatar"
                            class="w-16 h-16 rounded-full object-cover">
                        <div>
                            <h2 class="text-xl font-bold">{{ $channel->channel_name }}</h2>
                            <p class="text-gray-600 line-clamp-2">{{ $channel->deskripsi }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="w-full flex justify-center">
                <span class="justify-center text-center px-12 py-6 bg-white shadow-lg rounded-lg text-xl">Tidak ada Channel
                    yang sesuai dengan Pencarian tersebut.</span>
            </div>
        @endif
    @endif

    @if (count($channels) >= $jml_display)
        <button wire:click="loadMore"
            class="mt-4 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition duration-300">
            Load More
        </button>
    @endif
</div>