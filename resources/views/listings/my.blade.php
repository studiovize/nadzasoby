@section('title', title('Moje inzeráty'))
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Moje inzeráty
        </h1>
    </x-slot>

    <div class="flex flex-col gap-8">
        <x-container>
            <x-inner-container>
                <header>
                    <h2 class="text-4xl font-bold mb-4">Čeká na schválení ({{ $waiting_listings->count() }})</h2>
                </header>
                <div
                    class="grid grid-cols-1 sm:grid-cols-1 @if($waiting_listings->count() > 0) md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 @endif gap-10">

                    @each('listings.partials.listing', $waiting_listings, 'listing', 'listings.partials.no-my-listings')
                </div>
            </x-inner-container>
        </x-container>

        <x-container>
            <x-inner-container>
                <header>
                    <h2 class="text-4xl font-bold mb-4">Aktivní ({{ $active_listings->count() }})</h2>
                </header>
                <div
                    class="grid grid-cols-1 sm:grid-cols-1 @if($active_listings->count() > 0) md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 @endif gap-10">

                    @each('listings.partials.listing', $active_listings, 'listing', 'listings.partials.no-my-listings')
                </div>
            </x-inner-container>
        </x-container>

        <x-container>
            <x-inner-container>
                <header>
                    <h2 class="text-4xl font-bold">Neaktivní ({{ $inactive_listings->count() }})</h2>
                </header>
                <div
                    class="grid grid-cols-1 sm:grid-cols-1 @if($inactive_listings->count() > 0) md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 mt-4 @endif gap-10">
                    @each('listings.partials.listing', $inactive_listings, 'listing')
                </div>
            </x-inner-container>
        </x-container>

        <x-container>
            <x-inner-container>
                <header>
                    <h2 class="text-4xl font-bold">Zamítnuté ({{ $rejected_listings->count() }})</h2>
                </header>
                <div
                    class="grid grid-cols-1 sm:grid-cols-1 @if($rejected_listings->count() > 0) md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 mt-4 @endif gap-10">
                    @each('listings.partials.listing', $rejected_listings, 'listing')
                </div>
            </x-inner-container>
        </x-container>
    </div>
</x-app-layout>
