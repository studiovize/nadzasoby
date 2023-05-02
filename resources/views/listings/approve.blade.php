@section('title', title('Schvalování inzerátů'))
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Ke schválení ({{ $listings_to_approve->count() }})
        </h1>
    </x-slot>

    <x-container class="mb-8">
        <x-inner-container>
            @if(session()->has('message'))
                <div class="p-4 mb-4 bg-green-100 text-green-700 font-bold">
                    {{ session()->get('message') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-8">
                @each('listings.partials.listing', $listings_to_approve, 'listing', 'listings.partials.no-listings-to-approve')
            </div>
        </x-inner-container>
    </x-container>
</x-app-layout>
