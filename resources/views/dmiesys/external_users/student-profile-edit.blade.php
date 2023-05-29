@extends('layouts.dmiesys.app')

@section('title', '| Student - ' . $student->name)

@section('content')

<div class="screen">

    @include('components.premission-indicator', [
    'page' => 'Student Profile',
    'name' => $student['name'],
    'role' => 'Student',
    ])

    <div class="grid lg:grid-cols-2 lg:gap-x-20 xl:gap-x-32">
        <div class="menu-area d-flex flex-column">

            <a href="{{ route('student-profile.edit', 'information') }}" style="text-decoration: none;">
                <div class="menu-card @if ($information_auth ?? false) active-menu @endif">
                    <i class="bi bi-person-vcard text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Information</span>
                </div>
            </a>

            <a href="{{ route('student-profile.edit', 'projects') }}" style="text-decoration: none;">
                <div class="menu-card @if ($project_auth ?? false) active-menu @endif">
                    <i class="bi bi-folder text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">My Projects</span>
                </div>
            </a>

            <a href="{{ route('student-profile.edit','researches') }}" style="text-decoration: none;">
                <div class="menu-card @if ($research_auth ?? false) active-menu @endif">
                    <i class="bi bi-file-text text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">My Researches</span>
                </div>
            </a>

            <a href="{{ route('student-profile.edit', 'documents') }}" style="text-decoration: none;">
                <div class="menu-card @if ($document_auth ?? false) active-menu @endif">
                    <i class="bi bi-file-earmark-pdf text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Documents</span>
                </div>
            </a>

        </div>

        <div>

            @include('components.error-message')

            @if ($information_auth ?? false)

            <form method="POST" onsubmit="submitFunction()" action="#" enctype="multipart/form-data">
                @csrf @honeypot

                <div class="mb-3">
                    <label for="id" class="form-label">Registration No.</label>
                    <input type="text" class="form-input-readonly" value="{{ $student->student_id }}" id="id" disabled>
                </div>

                {{-- <div class="mb-3">
                    <label class="form-label" for="file_input">
                        Picture of yours
                    </label>
                    <input class="form-upload" aria-describedby="file_input_help" id="file_input" type="file">
                    <p class="form-input-help" id="file_input_help">
                        Your profile picture will be made public.
                    </p>
                </div> --}}

                {{-- <div class="mb-3">
                    <div
                        class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl dark:border-gray-700 dark:bg-gray-800">
                        <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-32 md:rounded-none md:rounded-l-lg"
                            src="{{ asset('storage/student-pictures/male-avatar.png') }}" alt="">
                        <div class="flex flex-col justify-between p-4 pt-0 leading-normal">
                            @if (is_null($student->profile_photo))
                            <div class="my-3">
                                <input class="form-upload" aria-describedby="file_input_help" id="file_input"
                                    type="file">
                                <p class="form-input-help" id="file_input_help">
                                    Your profile picture will be made public.
                                </p>
                            </div>
                            @else
                            <button type="button" class="btn btn-red my-3">delete my current photo</button>
                            @endif

                            <p class="font-normal text-gray-700 dark:text-gray-400 text-xs">
                                Please provide a professional portrait of yourself with a minimum resolution of 450x600
                                pixels. The image should be in either JPG or PNG format and its file size should be less
                                than 10 megabytes (MB). <br>
                            </p>
                        </div>
                    </div>

                </div> --}}

                @livewire('student-profile-picture-upload', ['student_id' => $student->student_id])

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input aria-describedby="name-helper" type="text" class="form-input"
                        value="{{ old('name') ?? $student->name }}" id="name" placeholder="Mr. A.B.C. Perera"
                        name="name" maxlength="50" size="50" required>
                    <p id="name-helper" class="form-input-help">Use the name format Mr. A.B.C. Perera</p>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input aria-describedby="email-helper" type="email" class="form-input"
                        value="{{ old('email') ?? $student->email }}" id="email" placeholder="youremail@email.com"
                        email="email" maxlength="50" size="50" required>
                    <p id="email-helper" class="form-input-help">Please enter a valid email address otherwise, you'll be
                        locked out</p>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input aria-describedby="phone-helper" type="text" class="form-input"
                        value="{{ old('phone') ?? $student->phone }}" id="phone" placeholder="0771231234" phone="phone"
                        maxlength="15" size="15">
                    <p id="phone-helper" class="form-input-help">Adding a phone number will help others to contact you
                    </p>
                </div>

                <div class="mb-3">
                    <label for="profile_link" class="form-label">Linkedin Profile</label>
                    <input aria-describedby="profile_link-helper" type="url" class="form-input"
                        value="{{ old('profile_link') ?? $student->profile_link }}"
                        placeholder="https://www.linkedin.com/in/myusername/" id="profile_link"
                        profile_link="profile_link">
                    <p id="profile_link-helper" class="form-input-help">Enter your linkedin profile link</p>
                </div>

                <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">

                <div class="flex items-center mb-3">
                    <input id="graduated-checkbox" name="graduated-checkbox" type="checkbox" value="1"
                        class="form-check" {{ $student->graduated ? 'checked' : '' }}>
                    <label for="graduated-checkbox" class="form-check-label">I graduated</label>
                </div>

                <div class="p-4 mb-4 text-xs text-blue-800 border border-blue-500 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                    role="alert">
                    <span class="font-semibold">Note!</span>
                    Once you indicate that you have "graduated," your profile will no longer be visible in the student
                    section. Additionally, your advisor will not receive notifications to schedule regular meetings with
                    you.
                </div>

                <div class="flex items-center mb-3">
                    <input id="job_seeker-checkbox" name="job_seeker-checkbox" type="checkbox" value="1"
                        class="form-check" {{ $student->job_seeker ? 'checked' : '' }} {{ $student->graduated &&
                    !is_null($student->cv)
                    ? '' : 'disabled' }}>
                    <label for="job_seeker-checkbox" class="form-check-label">I am a Job Seeker</label>
                </div>

                <div class="p-4 mb-4 text-xs text-blue-800 border border-blue-500 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                    role="alert">
                    <span class="font-semibold">Note!</span>
                    After you register as a job seeker, your CV will become visible to potential employers for a period
                    of 30 days. In case you are unable to find a job, you have the option to re-mark your profile as a
                    job seeker. You need to upload a CV and mark as a "graduated" first to check this box.
                </div>

                <div class="mb-3">
                    <label for="current_working" class="form-label">Current Working Company</label>
                    <input aria-describedby="current_working-helper" type="text" class="form-input"
                        value="{{ old('current_working') ?? $student->current_working }}" id="current_working"
                        placeholder="My position at My company" current_working="current_working" {{ $student->graduated
                    ? '' : 'disabled' }}>
                    <p id="current_working-helper" class="form-input-help">You can add your working place if marked as
                        graduated</p>
                </div>


                {{-- <div class="mb-3">
                    <label for="technicalstaff" class="form-label">Assign a technical staff
                        member</label>
                    <select id="technicalstaff" class="form-input" name="technicalstaff" required>
                        <option value="{{ null }}" selected>-- Select a user --</option>
                        @foreach ($technicalstaffs as $technicalstaff)
                        <option value="{{ $technicalstaff['id'] }}">{{ $technicalstaff['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div> --}}

                {{-- <div class="mb-3">
                    <label for="academicstaff" class="form-label">Assign a permanent staff
                        member (optional)</label>
                    <select id="academicstaff" class="form-input" name="academicstaff">
                        <option value="{{ null }}" selected>-- Select a user --</option>
                        @foreach ($academicstaffs as $academicstaff)
                        <option value="{{ $academicstaff['id'] }}">{{ $academicstaff['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div> --}}


                @include('components.submit-button', [
                'button' => 'Save Information',
                'icon' => 'bi-save',
                'cancel' => false,
                ])

            </form>

            @endif

            @if ($project_auth ?? false)
            Project page
            @endif

            @if ($research_auth ?? false)
            Reseach page
            @endif

            @if ($document_auth ?? false)
            document page
            @endif

        </div>
    </div>


</div>

@endsection