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

    <div class="mt-16 flex flex-col">
        @livewire('component.channel-show', ['slug' => $slug])

    </div>
    <x-custom.footerlanding></x-custom.footerlanding>
</body>

</html>