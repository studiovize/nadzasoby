<aside {{ $attributes->merge(['class' => 'flex flex-col gap-1 bg-white border-b-2 border-red-500 p-6']) }}>
    @isset($label)
        <x-label class="font-bold text-lg" for="{{ $name ?? '' }}">
            {{ $label }}
        </x-label>
    @endisset

    {{ $slot }}
</aside>
