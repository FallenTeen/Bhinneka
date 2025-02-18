<div class="-mt-3 from-gray-100 to transparent bg-gradient-to-b pb-6">
    <div class="mx-12 pt-6 mb-6">
        <div class="channel-header flex lg:flex-row xs:flex-col items-center bg-white p-12 rounded-xl shadow-xl">
            <div class="h-1/6">
                @if($channel->avatar)
                    <img src="{{ asset('storage/' . $channel->avatar) }}" class="max-h-lg aspect-square rounded-full object-cover"
                        alt="Channel Avatar">
                @else
                    <img src="{{ asset('storage/avatarsimages/default-avatar.png') }}" alt="Default Avatar"
                        class="w-full aspect-auto rounded-full">
                @endif
            </div>

            <div class="pl-16">
                <div class="flex items-center gap-8">
                    <h1 class="text-5xl font-extrabold text-gray-900 tracking-tight">{{ $channel->channel_name }}</h1>
                    <div class="text-ungumain">
                        @if ($channel->verified)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-12">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                            </svg>
                        @endif
                    </div>
                </div>
                <h3 class=" font-semibold opacity-55 text-md tracking-tight">{{ $channel->user->name }}</h3>
                <p class="text-lg text-gray-600 mt-2 leading-relaxed">{{ $channel->deskripsi }}</p>
                <h3 class="mt-2 font-semibold opacity-55 text-sm italic tracking-tight">
                    Bergabung pada {{ \Carbon\Carbon::parse($channel->created_at)->format('F Y') }}
                </h3>
                <div class="mt-6 flex flex-col">
                    <span class="text-sm text-gray-500 font-medium uppercase tracking-wider">External Links</span>
                    <div class="flex mt-2 space-x-4">
                        @foreach($externalLinks as $key => $link)
                            <span
                                class="text-lg font-semibold text-ungumain hover:text-ungusec transition-colors duration-300">
                                @if($key == 0)
                                    <a href="{{ $link }}" target="_blank">{{ $link }}</a>
                                @elseif($key == 1)
                                    <a href="https://www.instagram.com/{{ $link }}" target="_blank">{{ $link }}</a>

                                @elseif ($key == 2)
                                    <a href="https://{{ $link }}" target="_blank">{{ $link }}</a>
                                @endif
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('component.content-video-channel', ['slug' => $slug, 'hidename' =>false])
    <div class="w-full justify-center flex my-8">
        <a href="{{ route('content') }}" type="button"
            class="shadow-xl bg-white items-center justify-center text-center w-48 rounded-2xl h-14 relative text-black text-xl font-semibold border-4 border-white group">
            <div
                class="items-center bg-ungumain rounded-xl h-12 w-1/4 grid place-items-center absolute left-0 top-0 group-hover:w-full z-10 duration-500">
                <svg width="25px" height="25px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#000000" d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"></path>
                    <path fill="#000000"
                        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z">
                    </path>
                </svg>
            </div>
            <div class="w-full h-full items-center flex justify-end px-8">
                <p>Go Back</p>
            </div>
        </a>

    </div>
</div>