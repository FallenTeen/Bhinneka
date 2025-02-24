<nav class="bg-white/5 backdrop-blur-xl border-gray-200 py-2.5 dark:bg-gray-900">
    <div class="flex items-center justify-between max-w-screen-xl px-4 mx-auto">
        <!-- Logo Section -->
        <a href="{{ route('home')}}" class="flex items-center">
            <span
                class="self-center text-ungumain text-xl font-semibold whitespace-nowrap dark:text-white">Bhinneka</span>
            <span class="text-center self-center justify-center text-xl">.Space</span>
        </a>

        <!-- Navbar Links for large screens -->
        <div class="hidden lg:flex items-center space-x-8">
            <ul class="flex space-x-8">
                @php
                    $currentRoute = Route::currentRouteName();
                @endphp
                <li>
                    <a href="{{ route('home') }}"
                        class="{{ $currentRoute === 'home' ? 'text-purple-700' : 'text-gray-700 dark:text-white hover:text-purple-700 transition-all duration-300' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('content') }}"
                        class="{{ in_array($currentRoute, ['content', 'channel.show']) ? 'text-purple-700' : 'text-gray-700 dark:text-white hover:text-purple-700 transition-all duration-300' }}">
                        Content
                    </a>

                </li>
                @if (Auth::check() && in_array(Auth::user()->role_id, ['1', '2', '3']))
                    <li>
                        <a href="{{ route('allinvestor') }}"
                            class="{{ in_array($currentRoute, ['allinvestor', 'allinvestor.show']) ? 'text-purple-700' : 'text-gray-700 dark:text-white hover:text-purple-700 transition-all duration-300' }}">
                            <span class="flex flex-row items-center justify-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                                </svg>
                                investors
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                                </svg>

                            </span>
                        </a>
                    </li>
                @endif

            </ul>

        </div>
        <div class="z-40 hidden lg:flex">
            @if(Auth::check())
                <a href="{{ route('dashboard') }}"> <span
                        class="text-gray-900 font-medium hover:leading-snug duration-300 hover:text-ungusec">Hello,
                        {{ Auth::user()->username }}</span></a>
            @else
                <a href="{{ route('register') }}"
                    class="text-white bg-ungumain hover:bg-purple-500 hover:text-white focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800 transition-all duration-300">
                    Join Us Now!
                </a>
            @endif
        </div>


        <!-- Mobile Menu Toggle -->
        <div class="lg:hidden flex items-center">
            <button id="menu-toggle" type="button"
                class="inline-flex items-center p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="mobile-menu-2" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu (hidden by default) -->
    <div class="lg:hidden hidden" id="mobile-menu-2">
        <ul class="flex flex-col items-center py-4 space-y-4 font-medium">
            <li><a href="{{ route('home') }}" class="text-gray-700 dark:text-white hover:text-purple-700">Home</a></li>
            <li><a href="{{ route('content') }}" class="text-gray-700 dark:text-white hover:text-purple-700">Content</a>
            </li>

        </ul>
    </div>
</nav>