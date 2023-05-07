@extends('layouts.dmiesys.app')

@section('title', '| Password Confirm')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection

@push('styles')
<style>
    .main {
        display: flex;
        height: 85vh;
        width: 100%;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div class="main mx-auto">
    <div class="bg-white dark:bg-gray-800 px-2 pb-3 border-0 shadow-md dark:shadow-gray-900/80 mt-10 rounded-2xl">
        <div class="w-96 px-3 pt-4 pb-2">



            <div class="w-full mt-2 mb-3">
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-100">
                    <p class="text-sm font-medium">
                        Please confirm your password
                    </p>
                    <p class="text-xs mt-2">
                        You must confirm your password to continue.
                    </p>

                </div>

            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf @honeypot



                <div class="mb-3">
                    <label for="password" class="form-label"><i class="bi bi-lock-fill"></i>
                        Password</label>
                    <input type="password" class="form-input id=" password" name="password"
                        :value="{{ old('password') }}" required autocomplete="password" autofocus>
                    @forelse ($errors->all() as $error)
                    <span class="text-sm text-red-500" role="alert">
                        <strong>{{ $error }}</strong>
                    </span>
                    @empty
                    @endforelse
                </div>


                <div class="flex items-center justify-end">
                    <button type="submit" class="btn btn-blue">
                        <i class="bi bi-send mr-2"></i>
                        Confirm
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection