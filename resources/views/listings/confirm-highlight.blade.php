@section('title', title('Topovat inzerát'))
<x-app-layout>
    <x-slot name="header">
        <div class="md:flex-grow flex items-center justify-start">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Topovat inzerát
            </h1>
        </div>
    </x-slot>

    <x-container>
        <x-inner-container class="max-w-lg mx-auto text-center flex flex-col gap-6">
            <header>
                <h1 class="font-bold text-3xl">
                    Chcete zajistit rychlejší prodej?
                </h1>
            </header>
            <p>
                Topujte svůj inzerát za <b>{{ env('PRICE_HIGHLIGHT') }} kreditů</b>. Bude se ukazovat na začátku výsledků
                vyhledávání a bude barevně
                odlišný od ostatních inzerátů, aby bylo zaručené, že ho nikdo nepřehlédne.
            </p>

            <small class="uppercase">
                Náhled:
            </small>
            <div class="flex justify-center">
                @include('listings.partials.listing-preview', ['listing' => $listing])
            </div>

            <div class="flex items-center justify-center gap-4 mt-2">
                <x-button-link href="{{ route('listings.highlight', $listing) }}" theme="primary">Ano, topovat
                </x-button-link>
                <a href="{{ route('listings.show', $listing) }}" class="p-3">Nyní ne</a>
            </div>
        </x-inner-container>
    </x-container>
</x-app-layout>

