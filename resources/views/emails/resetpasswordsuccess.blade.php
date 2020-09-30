@component('mail::message')
# Password Reset Success

Your password has been reset succesfully for ***{{ config('app.name') }}*** by the user:

## Name: ***{{ $to[0]["name"] }}***

## Email: ***{{ $to[0]["address"] }}***

## Time: ***{{ $now }}***

@component('mail::button', ['url' => config('app.url') . "login"])
Login
@endcomponent

If this was a mistake, please reach out to {{ config('mail.from.address') }}.

Thanks,<br>
{{ config('app.name') }}

{{ config('mail.from.address') }}
@endcomponent
