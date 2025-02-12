<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-gray-900 antialiased bg-cover bg-center font-Poppins"
    style="background-image: url('{{ asset('storage/images/bg1.svg') }}');">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 dark:bg-gray-900/70">
        <div>
            <a href="/" wire:navigate>
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="flex w-full sm:max-w-3xl justify-center mt-6 backdrop-blur-xl shadow-2xl">
            <div
                class="lg:w-1/2 text-white hidden lg:flex bg-purple-600/50   rounded-l-lg flex-col items-center justify-center">
                <h1 class="text-4xl font-bold">Selamat Datang Di</h1>
                <h2 class="text-2xl italic font-semibold">Bhinneka.Space</h2>

                <a href="{{ route('home') }}"
                    class="mt-8 text-ungusec flex justify-center gap-2 items-center mx-auto shadow-xl text-lg bg-gray-50 backdrop-blur-md lg:font-semibold isolation-auto border-gray-50 before:absolute before:w-full before:transition-all before:duration-700 before:hover:w-full before:-left-full before:hover:left-0 before:rounded-full before:bg-goldmain hover:text-ungumain before:-z-10 before:aspect-square before:hover:scale-150 before:hover:duration-700 relative z-10 px-4 py-2 overflow-hidden border-2 rounded-full group">
                    Jelajahi Bhinneka
                    <svg class="w-8 h-8 justify-end group-hover:rotate-90 group-hover:bg-gray-50 text-ungumain ease-linear duration-300 rounded-full border border-ungusec group-hover:border-ungumain p-2 rotate-45"
                        viewBox="0 0 16 19" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 18C7 18.5523 7.44772 19 8 19C8.55228 19 9 18.5523 9 18H7ZM8.70711 0.292893C8.31658 -0.0976311 7.68342 -0.0976311 7.29289 0.292893L0.928932 6.65685C0.538408 7.04738 0.538408 7.68054 0.928932 8.07107C1.31946 8.46159 1.95262 8.46159 2.34315 8.07107L8 2.41421L13.6569 8.07107C14.0474 8.46159 14.6805 8.46159 15.0711 8.07107C15.4616 7.68054 15.4616 7.04738 15.0711 6.65685L8.70711 0.292893ZM9 18L9 1H7L7 18H9Z"
                            class="fill-ungusec hover:fill-ungumain group-hover:ungumain"></path>
                    </svg>
                </a>

            </div>
            <div class="lg:w-1/2 w-3/4 px-6 py-4 bg-white dark:bg-gray-800 rounded-sm lg:rounded-r-lg">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>