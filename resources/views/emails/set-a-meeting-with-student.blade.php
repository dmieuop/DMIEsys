@component('mail::message')
Hello {{ $body['student'] }},
<br>

{{ $body['advisor'] }}, your advisor, would like to meet with you and have a brief conversation. This time, your advisor
prefers to hold the meeting {{ $body['meeting_method'] }}. Your advisor just wants to see how you're doing these days.
You can find the meeting details below. If you have any concerns about the date or time, you are free to speak with your
advisor and change the meeting time.

**Email** : {{ $body['email'] }}<br>
**Phone** : {{ $body['phone'] }}<br>
**Date** : {{ $body['date'] }}<br>
**Time** : {{ date('h:i a', strtotime($body['time'])) }}<br>
@if ($body['meeting_link'])
**Meeting Link** : <a href="{{ $body['meeting_link'] }}">{{ $body['meeting_link'] }}</a>
@endif

@if ($body['message'])
{{ $body['message'] }}
@endif

Thank you,<br>
Department of Manufacturing and Industrial Engineering,<br>
Faculty of Engineering,University of Peradeniya,<br>
@endcomponent
