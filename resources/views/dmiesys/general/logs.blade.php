@extends('layouts.dmiesys.app')

@section('title', '| Logs')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection

@section('content')

<div class="wide-screen">

    <div class="grid grid-cols-1">

        <div class="mt-3">

            <p class="text-3xl font-semibold dark:text-white mb-3">Request log</p>

            {{ $logs->links() }}

            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow-md dark:shadow-gray-900/80 sm:rounded-lg">
                            <table class="min-w-full">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            #
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Action
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            By User
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Date
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Time
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                    <tr
                                        class="border-b @if ($log->state == 'passed') bg-green-100 dark:bg-green-300 @else bg-red-200 dark:bg-red-300 @endif dark:border-gray-700 ">
                                        <td
                                            class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-gray-900">
                                            {{ $log->id }}
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-900 whitespace-wrap dark:text-gray-900">
                                            {!! $log->action !!}
                                        </td>
                                        <td
                                            class="py-4 px-6 text-sm text-gray-900 whitespace-nowrap dark:text-gray-900">
                                            {{ $log->user }}
                                        </td>
                                        <td
                                            class="py-4 px-6 text-sm text-gray-900 whitespace-nowrap dark:text-gray-900">
                                            {{ $log->created_at->toDateString() }}
                                        </td>
                                        <td
                                            class="py-4 px-6 text-sm text-gray-900 whitespace-nowrap dark:text-gray-900">
                                            {{ $log->created_at->toTimeString() }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <table style="width: 100%" class="table table-auto hidden">
                <thead class="bg-blue-300">
                    <tr>
                        <th class="text-center" scope="col">#</th>
                        <th class="text-center" scope="col">Action</th>
                        <th class="text-center" scope="col">Status</th>
                        <th class="text-center" scope="col">User</th>
                        <th class="text-center" scope="col">Date</th>
                        <th class="text-center" scope="col">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                    <tr class="@if ($log->state == 'passed') bg-green-100 @else bg-red-100 @endif">
                        <th class="text-center text-sm" scope="row">{{ $log->id }}</th>
                        <td class="text-sm">{{ $log->action }}</td>
                        <td
                            class="fw-bold text-sm @if ($log->state == 'passed') text-success @else text-danger @endif text-center">
                            {{ $log->state }}</td>
                        <td class="text-sm">{{ $log->user }}</td>
                        <td class="text-sm">{{ $log->created_at->toDateString() }}</td>
                        <td class="text-sm">{{ $log->created_at->toTimeString() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="mt-3">

            <p class="text-3xl font-semibold dark:text-white mb-3">Authentication log</p>


            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow-md dark:shadow-gray-900/80 sm:rounded-lg">
                            <table class="min-w-full">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            User
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            IP Address
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Sign in
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Sign out
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($auths as $auth)
                                    <tr
                                        class="border-b @if ($auth->logout_at != null) bg-gray-100 dark:bg-gray-600 @else bg-white dark:bg-gray-800 @endif dark:border-gray-700 ">
                                        <td
                                            class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $auth->title }} {{ $auth->name }}
                                        </td>
                                        <td
                                            class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            {{ $auth->ip_address }}
                                        </td>
                                        <td
                                            class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            {{ $auth->login_at }}
                                        </td>
                                        <td
                                            class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            {{ $auth->logout_at }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>


</div>

@endsection