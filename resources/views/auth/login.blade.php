@extends('layouts.dmiesys.app')

@section('title', '| Login')

@push('styles')
<style>
    .main {
        display: flex;
        height: 77vh;
        width: 100%;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div class="main mx-auto">
    <div class="mt-10 rounded-2xl border-0 bg-white dark:bg-gray-800 px-2 pb-3 shadow-md dark:shadow-gray-900/80">
        <div class="w-96 px-3 pt-4 pb-2">

            <div class="mt-2 mb-3 w-full">
                <svg class="mx-auto" width="180" height="46" viewBox="0 0 180 46" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0.46875 35V0.875H10.5469C13.5625 0.875 16.2344 1.54688 18.5625 2.89062C20.9062 4.23437 22.7188 6.14063 24 8.60938C25.2812 11.0781 25.9219 13.9062 25.9219 17.0938V18.8047C25.9219 22.0391 25.2734 24.8828 23.9766 27.3359C22.6953 29.7891 20.8594 31.6797 18.4688 33.0078C16.0938 34.3359 13.3672 35 10.2891 35H0.46875ZM6.39844 5.65625V30.2656H10.2656C13.375 30.2656 15.7578 29.2969 17.4141 27.3594C19.0859 25.4062 19.9375 22.6094 19.9688 18.9688V17.0703C19.9688 13.3672 19.1641 10.5391 17.5547 8.58594C15.9453 6.63281 13.6094 5.65625 10.5469 5.65625H6.39844Z"
                        fill="#050404" />
                    <path
                        d="M39.5156 0.875L49.3594 27.0312L59.1797 0.875H66.8438V35H60.9375V23.75L61.5234 8.70312L51.4453 35H47.2031L37.1484 8.72656L37.7344 23.75V35H31.8281V0.875H39.5156Z"
                        fill="#F04839" />
                    <path d="M80.1328 35H74.2266V0.875H80.1328V35Z" fill="#464143" />
                    <path
                        d="M107.367 19.7656H93.3516V30.2656H109.734V35H87.4219V0.875H109.57V5.65625H93.3516V15.0781H107.367V19.7656Z"
                        fill="#978A76" />
                    <path
                        d="M127.523 28.1328C127.758 26.3828 126.797 25.1484 124.641 24.4297L120.234 23.1406C116.516 21.8594 114.719 19.7344 114.844 16.7656C114.953 14.5312 115.969 12.7031 117.891 11.2812C119.828 9.84375 122.102 9.14062 124.711 9.17188C127.273 9.20312 129.352 9.95312 130.945 11.4219C132.555 12.875 133.328 14.7734 133.266 17.1172L129.047 17.0938C129.078 15.8281 128.68 14.7969 127.852 14C127.023 13.2031 125.922 12.7891 124.547 12.7578C123.078 12.7266 121.812 13.0859 120.75 13.8359C119.766 14.5391 119.195 15.4609 119.039 16.6016C118.836 18.0703 119.734 19.1406 121.734 19.8125L123.867 20.3984C126.773 21.1484 128.836 22.125 130.055 23.3281C131.273 24.5312 131.836 26.0234 131.742 27.8047C131.648 29.3828 131.133 30.7578 130.195 31.9297C129.258 33.1016 128.008 34 126.445 34.625C124.883 35.2344 123.219 35.5156 121.453 35.4688C118.766 35.4375 116.547 34.6562 114.797 33.125C113.047 31.5781 112.203 29.5938 112.266 27.1719L116.508 27.1953C116.508 28.6172 116.961 29.7578 117.867 30.6172C118.773 31.4766 120.016 31.9062 121.594 31.9062C123.141 31.9375 124.477 31.6172 125.602 30.9453C126.727 30.2578 127.367 29.3203 127.523 28.1328ZM145.148 28.6016L154.172 9.64062H158.859L143.812 39.2188C141.719 43.3281 139.031 45.3594 135.75 45.3125C135.172 45.2969 134.32 45.1562 133.195 44.8906L133.57 41.375L134.672 41.4922C136.016 41.5547 137.172 41.25 138.141 40.5781C139.125 39.9219 139.992 38.8516 140.742 37.3672L142.266 34.4609L137.883 9.64062H142.312L145.148 28.6016ZM174.023 28.1328C174.258 26.3828 173.297 25.1484 171.141 24.4297L166.734 23.1406C163.016 21.8594 161.219 19.7344 161.344 16.7656C161.453 14.5312 162.469 12.7031 164.391 11.2812C166.328 9.84375 168.602 9.14062 171.211 9.17188C173.773 9.20312 175.852 9.95312 177.445 11.4219C179.055 12.875 179.828 14.7734 179.766 17.1172L175.547 17.0938C175.578 15.8281 175.18 14.7969 174.352 14C173.523 13.2031 172.422 12.7891 171.047 12.7578C169.578 12.7266 168.312 13.0859 167.25 13.8359C166.266 14.5391 165.695 15.4609 165.539 16.6016C165.336 18.0703 166.234 19.1406 168.234 19.8125L170.367 20.3984C173.273 21.1484 175.336 22.125 176.555 23.3281C177.773 24.5312 178.336 26.0234 178.242 27.8047C178.148 29.3828 177.633 30.7578 176.695 31.9297C175.758 33.1016 174.508 34 172.945 34.625C171.383 35.2344 169.719 35.5156 167.953 35.4688C165.266 35.4375 163.047 34.6562 161.297 33.125C159.547 31.5781 158.703 29.5938 158.766 27.1719L163.008 27.1953C163.008 28.6172 163.461 29.7578 164.367 30.6172C165.273 31.4766 166.516 31.9062 168.094 31.9062C169.641 31.9375 170.977 31.6172 172.102 30.9453C173.227 30.2578 173.867 29.3203 174.023 28.1328Z"
                        fill="#0FBBF1" />
                </svg>

            </div>

            <form method="POST" action="{{ route('login') }}" id="form">
                @csrf @honeypot
                <div class="mb-3">
                    <label for="username" class="form-label"><i class="bi bi-person-fill"></i>
                        {{ __('Email/ Username') }}</label>
                    <input type="text" class="form-input" id="username" name="username" value="{{ old('username') }}"
                        required autocomplete="username" autofocus>
                </div>

                <label for="password" class="form-label"><i class="bi bi-lock-fill"></i>{{ __(' Password') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex cursor-pointer items-center pl-3"
                        onclick="togglePasswordVisibility()">
                        <span class="bi bi-eye-slash text-lg" id="password_button"></span>
                    </div>
                    <input type="password" id="password" name="password"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                </div>

                @error('username')
                <span class="font-meduim text-sm text-red-600 dark:text-red-500" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror


                <div class="mb-2">
                    @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-gray-600 dark:text-gray-400"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                    @endif
                </div>
                <div class="flex items-center justify-end">
                    <button type="submit" class="btn btn-yellow">
                        <i class="bi bi-box-arrow-in-right mr-2"></i>
                        Sign in
                    </button>
                </div>
            </form>
            @env('local')
            <form action="{{ route('login') }}" method="post">
                @csrf @honeypot
                <input type="hidden" name="username" value="admin">
                <input type="hidden" name="password" value="password">
                <button type="submit">Log as Admin</button>
            </form>
            @endenv
        </div>
    </div>
</div>

@env('local')
<div>
    <a class="btn btn-blue" href="{{ route('external-user.index') }}">Student</a>
</div>
@endenv
@endsection


@push('scripts')
<script>
    function togglePasswordVisibility() {

            let password_button = document.getElementById("password_button");
            let password = document.getElementById("password");
            if (password.type === "password") {
                password.type = "text";
                if (password_button.classList.contains('bi-eye-slash')) {
                    password_button.classList.remove('bi-eye-slash');
                    password_button.classList.add('bi-eye');
                }
            } else {
                password.type = "password";
                if (password_button.classList.contains('bi-eye')) {
                    password_button.classList.remove('bi-eye');
                    password_button.classList.add('bi-eye-slash');
                }
            }
        }
</script>
@endpush