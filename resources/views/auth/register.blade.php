@section('title',  title('Registrace'))
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrace
        </h1>
    </x-slot>
    <x-container>
        <x-inner-container class="sm:max-w-md m-auto text-center flex flex-col gap-6">
            <header>
                <h1 class="text-3xl font-bold">Registrujte se zdarma a začněte vydělávat</h1>
            </header>

            <p>Vyberte typ účtu:</p>

            <div class="flex gap-4">
                <a href="{{ route('register-personal') }}"
                   class="flex-1 fake-square bg-red-500 text-white border-4 border-red-500 hover:bg-white hover:text-red-500">
                    <div class="absolute-center w-10 md:w-12 flex flex-col gap-4 pt-4 items-center">
                        {!! svg('icons/user.svg') !!}
                        <strong class="uppercase">Osobní</strong>
                    </div>
                </a>
                <a href="{{ route('register-company') }}"
                   class="flex-1 fake-square bg-red-500 text-white border-4 border-red-500 hover:bg-white hover:text-red-500">
                    <div class="absolute-center w-10 md:w-12 flex flex-col gap-4 pt-4 items-center">
                        {!! svg('icons/company.svg') !!}
                        <strong class="uppercase">Firemní</strong>
                    </div>
                </a>
            </div>

            <p class="text-center text-sm text-gray-600 leading-none">
                Máte už účet?
                <a class="underline hover:no-underline hover:text-gray-900" href="{{ route('login') }}">
                    Přihlaste se zde
                </a>
            </p>
        </x-inner-container>
    </x-container>
</x-app-layout>
