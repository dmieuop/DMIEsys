@extends('layouts.dmiesys.app')

@section('title', '| Manage Courses')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection


@section('content')

<div class="screen">

    @include('components.premission-indicator', ['page' => 'Manage Courses'])

    <div class="grid lg:grid-cols-2 lg:gap-x-20 xl:gap-x-32">
        <div class="menu-area d-flex flex-column">

            @can('add base course')
            <a href="{{ route('base-course.create') }}" style="text-decoration: none;">
                <div class="menu-card @if ($create_base_course_auth ?? false) active-menu @endif">
                    <i class="bi bi-journal-medical text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Create a base course</span>
                </div>
            </a>
            @endcan

            @can('see base course')
            <a href="{{ route('base-course.index') }}" style="text-decoration: none;">
                <div class="menu-card @if ($view_base_course_auth ?? false) active-menu @endif">
                    <i class="bi bi-journal-richtext text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">View a base course</span>
                </div>
            </a>
            @endcan

            @can('add course')
            <a href="{{ route('course.create') }}" style="text-decoration: none;">
                <div class="menu-card @if ($create_course_auth ?? false) active-menu @endif">
                    <i class="bi bi-journal-plus text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Create a course</span>
                </div>
            </a>
            @endcan

            @can('see course')
            <a href="{{ route('course.index') }}" style="text-decoration: none;">
                <div class="menu-card @if ($view_course_auth ?? false) active-menu @endif">
                    <i class="bi bi-journal-text text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">View a course</span>
                </div>
            </a>
            @endcan

        </div>

        <div>

            @include('components.error-message')

            @if ($create_base_course_auth ?? false)
            <form method="POST" onsubmit="submitFunction()" action="{{ route('base-course.store') }}"
                enctype="multipart/form-data">
                @csrf @honeypot

                <div class="mb-4">
                    <label for="course_code" class="form-label">Course Code</label>
                    <input type="text" class="form-input focus:shadow-md dark:shadow-gray-900/80" id="course_code"
                        name="course_code" placeholder="PRXXX" value="{{ old('course_code') }}" pattern="PR[0-9]{3}"
                        minlength=5 maxlength=5 size="5" required>
                </div>

                <div class="mb-4">
                    <label for="course_name" class="form-label">Course Name</label>
                    <input type="text" class="form-input focus:shadow-md dark:shadow-gray-900/80"
                        value="{{ old('course_name') }}" id="course_name" name="course_name" maxlength="100" size="100"
                        required>
                </div>

                <div class="mb-4">
                    <label for="credit" class="form-label">Course Credits</label>
                    <select id="credit" class="form-select w-full focus:shadow-md dark:shadow-gray-900/80"
                        name="credit">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option selected value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="genre" class="form-label">Course Type</label>
                    <select id="genre" class="form-select w-full focus:shadow-md dark:shadow-gray-900/80" name="genre">
                        <option selected value="cc">Core Course</option>
                        <option value="tc">Technical Course</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="coba_sheet" class="form-label">Select a COBA plan</label>
                    <input class="form-upload w-full focus:shadow-md dark:shadow-gray-900/80" name="coba_sheet"
                        type="file" id="coba_sheet" required>
                </div>

                @include('components.submit-button', [
                'button' => 'Create Course',
                'icon' => 'bi-plus-circle',
                'cancel' => false,
                ])

            </form>

            <div class="p-4 pb-3 mb-4 mt-3 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800"
                role="alert">
                Please use the provided format for COBA plan.
                <a target="_blank" href="{{ asset('storage/downloads/COBA Plan PRxxx - DMIE.xlsx') }}"
                    class="block mt-2 btn-sm rounded-full btn-gray">Download COBA template</a>
            </div>
            @endif

            @if ($edit_base_course_auth ?? false)
            <form method="POST" onsubmit="submitFunction()"
                action="{{ route('base-course.update', $course->course_code) }}">
                @method('patch')
                @csrf @honeypot

                <div class="mb-3">
                    <label for="course_code" class="form-label">Course Code</label>
                    <input type="text" class="form-select" value="{{ $course->course_code }}" id="course_code"
                        name="course_code" maxlength="100" size="100" readonly required>
                </div>

                <div class="mb-3">
                    <label for="course_name" class="form-label">Course Name</label>
                    <input type="text" class="form-select" value="{{ $course->course_name }}" id="course_name"
                        name="course_name" maxlength="100" size="100" required>
                </div>


                <div class="mb-3">
                    <label for="credit" class="form-label">Course Credit</label>
                    <select id="credit" class="form-select" name="credit">
                        <option @if ($course->credit == 1) selected @endif value="1">1</option>
                        <option @if ($course->credit == 2) selected @endif value="2">2</option>
                        <option @if ($course->credit == 3) selected @endif value="3">3</option>
                        <option @if ($course->credit == 4) selected @endif value="4">4</option>
                        <option @if ($course->credit == 5) selected @endif value="5">5</option>
                        <option @if ($course->credit == 6) selected @endif value="6">6</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="genre" class="form-label">Course Type</label>
                    <select id="genre" class="form-select" name="genre">
                        <option @if ($course->genre == 'cc') selected @endif value="cc">Core Course</option>
                        <option @if ($course->genre == 'tc') selected @endif value="tc">Technical Course
                        </option>
                    </select>
                </div>

                @include('components.submit-button', [
                'button' => 'Update',
                'icon' => 'bi-pencil',
                'cancel' => route('base-course.index'),
                ])

            </form>
            @endif

            @if ($view_base_course_auth ?? false)

            {{ $courses->links('', ['align' => 'center', 'hr' => true]) }}

            @forelse ($courses as $course)
            <div class="mb-3">
                <a class="btn-sm btn-gray" href="{{ route('base-course.show', $course->course_code) }}">{{
                    $course->course_code }}
                    ({{ $course->course_name }})
                </a>

                @can('edit base course')
                <a class="ml-2 btn-sm btn-yellow" href="{{ route('base-course.edit', $course->course_code) }}">
                    <i class="bi-pencil"></i>
                </a>
                @endcan
            </div>
            @empty
            No Base courses
            @endforelse


            @endif

            @if ($create_course_auth ?? false)

            <form action="{{ route('course.store') }}" onsubmit="submitFunction()" method="post">
                @csrf @honeypot

                <div class="mb-3">
                    <label for="course_code" class="form-label">Base Course Code</label>
                    <select id="course_code" class="form-select" name="course_code">
                        @forelse ($general_courses as $base_code)
                        <option value="{{ $base_code->course_code }}">{{ $base_code->course_code }} - {{
                            $base_code->course_name }}</option>
                        @empty
                        <option value="0">No Base Courses</option>
                        @endforelse
                    </select>
                </div>

                <div class="mb-3">
                    <label for="batch" class="form-label">Batch</label>
                    <select id="batch" class="form-select" name="batch">
                        @foreach ($batches as $batch)
                        <option value="{{ $batch }}">{{ $batch }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="course_id" class="form-label">Course ID</label>
                    <input type="text" class="form-input-readonly" value="{{ old('course_id') }}" id="course_id"
                        name="course_id" readonly required>
                </div>

                <div class="mb-3">
                    <label for="year" class="form-label">Year</label>
                    <select id="year" class="form-select" name="year">
                        @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select id="semester" class="form-select" name="semester">
                        @foreach ($semesters as $semester)
                        <option value="{{ $semester }}">Semester {{ $semester }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="drive_folder_id" class="form-label">Google Drive folder ID</label>
                    <input type="text" class="form-input" value="{{ old('drive_folder_id') }}" name="drive_folder_id">
                </div>

                <div class="mb-3">
                    <label for="period" class="form-label">Period</label>
                    <input type="text" class="form-input" value="{{ old('period') }}" placeholder="mm/yy - mm/yy"
                        name="period" required>
                </div>

                <div class="mb-3">
                    <label for="coordinator" class="form-label">Coordinator</label>
                    <select id="coordinator" class="form-select" name="coordinator">
                        @foreach ($lecturers as $coordinator)
                        <option value="{{ $coordinator['username'] }}">{{ $coordinator['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="moderator" class="form-label">Moderator</label>
                    <select id="moderator" class="form-select" name="moderator">
                        @foreach ($lecturers as $moderator)
                        <option value="{{ $moderator['username'] }}">{{ $moderator['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="secondexaminer" class="form-label">Second examiner</label>
                    <select id="secondexaminer" class="form-select" name="secondexaminer">
                        @foreach ($lecturers as $secondexaminer)
                        <option value="{{ $secondexaminer['username'] }}">{{ $secondexaminer['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="instructorincharge" class="form-label">Instructor in-charge
                    </label>
                    <select id="instructorincharge" class="form-select" name="instructorincharge">
                        @foreach ($instructors as $instructorincharge)
                        <option value="{{ $instructorincharge['username'] }}">
                            {{ $instructorincharge['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                @include('components.submit-button', [
                'button' => 'Create Course',
                'icon' => 'bi-plus-circle',
                'cancel' => false,
                ])

            </form>

            @endif

            @if ($edit_course_auth ?? false)

            <form action="{{ route('course.update', $course->course_id) }}" onsubmit="submitFunction()" method="post">
                @method('patch')
                @csrf @honeypot

                <div class="mb-3">
                    <label for="course_id" class="form-label">Course ID</label>
                    <input type="text" class="form-input-readonly" value="{{ $course->course_id }}" id="course_id"
                        name="course_id" readonly required>
                </div>

                <div class="mb-3">
                    <label for="year" class="form-label">Year</label>
                    <select id="year" class="form-select" name="year">
                        @foreach ($years as $year)
                        <option @if ($course->year == $year) selected @endif
                            value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select id="semester" class="form-select" name="semester">
                        @foreach ($semesters as $semester)
                        <option @if ($course->semester == $semester) selected @endif
                            value="{{ $semester }}">Semester
                            {{ $semester }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="drive_folder_id" class="form-label">Google Drive folder ID</label>
                    <input type="text" class="form-input" value="{{ $course->course_folder_id }}" name="drive_folder_id"
                        readonly>
                </div>

                <div class="mb-3">
                    <label for="period" class="form-label">Period</label>
                    <input type="text" class="form-input" value="{{ $course->period }}" placeholder="mm/yy - mm/yy"
                        name="period" required>
                </div>

                <div class="mb-3">
                    <label for="coordinator" class="form-label">Coordinator</label>
                    <select id="coordinator" class="form-select" name="coordinator">
                        @foreach ($lecturers as $coordinator)
                        <option @if ($course->coordinator_username == $coordinator['username']) selected @endif
                            value="{{ $coordinator['username'] }}">{{ $coordinator['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="moderator" class="form-label">Moderator</label>
                    <select id="moderator" class="form-select" name="moderator">
                        @foreach ($lecturers as $moderator)
                        <option @if ($course->moderator_username == $moderator['username']) selected @endif
                            value="{{ $moderator['username'] }}">{{ $moderator['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="secondexaminer" class="form-label">Second examiner</label>
                    <select id="secondexaminer" class="form-select" name="secondexaminer">
                        @foreach ($lecturers as $secondexaminer)
                        <option @if ($course->secondexaminer_username == $secondexaminer['username']) selected @endif
                            value="{{ $secondexaminer['username'] }}">{{ $secondexaminer['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="instructorincharge" class="form-label">Instructor in-charge
                    </label>
                    <select id="instructorincharge" class="form-select" name="instructorincharge">
                        @foreach ($instructors as $instructorincharge)
                        <option @if ($course->instructorincharge_username == $instructorincharge['username']) selected
                            @endif
                            value="{{ $instructorincharge['username'] }}">
                            {{ $instructorincharge['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                @include('components.submit-button', [
                'button' => 'Update',
                'icon' => 'bi-pencil',
                'cancel' => route('course.index'),
                ])

            </form>

            @endif

            @if ($view_course_auth ?? false)

            {{ $courses->links('', ['align' => 'center', 'hr' => true]) }}

            @forelse ($courses as $course)
            <div class="mb-3">
                <a class="btn-sm btn-gray" href="{{ route('course.show', $course->course_id) }}">{{ $course->course_id
                    }}
                    ({{ $course->status }})
                </a>

                @can('edit base course')
                <a class="ml-2 btn-sm btn-yellow" href="{{ route('course.edit', $course->course_id) }}">
                    <i class="bi-pencil"></i>
                </a>
                @endcan
            </div>
            @empty
            No Courses
            @endforelse

            @endif

        </div>
    </div>


</div>

@endsection

@push('scripts')
<script src="{{ asset('src/js/manage.courses.js') }}"></script>
@endpush