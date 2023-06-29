@component('mail::message')
Dear DMIE Office,
<br>

# A new booking has been placed by an {{ $body['request_type'] }} member.

## User Details

<x-mail::panel>
<strong>Name</strong>        : {{ $body['name'] }}<br>
@if($body['request_type'] == 'external')
<strong>Department</strong>  : {{ $body['department'] }}<br>
@endif
<strong>Email</strong>       : {{ $body['email'] }}<br>
<strong>Phone</strong>       : {{ $body['phone'] ?? '(Not provided)' }}<br>
</x-mail::panel>

## Booking Details

<x-mail::panel>
<strong>Requested Facility</strong> : {{ $body['facility'] }}<br>
<strong>Date</strong>              : {{ $body['date'] }}<br>
<strong>Time</strong>              : {{ $body['start_time'] }} To {{ $body['end_time'] }}<br>
<strong>Notes</strong>             : {{ $body['notes'] ?? '(No notes)' }}
</x-mail::panel>

Please log in to the DMIEsys and approve the booking.

@component('mail::button', ['url' => $body['url']])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
