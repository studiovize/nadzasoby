@component('mail::message')

# Zpráva z kontaktního formuláře

**Jméno:** {{ $data['name'] }}<br>
**E-mail:** <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a><br><br>
**Zpráva:**<br>
{{ $data['message'] }}
<br><br>
<hr>
<br>

<small>
    <i>Na zprávu odpovíte kliknutím na <b>Odpovědět</b>, jako byste odpovídali na e-mail.</i>
</small>
@endcomponent
