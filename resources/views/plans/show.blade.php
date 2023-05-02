@section('title',  title('Doplnit kredity'))
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Doplnit kredity
        </h1>
    </x-slot>

    <section class="w-full max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">


                <table class="table-fixed w-full">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 w-1/3 rounded-l-lg text-left">Množství kreditů</th>
                        <th class="p-4 w-1/3 text-left">Kredity navíc</th>
                        <th class="p-4 rounded-r-lg text-right">Cena</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="p-4">
                            @if($plan->credits === 999)
                                Neomezené
                            @else
                                {{ $plan->credits }}
                            @endif
                        </td>
                        <td class="p-4">{{ $plan->extra }}</td>
                        <td class="text-right p-4">{{ $plan->price }},- Kč</td>
                    </tr>
                    <tr class="border-t-2">
                        <td colspan="3" class="text-right p-4 text-lg">Celkem: <b>{{ $plan->price }},- Kč</b></td>
                    </tr>
                    </tbody>
                </table>

                <div class="flex justify-end">
                    <x-button-link href="{{ route('payments.create', $plan) }}">Přejít k platební bráně</x-button-link>
                </div>

            </div>
        </div>

    </section>
</x-app-layout>
