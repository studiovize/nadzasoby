@php
    $is_unread = $thread->isUnread(Auth::id());
    $is_active = (int) request()->route()->id === $thread->id
@endphp
<a href="{{ route('messages.show', $thread->id) }}"
   class="relative bg-white rounded-lg border-2 p-4 {{ $is_unread ? 'border-gray-400 font-bold ' : '' }} {{ $is_active ? 'bg-gray-100' : '' }}">
    @if($is_unread)
        <div class="absolute -top-2 -right-2 rounded-full w-4 h-4 bg-red-500"></div>
    @endif
    <header>
        <h4>
            {{ $thread->subject }}
            {{--            @if($is_unread)({{ $thread->userUnreadMessagesCount(Auth::id()) }})@endif--}}
        </h4>
    </header>
    {{--    <p>--}}
    {{--        {{ $thread->latestMessage->body }}--}}
    {{--    </p>--}}
    <p class="text-xs font-bold">
        {{ $thread->creator()->name }}
    </p>
</a>
