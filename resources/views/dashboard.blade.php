@extends('layouts.dmiesys.app')

@section('title', '| Dashboard')

@push('styles')
<style>
    .main {
        display: flex;
        height: 77vh;
        width: 96%;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')

@if(auth()->user()->has_update_notification ?? false)
<div class="absolute main">
    <div class="mt-10 rounded-2xl border-0 bg-white dark:bg-gray-700 px-2 pb-3 shadow-md dark:shadow-gray-900/80">
        <div class="w-96 px-3 pt-4 pb-2">
            <div class="mt-2 mb-1 w-full">
                <div class="p-3 text-center">
                    <h3 class="mb-5 font-semibold text-md text-gray-500 dark:text-gray-400">
                        DMIEsys updated to <b>{{ config('settings.system.version') }}</b>.
                        Read the Changelog to see the new improvements.
                    </h3>
                    </button>
                    <a href="{{ route('new.updates') }}" class="btn btn-purple">
                        See the Changelog</a>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="lg:grid-col-3 grid grid-cols-1 xl:grid-cols-4">

    <div class="mr-0 xl:mr-4">

        <div class="mb-3 rounded-xl bg-white p-2 shadow-md dark:bg-gray-800 dark:shadow-gray-900/80">
            <table>
                <tbody>
                    <tr>
                        <td rowspan="3" class="pl-2 pr-5">
                            @include('components.profile-image', [
                            'size' => '6rem',
                            'path' => auth()->user()->profile_photo_path,
                            ])
                        </td>
                        <td class="text-2xl font-medium dark:text-gray-300">
                            @if (date('H', time()) < 12) Good morning, @else Good afternoon, @endif </td>
                    </tr>
                    <tr>
                        <td class="text-xl font-medium dark:text-gray-300">
                            {{ auth()->user()->title }}
                            {{ explode(' ', auth()->user()->name, 2)[0] }}. </td>
                    </tr>
                    <tr>
                        <td class="text-md font-normal text-gray-800 dark:text-gray-500">
                            {{ auth()->user()->getRoleNames()[0] }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if (auth()->user()->active_status)
        @livewire('dashboard-calender')
        {{-- @livewire('show-calender-events') --}}
        @else
        <div class="mb-3 rounded-xl bg-red-200 p-2 shadow-md dark:bg-red-300 dark:shadow-gray-900/80">
            <p class="p-3 text-xl font-semibold italic text-red-700 dark:text-red-800">
                This account is deactivated!
            </p>
        </div>
        @endif

    </div>

    <div class="col-span-3">

        <div class="mb-3 rounded-xl bg-white p-3 pl-5 shadow-md dark:bg-gray-800 dark:shadow-gray-900/80">
            <p class="mb-4 font-semibold dark:text-gray-300">Academic</p>
            @include('dmiesys.widgets.academic_dashboard_widget')
        </div>

        <div class="mb-3 rounded-xl bg-white p-3 pl-5 shadow-md dark:bg-gray-800 dark:shadow-gray-900/80">
            <p class="mb-4 font-semibold dark:text-gray-300">Laboratories</p>
            @include('dmiesys.widgets.laboratories_dashboard_widget')
        </div>

        <div class="mb-3 rounded-xl bg-white p-3 pl-5 shadow-md dark:bg-gray-800 dark:shadow-gray-900/80">
            <p class="mb-4 font-semibold dark:text-gray-300">Human Resource</p>
            @include('dmiesys.widgets.human_resource_dashboard_widget')
        </div>

        <div class="mb-3 rounded-xl bg-white p-3 pl-5 shadow-md dark:bg-gray-800 dark:shadow-gray-900/80">
            <p class="mb-4 font-semibold dark:text-gray-300">Finance</p>
        </div>

        <div class="mb-3 rounded-xl bg-white p-3 pl-5 shadow-md dark:bg-gray-800 dark:shadow-gray-900/80">
            <p class="mb-4 font-semibold dark:text-gray-300">General</p>
            @include('dmiesys.widgets.general_dashboard_widget')
        </div>

    </div>

</div>
@endif
@endsection

@push('scripts')
<script>
    function showDayEvents(date) {
            window.livewire.emitTo('show-calender-events', 'showDayEvents', date);
        }
</script>
@endpush