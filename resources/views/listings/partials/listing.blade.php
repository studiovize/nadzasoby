<div
    class="max-w-sm pb-2 flex flex-col gap-4 pb-4 @if($listing->is_highlighted) ring-4 ring-red-400 @else border @endif transform hover:scale-105 hover:shadow-lg transition-all">
    <a href="{{ route('listings.show', ['listing' => $listing->slug]) }}" class="block relative">
        @if($listing->thumb)
            <x-thumb src="{{ $listing->thumb }}" alt="{{ $listing->title }}"/>
        @else
            <x-no-thumb/>
        @endif

        @if($listing->is_highlighted)
            <x-top/>
        @endif
    </a>

    <div class="w-full flex flex-col px-4 gap-4">
        <div class="flex flex-col gap-2 items-start flex-1">
            <p class="text-xs font-bold uppercase text-gray-400">{{ $listing->type === 'buy' ? 'Poptávka' : 'Nabídka' }}</p>
            <a href="{{ route('listings.show', ['listing' => $listing->slug]) }}" class="block font-bold text-xl">
                {{ $listing->title }}
            </a>

            <p class="text-gray-700 text-base text-left">
                {{ $listing->excerpt }}
            </p>
        </div>

        <div class="flex flex-col gap-2 items-start">
            <a href="{{ route('listings.search', ['category' => $listing->category->id]) }}"
               class="inline-block bg-gray-200 rounded px-3 py-1 text-sm font-semibold text-gray-700 hover:bg-gray-300">
                {{ $listing->category->name }}
            </a>

            <p class="text-xl font-bold text-red-500">
                {{ $listing->price_for_humans }} @if($listing->show_price)<small
                    class="opacity-502 text-xs text-gray-500">@if($listing->tax_included)s DPH @else bez
                    DPH @endif</small>@endif
            </p>

            <p class="text-gray-700 text-xs">
                {{ $listing->created_at->diffForHumans() }}
            </p>
        </div>

        @if(Route::currentRouteName() === 'listings.approve')
            <div class="flex items-center gap-2 text-center items-center">
                <x-button-link href="{{ route('listings.approve.yes', ['listing' => $listing->slug]) }}"
                               theme="success"
                               class="flex-1"
                >
                    Schválit
                </x-button-link>
                <x-button-link href="{{ route('listings.approve.no', ['listing' => $listing->slug]) }}"
                               theme="error"
                               class="flex-1"
                >
                    Zamítnout
                </x-button-link>
            </div>
        @elseif(Route::currentRouteName() === 'listings.removed')
            <div class="flex items-center gap-2 text-center items-center">
                <x-button-link href="{{ route('listings.approve.yes', ['listing' => $listing->slug]) }}"
                               theme="success"
                               class="flex-1"
                >
                    Schválit
                </x-button-link>
                <x-button-link href="{{ route('listings.remove', ['listing' => $listing->slug]) }}"
                               theme="error"
                               class="flex-1"
                >
                    Smazat
                </x-button-link>
            </div>
        @endif
    </div>
</div>
