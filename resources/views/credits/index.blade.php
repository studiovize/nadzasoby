@section('title', title('Kredity'))
<x-app-layout>
    <div class="flex flex-col gap-8">
        <x-container>
            <x-inner-container>
                <div class="flex flex-col md:flex-row gap-8 md:gap-4 w-full justify-between md:items-center">

                    <div class="flex-1 flex flex-col gap-6">
                        <header>
                            <h1 class="text-4xl font-bold">Jak fungují kredity?</h1>
                        </header>
                        <p class="text-base">
                            Kredity jsou klíčem k propojení vás s inzerující osobou a naopak. Zakoupením kreditů získáte
                            možnost nahlédnout na jednotlivé inzeráty, o které máte zájem. Po odemčení se vám zobrazí
                            chat s inzerující osobou, telefonní číslo na inzerce a bližší informace o produktech.
                        </p>
                    </div>

                    <div class="flex-1 md:text-center">
                        @auth
                            <header class="mb-4">
                                <h2 class="text-2xl font-bold">Stav kreditů</h2>
                            </header>

                            <strong class="text-5xl">{{ auth()->user()->credit_amount }}</strong>

                            @if(auth()->user()->credit_amount > 0)
                                <p class="text-base mt-4">Vaše kredity
                                    vyprší {{ auth()->user()->credit_expiration }}</p>
                            @endif
                        @endauth
                    </div>

                </div>
            </x-inner-container>
        </x-container>

        <x-container>
            <x-inner-container class="flex flex-col gap-6">
                <header>
                    <h2 class="text-4xl font-bold">Doplnit kredity</h2>
                </header>

                <div class="flex flex-col lg:flex-row w-full justify-between gap-4">
                    @foreach($plans as $plan)
                        <article class="flex-1 bg-gray-100 p-6 round2ed-xl border">
                            <header class="text-center mb-4">
                                @if($plan->credits === 999)
                                    <div class="w-9 mx-auto">
                                        {!! svg('icons/infinity.svg') !!}
                                    </div>
                                @else
                                    <h3 class="text-3xl font-bold">{{ $plan->credits }}</h3>
                                @endif
                                <p>kreditů</p>
                            </header>
                            <hr>
                            <ul class="list-disc list-inside mt-4">
                                @if($plan->credits === 999)
                                    <li><b>Neomezený kredit</b></li>
                                @else
                                    <li><b>{{ $plan->extra }}</b> kreditů navíc zdarma</li>
                                @endif
                                <li>Expirace kreditů za {{ $plan->length }} měsíce od zakoupení</li>
                            </ul>

                            <x-button-link href="{{ route('plans.show', ['plan' => $plan->credits]) }}"
                                           class="w-full mt-4"
                                           data-price="{{ $plan->price }}"
                                           data-amount="{{ $plan->credits }}"
                            >
                                Koupit za {{ $plan->price }},- Kč
                            </x-button-link>
                        </article>
                    @endforeach

                </div>

                <p class="text-center leading-none">
                    Uvedené ceny jsou včetně DPH.
                </p>
            </x-inner-container>
        </x-container>
    </div>
</x-app-layout>
