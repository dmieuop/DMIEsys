@component('mail::message')
Dear {{ $body['to_name'] }},
<br>

# You were assigned to a facility booking request.

## Booking Details

<x-mail::panel>
<strong>Facility</strong>   : {{ $body['facility'] }}<br>
<strong>Date</strong>       : {{ $body['date'] }}<br>
<strong>Time</strong>       : {{ $body['start_time'] }} To {{ $body['end_time'] }}
<strong>Notes</strong>       : {{ $body['notes'] ?? '(No notes)' }}
</x-mail::panel>

## Requester Details

<x-mail::panel>
<strong>Name</strong>        : {{ $body['name'] }}<br>
<strong>Phone</strong>        : {{ $body['phone'] ?? '(Not provided)' }}<br>
<strong>Email</strong>        : {{ $body['email'] }}<br>
</x-mail::panel>

You will get a reminder email 30 min before the booking time.


Thank you,<br>
{{ config('app.name') }}
@endcomponent
