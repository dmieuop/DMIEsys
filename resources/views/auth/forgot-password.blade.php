@extends('layouts.dmiesys.app')

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
<div class="screen">
    <div class="main">
        <div class="bg-white  dark:bg-gray-800 px-2 pb-3 border-0 shadow-md dark:shadow-gray-900/80 mt-10 rounded-2xl">
            <div class="w-96 px-3 pt-4 pb-2">
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    <p class="text-sm font-medium">
                        Forgot your password?
                    </p>
                    <p class="text-xs mt-2">
                        No problem. Just let us know your email address and we will email you a
                        password reset link that will allow you to choose a new one.
                    </p>

                </div>


                <form method="POST" action="{{ route('password.email') }}">
                    @csrf @honeypot

                    <div class="block">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-input" name="email" :value="old('email')" required autofocus>
                    </div>

                    @if (session()->has('errors'))
                    @forelse ($errors->all() as $error)
                    <span class="block text-sm font-meduim text-red-600 dark:text-red-500 my-2" role="alert">
                        <strong>{{ $error }}</strong>
                    </span>
                    @empty
                    @endforelse
                    @endif
                    @if (session('status'))
                    <div class="mb-4 mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="btn btn-blue">Send Password Reset Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection