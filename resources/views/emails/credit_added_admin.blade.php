@component('mail::message')
    Uživatel <b>{{ $user->name }} ({{ $user->email }})</b> koupil {{ $amount }} kreditů.
@endcomponent
