<div x-data="carousel()" x-init="init()" class="relative">
    <div class="flex overflow-hidden snap-x snap-mandatory scroll-smooth py-6" x-ref="carousel">
        @foreach ($contentVideos as $video)
            <div class="flex-none w-full sm:w-1/2 md:w-1/3 lg:w-1/3 snap-start relative px-12 group">
                <div
                    class="bg-white shadow-lg rounded-lg overflow-hidden transform transition-all duration-300 ease-in-out group-hover:scale-105">
                    <div class="relative pb-[56.25%] h-0">
                        @if(!$isSubscribed && $video->is_exclusive)
                            <img src="{{ route('thumbnail', ['encodedUrl' => $video->thumb]) }}" alt="{{ $video->judul }}"
                                class="absolute top-0 left-0 w-full h-full object-cover rounded-t-lg">
                        @else
                            <iframe src="{{ $video->url }}" title="{{ $video->judul }}"
                                class="absolute top-0 left-0 w-full h-full object-cover rounded-t-lg"></iframe>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold">{{ $video->judul }}</h3>
                            @if ($video->is_exclusive)

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
                        </div>
                        <p class="text-sm text-gray-600">{{ $video->deskripsi }}</p>
                        <p class="text-sm text-gray-400 pt-4">{{ $video->channel->channel_name }} -
                            {{ $video->channel->user->name }}
                        </p>
                    </div>
                    @if (!$isSubscribed && $video->is_exclusive)
                        <a href="youtube.com" target="_blank"
                            class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-75 rounded-lg group-hover:opacity-100 opacity-80 transition-opacity duration-300">
                            <span class="text-white text-sm px-2 py-1 rounded">
                                Subscribe to view
                            </span>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
       
    </div>

    <button
        class="absolute left-1 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white py-2 px-3 rounded-full hover:bg-opacity-75"
        x-on:click="prev()">
        &larr;
    </button>
    <button
        class="absolute right-1 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white py-2 px-3 rounded-full hover:bg-opacity-75"
        x-on:click="next()">
        &rarr;
    </button>
</div>

<script>
    function carousel() {
        return {
            currentIndex: 0,
            totalItems: {{ count($contentVideos) }},
            itemsPerSlide: 1,
            init() {
                this.updateItemsPerSlide();
                this.scrollToCurrent();
                window.addEventListener('resize', this.debounce(this.updateItemsPerSlide, 200));
            },
            debounce(func, delay) {
                let timeout;
                return function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, arguments), delay);
                };
            },
            updateItemsPerSlide() {
                if (window.innerWidth >= 1024) {
                    this.itemsPerSlide = 3;
                } else {
                    this.itemsPerSlide = 1;
                }
                this.scrollToCurrent();
            },
            scrollToCurrent() {
                this.$refs.carousel.scrollTo({
                    left: this.currentIndex * this.getCardWidth() / this.itemsPerSlide,
                    behavior: 'smooth'
                });
            },
            next() {
                if (this.currentIndex < this.totalItems - this.itemsPerSlide) {
                    this.currentIndex++;
                    this.scrollToCurrent();
                }
            },
            prev() {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                    this.scrollToCurrent();
                }
            },
            getCardWidth() {
                return this.$refs.carousel.firstElementChild.offsetWidth * this.itemsPerSlide;
            }
        };
    }
</script>