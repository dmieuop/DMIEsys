@component('mail::message')
Dear {{ $body['advisor'] }},
<br>

It appears that for over a month you skipped meetings and neglected to record any feedback on your students. Please plan
a meeting with your students, take notes of anything important, and assist your students in developing a great academic
career during this time.

@foreach($body['students'] as $student)
**Student** : {{ $student['name'] }}<br>
**Reg No** : {{ $student['student_id'] }}<br>
**Email** : {{ $student['email'] }}<br>
**Phone** : {{ $student['phone'] }}

@endforeach

Thank you,<br>
{{ config('app.name') }}
@endcomponent
