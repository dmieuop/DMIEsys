@extends('layouts.dmiesys.app')

@section('title', '| Manage Laboratories')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection


{{-- @push('styles')
<link rel="stylesheet" href="{{ asset('src/css/menu.css') }}">
@endpush --}}

@section('content')

<div class="screen">

    @include('components.premission-indicator', [
    'page' => 'Manage Laboratories',
    ])

    <div class="grid lg:grid-cols-2 lg:gap-x-20 xl:gap-x-32">
        <div class="menu-area d-flex flex-column">

            @can('add laboratory')
            <a href="{{ route('labs.create') }}" style="text-decoration: none;">
                <div class="menu-card @if ($add_lab_auth ?? false) active-menu @endif">
                    <i class="bi bi-building-add text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Add a new Laboratory</span>
                </div>
            </a>
            @endcan

        </div>

        <div>

            @include('components.error-message')

            @if ($add_lab_auth ?? false)

            <form method="POST" onsubmit="submitFunction()" action="{{ route('labs.store') }}">
                @csrf @honeypot

                <div class="mb-3">
                    <label for="name" class="form-label">Name of the lab</label>
                    <input type="text" class="form-input" value="{{ old('name') }}" id="name" name="name"
                        maxlength="100" size="100" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description (optional)</label>
                    <textarea name="description" class="form-textarea" id="description"
                        rows="10">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="1" name="allow_internal_booking" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Allow internal users to book this facility
                        </span>
                    </label>
                </div>

                <div class="mb-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="1" name="allow_external_booking" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Allow external users to book this facility
                        </span>
                    </label>
                </div>

                <div class="mb-3">
                    <label for="technicalstaff" class="form-label">Assign a technical staff
                        member (optional)</label>
                    <select id="technicalstaff" class="form-input" name="technicalstaff">
                        <option value="{{ null }}" selected>-- Select a user --</option>
                        @foreach ($technicalstaffs as $technicalstaff)
                        <option value="{{ $technicalstaff['id'] }}">{{ $technicalstaff['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="academicstaff" class="form-label">Assign a permanent staff
                        member (optional)</label>
                    <select id="academicstaff" class="form-input" name="academicstaff">
                        <option value="{{ null }}" selected>-- Select a user --</option>
                        @foreach ($academicstaffs as $academicstaff)
                        <option value="{{ $academicstaff['id'] }}">{{ $academicstaff['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="temporarystaff" class="form-label">Assign a temporary staff
                        member (optional)</label>
                    <select id="temporarystaff" class="form-input" name="temporarystaff">
                        <option value="{{ null }}" selected>-- Select a user --</option>
                        @foreach ($academicstaffs as $academicstaff)
                        <option value="{{ $academicstaff['id'] }}">{{ $academicstaff['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                @include('components.submit-button', [
                'button' => 'Add a Lab',
                'icon' => 'bi-plus-circle',
                'cancel' => false,
                ])

            </form>

        </div>
    </div>


</div>

@endsection

{{-- @push('scripts')
<script src="{{ asset('src/js/manage.courses.js') }}"></script>
@endpush --}}