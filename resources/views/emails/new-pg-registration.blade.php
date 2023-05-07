@component('mail::message')

Dear {{ $body['name'] }},
<br>

<h1>Welcome to the Postgraduate Programme at DMIE</h1>
<br>

Thank you for registering for the Postgraduate Programme in Engineering Management & Manufacturing Engineering -
{{ $body['year'] }}

<br>

**We will contact you soon**.

<br>

Thank you,<br><br>
Postgraduate Programme Coordinator,<br>
Department of Manufacturing and Industrial Engineering,<br>
Faculty of Engineering,University of Peradeniya,<br>
Peradeniya 20400,<br>
Sri Lanka.
@endcomponent
