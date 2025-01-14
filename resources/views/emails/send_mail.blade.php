@component('mail::message')
{{__('messages.hello')}} {{$user->name}},

{!! $user->send_message !!}

{{__('messages.thanks')}},<br>
{{ config('app.name') }}
@endcomponent