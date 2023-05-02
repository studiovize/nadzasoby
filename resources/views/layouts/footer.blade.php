@php
    $quick_links = [
        'listings.search' => 'Všechny inzeráty',
        'about' => 'Jak to funguje?',
        'credits.index' => 'Kredity',
        'faq' => 'Často kladené otázky',
        'listings.create' => 'Přidat inzerát',
    ];

    $terms_links = [
        'docs.terms' => 'Podmínky služby',
        'docs.personal-data' => 'Zásady ochrany osobních údajů',
        'cookies.settings' => 'Nastavení Cookies'
    ];

    $social_links = [
        'https://www.facebook.com/people/Nadz%C3%A1soby/100089496365478/' => 'icons/facebook.svg',
        'https://instagram.com/nadzasoby2' => 'icons/instagram.svg',
    ];

    $tags = getPopularSearches(5);

    $title_class = 'text-xl font-semibold';
@endphp
<footer class="bg-red-500 border-t-2 border-red-600 flex flex-col gap-12 py-12 text-white">
    <x-container class="flex flex-col md:flex-row gap-8 lg:gap-4">
        <aside class="w-full md:w-1/4">
            <header>
                <h3 class="{{ $title_class }}">Rychlé odkazy</h3>
            </header>

            <x-short-line/>

            <nav class="flex flex-col gap-4">
                @foreach($quick_links as $route => $title)
                    <a href="{{ route($route) }}" class="hover:underline">{{ $title }}</a>
                @endforeach
            </nav>
        </aside>

        <aside class="w-full md:w-1/4">
            <header>
                <h3 class="{{ $title_class }}">Podmínky</h3>
            </header>

            <x-short-line/>

            <div class="flex flex-col gap-8">
                <nav class="flex flex-col gap-4">
                    @foreach($terms_links as $route => $title)
                        <a href="{{ route($route) }}" @if(str_contains($route, '.pdf')) target="_blank"
                           @endif class="hover:underline">{{ $title }}</a>
                    @endforeach
                </nav>

                <div class="flex gap-4">
                    @foreach($social_links as $link => $icon)
                        <a href="{{ $link }}" class="w-8 inline-flex" target="_blank">
                            {!! svg($icon) !!}
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <aside class="w-full md:w-1/2">
            <header>
                <h3 class="{{ $title_class }}">Populární vyhledávání</h3>
            </header>

            <x-short-line/>

            <div class="flex flex-wrap gap-2">
                @foreach($tags as $item)
                    <x-tag :compact="true" href="{{ $item['link'] }}">{{ $item['label'] }}</x-tag>
                @endforeach
            </div>
        </aside>
    </x-container>

    <x-container class="text-center flex flex-col items-center gap-8">
        <p>
            &copy; {{ date('Y') }} REDIHEND s.r.o., IČO: 28216539<br>
            Špitálka 461/21a, Trnitá, 602 00 Brno
        </p>

        <div>
            <x-logo :link="true" :text="true"/>
        </div>
    </x-container>
</footer>
