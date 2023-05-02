@component('mail::message')

# Uživatel upravil inzerát

<b>Uživatel:</b> {{ $listing->user->name }}<br>
<b>Inzerát:</b> {{ $listing->title }}<br><br>

Inzerát nyní čeká na schválení.

@component('mail::button', ['url' => route('listings.show', $listing), 'color' => 'red'])
Zobrazit inzerát
@endcomponent

@endcomponent
