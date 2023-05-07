@component('mail::message')
Dear {{ $body['student'] }},
<br>


{{ $body['advisor'] }} was allocated as your academic advisor. If you have any questions about your academic programme
or any personal matter, you can discuss with your advisor now. Your advisor may also call you from time to time to speak
with you to help you build successful academic career.

**Advisor** : {{ $body['advisor'] }}<br>
**Email** : {{ $body['email'] }}<br>
**Phone** : {{ $body['phone'] }}


Thank you,<br>
Department of Manufacturing and Industrial Engineering,<br>
Faculty of Engineering,University of Peradeniya,<br>
@endcomponent
