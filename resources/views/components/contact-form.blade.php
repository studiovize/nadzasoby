<form action="{{ route('contact.store') }}" method="post"
      {!! $attributes->merge(['class' => 'flex flex-col gap-4']) !!} id="contact-form">
    @csrf
    <div class="flex flex-col gap-1">
        <x-label for="name" value="Jméno *"/>

        <x-input id="name" class="block w-full" type="text" name="name"
                 :value="old('name', Auth::check() ? Auth::user()->name : '')" required
                 autofocus/>
    </div>

    <div class="flex flex-col gap-1">
        <x-label for="email" value="E-mail *"/>

        <x-input id="email" class="block w-full" type="email" name="email"
                 :value="old('email', Auth::check() ? Auth::user()->email : '')"
                 required/>
    </div>

    <div class="flex flex-col gap-1">
        <x-label for="message" value="Zpráva *"/>

        <x-textarea id="message" class="block w-full" name="message"
                    required>{{ old('message') }}</x-textarea>
    </div>

    <x-button type="submit">
        Odeslat
    </x-button>

    <aside
        class="result absolute top-0 left-0 w-full h-full z-10 bg-white text-center">
        <div class="result-success flex flex-col gap-4 absolute top-0 left-0 w-full h-full flex flex-col items-center justify-center ">
            <div class="w-12 mx-auto text-green-500">
                {!! svg('icons/success.svg') !!}
            </div>
            <header class="max-w-md">
                <h2 class="text-xl font-bold">Děkujeme!</h2>
            </header>
            <p class="max-w-md">
                Vaše zpráva byla úspěšně odeslána.<br>V nejbližší době vám odpovíme.
            </p>
        </div>

        <div class="result-error flex flex-col gap-4 absolute top-0 left-0 w-full h-full flex flex-col items-center justify-center ">
            <div class="w-12 mx-auto text-red-500">
                {!! svg('icons/error.svg') !!}
            </div>
            <header class="max-w-md">
                <h2 class="text-xl font-bold">Chyba</h2>
            </header>
            <p class="max-w-md">
                Během odesílání zprávy došlo k chybě, zkuste to prosím znovu, nebo nám pošlete e-mail na <a
                    href="mailto:info@nadzasoby.cz" class="underline hover:no-underline">info@nadzasoby.cz</a>. Omlouváme se za potíže.
            </p>
        </div>
    </aside>
</form>
