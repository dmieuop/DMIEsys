@extends('layouts.dmiesys.app')

@section('title', '| Manage Marks')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection


{{-- @push('styles')
<link rel="stylesheet" href="{{ asset('src/css/menu.css') }}">
@endpush --}}

@section('content')

<div class="screen">

    @include('components.premission-indicator', [
    'page' => 'Manage Marks',
    ])

    <div class="grid lg:grid-cols-2 lg:gap-x-20 xl:gap-x-32">
        <div class="menu-area d-flex flex-column">

            @can('add mark')
            <a href="{{ route('marks.create') }}" style="text-decoration: none;">
                <div class="menu-card @if ($manage_marks_auth ?? false) active-menu @endif">
                    <i class="bi bi-upload text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Upload Marks sheet for a subject</span>
                </div>
            </a>
            @endcan

            @can('delete mark')
            <a href="{{ route('marks.index') }}" style="text-decoration: none;">
                <div class="menu-card @if ($delete_marks_auth ?? false) active-menu @endif">
                    <i class="bi bi-eraser text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Remove Marks (Bulk)</span>
                </div>
            </a>
            @endcan

        </div>

        <div>

            @include('components.error-message')



            @if ($manage_marks_auth ?? false)
            <form action="{{ route('marks.store') }}" onsubmit="submitFunction()" enctype="multipart/form-data"
                method="post">
                @csrf @honeypot

                <div class="p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800"
                    role="alert">
                    <span class="font-semibold">Note!</span> Uploading a marks sheet for any course will change the
                    course status from
                    'Ongoing' to
                    'Complete'.
                </div>

                <div class="mb-3">
                    <label for="mark_sheet" class="form-label">Select the file</label>
                    <input class="form-upload"
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="mark_sheet"
                        type="file" id="mark_sheet" required>
                </div>

                @include('components.submit-button', [
                'button' => 'Upload',
                'cancel' => false,
                'icon' => 'bi-cloud-upload-fill',
                ])


            </form>

            <div class="p-4 pb-3 mb-4 mt-3 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800"
                role="alert">
                Please use the provided format for Marksheet.
                <a target="_blank" href="{{ asset('storage/downloads/Marksheet PRxxx-Exx - DMIE.xlsx') }}"
                    class="block mt-2 btn-sm rounded-full btn-gray">Download Marksheet template</a>
            </div>
            @endif

            @if ($delete_marks_auth ?? false)

            {{ $courses->links('', ['align' => 'center', 'hr' => true]) }}

            @forelse ($courses as $course)
            <form action="{{ route('marks.destroy', $course->course_id) }}" method="post">
                @csrf @honeypot
                @method('DELETE')
                @include('components.submit-button', [
                'cancel' => false,
                'button' => 'Delete ' . $course->course_id . ' Marks',
                'icon' => 'bi-trash',
                'color' => 'btn-danger',
                'align' => '',
                ])
            </form>

            @empty
            No Courses
            @endforelse

            @endif

        </div>

    </div>

</div>


@endsection