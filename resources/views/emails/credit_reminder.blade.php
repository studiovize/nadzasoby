@component('mail::message')
<h1 style="text-align: center;">
Vaše kredity brzy vyprší!
</h1>

<p style="text-align: center;">
Kredity, které u nás máte, vyprši už za <b>{{ $days }} dní</b>! Neváhejte je ještě použít na odpovědi na inzeráty nebo topování vlastních. Nebo pokud dokoupíte další kredity, prodlouží se platnost stávajících.
</p>

@component('mail::button', ['url' => route('listings.index'), 'color' => 'red'])
Zobrazit inzeráty
@endcomponent

@endcomponent
