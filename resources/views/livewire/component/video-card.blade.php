<div x-data="{
    currentIndex: 0,
    videos: [
        { title: 'Judul 1', description: 'Deskripsi 1', channel: 'Channel 1', url: 'https://drive.google.com/file/d/1JRep0NAiqjbj1T2--KwEB5-waO_yLJZN/preview' },
        { title: 'Judul 2', description: 'Deskripsi 2', channel: 'Channel 2', url: 'https://drive.google.com/file/d/1JRep0NAiqjbj1T2--KwEB5-waO_yLJZN/preview' },
        { title: 'Judul 3', description: 'Deskripsi 3', channel: 'Channel 3', url: 'https://drive.google.com/file/d/1JRep0NAiqjbj1T2--KwEB5-waO_yLJZN/preview' },
        { title: 'Judul 4', description: 'Deskripsi 4', channel: 'Channel 4', url: 'https://drive.google.com/file/d/1JRep0NAiqjbj1T2--KwEB5-waO_yLJZN/preview' },
    ],
    getVisibleVideos() {
        return window.innerWidth >= 1024 ? this.videos.slice(this.currentIndex, this.currentIndex + 3) : [this.videos[this.currentIndex]];
    },
    next() {
        if (this.currentIndex < this.videos.length - (window.innerWidth >= 1024 ? 3 : 1)) {
            this.currentIndex++;
        }
    },
    prev() {
        if (this.currentIndex > 0) {
            this.currentIndex--;
        }
    }
}" class="relative w-full py-10">
    <div class="flex overflow-hidden transition-transform duration-500 ease-in-out justify-center flex-row gap-10 px-14">
        <template x-for="(video, index) in getVisibleVideos()" :key="index">
            <div class="bg-white shadow-lg rounded-lg flex flex-col w-full transform hover:scale-105 transition duration-300">
                <div class="relative rounded-t-lg overflow-hidden">
                    <iframe class="w-full aspect-video rounded-t-lg" x-bind:src="video.url" allowfullscreen></iframe>
                </div>
                <div class="p-4">
                    <h1 class="font-semibold text-md lg:text-2xl text-gray-900 line-clamp-1" x-text="video.title"></h1>
                    <h2 class="lg:font-light text-sm lg:text-md text-gray-900 line-clamp-1" x-text="video.description"></h2>
                    <h3 class="lg:font-light text-xs text-gray-400" x-text="video.channel"></h3>
                </div>
            </div>
        </template>
    </div>
    <!-- Navigasi -->
    <div class="absolute inset-0 flex items-center justify-between px-2 pointer-events-none">
        <button @click="prev" class="bg-gray-900 bg-opacity-75 text-white px-4 py-2 rounded-full shadow-lg hover:bg-opacity-100 transition duration-300 pointer-events-auto">
            &#10094;
        </button>
        <button @click="next" class="bg-gray-900 bg-opacity-75 text-white px-4 py-2 rounded-full shadow-lg hover:bg-opacity-100 transition duration-300 pointer-events-auto">
            &#10095;
        </button>
    </div>
</div>