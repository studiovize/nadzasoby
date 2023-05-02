@push('styles')
    <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}">
@endpush

@section('title', title($listing->title . ' - Inzerát'))
<x-app-layout>
    <x-slot name="header">
        <nav class="flex flex-wrap gap-2 text-gray-700 text-sm lg:text-base">
            @foreach($breadcrumbs['items'] as $crumb)
                <a href="{{ $crumb['link'] }}" class="underline hover:no-underline">
                    {{ $crumb['label'] }}
                </a>
                {!! $breadcrumbs['divider'] !!}
            @endforeach
            <div>
                {{ $listing->title }}
            </div>
        </nav>
    </x-slot>

    @if($listing->is_waiting_for_approval)
        <x-container class="mb-4">
            <div class="font-medium text-sm text-red-500 bg-red-500 bg-opacity-20 p-3">
                Tento inzerát čeká na schválení.
            </div>
        </x-container>
    @endif

    <x-container>
        <x-inner-container
            class="relative flex flex-wrap md:flex-nowrap gap-8 {{ $listing->is_highlighted ? 'ring-4 ring-red-400' : '' }}">
            @if($listing->is_highlighted)
                <x-top class="left-auto right-0"/>
            @endif

            <div class="w-full md:w-1/2">
                @if($listing->thumb)
                    <div class="h-auto lg:h-96 bg-gray-100">
                        <a href="{{ asset('uploads/' . $listing->images[0]) }}" data-lightbox="gallery">
                            <img src="{{ $listing->thumb }}" alt="" class="w-full h-full object-cover">
                        </a>
                    </div>

                    @if(is_array($listing->images) && count($listing->images) > 1)
                        <div class="grid grid-cols-4 gap-4 mt-4">
                            @foreach($listing->images as $key => $image)
                                @if($key !== 0)
                                    <a href="{{ asset('uploads/' . $image) }}"
                                       class="relative block w-full pb-full rounded-2xl" data-lightbox="gallery">
                                        <img data-lazy="{{ asset('uploads/' . $image) }}" alt=""
                                             class="absolute w-full h-full object-cover">
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="h-auto lg:h-96 bg-gray-100 flex">
                        <x-no-thumb class="m-auto"/>
                    </div>
                @endif
            </div>

            <div class="content w-full md:w-1/2 flex flex-col items-start gap-6">
                <div class="flex w-full items-center justify-between gap-4">
                    <div class="flex flex-wrap gap-4">
                        <x-tag :compact="true" theme="gray" :uppercase="true">{{ $listing->type_for_humans }}</x-tag>

                        @if(!$listing->is_approved)
                            <x-tag :compact="true" theme="red" :uppercase="true">Neschválený</x-tag>
                        @endif

                        @if($listing->is_approved && !$listing->is_active)
                            <x-tag :compact="true" theme="red" :uppercase="true">Neaktivní</x-tag>
                        @endif

                        @if(!$listing->belongs_to_current_user && $listing->is_unlocked)
                            <x-tag :compact="true" theme="green" :uppercase="true">Odemčeno</x-tag>
                        @endif
                    </div>
                    <div>
                        @if(Auth::check() && ($listing->belongs_to_current_user || Auth::user()->hasRole('admin')))
                            <div>
                                <x-button-icon theme="gray" href="{{ route('listings.edit', ['listing' => $listing->slug]) }}"
                                tooltip="Upravit">
                                    {!! svg('icons/edit.svg') !!}
                                </x-button-icon>
                            </div>
                        @endif
                    </div>
                </div>

                <header class="flex flex-col gap-2">
                    <h1 class="font-semibold text-4xl text-gray-800 leading-none">
                        {{ $listing->title }}
                    </h1>
                    @role('admin')
                    <p class="text-sm text-gray-500">
                        Uživatel: {{ $listing->user->name }} ({{ $listing->user->email }})
                    </p>
                    @endrole
                </header>

                <div class="md-formatted flex flex-col gap-4 w-full text-lg">
                    {!! $listing->content !!}
                </div>

                <div class="pt-6 w-full border-t-2">
                    <x-detail-row left="Množství:" right="{{ $listing->amount_for_humans }}"/>

                    <x-detail-row left="Stav:" right="{{ $listing->condition->name }}"/>

                    <x-detail-row left="Okres:">
                        <span class="block">{{ $listing->area->name }}</span>
                        @if(!$listing->is_unlocked)
                            <a class="inline-flex text-sm underline hover:no-underline text-red-600 leading-normal"
                               href="{{ route('listings.confirm-unlock', ['listing' => $listing->slug ]) }}">
                                (zobrazit celý kontakt)
                            </a>
                        @endif
                    </x-detail-row>

                    @if($listing->is_unlocked)
                        <x-detail-row left="Telefon:" right="{{ $listing->phone }}"/>
                    @endif

                    <x-detail-row left="Zobrazeno:" right="{{ $listing->views }}x"/>

                    <x-detail-row left="Datum vložení:" right="{{ $listing->created_at->format('d.m.Y \v H:i') }}"/>

                    <x-detail-row left="Cena:">
                        <span class="text-3xl font-bold text-red-500">
                            {{ $listing->price_for_humans }}
                            @if($listing->show_price)
                                <small class="text-xs text-gray-500">
                                    @if($listing->tax_included)
                                        s DPH
                                    @else
                                        bez DPH
                                    @endif
                                </small>
                            @endif
                        </span>
                    </x-detail-row>
                </div>

                @auth
                    <div class="w-full flex flex-col gap-2">
                        <div class="flex flex-col md:grid grid-cols-2 items-end gap-2">
                            @if(!$listing->belongs_to_current_user)
                                <x-button-link href="{{ route('listings.apply', ['listing' => $listing->slug ]) }}"
                                               class="w-full">Odpovědět @if(!$listing->is_unlocked)(1 kredit)@endif
                                </x-button-link>
                            @endif
                            @if($listing->waiting_for_approval)
                                <div class="p-4 rounded bg-green-100 text-green-700 font-bold w-full">
                                    Inzerát čeká na schválení.
                                </div>
                            @endif

                            @if($listing->belongs_to_current_user || Auth::user()->hasRole('admin'))
                                @if($listing->is_active)
                                    <x-button-link
                                        href="{{ route('listings.make-inactive', ['listing' => $listing->slug ]) }}"
                                        class="w-full" theme="ghost">Označit jako neaktivní
                                    </x-button-link>
                                @else
                                    <x-button-link
                                        href="{{ route('listings.make-active', ['listing' => $listing->slug ]) }}"
                                        class="w-full" theme="ghost">Označit jako aktivní
                                    </x-button-link>
                                @endif
                            @endif

                            @if($listing->belongs_to_current_user && !$listing->is_highlighted)
                                <x-button-link href="{{ route('listings.highlight-confirm', $listing) }}"
                                               class="w-full" theme="primary">Topovat
                                </x-button-link>
                            @endif
                        </div>
                        <div class="flex flex-col md:grid grid-cols-2 items-end gap-2">
                            @can('approve listings')
                                {{--                            <div class="flex flex-col md:flex-row gap-2 md:items-center text-center w-full">--}}
                                @if(!$listing->is_approved)
                                    <x-button-link
                                        theme="success"
                                        href="{{ route('listings.approve.yes', ['listing' => $listing->slug]) }}"
                                        class="flex-1">
                                        Schválit
                                    </x-button-link>
                                @else
                                    <x-button-link
                                        theme="error"
                                        href="{{ route('listings.approve.no', ['listing' => $listing->slug]) }}"
                                        class="flex-1">
                                        Zamítnout inzerát
                                    </x-button-link>
                                @endif

                                @if($listing->is_removed)
                                    <x-button-link
                                        theme="error"
                                        href="{{ route('listings.remove', ['listing' => $listing->slug]) }}"
                                        class="flex-1">
                                        Smazat
                                    </x-button-link>
                                @endif
                                {{--                            </div>--}}
                            @endcan
                        </div>
                    </div>
                @else
                    <div class="p-4 bg-red-100 text-red-700 font-bold w-full">
                        Pro možnost odpovědi se musíte <a href="{{ route('login') }}"
                                                          class="underline hover:no-underline">přihlásit</a>.
                    </div>
                @endauth


                {{--                <div>--}}
                {{--  // Sdileni--}}
                {{--                </div>--}}
            </div>
        </x-inner-container>
        {{--            TODO: doporucene inzeraty--}}
    </x-container>
</x-app-layout>

@push('scripts')
    <script src="{{ asset('js/lightbox-plus-jquery.js') }}"></script>
@endpush
