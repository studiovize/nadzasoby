@component('mail::message')

# Byl vytvořen nový inzerát

Dobrý den,<br>
zaznamenali jsme přidání vašeho inzerátu. Jakmile bude inzerát schválen našim systémem, bude zveřejněn.
<br><br>
Děkujeme za pochopení.

@component('mail::button', ['url' => route('listings.show', $listing), 'color' => 'red'])
Zobrazit inzerát
@endcomponent

@endcomponent
