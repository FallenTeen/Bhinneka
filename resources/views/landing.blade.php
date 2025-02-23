<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">

    <title>{{ config('app.name')}}</title>
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-Poppins">
    <div class="fixed top-0 w-full z-20">
        <x-custom.navbarlanding></x-custom.navbarlanding>
    </div>

    <section
        class="relative h-full lg:translate-y-12 items-center w-full px-6 lg:px-14 grid-cols-2 mx-auto overflow-x-hidden lg:grid md:py-14 lg:py-24 xl:py-14 lg:mt-3 xl:mt-5">

        <div data-aos="fade-left" class="pr-2 md:mb-14 py-14 md:py-0">
            <h1 class="text-3xl font-semibold text-ungumain xl:text-5xl lg:text-3xl"><span
                    class="block w-full">Bhinneka<span class="text-white font-medium">.Space</span></span></h1>
            <p class="py-4 text-lg text-gray-900 2xl:py-8 md:py-6 2xl:pr-5">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae nobis placeat labore repellat
                dignissimos qui dolorem alias quia quisquam nulla id totam, corporis aliquam fuga explicabo esse. Ullam,
                temporibus nulla.
            </p>
            <div class="mt-4 flex gap-4 items-center">
                <a href="#aboutus"
                    class="scroll-link px-5 py-3 text-lg tracking-wider text-white bg-ungumain rounded-lg md:px-8 hover:bg-purple group hover:bg-purple-600 duration-300"><span>Jelajahi</span>
                </a>
                <span class="italic font-light">Atau</span>
                <a href="{{route('register')}}"
                    class="px-5 py-3 bg-white/5 backdrop-blur-xl border-2 border-ungumain tracking-wider text-ungumain text-lg rounded-xl hover:bg-goldmain hover:text-gray-800 duration-300">Daftar</a>
            </div>
        </div>

        <div class="pb-10 overflow-hidden md:p-10 lg:p-0 sm:pb-0">
            <img id="heroImg1"
                class="transition-all duration-300 ease-in-out hover:scale-105 lg:w-full sm:mx-auto sm:w-4/6 sm:pb-12 lg:pb-0"
                src="https://bootstrapmade.com/demo/templates/FlexStart/assets/img/hero-img.png"
                alt="Awesome hero page image" width="500" height="488" />
        </div>
        <x-custom.purplegoldbg1></x-custom.purplegoldbg1>
    </section>
    <section class="w-full flex flex-col gap-8 my-6">
        <h1 class="font-bold text-3xl text-center">Mitra Kami</h1>
        <div class="flex overflow-hidden space-x-16 group">
            <div class="flex space-x-12 lg:space-x-36 animate-loop-scroll group-hover:paused">
                @for (
                        $i = 0;
                        $i < 14;
                        $i++
                    )
                                    <img loading="lazy" src="{{ asset('storage/icons/' . ($i % 2 == 0 ? 'amikompwt.png' : 'uksw.png')) }}"
                                        class="w-32 h-32" alt="Image {{ $i + 1 }}" />
                @endfor
            </div>

        </div>
    </section>
    <section class="relative" id="aboutus">
        <x-custom.purplegoldbg1></x-custom.purplegoldbg1>

        <div class="flex flex-col mx-6 lg:mx-24 justify-center gap-8">
            <div
                class="w-full bg-white/5 hover:scale-105 duration-300 backdrop-blur-xl shadow-xl px-8 py-12 rounded-3xl flex flex-col-reverse md:flex-row gap-4 items-center">
                <div class="w-full md:w-1/3 flex justify-center">
                    <img src="{{asset('storage/images/asset2.svg')}}" class="h-auto max-h-48 md:max-h-64"
                        alt="Ilustrasi">
                </div>
                <div class="flex flex-col w-full md:w-2/3 gap-4 text-center md:text-left">
                    <div class="font-bold text-gray-900 text-2xl md:text-3xl">Permudah Akuntabilitasmu</div>
                    <span class="text-gray-700 text-sm md:text-base">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi delectus soluta, quaerat corporis
                        excepturi libero nobis dolorem reprehenderit repellat nemo tenetur illo in fugiat aliquid fugit?
                        Qui voluptatum iusto consequuntur.
                    </span>
                </div>
            </div>

            <div
                class="w-full bg-white/5 hover:scale-105 duration-300 backdrop-blur-xl shadow-xl px-8 py-12 rounded-3xl flex flex-col md:flex-row gap-4 items-center">
                <div class="flex flex-col w-full md:w-2/3 gap-4 text-center md:text-left">
                    <div class="font-bold text-gray-900 text-2xl md:text-3xl">Permudah Kreatifitasmu</div>
                    <span class="text-gray-700 text-sm md:text-base">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi delectus soluta, quaerat corporis
                        excepturi libero nobis dolorem reprehenderit repellat nemo tenetur illo in fugiat aliquid fugit?
                        Qui voluptatum iusto consequuntur.
                    </span>
                </div>
                <div class="w-full md:w-1/3 flex justify-center">
                    <img src="{{asset('storage/images/asset3.svg')}}" class="h-auto max-h-48 md:max-h-64"
                        alt="Ilustrasi">
                </div>
            </div>

        </div>
    </section>
    <section class="my-12 w-full">
        @livewire('component.content-video-card')
        <div class="w-full justify-center flex">
            <a href="{{ route('content') }}"
                class=" pb-2 pt-1 bg-white cursor-pointer rounded-3xl border-2 border-[#9748FF] shadow-[inset_0px_-2px_0px_2px_#9748FF] group hover:bg-goldmain transition duration-300 ease-in-out">
                <span class="font-medium text-[#333] group-hover:text-gray-900 px-4">Lihat Lebih Banyak</span>
            </a>
        </div>
    </section>

    @if (!Auth::check() || !Auth::user()->subscribed)
        <section class="text-gray-700 body-font overflow-hidden">
            <h2 class="text-3xl font-bold text-center mb-8 pt-16">Mulai Jadi Bagian Dari Bhinneka</h2>
            <div class="container px-5 mx-auto flex flex-wrap">
                <div class="lg:w-1/4 mt-48 hidden lg:block">
                    <div
                        class="mt-px border-t border-gray-300 border-b border-l rounded-tl-lg rounded-bl-lg overflow-hidden">
                        <p class="bg-gray-100 text-gray-900 h-12 text-center px-4 flex items-center justify-start -mt-px">
                            Akses ke konten utama</p>
                        <p class="text-gray-900 h-12 text-center px-4 flex items-center justify-start">Akses konten
                            eksklusif</p>
                        <p class="bg-gray-100 text-gray-900 h-12 text-center px-4 flex items-center justify-start">Interaksi
                            dengan kreator</p>
                    </div>
                </div>
                <div class="flex lg:w-3/4 w-full flex-wrap lg:border border-gray-300 rounded-lg">
                    <div
                        class="hover:scale-105 duration-300 lg:w-1/2 lg:mt-px w-full mb-10 lg:mb-0 border-2 border-gray-300 lg:border-none rounded-lg lg:rounded-none">
                        <div class="px-2 text-center h-48 flex flex-col items-center justify-center">
                            <h3 class="tracking-widest">Basic</h3>
                            <h2 class="text-5xl text-gray-900 font-medium leading-none mb-4 mt-2">Free</h2>
                            <span class="text-sm text-gray-600">Akses konten</span>
                        </div>
                        <p class="bg-gray-100 text-gray-600 text-center h-12 flex items-center justify-center">
                            <span
                                class="w-5 h-5 inline-flex items-center justify-center  text-white rounded-full flex-shrink-0 bg-ungumain">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="3" class="w-3 h-3" viewBox="0 0 24 24">
                                    <path d="M20 6L9 17l-5-5"></path>
                                </svg>
                            </span>
                        </p>
                        <p class=" text-gray-600 text-center h-12 flex items-center justify-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2.2" class="w-5 h-5 text-gray-500" viewBox="0 0 24 24">
                                <path d="M18 6L6 18M6 6l12 12"></path>
                            </svg>
                        </p>
                        <p class="bg-gray-100 text-gray-600 text-center h-12 flex items-center justify-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2.2" class="w-5 h-5 text-gray-500" viewBox="0 0 24 24">
                                <path d="M18 6L6 18M6 6l12 12"></path>
                            </svg>
                        </p>
                        <div class="border-t border-gray-300 p-6 text-center rounded-bl-lg">
                            <button
                                class="flex items-center mt-auto text-white bg-ungumain border-0 py-2 px-4 w-full focus:outline-none hover:bg-goldmain duration-300 rounded">Button
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" class="w-4 h-4 ml-auto" viewBox="0 0 24 24">
                                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            <p class="text-xs text-gray-500 mt-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                Nulla minus fugit aspernatur minima. Maxime culpa eos quae fugiat neque consequuntur dolorum
                                laborum totam, fugit sunt omnis ad quam commodi praesentium?</p>
                        </div>
                    </div>
                    <div
                        class="hover:scale-105 duration-300 hover:border-none lg:w-1/2 lg:-mt-px w-full mb-10 lg:mb-0 border-2 rounded-lg border-ungumain relative">
                        <span
                            class="bg-ungumain text-white px-3 py-1 tracking-widest text-xs absolute right-0 top-0 rounded-bl">ONE-TIME PURCHASE</span>
                        <div class="px-2 text-center h-48 flex flex-col items-center justify-center">
                            <h3 class="tracking-widest">Subscribe</h3>
                            <h2
                                class="text-5xl text-gray-900 font-medium flex items-center justify-center leading-none mb-4 mt-2">
                                Rp. 65.000
                            </h2>
                            <span class="text-sm text-gray-600">Naikkan Eksklusifitas</span>
                        </div>
                        <p class="bg-gray-100 text-gray-600 text-center h-12 flex items-center justify-center">
                            <span
                                class="w-5 h-5 inline-flex items-center justify-center  text-white rounded-full flex-shrink-0 bg-ungumain">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="3" class="w-3 h-3" viewBox="0 0 24 24">
                                    <path d="M20 6L9 17l-5-5"></path>
                                </svg>
                            </span>
                        </p>
                        <p class="text-gray-600 text-center h-12 flex items-center justify-center">
                            <span
                                class="w-5 h-5 inline-flex items-center justify-center  text-white rounded-full flex-shrink-0 bg-ungumain">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="3" class="w-3 h-3" viewBox="0 0 24 24">
                                    <path d="M20 6L9 17l-5-5"></path>
                                </svg>
                            </span>
                        </p>
                        <p class="bg-gray-100 text-gray-600 text-center h-12 flex items-center justify-center">
                            <span
                                class="w-5 h-5 inline-flex items-center justify-center  text-white rounded-full flex-shrink-0 bg-ungumain">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="3" class="w-3 h-3" viewBox="0 0 24 24">
                                    <path d="M20 6L9 17l-5-5"></path>
                                </svg>
                            </span>
                        </p>
                        <div class="p-6 text-center border-t border-gray-300">
                            <button
                                class="flex items-center mt-auto text-white bg-ungumain border-0 py-2 px-4 w-full focus:outline-none hover:bg-goldmain duration-300 rounded">Button
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" class="w-4 h-4 ml-auto" viewBox="0 0 24 24">
                                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            <p class="text-xs text-gray-500 mt-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                Soluta tempore, autem ullam dicta ab aperiam consectetur necessitatibus non, illo culpa
                                atque officiis! Molestias maxime rem rerum eius nisi temporibus qui!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <section class="relative">
        <div class="flex justify-center px-5 py-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto my-32">
                <div class="flex items-center justify-center">
                    <div class="w-full max-w-sm mx-auto rounded-lg bg-white shadow-lg px-5 pt-5 pb-10 text-gray-800">
                        <div class="w-full pt-1 pb-5">
                            <div class="overflow-hidden bg-white p-2 rounded-full w-32 h-32 -mt-16 mx-auto shadow-lg">
                                <img src="{{asset('storage/icons/amikompwt.png')}}" alt="Amikom">
                            </div>
                        </div>
                        <div class="w-full mb-10">
                            <div class="text-3xl text-indigo-500 text-left leading-tight h-3">“</div>
                            <p class="text-sm text-gray-600 text-center px-5">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam obcaecati laudantium
                                recusandae, debitis eum voluptatem ad, illo voluptatibus temporibus odio provident.
                            </p>
                            <div class="text-3xl text-indigo-500 text-right leading-tight h-3 -mt-3">”</div>
                        </div>
                        <div class="w-full">
                            <p class="text-md text-indigo-500 font-bold text-center">Amikom</p>
                            <p class="text-xs text-gray-500 text-center">@amikompwt</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="w-full max-w-sm mx-auto rounded-lg bg-white shadow-lg px-5 pt-5 pb-10 text-gray-800">
                        <div class="w-full pt-1 pb-5">
                            <div class="overflow-hidden bg-white p-2 rounded-full w-32 h-32 -mt-16 mx-auto shadow-lg">
                                <img src="{{asset('storage/icons/uksw.png')}}" alt="UKSW">
                            </div>
                        </div>
                        <div class="w-full mb-10">
                            <div class="text-3xl text-indigo-500 text-left leading-tight h-3">“</div>
                            <p class="text-sm text-gray-600 text-center px-5">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam obcaecati laudantium
                                recusandae, debitis eum voluptatem ad, illo voluptatibus temporibus odio provident.
                            </p>
                            <div class="text-3xl text-indigo-500 text-right leading-tight h-3 -mt-3">”</div>
                        </div>
                        <div class="w-full">
                            <p class="text-md text-indigo-500 font-bold text-center">UKSW</p>
                            <p class="text-xs text-gray-500 text-center">@uksw</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Background -->
        <x-custom.purplegoldbg1></x-custom.purplegoldbg1>
    </section>

    <x-custom.footerlanding></x-custom.footerlanding>
</body>

</html>