@component('mail::message')
# Password Reset

A password reset has been requested for ***{{ config('app.name') }}*** by the user:

## Name: ***{{ $to[0]["name"] }}***

## Email: ***{{ $to[0]["address"] }}***

## Time: ***{{ $now }}***

@component('mail::button', ['url' => $resetUrl])
Reset Password
@endcomponent

If the button above does not work try pasting this link into your browser:

***{{ $resetUrl }}***

If this was a mistake, just ignore this email and nothing will happen.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
