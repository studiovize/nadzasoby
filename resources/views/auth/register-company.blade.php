@section('title',  title('Registrace - Firemní účet'))
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrace
        </h1>
    </x-slot>
    <x-container>
        <x-inner-container class="sm:max-w-md m-auto flex flex-col gap-4">
            <h1 class="text-3xl font-bold text-center">Firemní účet</h1>

            <!-- Validation Errors -->
            <x-auth-validation-errors :errors="$errors"/>

            <form method="POST" action="{{ route('register-company') }}" class="flex flex-col gap-4">
            @csrf
            <!-- Name -->
                <div class="flex flex-col gap-1">
                    <x-label for="name" value="Jméno *"/>

                    <x-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required
                             autofocus/>
                </div>

                <!-- Email Address -->
                <div class="flex flex-col gap-1">
                    <x-label for="email" value="E-mail *"/>

                    <x-input id="email" class="block w-full" type="email" name="email" :value="old('email')"
                             required/>
                </div>

                <!-- Password -->
                <div class="flex flex-col gap-1">
                    <x-label for="password" value="Heslo *"/>

                    <x-input id="password" class="block w-full"
                             type="password"
                             name="password"
                             required autocomplete="new-password"/>
                </div>

                {{--                <!-- Confirm Password -->--}}
                <div class="flex flex-col gap-1">
                    <x-label for="password_confirmation" value="Potvrzení hesla *"/>

                    <x-input id="password_confirmation" class="block w-full"
                             type="password"
                             name="password_confirmation" required/>
                </div>

                {{-- Phone --}}
                <div class="flex flex-col gap-1">
                    <x-label for="phone" value="Telefon"/>

                    <x-input id="phone" class="block w-full"
                             type="text"
                             name="phone"/>
                </div>

                {{-- ICO --}}
                <div class="flex flex-col gap-1">
                    <x-label for="ico" value="IČO"/>

                    <x-input id="ico" class="block w-full"
                             type="text"
                             name="ico"
                             required/>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('register') }}" class="inline-flex gap-2 items-center">
                        <span class="w-4">
                                {!! svg('icons/arrow-left.svg') !!}
                        </span>
                        Zpět
                    </a>
                    <x-button>
                        Registrovat
                    </x-button>
                </div>
            </form>
        </x-inner-container>
    </x-container>
</x-app-layout>
