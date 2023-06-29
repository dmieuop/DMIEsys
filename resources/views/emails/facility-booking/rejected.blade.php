@component('mail::message')
Dear {{ $body['name'] }},
<br>

# Your booking has been rejected.

## Booking Details

<x-mail::panel>
<strong>Department</strong> : {{ $body['department'] }}<br>
<strong>Facility</strong>   : {{ $body['facility'] }}<br>
<strong>Date</strong>       : {{ $body['date'] }}<br>
<strong>Time</strong>       : {{ $body['start_time'] }} To {{ $body['end_time'] }}<br>
<strong>Reason for rejection</strong>       : {{ $body['reason'] }}
</x-mail::panel>

Please contact department office for further details.


Thank you,<br>
{{ config('app.name') }} | <strong>DMIE</strong>
@endcomponent
