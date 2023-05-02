@section('title', title('Uživatel: '. $user->name))
<x-app-layout>
    <x-slot name="header">
        <div class="md:flex-grow flex items-center justify-start">
            <x-title>Uživatel: <b>{{ $user->name }}</b></x-title>
        </div>
    </x-slot>

    <x-container class="flex flex-col gap-4">
        <div>
            <x-button-link href="{{ route('admin.users') }}"
                           class="gap-2 hover:bg-red-500 hover:text-white"
                           theme="outline"
                           size="small"
            ><span class="w-4">{!! svg('icons/arrow-left.svg') !!}</span> Zpět na výpis uživatelů
            </x-button-link>
        </div>

        <div class="grid gap-4 grid-col-1 md:grid-cols-2">
            <section class="bg-white border-b-2 p-6 flex flex-col items-stretch gap-3">
                <header>
                    <h2 class="font-bold text-2xl">Osobní údaje</h2>
                </header>

                <div>
                    <x-detail-row left="ID" :right="$user->id"/>
                    <x-detail-row left="Role" :right="$user->role"/>
                    <x-detail-row left="Jméno" :right="$user->name"/>
                    <x-detail-row left="E-mail">
                        <a href="mailto:{{ $user->email }}" class="text-red-500 underline hover:no-underline font-bold"
                        >{{ $user->email }}</a>
                    </x-detail-row>
                    <x-detail-row left="Telefon" :right="$user->phone"/>
                    <x-detail-row left="Typ účtu" :right="$user->type"/>
                    <x-detail-row left="IČO" :right="$user->ico"/>
                    <x-detail-row left="Datum registrace" :right="$user->created_at"/>
                </div>
            </section>

            <div class="bg-white border-b-2 p-6 flex flex-col gap-6">
                <section class="flex flex-col gap-3">
                    <header>
                        <h2 class="font-bold text-2xl">Kredity</h2>
                    </header>
                    <div>
                        <x-detail-row left="Aktuální počet" :right="$credit->amount"/>
                        <x-detail-row left="Expirace" :right="$credit->expiration_date"/>
                    </div>
                </section>

                <section class="flex flex-col gap-3">
                    <header>
                        <h2 class="font-bold text-2xl">Pohyby kreditů</h2>
                    </header>

                    @if($spending_history->count() === 0)
                        <p>Žádné pohyby.</p>
                    @else
                        <table class="w-full border border-collapse text-sm">
                            <tr>
                                <th class="border border-gray-200 p-2 text-left">Datum</th>
                                <th class="border border-gray-200 p-2 text-left">Detaily</th>
                            </tr>
                            @foreach($spending_history as $history_row)
                                <tr class="hover:bg-gray-100">
                                    <td class="border border-gray-200 p-2" valign="middle">
                                        {{ $history_row->created_at }}
                                    </td>
                                    <td class="border border-gray-200 p-2 text-ellipsis" valign="middle">
                                        {!! $history_row->data !!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </section>
            </div>

            <section class="bg-white border-b-2 p-6 flex flex-col gap-3">
                <header>
                    <h2 class="font-bold text-2xl">Platby</h2>
                </header>

                @if($payments->count() === 0)
                    <p>Žádné platby.</p>
                @else
                    <table class="w-full border border-collapse text-sm">
                        <tr>
                            <th class="border border-gray-200 p-2 text-left">Datum</th>
                            <th class="border border-gray-200 p-2 text-center">Kredity</th>
                            <th class="border border-gray-200 p-2 text-right">Částka</th>
                        </tr>
                        @foreach($payments as $payment)
                            {{--                            @dd($history_row)--}}
                            <tr class="hover:bg-gray-100">
                                <td class="border border-gray-200 p-2" valign="middle">
                                    {{ $payment->created_at }}
                                </td>
                                <td class="border border-gray-200 p-2 text-center" valign="middle">
                                    {{ $payment->credits }} + {{ $payment->extra }}
                                </td>
                                <td class="border border-gray-200 p-2 text-right" valign="middle">
                                    {{ $payment->price_formatted }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="border border-gray-200 p-2 font-bold" colspan="2">
                                Celkem
                            </td>
                            <td class="border border-gray-200 p-2 text-right font-bold">
                                {{ $total_paid }}
                            </td>
                        </tr>
                    </table>
                @endif

            </section>

            <section class="bg-white border-b-2 p-6 flex flex-col gap-3">
                <header>
                    <h2 class="font-bold text-2xl">Inzeráty</h2>
                </header>

                @if($listings->count() === 0)
                    <p>Žádné inzeráty.</p>
                @else
                    <table class="w-full border border-collapse text-sm">
                        <tr>
                            <th class="border border-gray-200 p-2 text-left">Datum</th>
                            <th class="border border-gray-200 p-2 text-left">Stav</th>
                            <th class="border border-gray-200 p-2 text-left">Název</th>
                        </tr>

                        @foreach($listings as $listing)
                            {{--                            @dd($history_row)--}}
                            <tr class="hover:bg-gray-100">
                                <td class="border border-gray-200 p-2" valign="middle">
                                    {{ $listing->created_at }}
                                </td>
                                <td class="border border-gray-200 p-2" valign="middle">
                                    {{ $listing->status }}
                                </td>
                                <td class="border border-gray-200 p-2 text-ellipsis" valign="middle">
                                    <a href="{{ $listing->link }}"
                                       class="text-red-500 underline hover:no-underline font-bold">{{ $listing->title }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </section>
        </div>

        <section class="bg-white border-b-2 p-6 flex flex-col items-stretch gap-3 justify-between">
            <header>
                <h2 class="font-bold text-2xl">Historie</h2>
            </header>
            @if($history->count() === 0)
                <p>Žádná historie.</p>
            @else
                <table class="w-full border border-collapse text-sm">
                    <tr>
                        <th class="border border-gray-200 p-2 text-left">Datum</th>
                        <th class="border border-gray-200 p-2 text-left">Událost</th>
                        <th class="border border-gray-200 p-2 text-left">Detaily</th>
                    </tr>
                    @foreach($history as $history_row)
                        {{--                            @dd($history_row)--}}
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-200 p-2" valign="middle">
                                {{ $history_row->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td class="border border-gray-200 p-2" valign="middle">
                                {{ getTrackerActionForHumans($history_row->action) }}
                            </td>
                            <td class="border border-gray-200 p-2 text-ellipsis" valign="middle">
                                {!! getTrackerDataForHumans($history_row) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </section>
    </x-container>

</x-app-layout>
