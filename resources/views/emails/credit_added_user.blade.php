@component('mail::message')
<h1 style="text-align: center;">
Děkujeme za dokoupení kreditů
</h1>

<p style="text-align: center;">
Na vašem účtě přibylo <b>{{ $amount }}</b> {{ getPlural($total, 'kredit', 'kredity', 'kreditů') }}, dohromady máte <b>{{ $total }} {{ getPlural($total, 'kredit', 'kredity', 'kreditů') }}</b>.
</p>

@component('mail::button', ['url' => route('listings.index'), 'color' => 'red'])
Zobrazit inzeráty
@endcomponent

@endcomponent
