@section('title', title('Odpovědět na inzerát'))
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Odpovědět na inzerát
        </h2>
    </x-slot>

    <x-container>
        <x-inner-container class="sm:max-w-3xl m-auto">
            <form action="{{ route('messages.store') }}" method="post">
                @csrf
                <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                <div class="mb-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="subject">
                        Předmět
                    </label>
                    <x-input class="w-full"
                             value="Odpověď na {{ $listing->title }}"
                             id="subject"
                             name="subject"
                             type="text"
                             disabled
                    />
                </div>

                <div class="mb-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="message">
                        Zpráva
                    </label>
                    <textarea
                        class="appearance-none block w-full py-3 px-4 h-32 border-gray-300 focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50"
                        id="message" name="message" autofocus></textarea>
                </div>

                <div class="flex gap-4 items-center justify-between">
                    <a href="{{ route('listings.show', $listing) }}" class="underline hover:no-underline">< Zpět k inzerátu</a>
                    <x-button type="submit">Odeslat</x-button>
                </div>

            </form>
        </x-inner-container>
    </x-container>
</x-app-layout>
