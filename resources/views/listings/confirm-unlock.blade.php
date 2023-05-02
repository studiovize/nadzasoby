@section('title', title('Odemknout inzerát'))
<x-app-layout>
    {{--    <x-slot name="header">--}}
    {{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
    {{--            Odemknout inzerát--}}
    {{--        </h2>--}}
    {{--    </x-slot>--}}

    <x-container>
        <x-inner-container class="max-w-lg mx-auto text-center flex flex-col gap-4">

            <header>
                <h1 class="font-bold text-3xl">
                    Chcete odemknout tento inzerát za 1 kredit?
                </h1>
            </header>

            <p>
                Odemknutím inzerátu získate možnost odpovědět na inzerát a zobrazit jeho kontakt.
            </p>

            <div class="flex flex-col md:flex-row gap-2 items-center md:items-stretch justify-center">
                <form action="" method="post" class="inline-flex">
                    @csrf
                    <x-button>Odemknout inzerát</x-button>
                </form>
                <x-button-link theme="secondary" href="{{ route('listings.show', ['listing' => $listing]) }}">
                    Zpět k detailu
                </x-button-link>
            </div>

        </x-inner-container>
    </x-container>
</x-app-layout>
