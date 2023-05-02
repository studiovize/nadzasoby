@section('title',  title($thread->subject . ' - Zpráva'))
<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $thread->subject }}
        </h1>
    </x-slot>

    <x-container>
        <x-inner-container class="flex py-0 px-0 justify-between">
            <div class="w-full md:w-1/3 hidden md:flex border-r-2 p-6 flex-col gap-4">
                @each('messenger.partials.thread', $threads, 'thread', 'messenger.partials.no-threads')
            </div>

            <div class="w-full 2md:w-2/3 flex flex-col gap-4 justify-between">
                <div class="bg-red-500 text-white p-4">
                    Inzerát: <a href="{{ route('listings.show', $listing) }}"
                                class="font-bold underline hover:no-underline">{{ $listing->title }}</a>
                </div>

                <div class="flex flex-col gap-4 items-start p-6">
                    @each('messenger.partials.messages', $thread->messages, 'message')
                </div>

                @include('messenger.partials.form-message')
            </div>
        </x-inner-container>
    </x-container>
</x-app-layout>
