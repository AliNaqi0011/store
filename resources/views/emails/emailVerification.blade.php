@component('mail::message')
Your Email verification code is: {{$data['email_otpCode']}}


Thanks,<br>
{{ config('app.name') }}<br>


@endcomponent