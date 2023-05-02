@props(['value'])

@php
    $is_password = strpos($attributes->get('for'), 'password') !== false;
@endphp

<label {{ $attributes->merge(['class' => 'flex justify-between font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
    @if($is_password)
        <button data-toggle-type="{{ $attributes->get('for') }}" type="button" class="hover:underline">Zobrazit heslo</button>
    @endif
</label>
