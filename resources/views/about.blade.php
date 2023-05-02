@section('title', title('O nás'))
<x-app-layout>
    <x-slot name="header">
        <div class="md:flex-grow flex items-center justify-start">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                O nás
            </h1>
        </div>
    </x-slot>

    <x-container class="mb-8">
        <x-inner-container>
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <div class="flex flex-col gap-4 items-start">

                    <header class="flex items-center gap-2">
                        <div class="w-14 hidden sm:block">
                            {!! svg('icons/logo.svg') !!}
                        </div>
                        <h2 class="text-3xl font-bold">O Nadzásobách</h2>
                    </header>

                    <p class="max-w-2xl">
                        Nadzásoby jsou nový začínající portál, jejichž cílem je v krátké chvíli zbavit firmy dlouho
                        neprodejných skladových zásob a zboží, které firma nakoupila/vyrobila v nadměrném množství. Také
                        se zajímáme o zboží, které by bylo v běžných kamenných obchodech jen těžce prodejné, jako je
                        zboží s poškozeným obalem nebo blížící se expirační dobou.
                    </p>


                    <x-button-link href="{{ route('listings.search') }}">Zobrazit nabídky</x-button-link>
                </div>
                <div class="w-full h-full">
                    <img src="{{ asset('img/photo2.jpg') }}" alt="" class="object-cover w-full h-full max-h-96">
                </div>
            </div>
        </x-inner-container>
    </x-container>

    <x-container class="mb-8">
        <x-inner-container>
            <header class="mb-4">
                <h2 class="text-3xl font-bold">Jak to funguje?</h2>
            </header>

            <div class="flex flex-col md:flex-row items-center md:items-stretch justify-center gap-8">

                <div class="relative flex-1 w-full bg-gray-100 py-6 px-8 rounded-lg flex flex-col gap-4">
                    <h3 class="text-2xl font-bold text-red-500">Hledáte zboží?</h3>

                    <div
                        class="hidden2 lg:block absolute top-6 right-6 lg:top-8 lg:right-8 w-8 h-8 lg:w-24 lg:h-24 text-gray-300 pointer-events-none">
                        {!! svg('icons/search.svg') !!}
                    </div>

                    {{--                    <div class="border-b border-gray-400 my-4"></div>--}}


                    <ul class="flex-1 list-disc list-inside flex flex-col gap-2 max-w-xs">
                        <li>Vyhledejte zboží, o které máte zájem</li>
                        <li>V případě zájmu nakupte kredity</li>
                        <li>Kontaktujte inzerce a domluvte se na formě platby a dodání</li>
                        <li>Zboží je vaše jedním klikem</li>
                    </ul>

                    <div>
                        <x-button-link href="{{ route('listings.search') }}">Hledat v inzerátech
                        </x-button-link>
                    </div>
                </div>

                <div class="relative flex-1 w-full bg-gray-100 py-6 px-8 rounded-lg flex flex-col gap-4">
                    <h3 class="text-2xl font-bold text-red-500">Inzerujete?</h3>

                    <div
                        class="hidden2 lg:block absolute top-6 right-6 lg:top-8 lg:right-8 w-8 h-8 lg:w-24 lg:h-24 text-gray-300 pointer-events-none">
                        {!! svg('icons/deal.svg') !!}
                    </div>

                    {{--                    <div class="border-b border-gray-400 my-4"></div>--}}

                    <ul class="flex-1 list-disc list-inside flex flex-col gap-2 max-w-sm">
                        <li>Nakupte kredity</li>
                        <li>Vyfoťte zboží</li>
                        <li>Popište aktuální stav, množství, velikosti, barva – čím více informací, tím větší
                            pravděpodobnost úspěšného prodeje
                        </li>
                        <li>Využij možností VIP inzerátů pro rychlejší odbyt</li>
                    </ul>

                    <div>
                        <x-button-link href="{{ route('listings.create') }}">Přidat inzerát</x-button-link>
                    </div>
                </div>

            </div>
        </x-inner-container>
    </x-container>


    <x-container class="mb-8">
        <x-inner-container class="relative">
            <div
                class="hidden md:block absolute bottom-1/2 right-6 lg:right-24 transform translate-y-1/2 w-32 md:w-40 text-gray-300">
                {!! svg('icons/coins.svg') !!}
            </div>

            <header class="relative mb-4">
                <h2 class="text-3xl font-bold">Jak fungují kredity?</h2>
            </header>

            <p class="relative max-w-xl">
                Kredity jsou klíčem k propojení vás s inzerující osobou a naopak. Zakoupením kreditů získáte možnost
                nahlédnout na jednotlivé inzeráty, o které máte zájem. Po odemčení se vám zobrazí chat s inzerující
                osobou, telefonní číslo na inzerce a bližší informace o produktech.
            </p>

            <x-button-link class="mt-4" href="{{ route('credits.index') }}">Více o kreditech</x-button-link>
        </x-inner-container>
    </x-container>


    <x-container>
        <x-inner-container>
            <header class="mb-8">
                <h2 class="text-3xl lg:text-center font-bold">Často kladené otázky</h2>
            </header>

            <x-faq/>
        </x-inner-container>
    </x-container>

</x-app-layout>
