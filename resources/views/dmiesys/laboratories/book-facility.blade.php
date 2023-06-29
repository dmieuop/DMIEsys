@extends('layouts.dmiesys.app')

@section('title', '| Book a Facility')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection


{{-- @push('styles')
<link rel="stylesheet" href="{{ asset('src/css/menu.css') }}">
@endpush --}}

@section('content')

<div class="screen">

    @include('components.premission-indicator', [
    'page' => 'Book a Facility',
    ])

    <div class="grid lg:grid-cols-2 lg:gap-x-20 xl:gap-x-32">
        <div class="menu-area d-flex flex-column">


            @if(!($approve_booking_single_auth ?? false))
            <a href="{{ route('book-labs.create') }}" style="text-decoration: none;">
                <div class="menu-card @if ($book_lab_auth ?? false) active-menu @endif">
                    <i class="bi bi-building-down text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Book a Laboratory</span>
                </div>
            </a>

            @can('approve booking')
            <a href="{{ route('book-labs.index') }}" style="text-decoration: none;">
                <div class="menu-card @if ($approve_booking_auth ?? false) active-menu @endif">
                    <i class="bi bi-check2-circle text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Approve Bookings</span>
                </div>
            </a>
            @endcan

            @else
            <a href="{{ route('book-labs.index') }}" style="text-decoration: none;">
                <div class="menu-card @if ($approve_booking_single_auth ?? false) active-menu @endif">
                    <i class="bi bi-caret-left text-5xl align-middle"></i>
                    <span class="text-xl font-medium align-middle">Back to other bookings</span>
                </div>
            </a>
            @endif

        </div>

        <div>

            @include('components.error-message')

            @if ($book_lab_auth ?? false)


            <form method="POST" onsubmit="submitFunction()" action="{{ route('book-labs.store') }}">
                @csrf @honeypot

                @livewire('lab-booking-view')

                <div class="mb-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_time" class="form-label">Start Time</label>
                            <select id="start_time" class="form-select" name="start_time" required>
                                <option value="{{ null }}" selected>-- Select time --</option>
                                @foreach ($starting_times as $starting_time)
                                <option value="{{ $starting_time }}">{{ date('h:i a', strtotime($starting_time)) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="end_time" class="form-label">End Time</label>
                            <select id="end_time" class="form-select" name="end_time" required>
                                <option value="{{ null }}" selected>-- Select time --</option>
                                @foreach ($ending_times as $ending_time)
                                <option value="{{ $ending_time }}">{{ date('h:i a', strtotime($ending_time)) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" class="form-input-readonly" value="{{ auth()->user()->name }}"
                        disabled>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Email</label>
                    <input type="text" id="email" class="form-input-readonly" value="{{ auth()->user()->email }}"
                        disabled>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" id="phone" name="phone" class="form-input"
                        value="{{ old('phone') ?? auth()->user()->phone }}" placeholder="Enter a phone number">
                </div>


                <div class="mb-3">
                    <label for="note" class="form-label">Special Notes (optional)</label>
                    <textarea name="note" class="form-textarea" id="note" rows="3"
                        placeholder="Mention your requirements such as projectors, whiteboard, etc">{{ old('note') }}</textarea>
                </div>

                @include('components.submit-button', [
                'button' => 'Confirm Booking',
                'icon' => 'bi-plus-circle',
                'cancel' => false,
                ])

            </form>

            @endif

            @if ($approve_booking_auth ?? false)

            @forelse ($bookings as $booking)
            <div id="alert-additional-content-1" onclick="window.location='{{ route('book-labs.show', $booking->id) }}'"
                class="p-4 mb-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800 hover:border-blue-600 hover:shadow-md dark:hover:border-blue-400 cursor-pointer"
                role="alert">
                <div class="flex items-center">
                    <span class="sr-only">Booking Info</span>
                    <h3 class="text-md font-semibold">{{ $booking->getLab->name }} booking</h3>
                </div>
                <div class="mt-2 text-xs">
                    <p><strong>Booking Date</strong> : {{ $booking->date }}</p>
                    <p><strong>Booking Time</strong> : {{ date('h:i a', strtotime($booking->start_time)) }} - {{
                        date('h:i a', strtotime($booking->end_time)) }}</p>
                    <p><strong>Request From</strong> : {{ $booking->from }} member</p>
                </div>
            </div>
            @empty

            <div id="alert-additional-content-1"
                class="p-4 mb-4 text-gray-800 border border-gray-300 rounded-lg bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-800"
                role="alert">
                <div class="flex items-center">
                    <span class="sr-only">Booking Info</span>
                    <h3 class="text-md font-normal">No bookings to approve</h3>
                </div>
            </div>

            @endforelse

            @endif

            @if ($approve_booking_single_auth ?? false)

            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-5">
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="col" colspan="2"
                            class=" px-3 py-2 font-semibold whitespace-nowrap text-blue-600 dark:text-gray-300">
                            Booking Details
                        </th>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Facility
                        </th>
                        <td class="px-6 py-2">
                            : {{ $booking->getLab->name }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Date
                        </th>
                        <td class="px-6 py-2">
                            : {{ $booking->date }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Time
                        </th>
                        <td class="px-6 py-2">
                            : From {{ date('h:i a', strtotime($booking->start_time)) }} To {{
                            date('h:i a', strtotime($booking->end_time)) }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="col" colspan="2"
                            class="px-3 py-2 font-semibold whitespace-nowrap text-blue-600 dark:text-gray-300">
                            User Details
                        </th>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Name
                        </th>
                        <td class="px-6 py-2">
                            : {{ $booking->name }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Email
                        </th>
                        <td class="px-6 py-2">
                            : {{ $booking->email }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Phone
                        </th>
                        <td class="px-6 py-2">
                            : {!! $booking->phone ?? '<i>(Not provided)</i>' !!}
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Request From
                        </th>
                        <td class="px-6 py-2">
                            : {{ $booking->from }} member
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Department
                        </th>
                        <td class="px-6 py-2">
                            : {{ $booking->department }}
                        </td>
                    </tr>
                    <tr class="bg-white dark:bg-gray-800">
                        <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Special Notes
                        </th>
                        <td class="px-6 py-2">
                            : {!! $booking->note ?? '<i>(No notes)</i>' !!}
                        </td>
                    </tr>
                </tbody>
            </table>

            <form method="POST" action="{{ route('book-labs.update', $booking->id) }}">
                @csrf @method('PUT') @honeypot

                <div class="mb-3">
                    <label for="technical_officer" class="form-label">Assign a technical officer (only for approval)
                    </label>
                    <select id="technical_officer" class="form-select" name="technical_officer">
                        <option value="{{ null }}" selected>-- Select status --</option>
                        @foreach ($technical_officers as $technical_officer)
                        <option value="{{ $technical_officer->id }}">{{ $technical_officer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="reason" class="form-label">Reason for rejection (only for rejection)</label>
                    <input type="text" id="reason" name="reason" class="form-input"
                        placeholder="Enter a reason for rejection">
                </div>

                <div class="mb-3 grid grid-cols-2 gap-3">
                    <div
                        class="flex items-center pl-4 border border-gray-200 hover:bg-green-100 dark:hover:bg-green-700 rounded dark:border-gray-700 hover:border-green-500">
                        <input id="bordered-radio-1" type="radio" value="approved" name="status"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            required>
                        <label for="bordered-radio-1"
                            class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Approve</label>
                    </div>
                    <div
                        class="flex items-center pl-4 border border-gray-200 rounded dark:border-gray-700 dark:hover:bg-red-500 hover:border-red-500 hover:bg-red-100">
                        <input required id="bordered-radio-2" type="radio" value="rejected" name="status"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="bordered-radio-2"
                            class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Reject</label>
                    </div>
                </div>

                @include('components.submit-button', [
                'button' => 'Confirm',
                'icon' => 'bi-plus-circle',
                'cancel' => false,
                ])

            </form>

            @endif

        </div>
    </div>


</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/datepicker.min.js"></script>
@endpush