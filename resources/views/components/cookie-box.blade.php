@props([
'required' => false,
'checked' => false
])

<label class="w-full flex gap-4 bg-white p-6 border-b-2 border-red-600" for="{{ $attributes->get('name') }}">
    <div>
        <label class="{{ $required ? 'disabled opacity-50' : '' }}" for="{{ $attributes->get('name') }}">
            <input type="checkbox"
                   class="bg-white border-2 border-red-500 text-red-500 focus:ring-red-200"
                   id="{{ $attributes->get('name') }}"
                   name="{{ $attributes->get('name') }}"
                {{ $required ? 'disabled' : '' }}
                {{ ($checked || $required) ? 'checked' : '' }}
            >
        </label>
    </div>

    <div class="flex-1 flex flex-col gap-2">
        <header>
            <h2 class="text-lg font-semibold">
                {{ $attributes->get('title') }}
            </h2>
        </header>
        @if($attributes->has('list'))
            <ul class="text-sm flex flex-col gap-4">
                @foreach($attributes->get('list') as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</label>
