@extends('layouts.dmiesys.app')

@section('title', '| Manage Courses')
@section('back_page', 'Go back to View Course')
@section('back_link') {{ route('course.index') }} @endsection


@section('content')

<div class="screen pt-4">

    <div class="flex flex-col mb-3">
        <div class="overflow-x-auto shadow-md dark:shadow-gray-900/80 sm:rounded-lg">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden ">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                        <thead class="bg-gray-200 dark:bg-gray-700">
                            <tr>
                                <th class="h4 ps-3 p-2" colspan="2">Course Details</th>
                            </tr>
                        </thead>
                        <tbody class="table-seconadry bg-white dark:bg-gray-800">
                            <tr>
                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    style="width:20%">Course ID</td>
                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    colspan="3">{{ $course->course_id }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Course Name</td>
                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    colspan="3">{{ $course->course_name }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Year</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $course->year }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Semester</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Semester {{ $course->semester }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Category</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @if ($genre == 'cc')
                                    Core Course
                                    @elseif($genre == 'tc')
                                    Technical Course
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Credits</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $credit }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Batch</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $course->batch }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Period</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $course->period }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Coordinator</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $course->coordinator }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Moderator</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $course->moderator }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Second Examiner</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $course->secondexaminer }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Instructor in-charge</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $course->instructorincharge }}</td>
                            </tr>
                            @if ($course->status == 'Ongoing')
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Status</td>
                                <td
                                    class="py-4 px-6 text-sm font-semibold whitespace-nowrap dark:text-white text-green-600">
                                    {{ $course->status }}</td>
                            </tr>
                            @elseif($course->status == 'Complete')
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Status</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium whitespace-nowrap dark:text-white text-red-600">
                                    {{ $course->status }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Marks Updated on</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $course->updated_at->toDateString() }}</td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold" colspan="2">Marks Breakdown</td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Assignments</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @if ($course->assignmentweight)
                                    {{ $course->assignmentweight }}%
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Tutorials</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @if ($course->tutorialweight)
                                    {{ $course->tutorialweight }}%
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Quizzes</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @if ($course->quizweight)
                                    {{ $course->quizweight }}%
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Practicals</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @if ($course->practicalweight)
                                    {{ $course->practicalweight }}%
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Mid Exam</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @if ($course->midexamweight)
                                    {{ $course->midexamweight }}%
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    End Exam</td>
                                <td
                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @if ($course->endexamweight)
                                    {{ $course->endexamweight }}%
                                    @endif
                                </td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('base-course.show', $course->course_code) }}">
        <button class="btn btn-green" type="submit">View COBA plan of
            {{ $course->course_code }}</button>
    </form>


</div>

@endsection