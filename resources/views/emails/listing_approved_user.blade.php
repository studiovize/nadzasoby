@component('mail::message')

# Inzerát byl schválen
Váš inzerát **{{ $listing->title }}** byl schválen.

@component('mail::button', ['url' => route('listings.show', $listing), 'color' => 'red'])
    Zobrazit inzerát
@endcomponent

@endcomponent
