@component('mail::message')

# Byl přidaný nový inzerát
<small>Kategorie: {{ $listing->category->name }}</small>
<br>
<hr>
<br>
<b>{{ $listing->title }}</b>
<br><br>
{{ strip_tags(br2nl($listing->content)) }}
<br>
<br>
<hr>
<br>
<p style="text-align:center;">Inzerát nyní čeká na schválení.</p>

@component('mail::button', ['url' => route('listings.show', $listing), 'color' => 'red'])
Zobrazit inzerát
@endcomponent

@endcomponent
