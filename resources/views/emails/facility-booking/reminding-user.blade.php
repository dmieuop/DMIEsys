@component('mail::message')
Dear {{ $body['name'] }},
<br>

# You have a booking in 30min from now.

## Booking Details

<x-mail::panel>
<strong>Department</strong>         : {{ $body['department'] }}<br>
<strong>Requested Facility</strong> : {{ $body['facility'] }}<br>
<strong>Date</strong>              : {{ $body['date'] }}<br>
<strong>Time</strong>              : {{ $body['start_time'] }} To {{ $body['end_time'] }}
</x-mail::panel>

## Assigned TO Member Details

<x-mail::panel>
<strong>Name</strong>        : {{ $body['to_name'] }}<br>
<strong>Phone</strong>        : {{ $body['to_phone'] ?? '(Not provided)' }}<br>
<strong>Email</strong>        : {{ $body['to_email'] }}<br>
</x-mail::panel>


Thank you,<br>
{{ config('app.name') }} | <strong>DMIE</strong>
@endcomponent
