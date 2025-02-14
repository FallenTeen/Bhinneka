<div>
    @php
        use Illuminate\Support\Facades\Crypt;
    @endphp
    @if ($search)
        <h3 class="text-2xl font-semibold mb-4 px-8">Content</h3>
    @endif
    <div
        class="grid justify-center items-center grid-cols-{{ $contentVideos->count() == 0 ? '1' : '1 md:grid-cols-3 lg:grid-cols-4' }} gap-8 px-8">

        @if ($contentVideos->count() > 0)

            @foreach ($contentVideos as $video)
                <div class="flex-none w-full snap-start relative group hover:scale-105 hover:shadow-2xl duration-300 shadow-xl">
                    <a href="{{ route('content.show', $video->slug) }}"
                        class=" bg-white shadow-lg rounded-lg overflow-hidden transform transition-all duration-300 ease-in-out group-hover:scale-105 hover:shadow-2xl">
                        <div class="relative pb-[56.25%] h-0">
                            @if(!$isSubscribed && $video->is_exclusive && !$video->isOwner)
                                <img src="{{ route('thumbnail', ['encodedUrl' => $video->thumb]) }}" alt="{{ $video->judul }} "
                                    class="absolute top-0 left-0 w-full h-full object-cover rounded-t-lg">
                            @else
                                <iframe src="{{ $video->url }}" title="{{ $video->judul }} "
                                    class="absolute top-0 left-0 w-full h-full object-cover rounded-t-lg"></iframe>
                            @endif
                        </div>

                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold">{{ $video->judul }}</h3>
                                @if ($video->is_exclusive)
                                    @if ($video->isOwner)
                                        <div
                                            class="text-blue-400 hover:text-blue-600 cursor-pointer transition-all duration-200 transform hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                            </svg>
                                        </div>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128" width="32" height="32">
                                            <rect x="25.148" y="87.83" width="77.705" height="10.553" rx="4.872" fill="#f89068" />
                                            <path
                                                d="M100.551 47.49a7.624 7.624 0 0 0-5.986 12.355l-16.534 7.6-11.48-22.586a7.631 7.631 0 1 0-5.1 0L49.969 67.446l-16.534-7.6a7.732 7.732 0 1 0-5.04 2.842l4.251 25.142h62.708l4.251-25.143a7.628 7.628 0 1 0 .946-15.2z"
                                                fill="#ffc26f" />
                                            <path
                                                d="M64 96.633a1.75 1.75 0 0 1 0 3.5h-1.667a1.75 1.75 0 0 1 0-3.5zm37.075-32.146-3.651 21.594h.556a6.63 6.63 0 0 1 6.62 6.619v.808a6.63 6.63 0 0 1-6.623 6.622H73a1.75 1.75 0 0 1 0-3.5h24.98a3.126 3.126 0 0 0 3.123-3.122V92.7a3.126 3.126 0 0 0-3.123-3.122H30.02A3.126 3.126 0 0 0 26.9 92.7v.808a3.126 3.126 0 0 0 3.123 3.122H52.5a1.75 1.75 0 0 1 0 3.5H30.02a6.63 6.63 0 0 1-6.62-6.619V92.7a6.63 6.63 0 0 1 6.623-6.622h.556l-3.654-21.591a9.381 9.381 0 1 1 9.9-9.366 9.288 9.288 0 0 1-.874 3.956l13.216 6.075 9.91-19.5a9.381 9.381 0 1 1 9.836 0l9.91 19.5 13.216-6.075a9.288 9.288 0 0 1-.874-3.956 9.381 9.381 0 1 1 9.905 9.366zM100.551 61a5.881 5.881 0 1 0-5.881-5.881 5.818 5.818 0 0 0 1.268 3.639 1.751 1.751 0 0 1-.643 2.675l-16.534 7.6a1.749 1.749 0 0 1-2.291-.8L64.99 45.652a1.752 1.752 0 0 1 .975-2.442 5.881 5.881 0 1 0-3.93 0 1.752 1.752 0 0 1 .975 2.442L51.53 68.238a1.749 1.749 0 0 1-2.291.8l-16.534-7.6a1.75 1.75 0 0 1-.642-2.675 5.823 5.823 0 0 0 1.267-3.639A5.881 5.881 0 1 0 27.449 61a6.121 6.121 0 0 0 .732-.051 1.755 1.755 0 0 1 1.94 1.445l4 23.685h59.75l4-23.685a1.754 1.754 0 0 1 1.94-1.445 6.121 6.121 0 0 0 .74.051z"
                                                fill="#13134c" />
                                        </svg>
                                    @endif

                                @endif
                            </div>
                            <p class="text-sm text-gray-600 line-clamp-2 min-h-[3em]">{{ $video->deskripsi }}</p>
                            <p class="text-sm text-gray-400 pt-4">
                                <a href="{{ route('channel.show', $video->channel->slug) }}"
                                    class="text-ungumain hover:underline line-clamp-1">
                                    {{ $video->channel->channel_name }} - {{ $video->channel->user->name }}
                                </a>
                            </p>
                        </div>
                        @if (!$isSubscribed && $video->is_exclusive && !$video->isOwner)
                            <a href="{{ route('content.show', $video->slug) }}" target="_blank"
                                class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-75 rounded-lg group-hover:opacity-100 opacity-80 transition-opacity duration-300">
                                <span class="text-white text-sm px-2 py-1 rounded">
                                    Subscribe to view
                                </span>
                            </a>
                        @endif
                    </a>
                </div>
            @endforeach
        @else
            <div class="w-full flex justify-center">
                <span class="justify-center text-center px-12 py-6 bg-white shadow-lg rounded-lg text-xl">Tidak ada konten
                    yang sesuai dengan Pencarian tersebut.</span>
            </div>
        @endif
    </div>

    <!-- Show More Button -->
    @if ($contentVideos->count() >= $jml_display)
        <div class="w-full flex justify-center py-6">
            <button wire:click="loadMore"
                class="px-6 py-2 bg-ungumain text-white font-bold rounded-full hover:bg-goldmain hover:text-gray-900 border-3 border-ungumain hover:border-ungumain hover:border-3 ">
                Show More
            </button>
        </div>
    @endif
</div>