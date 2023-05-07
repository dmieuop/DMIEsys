@extends('layouts.dmiesys.app')

@section('title', '| Settings')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection


@section('content')

<div class="screen">

    @include('components.premission-indicator', [
    'page' => 'DMIEsys Settings',
    ])

    @include('components.error-message')


    @can('set pg registration')
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md dark:shadow-gray-900/80 mb-5">

        <p class="text-2xl font-semibold dark:text-white text-center">Postgraduate Programme Settings</p>


        <form action="{{ route('settings.update', 'pg-intake-year') }}" method="post">
            @csrf @honeypot
            @method('patch')
            <div class="flex justify-between items-center">
                <div class="mb-3">
                    <label for="pg-intake-year" class="form-label">Postgraduate Programme Intake
                        Year</label>
                    <select class="form-select" name="value" aria-label="Default select example" required>
                        @foreach ($years as $year)
                        <option @if ($pg_intake_year==$year) selected @endif value="{{ $year }}">
                            {{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button class="btn btn-green">
                        <i class="bi bi-save2"></i> Save
                    </button>
                </div>
            </div>
        </form>

        <form action="{{ route('settings.update', 'pg-application-open-date') }}" method="post">
            @csrf @honeypot
            @method('patch')
            <div class="flex justify-between items-center">
                <div class="mb-3">
                    <label for="pg-application-open-date" class="form-label">Postgraduate Programme
                        Open Date</label>
                    <input type="date" class="form-input" name="value" id="pg-application-open-date"
                        value="{{ $pg_application_open_date }}" required>
                </div>
                <div>
                    <button class="btn btn-green">
                        <i class="bi bi-save2"></i> Save
                    </button>
                </div>
            </div>
        </form>

        <form action="{{ route('settings.update', 'pg-application-close-date') }}" method="post">
            @csrf @honeypot
            @method('patch')
            <div class="flex justify-between items-center">
                <div class="mb-3">
                    <label for="pg-application-close-date" class="form-label">Postgraduate Programme
                        Close Date</label>
                    <input type="date" class="form-input" name="value" id="pg-application-close-date"
                        value="{{ $pg_application_close_date }}" required>
                </div>
                <div>
                    <button class="btn btn-green">
                        <i class="bi bi-save2"></i> Save
                    </button>
                </div>
            </div>
        </form>

        <form action="{{ route('settings.update', 'pg-emgt-offer') }}" method="post">
            @csrf @honeypot
            @method('patch')
            <div class="flex justify-between items-center">
                <div class="mb-3">
                    <label for="pg-emgt-offer" class="form-label">Engineering Management is
                        offered?</label>
                    <select class="form-select" name="bool" aria-label="Default select example" required>
                        <option @if ($pg_emgt_offer) selected @endif value="{{ 1 }}">Yes
                        </option>
                        <option @if (!$pg_emgt_offer) selected @endif value="{{ 0 }}">No
                        </option>
                    </select>
                </div>
                <div>
                    <button class="btn btn-green">
                        <i class="bi bi-save2"></i> Save
                    </button>
                </div>
            </div>
        </form>

        <form action="{{ route('settings.update', 'pg-meng-offer') }}" method="post">
            @csrf @honeypot
            @method('patch')
            <div class="flex justify-between items-center">
                <div class="mb-3">
                    <label for="pg-meng-offer" class="form-label">Manufacturing Engineering is
                        offered?</label>
                    <select class="form-select" name="bool" aria-label="Default select example" required>
                        <option @if ($pg_meng_offer) selected @endif value="{{ 1 }}">Yes
                        </option>
                        <option @if (!$pg_meng_offer) selected @endif value="{{ 0 }}">No
                        </option>
                    </select>
                </div>
                <div>
                    <button class="btn btn-green">
                        <i class="bi bi-save2"></i> Save
                    </button>
                </div>
            </div>
        </form>

    </div>
    @endcan


</div>

@endsection

{{-- @push('scripts')
<script src="{{ asset('src/js/manage.courses.js') }}"></script>
@endpush --}}