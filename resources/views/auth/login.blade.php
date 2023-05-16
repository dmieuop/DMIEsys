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
                <img class="mx-auto" src="{{ asset('src/img/dmiesys-logo.svg') }}" alt="DMIEsys logo">
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


            {{-- <div class="block">
                <button type="submit" class="btn btn-blue w-full">
                    <i class="bi bi-person-vcard-fill mr-2"></i>
                    Student Login
                </button>
            </div> --}}

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

{{-- @env('local')
<div>
    <a class="btn btn-blue" href="{{ route('external-user.index') }}">Student</a>
</div>
@endenv --}}
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