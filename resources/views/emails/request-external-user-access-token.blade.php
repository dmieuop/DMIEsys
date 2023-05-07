@component('mail::message')

Hi,
<br>

It appears that you have requested permission to update your DMIEsys profile. Please access your profile by clicking the link below.

(Please do not forward this link to anyone else. This link will only be active for a few hours.)

@component('mail::button', ['url' => $body['url']])
Edit my profile
@endcomponent

Thank you,<br>
{{ config('app.name') }}
@endcomponent
