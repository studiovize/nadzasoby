@section('title',  title('Přihlášení'))
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Přihlášení
        </h1>
    </x-slot>
    <x-container>
        <x-inner-container class="sm:max-w-md m-auto">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')"/>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors"/>

            <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
                <div>
                    <x-label for="email" value="E-mail"/>

                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                             required autofocus/>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-label for="password" value="Heslo"/>

                    <x-input id="password" class="block mt-1 w-full"
                             type="password"
                             name="password"
                             required autocomplete="current-password"/>
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                               class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50"
                               name="remember">
                        <span class="ml-2 text-sm text-gray-600">Zapamatovat</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="text-sm text-gray-600 hover:text-gray-900 underline hover:no-underline"
                       href="{{ route('password.request') }}">
                        Zapomenuté heslo
                    </a>

                    <x-button class="ml-3">
                        Přihlásit
                    </x-button>
                </div>
            </form>
        </x-inner-container>
    </x-container>
</x-app-layout>
