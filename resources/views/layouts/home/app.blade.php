<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', ' ') | Department of Manufacturing and Industrial Engineering</title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    @stack('styles', '')
</head>

<body class="dark:bg-black bg-gray-100">
    @include('layouts.home.contact-us')
    <div id="app">
        <!-- nab bar start  -->
        @include('layouts.home.navbar')
        @include('layouts.home.side-navbar')
        @include('layouts.home.buttom-nav')
        <!-- nav bar end -->

        <main class="py-20" id="main">
            <div class="px-4 md:px-8">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts', '')
    <script src="{{ asset('src/js/toggle-dark-mode.js') }}"></script>
    @livewireScripts
</body>

</html>