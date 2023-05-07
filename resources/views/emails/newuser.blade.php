@component('mail::message')

<h1>Welcome to the DMIEsys</h1>
<br>


You were added to the DMIEsys as a {{ $body['role'] }}. <br>
Click **'Sign in'** and use the provided username and password to login.

(Once you login, you can update your profile and choose a new username)

**Username** : {{ $body['username'] }}<br>
**Password** : {{ $body['password'] }}

@component('mail::button', ['url' => $body['url']])
Sign in
@endcomponent

Thank you,<br>
{{ config('app.name') }}
@endcomponent
