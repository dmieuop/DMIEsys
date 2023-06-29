@component('mail::message')
Dear {{ $body['name'] }},
<br>

# Your booking has been placed successfully.

## Booking Details

<x-mail::panel>
<strong>Department</strong> : {{ $body['department'] }}<br>
<strong>Facility</strong>   : {{ $body['facility'] }}<br>
<strong>Date</strong>       : {{ $body['date'] }}<br>
<strong>Time</strong>       : {{ $body['start_time'] }} To {{ $body['end_time'] }}
</x-mail::panel>

You will be notified once your booking is approved.


Thank you,<br>
{{ config('app.name') }} | <strong>DMIE</strong> 
@endcomponent
