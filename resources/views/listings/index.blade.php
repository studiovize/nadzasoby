@section('title', title('Nabídka zboží'))

<x-app-layout>
    @guest
        <x-slot name="banner">
            <a href="{{ route('register') }}" class="hover:underline">Akce! Registrujte se a získejte 2 kredity s platností 14 dnů.</a>
        </x-slot>
    @endguest
    <x-container class="mb-8">
        <div class="relative p-8 md:p-12 lg:p-16 text-white h-auto md:h-96 flex items-center overflow-hidden bg-black">
            <div
                class="absolute opacity-70 w-full h-full transition-transform duration-1000 transform bg-center bg-cover top-0 left-0"
                style="background-image:url({{ asset('img/photo1.jpg') }})"></div>
            <div class="relative">
                <header>
                    <h1 class="text-4xl font-bold filter drop-shadow-sm">
                        V nadzásobách vám leží peníze.<br>
                        Nadzásoby za super peníze.
                    </h1>
                </header>

                <div class="mt-8 flex flex-col md:flex-row gap-2">
                    <x-button-link href="{{ route('about') }}">Jak to funguje?</x-button-link>
                    @guest
                        <x-button-link href="{{ route('register') }}" theme="outline-white">Registrovat se
                        </x-button-link>
                    @endguest
                </div>
            </div>
        </div>
    </x-container>

    <x-container class="mb-8 text-center">
        <x-inner-container>
            <header>
                <h2 class="font-semibold text-3xl mb-4 text-gray-800 leading-tight">Hledat</h2>
            </header>
            <form class="flex flex-col md:flex-row gap-4 w-full justify-center items-center md:items-end"
                  action="{{ route('listings.search', ['category' => request()->has('category') ? request()->get('category') : '']) }}"
                  method="get">
                <div class="relative w-full lg:w-1/2 text-left">
                    <x-input type="text" name="s" id="s" class="w-full py-3" value="{{ request()->get('s') }}"/>
                </div>
                <x-button>Hledat</x-button>
            </form>

            <em class="block text-sm mt-2 text-gray-500 w-full">(např. PET, kabely, cihly...)</em>
        </x-inner-container>
    </x-container>

    <x-container class="mb-8">
        <x-inner-container>
            <header class="mb-4">
                <h3 class="text-2xl">Kategorie</h3>
            </header>
            <div class="flex flex-wrap gap-2">
                <x-tag theme="red"
                       href="{{ route('listings.search', ['s' => request()->has('s') ? request()->get('s') : '']) }}">
                    Všechny
                    <x-badge class="ml-2">{{ $listings_count }}</x-badge>
                </x-tag>

                @foreach($categories as $category)
                    <x-tag
                        href="{{ route('listings.search', ['category' => $category->id]) }}">
                        {{ $category->name }}
                        <x-badge class="ml-2">{{ $category->listings_count }}</x-badge>
                    </x-tag>
                @endforeach
            </div>
        </x-inner-container>
    </x-container>

    <x-container>
        <x-inner-container>
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-8">
                @each('listings.partials.listing', $listings, 'listing', 'listings.partials.no-active-listings')
            </div>

            @if($listings->count() !== 0)
                <div class="mt-10 mb-2 text-center">
                    <x-button-link href="{{ route('listings.search') }}">Zobrazit všechny nabídky</x-button-link>
                </div>
            @endif

        </x-inner-container>
    </x-container>
</x-app-layout>
