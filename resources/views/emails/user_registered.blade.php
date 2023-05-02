@component('mail::message')
Dobrý den,  {{-- use double space for line break --}}
děkujeme za registraci do Nadzásob.

# Prodávate?
Neváhejte rovnou vložit inzerát, je to zdarma.
@component('mail::button', ['url' => route('listings.create'), 'color' => 'red'])
Vložit inzerát
@endcomponent

# Hledáte zboží?
V naší nabídce je momentálně více než {{ $listings_count }} nabídek!
@component('mail::button', ['url' => route('listings.search'), 'color' => 'red'])
Hledat zboží
@endcomponent

@endcomponent
