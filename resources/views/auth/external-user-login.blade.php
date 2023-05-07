@extends('layouts.dmiesys.app')

@section('title', '| External User Login')

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
                        Do you need to update your profile?
                    </p>
                    <p class="text-xs mt-2">
                        Select your profile and click verify button.
                    </p>
                </div>


                <form method="POST" action="{{ route('external-user.store') }}">
                    @csrf @honeypot

                    @livewire('external-user-auth-dropdown')

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
                        <button type="submit" class="btn btn-blue">Verify Me</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection