@component('mail::message')

Dear {{ $body['refereename'] }},
<br>


{{ $body['applicantname'] }} has mentioned you as the referee on {{ $body['gender'] }} application for
the {{ $body['degree'] }}, {{ $body['cat'] }} degree offered at the Department of Manufacturing & Industrial
Engineering, University of Peradeniya.

<br>

Please click button below to upload a referee report for {{ $body['applicantname'] }}.<br>
(You can download the provided template for the referee report at the upload page)

<br>
@component('mail::button', ['url' => $body['url']])
Upload Referee Report
@endcomponent
<br>

**Please note that this link will only be valid until {{ $body['exp_date'] }}.**
<br>

<i>(Please disregard this email, if it is not intended for you.)</i>

<br>
Thank you,<br><br>
Postgraduate Programme Coordinator,<br>
Department of Manufacturing and Industrial Engineering,<br>
Faculty of Engineering,University of Peradeniya,<br>
Peradeniya 20400,<br>
Sri Lanka.
@endcomponent
