@component('mail::message')
    Uživatel <b>{{ $user->name }} ({{ $user->email }})</b> utratil {{ $spent }} kreditů. Zbývá mu {{ $total }} kreditů.

    Způsob útraty: @if($reason === 'highlight') Topování inzerátu @else Odemknutí inzerátu @endif

    Inzerát: <a href="{{ route('listings.show', $listing->slug) }}">{{ $listing->title }}</a>
@endcomponent
