@extends('layouts.dmiesys.app')

@section('title', '| Student Login')

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
<div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
    <div class="rounded-2xl border-0 bg-white dark:bg-gray-800 px-5 pt-4 pb-3 w-96 shadow-md dark:shadow-gray-900/80">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            <p class="text-sm font-medium">
                Do you need to update your profile?
            </p>
            <p class="text-xs mt-2">
                Select your profile and click verify button.
            </p>
        </div>


        <form method="POST" action="{{ route('student-profile.store') }}">
            @csrf @honeypot

            @livewire('student-login-dropdown')

            @if (session()->has('errors'))
            @forelse ($errors->all() as $error)
            <span class="block text-sm text-red-600 dark:text-red-500 my-2" role="alert">
                <strong>{{ $error }}</strong>
            </span>
            @empty
            @endforelse
            @endif
            @if (session('status'))
            <div class="mb-4 mt-2 text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="btn btn-blue">
                    <i class="bi bi-check2-circle mr-2"></i>
                    Verify Me
                </button>
            </div>
        </form>
    </div>

    <div class="p-4 my-2 text-xs text-blue-800 rounded-xl bg-blue-50 dark:bg-gray-800 dark:text-blue-400 w-96 shadow-md dark:shadow-gray-900/80"
        role="alert">
        <strong>Note!</strong> If you can't find your profile, please send a email to
        <span class="font-semibold">{{ config('settings.contact.office') }}</span>
    </div>

</div>
@endsection