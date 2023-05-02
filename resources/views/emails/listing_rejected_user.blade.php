@component('mail::message')

# Inzerát byl zamítnut

Dobrý den,<br>
váš inzerát **{{ $listing->title }}** byl našim systémem zamítnut.
<br><br>
V případě, že byl inzerát topován, vám byly navráceny kredity za topování.
<br><br>
Pokud si myslíte, že došlo k chybě a inzerát neporušuje naše pravidla, napište nám e-mail na <a href="mailto:info@nadzasoby.cz">info@nadzasoby.cz</a> a určitě to společně vyřešíme.
<br><br>
Děkujeme za pochopení.

@endcomponent
