@section('title', title('Často kladené otázky (FAQ)'))
<x-app-layout>
    <x-slot name="header">
        <div class="md:flex-grow flex items-center justify-start">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Často kladené otázky
            </h1>
        </div>
    </x-slot>

    <x-container>
        <x-inner-container>
            <x-faq/>
        </x-inner-container>
    </x-container>

</x-app-layout>
