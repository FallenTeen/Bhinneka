<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name')}}</title>
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-Poppins">
    <div class="fixed top-0 w-full z-20">
        <x-custom.navbarlanding></x-custom.navbarlanding>
    </div>

    <div class="mt-16">
        @livewire('component.contentshow', ['slug' => $slug])
    </div>
    <div>
        @livewire('component.content-video-all')
    </div>
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
    <x-custom.footerlanding></x-custom.footerlanding>
</body>

</html>