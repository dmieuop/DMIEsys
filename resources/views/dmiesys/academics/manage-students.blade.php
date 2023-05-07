@extends('layouts.dmiesys.app')

@section('title', '| Manage Students')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection


@section('content')

<div class="screen">

    @include('components.premission-indicator', ['page' => 'Manage Students'])

    <div class="grid lg:grid-cols-2 lg:gap-x-20 xl:gap-x-32">
        <div class="menu-area d-flex flex-column">

            @can('add student')
            <a href="{{ route('student.create') }}" style="text-decoration: none;">
                <div class="menu-card @if ($enter_student_single_auth ?? false) active-menu @endif">
                    <i class="bi bi-person-plus align-middle text-5xl"></i>
                    <span class="align-middle text-xl font-medium">Enter Student record (single)</span>
                </div>
            </a>
            @endcan

            @can('add student')
            <a href="{{ route('students.create') }}" style="text-decoration: none;">
                <div class="menu-card @if ($enter_student_bulk_auth ?? false) active-menu @endif">
                    <i class="bi bi-people align-middle text-5xl"></i>
                    <span class="align-middle text-xl font-medium">Enter Student record (bulk)</span>
                </div>
            </a>
            @endcan

            @can('see student')
            <a href="{{ route('student.index') }}" style="text-decoration: none;">
                <div class="menu-card @if ($view_student_auth ?? false) active-menu @endif">
                    <i class="bi bi-person-bounding-box align-middle text-5xl"></i>
                    <span class="align-middle text-xl font-medium">View a student record</span>
                </div>
            </a>
            @endcan


        </div>


        <div>

            @include('components.error-message')

            @if ($enter_student_single_auth ?? false)

            <form action="{{ route('student.store') }}" method="post" onsubmit="submitFunction()">
                @csrf @honeypot

                <div class="mb-3">
                    <label for="batch" class="form-label">Batch</label>
                    <select id="batch" class="form-select" name="batch">
                        @foreach ($batches as $batch)
                        <option value="{{ $batch }}">{{ $batch }}</option>
                        @endforeach
                    </select>
                </div>

                <label for="student_id" class="form-label">Registration number</label>
                <div class="mb-3 flex">
                    <span id="student_batch"
                        class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-200 px-3 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-400">

                    </span>
                    <input type="text"
                        class="block w-full min-w-0 flex-1 rounded-none rounded-r-lg border border-gray-300 border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="student_id" value="{{ old('student_id') }}" pattern="[0-9]{3}" maxlength="3" size=3
                        required>
                </div>

                <input type="hidden" id="id" name="id" value="{{ old('id') }}" maxlength="6" size="6">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-input" value="{{ old('name') }}" maxlength="50" size="50" name="name"
                        required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-input" value="{{ old('email') }}" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-input" value="{{ old('phone') }}" maxlength="10" size="10"
                        name="phone">
                </div>

                @include('components.submit-button', [
                'button' => 'Add Student',
                'icon' => 'bi-person-plus-fill',
                'cancel' => false,
                ])


            </form>

            @endif

            @if ($enter_student_bulk_auth ?? false)


            <form action="{{ route('students.store') }}" enctype="multipart/form-data" method="post"
                onsubmit="submitFunction()">
                @csrf @honeypot

                <div class="mb-3">
                    <label for="batch" class="form-label">Batch</label>
                    <select id="batch" class="form-select" name="batch">
                        @foreach ($batches as $batch)
                        <option value="{{ $batch }}">{{ $batch }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="student_list" class="form-label">Select the file</label>
                    <input class="form-upload"
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="student_list"
                        type="file" id="student_list" required>
                </div>

                @include('components.submit-button', [
                'button' => 'Upload',
                'icon' => 'bi-cloud-upload-fill',
                'cancel' => false,
                ])


            </form>

            <div class="mb-4 mt-3 rounded-lg bg-blue-100 p-4 pb-3 text-sm text-blue-700 dark:bg-blue-200 dark:text-blue-800"
                role="alert">
                Please use the provided format for Student list.
                <a target="_blank" href="{{ asset('storage/downloads/Student List Exx - DMIE.xlsx') }}"
                    class="btn-sm btn-gray mt-2 block rounded-full">Download Student List template</a>
            </div>


            @endif

            @if ($view_student_auth ?? false)
            @livewire('student-drop-down-view')
            @endif

            @if ($view_student_single_auth ?? false)


            <div class="mb-3">
                <label for="student_id" class="form-label">Registration number</label>
                <input type="text" class="form-input-readonly" value="{{ $student->student_id }}" readonly>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-input-readonly" value="{{ $student->name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-input-readonly" value="{{ $student->email }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-input-readonly" value="{{ $student->phone }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">LinkedIn Profile</label>
                <p><a class="btn-sm btn-blue @if (!$student->profile_link) hidden @endif btn-info no-u h6 rounded-full"
                        target="_blank" href="{{ $student->profile_link }}">Goto Profile</a>
                </p>
                <p class="@if ($student->profile_link) hidden @endif text-sm italic text-gray-600">
                    (no LinkedIn profile added)
                </p>
            </div>

            <div class="@if (!$student->graduated) hidden @endif mb-3">
                <label class="form-label">Currently Working</label>
                <input type="text" class="form-input-readonly" value="{{ $student->current_working ?? '---' }}"
                    readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <p class="font-semibold">
                    @if ($student->graduated)
                    Graduated
                    @else
                    Undergraduate
                    @endif
                </p>
            </div>

            @can('edit student')
            <div>
                @can('edit student')
                <div class="flex justify-end">
                    <a href="{{ route('student.edit', $student->student_id) }}" class="btn btn-yellow">
                        <i class="bi bi-pencil-fill"></i>
                        Edit</a>
                </div>
                @endcan
                @can('delete student')
                <div>
                    <form action="{{ route('student.destroy', $student->student_id) }}" method="post">
                        @csrf @honeypot
                        @method('delete')
                        @include('components.submit-button', [
                        'button' => 'Delete',
                        'icon' => 'bi-trash-fill',
                        'cancel' => false,
                        'color' => 'btn-red',
                        'loop' => 'student',
                        ])
                    </form>
                </div>
                @endcan

            </div>
            @endcan

            @endif

            @if ($edit_student_single_auth ?? false)
            <form action="{{ route('student.update', $student->student_id) }}" onsubmit="submitFunction()"
                method="post">
                @method('patch')
                @csrf @honeypot

                <div class="mb-3">
                    <label for="student_id" class="form-label">Registration number</label>
                    <input type="text" class="form-input-readonly" value="{{ $student->student_id }}" name="student_id"
                        readonly required>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-input" value="{{ $student->name }}" maxlength="50" size="50"
                        name="name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-input" value="{{ $student->email }}" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-input" value="{{ $student->phone }}" maxlength="10" size="10"
                        name="phone">
                </div>

                <div class="mb-3 flex items-center">
                    <input id="graduated" aria-describedby="graduated" name="graduated" type="checkbox"
                        class="form-check" @if ($student->graduated) checked @endif>
                    <label for="graduated" class="form-check-label">Graduated</label>
                </div>

                <div class="mb-3">
                    <label for="profile_link" class="form-label">LinkedIn Profile</label>
                    <input type="url" class="form-input" value="{{ $student->profile_link }}" name="profile_link">
                </div>

                <div class="mb-3">
                    <label for="current_working" class="form-label">Currently working</label>
                    <input type="text" class="form-input" value="{{ $student->current_working }}"
                        name="current_working">
                </div>

                @include('components.submit-button', [
                'button' => 'Update',
                'icon' => 'bi-pencil-square',
                'cancel' => route('student.show', $student->student_id),
                ])


            </form>
            @endif

        </div>

    </div>

</div>


@endsection

@push('scripts')
<script src="{{ asset('src/js/manage.students.js') }}"></script>
@endpush