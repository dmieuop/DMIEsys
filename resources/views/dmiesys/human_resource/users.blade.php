@extends('layouts.dmiesys.app')

@section('title', '| Manage Users')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection


@section('content')

<div class="screen">

    @include('components.premission-indicator', [
    'page' => 'Add/ Edit Users',
    ])

    @can('add user')
    <div class="grid grid-cols-2">
        <div>
            <p class="fw-500 text-2xl dark:text-white">
                Add a new user to the system
            </p>
            <p class="dark:text-gray-300">
                Once you add them to the system, they will get an email with the instructions. Their accounts will be
                activated once they log in.
            </p>
        </div>
        <div class="col-md-7">

            @livewire('add-new-user')

        </div>
    </div>
    @endcan

    @can('change user role')
    <div class="grid grid-cols-2">
        <div>
            <p class="fw-500 text-2xl dark:text-white">
                Change user role
            </p>
            <p class="dark:text-gray-300">
                You can change the role of some users. They'll get notified once modifications are made.
            </p>
        </div>
        <div class="col-md-7">

            @livewire('update-user-role')

        </div>
    </div>
    @endcan

    @role('Head of the Department')
    <div class="grid grid-cols-2">
        <div>
            <p class="fw-500 text-2xl dark:text-white">
                Assign a new HoD
            </p>
            <p class="dark:text-gray-300">
                Once you assign a new head, You will lose the all access
                privileges only the HoD has. <br><strong class="text-red-600 dark:text-red-500">(You can't undo this
                    oparation)</strong>
            </p>
        </div>
        <div class="col-md-7">

            @livewire('assign-new-hod')

        </div>
    </div>
    @endrole

    @can('deactivate user')
    {{-- <div class="grid grid-cols-2">
        <div>
            <p class="fs-4 text-danger fw-500">
                Remove users
            </p>
            <p class="text-danger fw-500">
                <strong>Note: </strong> You can't undo this oparation.
            </p>
        </div>
        <div class="col-md-7">

            <div class="card rounded-2xl">
                <div class="card-body p-4 pb-0">

                    <div class="mb-5">
                        <span class="fw-bold text-purple-600">Lectures</span>
                        <hr>
                        @foreach ($users as $user)
                        @if ($user->hasAnyRole(['Professor', 'Senior Lecturer', 'Lecturer', 'Contract Basis Lecturer',
                        'Probationary Lecturer', 'Visiting Lecture', 'Temporary Lecturer']))
                        <form action="{{ route('user-profile.destroy', $user->id) }}" method="post">
                            @csrf @honeypot
                            @method('delete')
                            <div class="row">
                                <div class="col-8 pt-4">
                                    {{ $user->title }} {{ $user->name }}
                                </div>
                                <div class="col-4">
                                    @include('components.submit-button', [
                                    'button' => 'Delete',
                                    'cancel' => false,
                                    'color' => 'btn-red',
                                    'icon' => 'bi-trash',
                                    'loop' => $user->id,
                                    ])
                                </div>
                            </div>
                        </form>
                        @endif
                        @endforeach
                    </div>

                    <div class="mb-5">
                        <span class="fw-bold text-purple-600">Instructors</span>
                        <hr>
                        @foreach ($users as $user)
                        @if ($user->hasAnyRole(['Temporary Instructor', 'Instructor']))
                        <form action="{{ route('user-profile.destroy', $user->id) }}" method="post">
                            @csrf @honeypot
                            @method('delete')
                            <div class="row">
                                <div class="col-8 pt-4">
                                    {{ $user->title }} {{ $user->name }}
                                </div>
                                <div class="col-4">
                                    @include('components.submit-button', [
                                    'button' => 'Delete',
                                    'cancel' => false,
                                    'color' => 'btn-red',
                                    'icon' => 'bi-trash',
                                    'loop' => $user->id,
                                    ])
                                </div>
                            </div>
                        </form>
                        @endif
                        @endforeach
                    </div>

                    <div class="mb-5">
                        <span class="fw-bold text-purple-600">Research Assistants</span>
                        <hr>
                        @foreach ($users as $user)
                        @if ($user->hasRole('Research Assistant') == 6)
                        <form action="{{ route('user-profile.destroy', $user->id) }}" method="post">
                            @csrf @honeypot
                            @method('delete')
                            <div class="row">
                                <div class="col-8 pt-4">
                                    {{ $user->title }} {{ $user->name }}
                                </div>
                                <div class="col-4">
                                    @include('components.submit-button', [
                                    'button' => 'Delete',
                                    'cancel' => false,
                                    'color' => 'btn-red',
                                    'icon' => 'bi-trash',
                                    'loop' => $user->id,
                                    ])
                                </div>
                            </div>
                        </form>
                        @endif
                        @endforeach
                    </div>

                    <div class="mb-5">
                        <span class="fw-bold text-purple-600">Technical Operator</span>
                        <hr>
                        @foreach ($users as $user)
                        @if ($user->hasAnyRole(['Technical Officer', 'Instrument Mechanic', 'Machine Operator']) == 7)
                        <form action="{{ route('user-profile.destroy', $user->id) }}" method="post">
                            @csrf @honeypot
                            @method('delete')
                            <div class="row">
                                <div class="col-8 pt-4">
                                    {{ $user->title }} {{ $user->name }}
                                </div>
                                <div class="col-4">
                                    @include('components.submit-button', [
                                    'button' => 'Delete',
                                    'cancel' => false,
                                    'color' => 'btn-red',
                                    'icon' => 'bi-trash',
                                    'loop' => $user->id,
                                    ])
                                </div>
                            </div>
                        </form>
                        @endif
                        @endforeach
                    </div>

                    <div class="mb-5">
                        <span class="fw-bold text-purple-600">Management Assistants & PG Admins</span>
                        <hr>
                        @foreach ($users as $user)
                        @if ($user->hasAnyRole(['Management Assistant (DMIE)', 'Management Assistant (PG)']))
                        <form action="{{ route('user-profile.destroy', $user->id) }}" method="post">
                            @csrf @honeypot
                            @method('delete')
                            <div class="row">
                                <div class="col-8 pt-4">
                                    {{ $user->title }} {{ $user->name }}
                                </div>
                                <div class="col-4">
                                    @include('components.submit-button', [
                                    'button' => 'Delete',
                                    'cancel' => false,
                                    'color' => 'btn-red',
                                    'icon' => 'bi-trash',
                                    ])
                                </div>
                            </div>
                        </form>
                        @endif
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div> --}}
    @endcan

</div>

@endsection