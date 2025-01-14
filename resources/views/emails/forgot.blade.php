@component('mail::message')
{{ __('messages.hello') }} {{$user->name}},

<p>{{ __('messages.reset_password_message') }} </p>

@component('mail::button', ['url' => url('reset/'.$user->remember_token)])
{{__('messages.reset_password') }}
@endcomponent


{{__('messages.thanks')}},<br>
{{ config('app.name') }}
@endcomponent