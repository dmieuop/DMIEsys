@extends('layouts.dmiesys.app')

@section('title', '| Course ILO archivement')
@section('back_page', 'Go back to Course ILO archivement')
@section('back_link') {{ route('course-report.index') }} @endsection


@push('styles')
<style>
    .bg-red {
        background-color: #e4ccce !important;
    }

    .bg-green {
        background-color: #afdfc9 !important;
    }
</style>
@endpush

@section('content')

<div class="screen pt-4">

    <div class="p-4 mb-4 pl-5 text-3xl font-semibold text-white bg-gradient-to-r from-indigo-600 to-green-500 rounded-lg dark:bg-blue-200"
        role="alert">
        Course Details
    </div>

    <div class="bg-white dark:bg-gray-700 dark:text-white rounded-xl p-3 px-4 shadow-md dark:shadow-gray-900/80 mb-3">
        <table class="table-auto w-full border-collapse border border-blue-800 dark:border-gray-400">
            <tbody>
                <tr>
                    <td class="font-semibold pl-3 dark:border-gray-400 border border-blue-600">Course ID</td>
                    <td class="pl-3 border dark:border-gray-400 border-blue-600" colspan="3">{{ $course->course_id }}
                    </td>
                </tr>
                <tr>
                    <td class="font-semibold pl-3 dark:border-gray-400 border border-blue-600">Course Name</td>
                    <td class="pl-3 border dark:border-gray-400 border-blue-600" colspan="3">{{ $course->course_name }}
                    </td>
                </tr>
                <tr>
                    <td class="font-semibold pl-3 dark:border-gray-400 border border-blue-600">Year</td>
                    <td class="pl-3 border dark:border-gray-400 border-blue-600">{{ $course->year }}</td>
                    <td class="font-semibold pl-3 dark:border-gray-400 border border-blue-600">Coordinator</td>
                    <td class="pl-3 border dark:border-gray-400 border-blue-600">{{ $course->coordinator }}</td>
                </tr>
                <tr>
                    <td class="font-semibold pl-3 dark:border-gray-400 border border-blue-600">Semester</td>
                    <td class="pl-3 border dark:border-gray-400 border-blue-600">{{ $course->semester }}</td>
                    <td class="font-semibold pl-3 dark:border-gray-400 border border-blue-600">Moderator</td>
                    <td class="pl-3 border dark:border-gray-400 border-blue-600">{{ $course->moderator }}</td>
                </tr>
                <tr>
                    <td class="font-semibold pl-3 dark:border-gray-400 border border-blue-600">Batch</td>
                    <td class="pl-3 border dark:border-gray-400 border-blue-600">{{ $course->batch }}</td>
                    <td class="font-semibold pl-3 dark:border-gray-400 border border-blue-600">Second Examiner</td>
                    <td class="pl-3 border dark:border-gray-400 border-blue-600">{{ $course->secondexaminer }}</td>
                </tr>
                <tr>
                    <td class="font-semibold pl-3 dark:border-gray-400 border border-blue-600">Period</td>
                    <td class="pl-3 border dark:border-gray-400 border-blue-600">{{ $course->period }}</td>
                    <td class="font-semibold pl-3 dark:border-gray-400 border border-blue-600">Instructor in-charge</td>
                    <td class="pl-3 border dark:border-gray-400 border-blue-600">{{ $course->instructorincharge }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-x-3 gap-y-3 mb-5">
        <div class="lg:col-span-7">
            <div
                class="bg-white dark:bg-gray-700 dark:text-gray-400 rounded-xl p-3 pb-3 px-2 shadow-md dark:shadow-gray-900/80 h-100">
                <div>
                    <canvas id="lochart" width="auto" height="100rem"></canvas>
                </div>
                <div class="mr-2 mt-1 text-right">
                    <span style="cursor: pointer" id="areabtn" onclick="changetype('area')"
                        class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-500 dark:text-black">Area</span>
                    <span style="cursor: pointer" id="barbtn" onclick="changetype('bar')"
                        class="bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-800 dark:text-gray-300">Bar</span>
                    <span style="cursor: pointer" id="linebtn" onclick="changetype('line')"
                        class="bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-800 dark:text-gray-300">Line</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5">
            <div
                class="bg-white dark:bg-gray-700 dark:text-gray-400 rounded-xl flex px-5 shadow-md dark:shadow-gray-900/80 h-full">
                <table class="w-100 mt-3 mx-auto">
                    <tbody class="fw-500">
                        <tr>
                            <td class="pr-3" style="width:18%" rowspan="4">
                                <div style="width: 15rem">
                                    <canvas id="mapchart" width="auto" height="auto"></canvas>
                                </div>
                            </td>
                            <td>Max. Mark</td>
                            <td class="text-right">{{ $maxmark }}%</td>
                        </tr>
                        <tr>
                            <td>Min. Mark</td>
                            <td class="text-right">{{ $minmark }}%</td>
                        </tr>
                        <tr>
                            <td>Number of Students</td>
                            <td class="text-right">{{ count($studentmarks) }}</td>
                        </tr>
                        <tr>
                            <td>Average Mark</td>
                            <td class="text-right">{{ $avgmark }}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div
        class="p-4 mb-4 pl-5 text-3xl font-semibold text-white bg-gradient-to-r from-pink-600 to-blue-500 rounded-xl shadow-md dark:shadow-gray-900/80">
        ILO Achievement
    </div>


    <div class="relative overflow-x-auto shadow-md dark:shadow-gray-900/80 sm:rounded-xl">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-lg">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 text-lg">
                        Student ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-lg">
                        Name
                    </th>
                    @for ($i = 1; $i <= $basecourse->total_los; $i++)
                        <th scope="col" class="px-6 py-3"><b class="text-lg">LO{{ $i }}</b>/{{ $basecourse['lo_' . $i]
                            }}</th>
                        @endfor
                        <th scope="col" class="px-6 py-3 text-lg">
                            Total
                        </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($studentmarks as $studentmark)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        {{ $loop->iteration }}
                    </th>
                    <td class="px-6 py-4 font-semibold">
                        <a style="text-decoration:none; target=" _blank"
                            href="{{ route('student-report.show', $studentmark['student_id']) }}">{{
                            $studentmark['student_id'] }}</a>
                    </td>
                    <td class="px-6 py-4">
                        {{ $studentmark['name'] }}
                    </td>
                    @for ($i = 1; $i <= $basecourse->total_los; $i++)
                        <td
                            class="px-6 py-4 text-center @if ($studentmark['lo' . $i] * 2 >= $basecourse['lo_' . $i]) dark:bg-green-500 dark:text-black bg-green-200 text-green-700 @else dark:bg-red-400 dark:text-black bg-red-200 text-red-700 @endif">
                            {{ $studentmark['lo' . $i] }}
                        </td>
                        @endfor
                        <td
                            class="px-6 py-4 text-right font-semibold @if ($studentmark['total'] < 50) text-red-500 @endif">
                            {{ $studentmark['total'] }} %
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.4.0/dist/chart.min.js"></script>
<script type="text/javascript">
    var allmarks = <?php echo json_encode($allmarks); ?>;
        var lomap = <?php echo json_encode($lomap); ?>;
        var lomaplbl = <?php echo json_encode($lomaplbl); ?>;
</script>
<script src="{{ asset('src/js/coursemarksgraph.js') }}"></script>
@endpush