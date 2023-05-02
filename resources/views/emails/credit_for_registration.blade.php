@component('mail::message')
<h1 style="text-align: center;">
    Kredity za registraci
</h1>

<p style="text-align: center;">
    Děkujeme za registraci, jako poděkování jsme vám přidali <b>{{ $amount }} {{ getPlural($amount, 'kredit', 'kredity', 'kreditů') }}</b>.
</p>

@component('mail::button', ['url' => route('listings.index'), 'color' => 'red'])
    Zobrazit inzeráty
@endcomponent

@endcomponent
