@extends('layouts.dmiesys.app')

@section('title', '| Student Affairs')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }}
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('src/css/tooltip.css') }}">
@endpush

@section('content')

<div class="screen">
    @include('components.premission-indicator', ['page' => 'Student Affairs'])

    <div class="grid lg:grid-cols-2 lg:gap-x-20 xl:gap-x-32">
        <div class="menu-area d-flex flex-column">

            @can('add student advisor')
            <a href="{{ route('student-advisor.create') }}" style="text-decoration: none;">
                <div class="menu-card @if ($enter_student_advisor_single_auth ?? false) active-menu @endif">
                    <i class="bi bi-hdd-network align-middle text-5xl"></i>
                    <span class="align-middle text-xl font-medium">Set student advisor (single)</span>
                </div>
            </a>
            @endcan

            @can('add student advisor')
            <a href="{{ route('students-advisor.create') }}" style="text-decoration: none;">
                <div class="menu-card @if ($enter_student_advisor_bulk_auth ?? false) active-menu @endif">
                    <i class="bi bi-hdd-stack align-middle text-5xl"></i>
                    <span class="align-middle text-xl font-medium">Set student advisor (bulk)</span>
                </div>
            </a>
            @endcan

            @can('add advisory comments')
            <a href="{{ route('meet-students.index') }}" style="text-decoration: none;">
                <div class="menu-card @if ($enter_student_advisory_comment_auth ?? false) active-menu @endif">
                    <i class="bi bi-calendar-day align-middle text-5xl"></i>
                    <span class="align-middle text-xl font-medium">Meet My Student</span>
                </div>
            </a>
            @endcan

            @if (auth()->user()->hasRole('Head of the Department') ||
            auth()->user()->can('student counselor'))
            <a href="{{ route('meet-students.create') }}" style="text-decoration: none;">
                <div class="menu-card @if ($resolve_need_my_attention_auth ?? false) active-menu @endif">
                    <i class="bi bi-exclamation-square align-middle text-5xl"></i>
                    <span class="align-middle text-xl font-medium">Needs My Attention</span>
                </div>
            </a>
            @endif

            @role('Head of the Department')
            <a href="{{ route('student-advisor.index') }}" style="text-decoration: none;">
                <div class="menu-card @if ($advisory_commitment_auth ?? false) active-menu @endif">
                    <i class="bi bi-kanban align-middle text-5xl"></i>
                    <span class="align-middle text-xl font-medium">See Advisors' Commitment</span>
                </div>
            </a>
            @endrole

        </div>

        <div>
            @include('components.error-message')

            @if ($enter_student_advisor_single_auth ?? false)
            @livewire('student-advisor-set-list')
            @endif


            @if ($enter_student_advisor_bulk_auth ?? false)
            <form action="{{ route('student-advisor.store') }}" enctype="multipart/form-data" method="post"
                onsubmit="submitFunction()">
                @csrf @honeypot @livewire('check-advisors-for-batch')

                <div class="mb-3">
                    <label for="student_advisor_list" class="form-label">Select the file</label>
                    <input class="form-upload"
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                        name="student_advisor_list" type="file" id="student_advisor_list" required />
                </div>

                @include('components.submit-button', ['button' => 'Upload', 'icon' => 'bi-cloud-upload-fill', 'cancel'
                => false])
            </form>

            <div class="mb-4 mt-3 rounded-lg bg-blue-100 p-4 pb-3 text-sm text-blue-700 dark:bg-blue-200 dark:text-blue-800"
                role="alert">
                Please use the provided format for Advisory list.
                <a target="_blank"
                    href="{{ asset('storage/downloads/Students Advisory List Exx DD-MM-YYYYY v1.0 DMIEsys.xlsx') }}"
                    class="btn-sm btn-gray mt-2 block rounded-full">Download Advisory List template</a>
            </div>
            @endif

            @if ($enter_student_advisory_comment_auth ?? false)
            <div id="alert-additional-content-1" class="mb-4 rounded-lg bg-blue-100 p-4 dark:bg-blue-200" role="alert">
                <div class="flex items-center">
                    <i class="bi bi-info-circle-fill mr-2 text-blue-700 dark:text-blue-800"></i>
                    <h3 class="text-lg font-medium text-blue-700 dark:text-blue-800">
                        Arrange a meeting
                    </h3>
                </div>
                <div class="mt-2 mb-4 text-sm text-blue-700 dark:text-blue-800">
                    It's best to meet your student from time to time. You can arrange a meeting with a student by
                    calling them or sending a personal email. Or you can send an email through
                    DMIEsys by clicking the button below.
                </div>
                <div class="flex">
                    <button type="button" class="btn-sm btn-blue" data-modal-toggle="set_a_meeting_modal">
                        <i class="bi bi-calendar3-event"></i>
                        Set a Meeting
                    </button>
                    <button type="button" class="btn-sm btn-gray ml-2" data-dismiss-target="#alert-additional-content-1"
                        aria-label="Close">
                        Dismiss
                    </button>
                </div>
            </div>
            <!-- Main modal -->
            <div id="set_a_meeting_modal" tabindex="-1" aria-hidden="true"
                class="h-modal fixed top-0 right-0 left-0 z-50 hidden w-full overflow-y-auto overflow-x-hidden md:inset-0 md:h-full">
                <div class="relative h-full w-full max-w-2xl p-4 md:h-auto">
                    <!-- Modal content -->
                    <form action="{{ route('meet-students.update', auth()->user()->id) }}" method="post">
                        @csrf @honeypot @method('patch')
                        <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
                            <!-- Modal header -->
                            <div class="flex items-start justify-between rounded-t border-b p-4 dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Arrange a meeting
                                </h3>
                            </div>
                            <!-- Modal body -->
                            <div class="space-y-6 p-6">
                                <div class="mb-3">
                                    <label for="student" class="form-label">Student</label>
                                    <select id="student" class="form-select" name="student" required>
                                        <option value="{{ null }}">
                                            -- Select Student --
                                        </option>
                                        @foreach ($students as $student)
                                        <option value="{{ $student->student_id }}">
                                            {{ $student->student_id }} {{ $student->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 grid grid-cols-2 gap-x-3">
                                    <div>
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" name="date" id="date" class="form-input"
                                            value="{{ old('date') }}" required />
                                    </div>
                                    <div>
                                        <label for="time" class="form-label">Time</label>
                                        <input type="time" name="time" id="time" class="form-input"
                                            value="{{ old('time') }}" required />
                                    </div>
                                </div>

                                <div class="mb-3 flex">
                                    <div class="mr-3 flex items-center">
                                        <input id="country-option-1" type="radio" name="meeting_method"
                                            value="in-person" class="form-option" onclick="showHideMeetingLink('none')"
                                            checked />
                                        <label for="country-option-1" class="form-option-label">
                                            In-person
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="country-option-2" type="radio" name="meeting_method" value="online"
                                            class="form-option" onclick="showHideMeetingLink('block')" />
                                        <label for="country-option-2" class="form-option-label">
                                            Online
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3" id="meeting_link_box" style="display: none;">
                                    <label for="meeting_link" class="form-label">Meeting link</label>
                                    <input type="url" name="meeting_link" value="{{ old('meeting_link') }}"
                                        id=" meeting_link" class="form-input" />
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label">Other Instructions (Optional) </label>
                                    <textarea class="form-textarea" name="message" id="message"
                                        rows="5">{{ old('message') }}</textarea>
                                </div>
                            </div>
                            <!-- Modal footer -->
                            <div
                                class="flex items-center space-x-2 rounded-b border-t border-gray-200 p-6 dark:border-gray-600">
                                <button type="submit" class="btn btn-yellow">
                                    <i class="bi bi-send"></i>
                                    Send
                                </button>
                                <button data-modal-toggle="set_a_meeting_modal" type="button"
                                    class="btn btn-gray dark:button ml-2">Close</button>
                            </div>
                        </div>
                    </form>

                    <script>
                        function showHideMeetingLink(option) {
                                    document.getElementById("meeting_link_box").style.display = option;
                                }
                    </script>
                </div>
            </div>

            <form action="{{ route('meet-students.store') }}" method="post" onsubmit="submitFunction()">
                @csrf @honeypot

                <div class="mb-3">
                    <label for="student_id" class="form-label">Student you are meeting</label>
                    <select id="student_id" class="form-select" name="student_id" required>
                        <option value="{{ null }}"> -- Select Student --</option>
                        @foreach ($students as $student)
                        <option value="{{ $student->student_id }}">
                            {{ $student->student_id }} {{ $student->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="comment" class="form-label">Comment on meeting</label>
                    <textarea name="comment" id="comment" rows="5" class="form-textarea"
                        placeholder="This comment is fully encrypted. Even the server admin will not have the privilege to see them. You can insert any personal details here. If you mark them for attention, HOD will be able to see your comment."
                        required></textarea>
                </div>

                <div class="mb-3">
                    <input id="need_hod_attention" name="need_hod_attention" type="checkbox" value="yes"
                        class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-red-600 focus:ring-2 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-red-600" />
                    <label for="need_hod_attention" class="ml-2 text-sm font-semibold text-red-600 dark:text-red-700">
                        Needs HOD's Attention</label>
                </div>

                <div class="mb-3">
                    <input id="need_sc_attention" name="need_sc_attention" type="checkbox" value="yes"
                        class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-red-600 focus:ring-2 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-red-600" />
                    <label for="need_sc_attention" class="ml-2 text-sm font-semibold text-red-600 dark:text-red-700">
                        Needs Student Counselor's Attention</label>
                </div>

                @include('components.submit-button', ['button' => 'Save Comment', 'icon' => 'bi-save2', 'cancel' =>
                false])
            </form>

            @livewire('show-past-advisory-comments')

            <script>
                const student_id = document.getElementById("student_id");
                        student_id.addEventListener("change", (e) => {
                            window.livewire.emitTo("show-past-advisory-comments", "showPastComments", student_id.value);
                        });
            </script>
            @endif

            @if ($resolve_need_my_attention_auth ?? false)
            @forelse ($comments as $comment)
            <div id="alert-additional-content-2"
                class="mb-4 rounded-lg bg-red-100 p-4 pb-2 shadow-md dark:bg-red-200 dark:shadow-gray-900/80"
                role="alert">
                <div class="flex items-center">
                    <h3 class="text-md font-medium text-red-700 dark:text-red-800">
                        {{ $comment->student_id }} ({{ $comment->hasStudent->name }})
                    </h3>
                </div>
                <div class="mt-2 mb-4 text-sm text-red-700 dark:text-red-800">
                    {{ $comment->comment }}
                </div>
                <div class="mt-2 mb-4 text-sm text-red-700 dark:text-red-800">
                    <strong>Email: </strong>{{ $comment->hasStudent->email }}<br />
                    <strong>Phone: </strong>{{ $comment->hasStudent->phone }}
                </div>
                <div class="flex justify-between">
                    <a href="{{ route('students-advisor.resolve', $comment->id) }}" class="btn btn-red">
                        I took necessary actions
                    </a>
                    <span class="text-xs font-semibold text-red-600 dark:text-red-600">
                        By {{ $comment->hasAdvisor->title }} {{ $comment->hasAdvisor->name }},<br />
                        {{ $comment->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
            @empty
            <div class="rounded-lg bg-gray-100 p-4 text-sm text-gray-700 dark:bg-gray-700 dark:text-gray-300"
                role="alert">
                No Advisory comemnts needs my attention for now.
            </div>
            @endforelse

            @endif

            @if ($advisory_commitment_auth ?? false)
            <table class="w-full text-left">
                <tbody>
                    @foreach ($lecturers as $lecturer)
                    <tr class="border-b dark:border-gray-700 dark:bg-gray-800">
                        <td class="px-3 py-4 text-sm dark:text-white">
                            {{ $lecturer->title }} {{ $lecturer->name }}
                        </td>
                        <td class="px-3 py-4">
                            <div>
                                @foreach ($lecturer->getStudents as $student)
                                @if ($student->last_advisory_report >= now()->subMonths(3))
                                <div
                                    class="tooltip bi bi-check-circle-fill mr-2 cursor-pointer text-green-600 dark:text-green-500">
                                    <span class="tooltip-text text-xs">
                                        {{ $student->student_id }} <br>
                                        Last report on: {{ $student->last_advisory_report }}
                                    </span>
                                </div>
                                @elseif($student->last_advisory_report > now()->subMonths(6))
                                <div
                                    class="tooltip bi bi-question-circle-fill mr-2 cursor-pointer text-amber-500 dark:text-amber-400">
                                    <span class="tooltip-text text-xs">
                                        {{ $student->student_id }} <br>
                                        Last report on: {{ $student->last_advisory_report }}
                                    </span>
                                </div>
                                @else
                                <div
                                    class="tooltip bi bi-x-circle-fill mr-2 cursor-pointer text-red-600 dark:text-red-500">
                                    <span class="tooltip-text text-xs">
                                        {{ $student->student_id }} <br>
                                        Last report on: {{ $student->last_advisory_report }}
                                    </span>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>

@endsection