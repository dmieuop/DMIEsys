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
        <div class="bg-white dark:bg-gray-800 px-2 pb-3 border-0 shadow-md dark:shadow-gray-900/80 mt-10 rounded-2xl">
            <div class="w-96 px-3 pt-4 pb-2">

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf @honeypot

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <input type="hidden" name="email" value="{{ old('email', $request->email) }}">



                    @if (session()->has('errors'))
                    @forelse ($errors->all() as $error)
                    <span class="block text-sm font-meduim text-red-600 dark:text-red-500 mb-2" role="alert">
                        <strong>{{ $error }}</strong>
                    </span>
                    @empty
                    @endforelse
                    @else
                    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                        <p class="text-sm font-medium">
                            Everything is good to go..
                        </p>
                        <p class="text-xs mt-2">
                            Please choose a new strong password.
                        </p>

                    </div>
                    @endif

                    <div class="mt-4">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-input" id="password" name="password" required
                            autocomplete="new-password" autofocus>
                    </div>

                    <div class="mt-4">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" class="form-input"
                            name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="btn btn-blue">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection