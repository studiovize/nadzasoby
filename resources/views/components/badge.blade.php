@props(['theme' => 'gray', 'rounded' => true, 'uppercase' => false])

@php
    $classes = 'inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none ';
    switch($theme){
        case 'red':
            $classes .= 'bg-red-500 text-white';
            break;
        case 'green':
            $classes .= 'bg-green-200 text-black';
            break;
        case 'gray':
            default:
                $classes .= 'bg-gray-400 text-white';
                break;
    }
    $classes .= $uppercase ? ' uppercase' : '';
    $classes .= $rounded ? ' rounded-full' : ' rounded-md';
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
