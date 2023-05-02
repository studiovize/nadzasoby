@section('title',  title('Zapomenuté heslo'))
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Zapomenuté heslo
        </h1>
    </x-slot>
    <x-container>
        <x-inner-container class="sm:max-w-md m-auto">

            <div class="mb-4 text-sm text-gray-600">
                Zapomněli jste heslo? Žádný problém! Zadejte e-mail a my vám obratem zašleme odkaz pro obnovení hesla.
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')"/>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors"/>

            <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
                <div>
                    <x-label for="email" value="E-mail"/>

                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                             required autofocus/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button>
                        Poslat odkaz na e-mail
                    </x-button>
                </div>
            </form>

        </x-inner-container>
    </x-container>
</x-app-layout>
