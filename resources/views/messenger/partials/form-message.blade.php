<form action="{{ route('messages.update', $thread->id) }}" method="post" class="border-t-2 p-6">
    <div class="flex gap-4 items-start">
    {{ method_field('put') }}
    {{ csrf_field() }}

    <!-- Message Form Input -->
        <div class="flex-grow w-full">
            <x-input name="message" type="text" class="w-full py-3" value="{{ old('message') }}"/>
        </div>

    {{--    @if($users->count() > 0)--}}
    {{--        <div class="checkbox">--}}
    {{--            @foreach($users as $user)--}}
    {{--                <label title="{{ $user->name }}">--}}
    {{--                    <input type="checkbox" name="recipients[]" value="{{ $user->id }}">{{ $user->name }}--}}
    {{--                </label>--}}
    {{--            @endforeach--}}
    {{--        </div>--}}
    {{--@endif--}}

    <!-- Submit Form Input -->
        <div class="flex-grow-0">
            <x-button type="submit">
                Odeslat
            </x-button>
        </div>
    </div>
</form>
