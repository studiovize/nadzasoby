@section('title', title(strip_tags($title)))
<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl text-gray-800 leading-tight">
            {!! $title !!}
        </h1>
    </x-slot>


    <x-container>
        <div class="flex flex-col lg:flex-row gap-4">
            <div class="w-full lg:w-1/4">
                @include('listings.partials.filters')
            </div>

            <div class="w-full lg:w-3/4 flex flex-col gap-4">
                <x-inner-container class="flex flex-col gap-6">
                    <div class="flex flex-col gap-8">

                        <div class="flex justify-end items-center gap-4">
                            <label for="pagination-change" class="leading-none text-sm">Počet výsledků na stránce:</label>
                            <div class="w-24">
                                @php
                                    $pagination_options = [6, 12, 24, 48, 96];
                                @endphp
                                <x-select name="pagination-change" id="pagination-change" data-form="filters-form">
                                    @foreach($pagination_options as $option)
                                        <option value="{{ $option }}"
                                                @if(isset($_GET['pagination']) && $_GET['pagination'] == $option) selected @endif
                                        >{{ $option }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                        </div>

                        <div
                            class="grid grid-cols-1 @if($listings->count() > 0) md:grid-cols-2 xl:grid-cols-3 @endif gap-8">
                            @each('listings.partials.listing', $listings, 'listing', 'listings.partials.no-listings')
                        </div>

                        @if($listings->count() !== 0)
                            <div>
                                {{ $listings->links() }}
                            </div>
                        @endif
                    </div>
                </x-inner-container>
            </div>
        </div>
    </x-container>
</x-app-layout>
