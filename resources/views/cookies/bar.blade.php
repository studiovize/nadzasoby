<aside
    class="fixed bottom-0 left-0 w-full h-[calc(100vh-65px)] bg-white z-20 shadow-2xl pt-12 pb-6 px-6 transition-transform duration-500 justify-between flex"
    id="cookie-bar"
>
    <div class="flex flex-col sm:flex-row sm:items-center gap-6 w-full max-w-2xl m-auto">
        <div class="flex flex-col gap-2">
            <header>
                <h3 class="font-bold">Používáme soubory cookies</h3>
            </header>

            <p class="text-sm max-w-sm2">
                Soubory cookies používáme k analýze návštěvnosti a ke zlepšení webových stránek.
            </p>

            <div class="flex gap-4">
                <a href="{{ route('cookies.settings') }}" class="underline hover:no-underline">Nastavení</a>
                <a href="{{ asset('docs/zasady_ochrany_osobnich_udaju.pdf') }}" target="_blank"
                   rel="noreferrer nofollow"
                   class="underline hover:no-underline">O cookies</a>
            </div>
        </div>

        <div class="flex-shrink-0 flex flex-col items-stretch gap-2">
            <x-button id="cookie-bar-accept">Příjmout všechny</x-button>
            <x-button theme="secondary" id="cookie-bar-deny">Odmítnout všechny</x-button>
        </div>

        <button class="absolute top-3 right-6 w-6 h-6 text-gray-400 hover:text-gray-600 transition-colors duration-200"
                id="cookie-bar-close"
        >
            {!! svg('icons/close.svg') !!}
        </button>
    </div>
</aside>

@push('scripts')
    <script src="{{ mix('js/cookies.js') }}"></script>
@endpush
