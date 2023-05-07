@component('mail::message')

<h1>{{ $body['name'] }} has sent you a message!</h1>
<br>

Hello DMIE, <br>

{{ $body['message'] }}
<br>

Thank You,<br>
{{ $body['name'] }}<br>
{{ $body['phone'] }}<br>
{{ $body['email'] }}

@endcomponent
