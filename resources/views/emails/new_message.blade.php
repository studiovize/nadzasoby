@component('mail::message')
Dobrý den,  {{-- use double space for line break --}}
v Nadzásobách vám právě dorazila nová zpráva.

@component('mail::button', ['url' => route('messages.show', $thread->id), 'color' => 'red'])
Přečíst zprávu
@endcomponent

@endcomponent
