@section('title',  title('Kredity byly navýšeny'))
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Platba proběhla úspěšně
        </h1>
    </x-slot>

    <x-container class="mb-8">
        <x-inner-container>
            @if($payment->status === 'success')
                <header>
                    <h1 class="text-4xl font-bold">Vaše kredity byly navýšeny</h1>
                </header>

                <p class="text-base mt-4 mb-4">
                    Děkujeme za vaši platbu, na účet jsme vám připsali <b>{{ $payment->plan->total_credits }}
                        kreditů</b>. Nyní můžete přidávat inzeráty nebo odpovědět na kterýkoliv z naší pestré
                    nabídky.
                </p>

                <h2 class="text-xl font-bold">Co teď?</h2>

                <div class="mt-4 flex flex-col md:flex-row gap-2">
                    <x-button-link href="{{ route('listings.create') }}">Přidat inzerát</x-button-link>
                    <x-button-link href="{{ route('listings.search') }}" theme="secondary">Zobrazit nabídky
                    </x-button-link>
                </div>
                @if(env('APP_ENV') === 'production')
                    @push('scripts')
                        <script>
                            function handleGtmLoad() {
                                var data = {
                                    event: 'purchase',
                                    content_name: 'Kredity',
                                    currency: 'CZK',
                                    value: {{ $plan->price }},
                                    transaction_id: {{ $payment->id }},
                                    items: [
                                        {
                                            item_id: {{ $plan->credits }},
                                            item_name: '{{ $plan->credits }} kreditů',
                                            currency: 'CZK',
                                            price: {{ $plan->price }},
                                            discount: 0,
                                            quantity: 1
                                        }
                                    ]
                                };
                                window.sendToGtm(data)
                            }

                            window.addEventListener('load', handleGtmLoad);
                        </script>

                        <script type="text/javascript" src="https://c.seznam.cz/js/rc.js"></script>
                        <script>
                            var conversionConf = {
                                id: 100165506,
                                value: null
                            };

                            if (window.rc && window.rc.conversionHit) {
                                window.rc.conversionHit(conversionConf);
                            }
                        </script>
                    @endpush
                @endif
            @else
                <header>
                    <h1 class="text-4xl font-bold">Nastala chyba</h1>
                </header>

                <p class="text-base mt-4 mb-4">
                    Během připisování kreditů se stala chyba. Prosím, ozvěte se nám na e-mail <a
                        href="mailto:info@nadzasoby.cz" class="underline hover:no-underline">info@nadzasoby.cz</a>.
                    Omlouváme se za potíže.
                </p>
            @endif
        </x-inner-container>
    </x-container>
</x-app-layout>
