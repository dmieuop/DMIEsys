@extends('layouts.dmiesys.app')

@section('title', '| Manage Machines')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection


{{-- @push('styles')
<link rel="stylesheet" href="{{ asset('src/css/menu.css') }}">
@endpush --}}

@section('content')

<div class="screen">

    @include('components.premission-indicator', [
    'page' => 'Manage Machines',
    ])

    <div class="grid lg:grid-cols-2 lg:gap-x-20 xl:gap-x-32">
        <div class="menu-area d-flex flex-column">

            @can('add machine')
            <a href="{{ route('machines.create') }}" style="text-decoration: none;">
                <div class="menu-card @if ($add_machine_auth ?? false) active-menu @endif">
                    <i class="bi bi-laptop text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Add a new Machine</span>
                </div>
            </a>
            @endcan

            @can('add maintenance')
            <a href="{{ route('maintenance-schedule.create') }}" style="text-decoration: none;">
                <div class="menu-card @if ($upload_maintenance_schedule_auth ?? false) active-menu @endif">
                    <i class="bi bi-cloud-upload text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Upload a maintenance schedule</span>
                </div>
            </a>
            @endcan

            @can('update maintenance')
            <a href="{{ route('maintenance-record.index') }}" style="text-decoration: none;">
                <div class="menu-card @if ($update_maintenance_records_auth ?? false) active-menu @endif">
                    <i class="bi bi-clipboard-check text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Update maintenance records</span>
                </div>
            </a>
            @endcan

        </div>

        <div>

            @include('components.error-message')

            @if ($add_machine_auth ?? false)

            <form method="POST" onsubmit="submitFunction()" action="{{ route('machines.store') }}">
                @csrf @honeypot

                <div class="mb-3">
                    <label for="name" class="form-label">Name of the Machine</label>
                    <input type="text" class="form-input" value="{{ old('name') }}" id="name" name="name"
                        maxlength="100" size="100" required>
                </div>

                <div class="mb-3">
                    <label for="model" class="form-label">Model</label>
                    <input type="text" class="form-input" value="{{ old('model') }}" id="model" name="model"
                        maxlength="50" size="50" required>
                </div>

                <div class="mb-3">
                    <label for="brand" class="form-label">Brand name (optional)</label>
                    <input type="text" class="form-input" value="{{ old('brand') }}" id="brand" name="brand"
                        maxlength="50" size="50">
                </div>

                <div class="mb-3">
                    <label for="mfcountry" class="form-label">Manufactured Country
                        (optional)</label>
                    <input type="text" class="form-input" value="{{ old('mfcountry') }}" id="mfcountry" name="mfcountry"
                        maxlength="50" size="50">
                </div>

                <div class="mb-3">
                    <label for="year_of_made" class="form-label">Manufactured Year</label>
                    <input type="text" class="form-input" value="{{ old('year_of_made') }}" id="year_of_made"
                        name="year_of_made" maxlength="4" size="4" required>
                </div>

                <div class="mb-3">
                    <label for="date_of_purchased" class="form-label">Date of purchased</label>
                    <input type="date" class="form-input" value="{{ old('date_of_purchased') }}" id="date_of_purchased"
                        name="date_of_purchased" required>
                </div>

                <div class="mb-3">
                    <label for="lab_id" class="form-label">Belongs to the Lab</label>
                    <select id="lab_id" class="form-select" name="lab_id">
                        <option value="{{ null }}" selected>Belongs to no lab</option>
                        @foreach ($labs as $lab)
                        <option value="{{ $lab['id'] }}">{{ $lab['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="power_consumption" class="form-label">Power consumption in watts
                        (optional)</label>
                    <input type="number" class="form-input" value="{{ old('power_consumption') }}" max="1000000"
                        id="power_consumption" name="power_consumption">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description (optional)</label>
                    <textarea name="description" class="form-textarea" id="description"
                        rows="6">{{ old('description') }}</textarea>
                </div>



                @include('components.submit-button', [
                'button' => 'Add a Machine',
                'icon' => 'bi-plus-circle',
                'cancel' => false,
                ])

            </form>

            @endif


            @if ($upload_maintenance_schedule_auth ?? false)

            <form action="{{ route('maintenance-schedule.store') }}" onsubmit="submitFunction()"
                enctype="multipart/form-data" method="post">
                @csrf @honeypot

                <div class="mb-3">
                    <label for="machine_id" class="form-label">Select a machine</label>
                    <select id="machine_id" class="form-select" name="machine_id" required>
                        <option value="{{ null }}" selected>-- Select --</option>
                        @foreach ($machines as $machine)
                        <option value="{{ $machine['id'] }}">{{ $machine['brand'] }}
                            {{ $machine['name'] }}
                            {{ $machine['model'] }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3">
                    <label for="user_id" class="form-label">Responsible a Technical Staff
                        member</label>
                    <select id="user_id" class="form-select" name="user_id" required>
                        <option value="{{ null }}" selected>-- Select --</option>
                        @foreach ($tos as $to)
                        <option value="{{ $to['id'] }}">{{ $to['title'] }} {{ $to['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="starting_date" class="form-label">Schedule starting date</label>
                    <input type="date" class="form-select" value="{{ old('starting_date') }}" name="starting_date"
                        required>
                </div>

                <div class="mb-3">
                    <label for="maintenance-schedule" class="form-label">Select the file</label>
                    <input class="form-upload"
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                        name="maintenance-schedule" type="file" id="maintenance-schedule" required>
                </div>

                @include('components.submit-button', [
                'button' => 'Upload',
                'cancel' => false,
                'icon' => 'bi-cloud-upload-fill',
                ])


            </form>

            <div class="p-4 pb-3 mb-4 mt-3 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800"
                role="alert">
                Please use the provided format for Maintenance Schedule.
                <a target="_blank" href="{{ asset('storage/downloads/Maintenance Schedule for Machines -v1.0.xlsx') }}"
                    class="block mt-2 btn-sm rounded-full btn-gray">Download Maintenance
                    Schedule template</a>
            </div>


            @endif

            @if ($update_maintenance_records_auth ?? false)

            {{ $today_list->links() }}

            @forelse ($today_list as $task)

            <form method="POST" onsubmit="submitFunction()"
                action="{{ route('maintenance-record.update', $task->id) }}">
                @method('patch')
                @csrf @honeypot

                <div class="mb-3">
                    <label for="machine" class="form-label">Machine name</label>
                    <input class="form-input" id="machine"
                        value="{{ $task->hasMachine['brand']  . ' ' . $task->hasMachine['model'] . ' ' . $task->hasMachine['name'] }} }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label for="task" class="form-label">Task</label>
                    <textarea class="form-textarea" id="task" rows="3" readonly>{{ $task->hasTask['task'] }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="table_ref" class="form-label">Table reference</label>
                    <input class="form-input" id="table_ref" value="{{ $task->hasTask['table_ref_no'] }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="comments" class="form-label">Comments (optional)</label>
                    <textarea name="comments" class="form-textarea" id="comments" rows="6"
                        placeholder="Anything special to say?">{{ old('comments') }}</textarea>
                </div>

                @include('components.submit-button', [
                'button' => 'Mark as complete',
                'cancel' => false,
                'icon' => 'bi-check2-circle',
                ])

            </form>

            @empty

            <p class="dark:text-gray-400 italic">
                (You have no more maintenance tasks to complete today)
            </p>

            @endforelse


            @endif



        </div>
    </div>

</div>

@endsection

{{-- @push('scripts')
<script src="{{ asset('src/js/manage.courses.js') }}"></script>
@endpush --}}