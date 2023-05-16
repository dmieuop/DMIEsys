<!-- This example requires Tailwind CSS v2.0+ -->
<nav class="fixed z-50 w-full bg-blue-800 dark:bg-gray-900 print:hidden">
    <div class="mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile home button-->
                <button type="button" onclick="window.location.href='{{ route('home') }}';"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <i class="bi bi-house-fill block h-6 w-6"></i>
                </button>
            </div>
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex flex-shrink-0 items-center">
                    <p class="text-3xl font-semibold text-yellow-300 dark:text-white">DMIE<sup
                            class="font-normal text-white dark:text-red-300">sys</sup><sub
                            class="text-xs text-gray-400 dark:text-gray-500">{{ config('settings.system.version')
                            }}</sub>
                    </p>
                </div>
                @guest
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <a href="https://dmie.eng.pdn.ac.lk"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-blue-600 hover:text-white dark:hover:bg-gray-700">Home</a>
                    </div>
                </div>
                @endguest
                @auth
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4 ml-3 mt-2">
                        <a href="@yield('back_link', '/')" class="btn-sm btn-yellow">
                            @yield('back_page', 'Home')</a>
                    </div>
                </div>
                @endauth
            </div>

            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

                @auth
                @can('see notification')
                @livewire('notification-badge')
                @endcan
                @endauth

                <div class="relative mx-3">
                    <button type="button" data-tooltip-target="tooltip-dark-mode-btn" data-tooltip-placement="bottom"
                        onclick="toggleDarkMode()">
                        <i id="dark-mode-icon" class="text-lg text-white dark:text-gray-400 bi bi-sun-fill"></i>
                    </button>
                    <div id="tooltip-dark-mode-btn" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Theme
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>


                <!-- Profile dropdown -->
                @auth
                <div class="relative ml-3">
                    <div>
                        <button type="button" id="profile-dropdown-button"
                            class="flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            @include('components.profile-image', [
                            'size' => '35px',
                            'path' => auth()->user()->profile_photo_path,
                            ])
                        </button>
                    </div>

                    <div class="absolute right-0 mt-2 hidden w-48 origin-top-right rounded-md bg-white py-1 font-semibold shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800"
                        id="profile-dropdown-menu" role="menu" aria-orientation="vertical"
                        aria-labelledby="user-menu-button" tabindex="-1">

                        <a href="{{ route('user-profile.edit', auth()->user()->username) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                            role="menuitem" tabindex="-1" id="user-menu-item-0">Profile</a>

                        @canany(['add new hod', 'select new hod', 'add user', 'see user', 'edit user', 'deactivate
                        user', 'change user role'])
                        <a href="{{ route('settings.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                            role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
                        @endcan

                        @can('can chat')
                        <a href="{{ route('messages.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                            role="menuitem" tabindex="-1" id="user-menu-item-1">Messages</a>
                        @endcan

                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf @honeypot
                            <a href="#"
                                class="font- block px-4 py-2 text-sm font-bold text-red-500 hover:bg-gray-100 hover:text-red-600 dark:text-red-400 dark:hover:bg-gray-700"
                                role="menuitem" tabindex="-1" id="user-menu-item-2"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sign out</a>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>

</nav>
@can('can chat')
@auth
<div class="@yield('chat-icon', ' ') fixed bottom-3 right-3 w-16 h-16 dark:bg-green-600 dark:hover:bg-green-700 bg-blue-500 hover:bg-blue-700 rounded-full cursor-pointer flex justify-center pt-3 print:hidden"
    style="z-index: 1000">
    <a href="{{ route('messages.index') }}">
        <i class="bi bi-chat-dots-fill text-4xl text-white"></i>
    </a>
    @livewire('messages-indicator')
</div>
@endauth
@endcan