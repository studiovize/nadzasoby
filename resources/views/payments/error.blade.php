@section('title',  title('Chyba'))
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Chyba
        </h1>
    </x-slot>

    <x-container class="mb-8">
        <x-inner-container class="max-w-lg mx-auto">
            <header>
                <h1 class="text-4xl font-bold">Během zpracování platby došlo k chybě</h1>
            </header>

            <p class="text-base mt-4 mb-4">
                Při placení došlo k chybě, prosíme, zkuste to znovu.
            </p>

            <pre class="p-4 bg-gray-100 rounded-lg text-sm">{{ $message }}</pre>
        </x-inner-container>
    </x-container>
</x-app-layout>
