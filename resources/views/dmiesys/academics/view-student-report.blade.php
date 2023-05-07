@extends('layouts.dmiesys.app')

@section('title', '| Course ILO archivement')
@section('back_page', 'Go back to Course ILO archivement')
@section('back_link') {{ route('student-report.index') }} @endsection


@push('styles')
<link rel="stylesheet" href="{{ asset('src/css/viewstudentreport.css') }}">
@endpush

@section('content')

<div class="screen pt-4">

    <div
        class="p-4 mb-4 pl-5 text-3xl font-semibold text-white bg-gradient-to-r from-pink-600 to-blue-500 rounded-xl shadow-md dark:shadow-gray-900/80">
        Student Details
    </div>

    <div class="bg-white dark:bg-gray-800 dark:text-white rounded-xl p-3 px-4 shadow-md dark:shadow-gray-900/80 mb-3">
        <table class="table-auto w-full border-collapse border border-blue-800 dark:border-gray-400">
            <tbody>
                <tr>
                    <td class="dark:border-gray-400 font-semibold pl-3 border border-blue-600">Student ID</td>
                    <td class="dark:border-gray-400 pl-3 border border-blue-600" colspan="3">
                        {{ $studentdetails->student_id }}</td>
                </tr>
                <tr>
                    <td class="dark:border-gray-400 font-semibold pl-3 border border-blue-600">Name</td>
                    <td class="dark:border-gray-400 pl-3 border border-blue-600" colspan="3">
                        {{ $studentdetails->name }}</td>
                </tr>
                <tr>
                    <td class="dark:border-gray-400 font-semibold pl-3 border border-blue-600">Batch</td>
                    <td class="dark:border-gray-400 pl-3 border border-blue-600" colspan="3">
                        {{ $studentdetails->batch }}</td>
                </tr>
                <tr>
                    <td class="dark:border-gray-400 font-semibold pl-3 border border-blue-600">Email</td>
                    <td class="dark:border-gray-400 pl-3 border border-blue-600" colspan="3">
                        {{ $studentdetails->email }}</td>
                </tr>
                <tr>
                    <td class="dark:border-gray-400 font-semibold pl-3 border border-blue-600">Phone</td>
                    <td class="dark:border-gray-400 pl-3 border border-blue-600" colspan="3">
                        {{ $studentdetails->phone }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div
        class="p-4 mb-4 pl-5 text-3xl font-semibold text-white bg-gradient-to-r from-indigo-600 to-green-500 rounded-xl shadow-md dark:shadow-gray-900/80">
        Summary Report
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 lg:gap-x-5">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-3 pb-1 px-4 mb-3 shadow-md dark:shadow-gray-900/80">
            <p class="text-center dark:text-white font-semibold mb-0 fs-5">Core Course</p>
            <div class="flex">
                <div class="roundProgressBar mx-auto">
                    <div
                        class="outer @if ($summary['angle_cc'] == 180) bg-lsuccess @elseif($summary['angle_cc'] >= 135) bg-lprimary @elseif($summary['angle_cc'] >= 90) bg-lwarning @else bg-ldanger @endif">
                        <div class="text">
                            <b>Courses</b>
                            <br>
                            {{ $summary['passed_cc'] }}/{{ $summary['total_cc'] }}
                            <br>
                            ({{ (int) (($summary['angle_cc'] * 100) / 180) }}%)
                        </div>
                    </div>
                    <svg style="stroke-dashoffset: {{ 480 - ($summary['angle_cc'] * 480) / 180 }}; stroke:@if ($summary['angle_cc'] == 180) forestgreen @elseif($summary['angle_cc'] >= 135) dodgerblue @elseif($summary['angle_cc'] >= 90) gold @else crimson @endif"
                        xmlns="http://www.w3.org/2000/svg" version="1.1">
                        <circle cx="50%" cy="50%" r="77" stroke-linecap="round" />
                    </svg>
                </div>
                <div class="roundProgressBar mx-auto">
                    <div
                        class="outer @if ($summary['angle_lo_cc'] == 180) bg-lsuccess @elseif($summary['angle_lo_cc'] >= 135) bg-lprimary @elseif($summary['angle_lo_cc'] >= 90) bg-lwarning @else bg-ldanger @endif">
                        <div class="text">
                            <b>ILOs</b>
                            <br>
                            {{ $summary['passed_lo_cc'] }}/{{ $summary['total_lo_cc'] }}
                            <br>
                            ({{ (int) (($summary['angle_lo_cc'] * 100) / 180) }}%)
                        </div>
                    </div>
                    <svg style="stroke-dashoffset: {{ 480 - ($summary['angle_lo_cc'] * 480) / 180 }}; stroke:@if ($summary['angle_lo_cc'] == 180) forestgreen @elseif($summary['angle_lo_cc'] >= 135) dodgerblue @elseif($summary['angle_lo_cc'] >= 90) gold @else crimson @endif"
                        xmlns="http://www.w3.org/2000/svg" version="1.1">
                        <circle cx="50%" cy="50%" r="77" stroke-linecap="round" />
                    </svg>
                </div>

            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-3 pb-1 px-4 mb-3 shadow-md dark:shadow-gray-900/80">
            <p class="text-center dark:text-white font-semibold mb-0 fs-5">Technical Course</p>
            <div class="flex">
                <div class="roundProgressBar mx-auto">
                    <div
                        class="outer @if ($summary['angle_tc'] == 180) bg-lsuccess @elseif($summary['angle_tc'] >= 135) bg-lprimary @elseif($summary['angle_tc'] >= 90) bg-lwarning @else bg-ldanger @endif">
                        <div class="text">
                            <b>Courses</b>
                            <br>
                            {{ $summary['passed_tc'] }}/{{ $summary['total_tc'] }}
                            <br>
                            ({{ (int) (($summary['angle_tc'] * 100) / 180) }}%)
                        </div>
                    </div>
                    <svg style="stroke-dashoffset: {{ 480 - ($summary['angle_tc'] * 480) / 180 }}; stroke:@if ($summary['angle_tc'] == 180) forestgreen @elseif($summary['angle_tc'] >= 135) dodgerblue @elseif($summary['angle_tc'] >= 90) gold @else crimson @endif"
                        xmlns="http://www.w3.org/2000/svg" version="1.1">
                        <circle cx="50%" cy="50%" r="77" stroke-linecap="round" />
                    </svg>
                </div>
                <div class="roundProgressBar mx-auto">
                    <div
                        class="outer @if ($summary['angle_lo_tc'] == 180) bg-lsuccess @elseif($summary['angle_lo_tc'] >= 135) bg-lprimary @elseif($summary['angle_lo_tc'] >= 90) bg-lwarning @else bg-ldanger @endif">
                        <div class="text">
                            <b>ILOs</b>
                            <br>
                            {{ $summary['passed_lo_tc'] }}/{{ $summary['total_lo_tc'] }}
                            <br>
                            ({{ (int) (($summary['angle_lo_tc'] * 100) / 180) }}%)
                        </div>
                    </div>
                    <svg style="stroke-dashoffset: {{ 480 - ($summary['angle_lo_tc'] * 480) / 180 }}; stroke:@if ($summary['angle_lo_tc'] == 180) forestgreen @elseif($summary['angle_lo_tc'] >= 135) dodgerblue @elseif($summary['angle_lo_tc'] >= 90) gold @else crimson @endif"
                        xmlns="http://www.w3.org/2000/svg" version="1.1">
                        <circle cx="50%" cy="50%" r="77" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-3 pb-1 px-4 mb-3 shadow-md dark:shadow-gray-900/80">
            <p class="text-center dark:text-white font-semibold mb-0 fs-5">All Courses</p>
            <div class="flex">
                <div class="roundProgressBar mx-auto">
                    <div
                        class="outer @if ($summary['angle_c'] == 180) bg-lsuccess @elseif($summary['angle_c'] >= 135) bg-lprimary @elseif($summary['angle_c'] >= 90) bg-lwarning @else bg-ldanger @endif">
                        <div class="text">
                            <b>Courses</b>
                            <br>
                            {{ $summary['passed_c'] }}/{{ $summary['total_c'] }}
                            <br>
                            ({{ (int) (($summary['angle_c'] * 100) / 180) }}%)
                        </div>
                    </div>
                    <svg style="stroke-dashoffset: {{ 480 - ($summary['angle_c'] * 480) / 180 }}; stroke:@if ($summary['angle_c'] == 180) forestgreen @elseif($summary['angle_c'] >= 135) dodgerblue @elseif($summary['angle_c'] >= 90) gold @else crimson @endif"
                        xmlns="http://www.w3.org/2000/svg" version="1.1">
                        <circle cx="50%" cy="50%" r="77" stroke-linecap="round" />
                    </svg>
                </div>
                <div class="roundProgressBar mx-auto">
                    <div
                        class="outer @if ($summary['angle_lo_c'] == 180) bg-lsuccess @elseif($summary['angle_lo_c'] >= 135) bg-lprimary @elseif($summary['angle_lo_c'] >= 90) bg-lwarning @else bg-ldanger @endif">
                        <div class="text">
                            <b>ILOs</b>
                            <br>
                            {{ $summary['passed_lo_c'] }}/{{ $summary['total_lo_c'] }}
                            <br>
                            ({{ (int) (($summary['angle_lo_c'] * 100) / 180) }}%)
                        </div>
                    </div>
                    <svg style="stroke-dashoffset: {{ 480 - ($summary['angle_lo_c'] * 480) / 180 }}; stroke:@if ($summary['angle_lo_c'] == 180) forestgreen @elseif($summary['angle_lo_c'] >= 135) dodgerblue @elseif($summary['angle_lo_c'] >= 90) gold @else crimson @endif"
                        xmlns="http://www.w3.org/2000/svg" version="1.1">
                        <circle cx="50%" cy="50%" r="77" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    @foreach ($coursedetails as $coursedetail)
    <div class="@if ($loop->last) mb-5 @endif">
        <div
            class="bg-white dark:bg-gray-800 dark:text-white rounded-xl p-2 px-4 mb-3 shadow-md dark:shadow-gray-900/80">
            <table class="w-full">
                <tbody>
                    <tr>
                        <td style="width:12%; vertical-align:middle" class="ms-3 font-semibold" rowspan="2">
                            <a target="_blank" style="text-decoration: none;" class="text-black pl-3 dark:text-white"
                                href="{{ route('course-report.show', $coursedetail['course_id']) }}">{{
                                $coursedetail['course_code'] }}</a>
                            <span style="text-transform:uppercase;"
                                class="ml-5 bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-200 dark:text-blue-800">
                                {{ $coursedetail['genre'] }}</span>
                        </td>
                        <td style="width: 5%; vertical-align:middle" class="fw-500">ILOs</td>
                        <td colspan="3">
                            <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                                <div class="h-4 rounded-full @if ($coursedetail['passed_los'] == $coursedetail['total_los']) bg-green-600 dark:bg-green-500 @else bg-red-600 dark:bg-red-500 @endif"
                                    style="width: {{ ($coursedetail['passed_los'] * 100) / $coursedetail['total_los'] }}%">
                                </div>
                            </div>
                        </td>
                        <td style="width: 5%; vertical-align:middle" class="text-right pr-3 fw-500">
                            {{ $coursedetail['passed_los'] }}/{{ $coursedetail['total_los'] }}
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle" class="fw-500">Marks</td>
                        <td colspan="3">

                            <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                                <div class="h-4 rounded-full bg-indigo-600 dark:bg-blue-400"
                                    style="width: {{ $coursedetail['final_mark'] }}%">
                                </div>
                            </div>
                        </td>
                        <td style="vertical-align:middle" class="text-right pr-3 font-semibold">
                            {{ $coursedetail['final_mark'] }}%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

    <div
        class="p-4 mb-4 pl-5 text-3xl font-semibold text-white bg-gradient-to-r from-blue-600 to-red-500 rounded-xl shadow-md dark:shadow-gray-900/80">
        Detail Report (ILOs)
    </div>

    @foreach ($coursedetails as $coursedetail)
    @for ($i = 1; $i <= $coursedetail['total_los']; $i++) <div
        class="bg-white dark:bg-gray-800 dark:text-white rounded-xl p-0 px-3 @if ($i == $coursedetail['total_los']) mb-4 @else mb-2 @endif shadow-md dark:shadow-gray-900/80">
        <table class="w-full">
            <tbody>
                <tr>
                    <td style="width:10%" class="fw-500 pl-3">
                        {{ $coursedetail['course_code'] }}-LO{{ $i }}
                    </td>
                    <td>
                        <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                            <div class="h-4 rounded-full pr-3 text-xs text-right text-white font-semibold @if ($coursedetail['lo_' . $i . '_%'] < 50) bg-red-600 dark:bg-red-500 @else bg-green-600 dark:bg-green-500 @endif"
                                style="width: {{ $coursedetail['lo_' . $i . '_%'] }}%">
                                {{ round($coursedetail['lo_' . $i . '_%'], 1) }}%
                            </div>
                        </div>
                    </td>
                    <td style="width:5%" class="text-right pr-3 fw-500">
                        {{ $coursedetail['lo_' . $i] }}/{{ $coursedetail['lo_' . $i . '_ref'] }}
                    </td>
                </tr>
            </tbody>
        </table>
</div>
@endfor
@endforeach

</div>

@endsection