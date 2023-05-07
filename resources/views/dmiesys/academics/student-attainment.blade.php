@extends('layouts.dmiesys.app')

@section('title', '| Student Attainment')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection


{{-- @push('styles')
<link rel="stylesheet" href="{{ asset('src/css/menu.css') }}">
@endpush --}}

@section('content')

<div class="screen">

    @include('components.premission-indicator', [
    'page' => 'Student Attainment',
    ])

    <div class="grid lg:grid-cols-2 lg:gap-x-20 xl:gap-x-32">
        <div class="menu-area d-flex flex-column">

            @can('see attainment report')
            <a href="{{ route('student-report.index') }}" style="text-decoration: none;">
                <div class="menu-card @if ($student_attainment_auth ?? false) active-menu @endif">
                    <i class="bi bi-mortarboard text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Student attainment report</span>
                </div>
            </a>
            @endcan

            @can('see ilo achievement')
            <a href="{{ route('course-report.index') }}" style="text-decoration: none;">
                <div class="menu-card @if ($course_ilo_auth ?? false) active-menu @endif">
                    <i class="bi bi-file-bar-graph text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Course ILO achievement</span>
                </div>
            </a>
            @endcan

        </div>
        <div>

            @include('components.error-message')

            @if ($student_attainment_auth ?? false)
            @livewire('student-report-selection')
            @endif

            @if ($course_ilo_auth ?? false)
            @livewire('course-report-selection')
            @endif



        </div>
    </div>


</div>

@endsection


@push('scripts')
{{-- <script src="{{ asset('src/js/student.attainment.js') }}"></script> --}}
@endpush