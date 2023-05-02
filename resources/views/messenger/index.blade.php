@section('title', title('Zprávy'))
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Zprávy
        </h1>
    </x-slot>


    <x-container>
        <x-inner-container class="flex py-0">
{{--            @include('messenger.partials.flash')--}}

            <div class="w-full lg:w-1/3 lg:border-r-2 py-6 lg:pr-6 flex flex-col gap-4">
                @each('messenger.partials.thread', $threads, 'thread', 'messenger.partials.no-threads')
            </div>

            {{--            <div class="w-full md:w-2/3 p-6"></div>--}}
        </x-inner-container>
    </x-container>
</x-app-layout>
