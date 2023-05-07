@extends('layouts.dmiesys.app')

@section('title', '| Password Confirm')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection

@push('styles')
<style>
    .main {
        display: flex;
        height: 70vh;
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



            <div class="w-full mt-2">
                <div class="mb-2 text-md text-gray-600 dark:text-gray-100">
                    <p class="text-md text-green-400 font-medium">
                        Email address successfully verified!
                    </p>
                    <p class="text-sm mt-2">
                        Now your new email address is updated to your profile.
                    </p>

                </div>

            </div>


        </div>
    </div>

</div>
@endsection