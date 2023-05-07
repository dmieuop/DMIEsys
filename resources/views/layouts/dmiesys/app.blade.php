<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DMIEsys') }} @yield('title', ' ')</title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    @stack('styles', '')
</head>

<body style="font-family: 'Poppins', sans-serif;" id="main-body">
    <audio src="{{ asset('src/sound/notification.mp3') }}" class="hidden" controls id="notification_sound"></audio>
    <audio src="{{ asset('src/sound/message.mp3') }}" class="hidden" controls id="message_sound"></audio>
    <audio src="{{ asset('src/sound/sent.mp3') }}" class="hidden" controls id="sent_sound"></audio>
    <div id="app">
        <!-- nab bar start  -->
        <div>
            @include('layouts.dmiesys.navbar')
        </div>
        <!-- nav bar end -->

        <main class="py-20" id="main">
            <div class="px-4 md:px-8">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts', '')
    <script src="{{ asset('src/js/toggle-dark-mode.js') }}"></script>
    @auth
    <script src="{{ asset('src/js/script.js') }}"></script>
    @include('sweetalert::alert')
    @can('see notification')
    @livewire('instant-notification')
    <div id="notification-modal" tabindex="-1"
        class="h-modal fixed top-0 right-0 left-0 z-50 hidden w-full overflow-y-auto overflow-x-hidden md:inset-0 md:h-full">
        <div class="relative h-full w-full max-w-lg p-4 md:h-auto">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t p-6 py-3">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Notifications
                    </h3>
                    <button type="button"
                        class="ml-auto inline-flex items-center rounded-lg bg-transparent p-1.5 text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="notification-modal">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                @livewire('dashboard-notifications')
                <!-- Modal footer -->
                <div class="flex items-center space-x-2 rounded-b p-6 py-3">
                </div>
            </div>
        </div>
    </div>
    @endcan
    @endauth
    @livewireScripts
</body>

</html>