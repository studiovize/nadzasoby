@props(['disabled' => false])
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded border-gray-300 focus:border-red-300 focus:ring focus:ring-red-200/50']) !!}>
