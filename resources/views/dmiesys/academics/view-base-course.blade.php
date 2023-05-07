@extends('layouts.dmiesys.app')

@section('title', '| View Base Course')
@section('back_page', 'Go back to View Base Course')
@section('back_link') {{ route('base-course.index') }} @endsection

@section('content')

<div class="screen">

    <p class="font-medium text-3xl dark:text-white mt-3 mb-4">
        {{ $basecourse->course_code . ' | ' . $basecourse->course_name }}
    </p>

    <p class="text-xl dark:text-white mt-3 mb-4">Credit : <b>{{ $basecourse->credit }}</b>,
        Type : <b>
            @if ($basecourse->genre == 'cc')
            Core course
            @else
            Technical course
            @endif
        </b></p>

    <table class="min-w-full">
        <thead class="bg-gray-50 dark:bg-gray-700" style="vertical-align: middle">
            <tr>
                <th class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"
                    colspan="3">Assessment Description</th>
                <th class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"
                    style="width: 7%">Total weight</th>
                @for ($i = 1; $i <= $basecourse->total_los; $i++)
                    <th class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"
                        style="width: 5%">LO{{ $i }}</th>
                    @endfor
                    <th class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"
                        style="width: 7%">Marks Breakdown</th>
            </tr>
        </thead>
        <tbody>
            @include('components.course-details-row', ['components' => $assignments, 'name' => 'assignment'])
            @include('components.course-details-row', ['components' => $tutorials, 'name' => 'tutorial'])
            @include('components.course-details-row', ['components' => $quizzes, 'name' => 'quiz'])
            @include('components.course-details-row', ['components' => $practicals, 'name' => 'practical'])
            @include('components.course-details-row', ['components' => $midquestions, 'name' => 'midquestion',
            'itemname' =>
            'Mid Question'])
            @include('components.course-details-row', ['components' => $endquestions, 'name' => 'endquestion',
            'itemname' =>
            'End Question'])

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white" colspan="4">
                    Total</td>
                @php
                $iolsum = 0;
                @endphp
                @for ($i = 1; $i <= $basecourse->total_los; $i++)
                    <th class="text-center dark:text-white font-semibold" style="width: 5%">
                        {{ $basecourse['lo_' . $i] }}
                        @php
                        $iolsum += $basecourse['lo_' . $i];
                        @endphp
                    </th>
                    @endfor
                    <td class="text-center dark:text-white font-semibold">
                        {{ $iolsum }}
                    </td>
            </tr>

        </tbody>
    </table>

</div>

@endsection