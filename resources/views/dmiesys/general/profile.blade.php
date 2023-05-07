@extends('layouts.dmiesys.app')

@section('title', '| Profile')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection


@section('content')

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    @if (Laravel\Fortify\Features::canUpdateProfileInformation())
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <x-section-title>
            <x-slot name="title">Profile Information</x-slot>
            <x-slot name="description">
                Update your account's profile information and email address.
            </x-slot>
        </x-section-title>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div
                class="px-4 py-5 bg-white sm:p-6 shadow 'sm:rounded-tl-md sm:rounded-tr-md sm:rounded-md  dark:bg-gray-900">

                @include('components.error-message')

                <form action="{{ route('user-profile.update', auth()->user()->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf @honeypot
                    @method('patch')
                    <input type="hidden" name="_type" value="profile_update_request">
                    <div>
                        <div class="grid grid-cols-1 md:grid-cols-3">

                            <div class="md:col-span-2">
                                <div class="mb-3">
                                    <div class="col-md-3 mb-3">
                                        <label for="title" class="form-label">Title
                                        </label>
                                        <select name="title" id="title" class="form-select">
                                            <option @if (auth()->user()->title == 'Mr') selected @endif value="Mr">Mr
                                            </option>
                                            <option @if (auth()->user()->title == 'Mrs') selected @endif value="Mrs">
                                                Mrs</option>
                                            <option @if (auth()->user()->title == 'Miss') selected @endif value="Miss">
                                                Miss</option>
                                            <option @if (auth()->user()->title == 'Ms') selected @endif value="Ms">Ms
                                            </option>
                                            <option @if (auth()->user()->title == 'Dr') selected @endif value="Dr">Dr
                                            </option>
                                            <option @if (auth()->user()->title == 'Prof') selected @endif value="Prof">
                                                Prof</option>
                                            <option @if (auth()->user()->title == 'Eng') selected @endif value="Eng">
                                                Eng</option>
                                        </select>
                                    </div>
                                    <div class="col-md-9 mb-3">
                                        <label for="name" class="form-label">Name
                                        </label>
                                        <input type="text" maxlength="100" class="form-input"
                                            value="{{ auth()->user()->name }}" id="name" name="name" required>
                                    </div>
                                </div>
                                @can('update profile picture')
                                <div class="mb-3">
                                    <label for="profilePicture" class="form-label">Select a new
                                        photo</label>
                                    <input class="form-upload" aria-describedby="photoHelp" type="file"
                                        name="profilePicture" id="profilePicture" accept="image/*">
                                    <div id="photoHelp" class="form-input-help">Images should be at least
                                        300×300px and less
                                        than 1 MB.</div>
                                </div>
                                @endcan
                            </div>

                            @can('update profile picture')
                            <div class="flex items-center justify-end">
                                <div>
                                    @include('components.profile-image', [
                                    'size' => '22vh',
                                    'class' => 'shadow-md dark:shadow-gray-900/80',
                                    'path' => auth()->user()->profile_photo_path,
                                    ])
                                </div>
                            </div>
                            @endcan

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email
                            </label>
                            <input type="email" maxlength="50" value="{{ auth()->user()->email }}" class="form-input"
                                id="email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone
                            </label>
                            <input type="text" maxlength="20" value="{{ auth()->user()->phone }}" class="form-input"
                                name="phone" id="phone">
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button>
                            {{ __('Save') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-section-border />
    @endif

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
    <div class="mt-10 sm:mt-0">
        @livewire('profile.update-password-form')
    </div>

    <x-section-border />
    @endif

    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
    <div class="mt-10 sm:mt-0">
        @livewire('profile.two-factor-authentication-form')
    </div>

    <x-section-border />
    @endif

    <div class="mt-10 sm:mt-0">
        @livewire('profile.logout-other-browser-sessions-form')
    </div>

    @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
    <x-section-border />

    <div class="mt-10 sm:mt-0">
        @livewire('profile.delete-user-form')
    </div>
    @endif
</div>

@endsection