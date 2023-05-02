@component('mail::message')
<h1>
Vaše kredity vypršely
</h1>

<p>
Bohužel jsme museli deaktivovat {{ $total }} kreditů, které jste u nás koupili, protože jim vypršela doba platnosti. Až je budete chtít znovu doplnit, klikněte na tlačitko níže.
</p>

@component('mail::button', ['url' => route('credits.index'), 'color' => 'red'])
Koupit kredity
@endcomponent

@endcomponent
