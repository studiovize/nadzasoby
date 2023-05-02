@section('title', title('Přehled'))
<x-app-layout>
    <x-slot name="header">
        <div class="md:flex-grow flex items-center justify-start">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Přehled
            </h1>
        </div>
    </x-slot>

    <x-container>
        <div class="grid gap-4 grid-col-1 md:grid-cols-2 xl:grid-cols-3">
            <section class="bg-white border-b-2 p-6 flex flex-col items-stretch gap-3 justify-between">
                <header>
                    <h2 class="font-bold text-2xl">Stav kreditu: {{ auth()->user()->credit_amount }}</h2>
                </header>

                <p>
                    @if(auth()->user()->credit_amount > 0)
                        Vaše kredity vyprší <b>{{ auth()->user()->credit_expiration }}</b>
                    @endif
                </p>

                <div class="flex items-start flex-wrap gap-x-4 gap-y-2 sm:gap-y-4">
                    <x-button-link href="{{ route('credits.index') }}">
                        Koupit kredity
                    </x-button-link>
                </div>
            </section>

            <section class="bg-white border-b-2 p-6 flex flex-col items-start gap-3">
                <header class="flex-1">
                    <h2 class="font-bold text-2xl">Inzeráty</h2>
                </header>
                <p class="text-base">
                    @php $active_listings_count = auth()->user()->active_listings->count() @endphp
                    Máte <b>{{ $active_listings_count }}</b>
                    {{ getPlural($active_listings_count, 'aktivní inzerát, ', 'aktivní inzeráty, ', 'aktivních inzerátů, ') }}
                    z toho <b>{{ auth()->user()->listings_for_approval->count() }}</b> čekají na schválení.
                </p>

                <div class="flex items-center flex-wrap gap-x-4 gap-y-2 sm:gap-y-4">
                    <x-button-link href="{{ route('listings.create') }}">
                        Přidat inzerát
                    </x-button-link>

                    <a href="{{ route('listings.my') }}" class="underline hover:no-underline">Spravovat inzeráty</a>
                </div>
            </section>

            <section class="bg-white border-b-2 p-6 flex flex-col">
                <header class="mb-3 flex-1">
                    <h2 class="font-bold text-2xl">Zprávy</h2>
                </header>
                <p class="text-base mb-3">
                    @php $unread_count = auth()->user()->newThreadsCount(); @endphp
                    @if($unread_count > 0)
                        Máte
                        <b>{{ $unread_count }}</b> {{ getPlural($unread_count, 'nepřečtenou zprávu.', 'nepřečtené zprávy.', 'nepřečtených zpráv.') }}
                    @else
                        Nemáte žádné nepřečtené zprávy.
                    @endif
                </p>

                <div class="flex items-start flex-wrap gap-x-4 gap-y-2 sm:gap-y-4">
                    <x-button-link href="{{ route('messages.index') }}" class="">
                        Zobrazit zprávy
                    </x-button-link>
                </div>
            </section>


        </div>

    </x-container>

</x-app-layout>
