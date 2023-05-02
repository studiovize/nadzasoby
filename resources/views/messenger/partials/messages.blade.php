@php
$my_message = $message->user->id === request()->user()->id;
@endphp
<section
    class="rounded-lg {{ $my_message ? 'bg-gray-100 border-gray-200 text-right self-end rounded-br-none' : 'bg-red-100 border-red-200 rounded-bl-none'  }} border-2 p-4 max-w-sm">
    <header class="mb-2">
        <h5 class="font-bold text-sm">{{ $message->user->short_name }}</h5>
    </header>
    <p class="text-base mb-2">{{ $message->body }}</p>

    <p class="text-xs">
        {{ $message->created_at->diffForHumans() }}
    </p>
</section>
