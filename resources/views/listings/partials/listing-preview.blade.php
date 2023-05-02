<div
    class="w-full max-w-sm pb-2 flex flex-col gap-4 pb-4 @if($listing->is_highlighted) ring-4 ring-red-400 @else border @endif">
    <div class="block relative">
        @if($listing->thumb)
            <img class="w-full h-64 object-cover object-center"
                 src="{{ $listing->thumb }}" alt="{{ $listing->title }}">
        @else
            <div class="w-full h-64 flex bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 455 455"
                     xml:space="preserve" class="m-auto" fill='#D1D1D1'><path
                        d="M361 131a8 8 0 0 0-3 14l2 3v160c0 1-1 2-3 2H180a7 7 0 1 0 0 15h178c9 0 17-8 17-17V148c0-9-6-16-14-17zM275 130H98c-10 0-18 8-18 18v160c0 8 5 15 13 17a8 8 0 0 0 9-6c1-4-1-8-5-9l-2-2V148c0-2 1-3 3-3h177a7 7 0 1 0 0-15z"/>
                    <path
                        d="m235 171-8-1a58 58 0 0 0-56 66 8 8 0 0 0 14-2v-6a43 43 0 0 1 48-42 7 7 0 1 0 2-15zM219 285h9a58 58 0 0 0 56-66 8 8 0 0 0-14 3v6a43 43 0 0 1-49 42 7 7 0 1 0-2 15zM319 203a17 17 0 0 0 2-33c-3 0-5 1-7 3l-10 10-2 6c1 8 8 14 17 14zM118 115h30a7 7 0 1 0 0-15h-30a7 7 0 1 0 0 15z"/>
                    <path
                        d="M388 67a226 226 0 0 0-321 0 226 226 0 0 0 0 321 226 226 0 0 0 321 0 226 226 0 0 0 0-321zM15 228A213 213 0 0 1 372 72L72 372c-35-38-57-89-57-144zm213 212c-56 0-107-22-145-57L383 83a212 212 0 0 1-155 357z"/></svg>
            </div>
        @endif
        @if($listing->is_highlighted)
            <x-top/>
        @endif
    </div>

    <div class="px-4 flex flex-col gap-2 items-start flex-1 mb-4">
        <p class="block font-bold text-xl">
            {{ $listing->title }}
        </p>

        <p class="text-gray-700 text-base text-left">
            {{ $listing->excerpt }}
        </p>
    </div>

    <div class="px-4 flex flex-col gap-2 items-start">
        <p class="inline-block bg-gray-200 rounded px-3 py-1 text-sm font-semibold text-gray-700">
            {{ $listing->category->name }}
        </p>

        <p class="text-xl font-bold text-red-500">
            {{ $listing->price_for_humans }}
            @if($listing->show_price)
                <small class="opacity-502 text-xs text-gray-500">
                    @if($listing->tax_included)s DPH @else bez DPH @endif
                </small>
            @endif
        </p>

        <p class="text-gray-700 text-xs">
            {{ $listing->created_at->diffForHumans() }}
        </p>
    </div>
</div>
