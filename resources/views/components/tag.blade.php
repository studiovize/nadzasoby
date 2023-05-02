@props(['theme' => 'gray', 'compact' => false, 'uppercase' => false])
@php
    $is_link = isset($attributes['href']);
    $classes = 'inline-flex items-center rounded font-semibold ';
    switch($theme){
        case 'red':
            $classes .= 'bg-red-500 text-white' . ($is_link ? ' hover:bg-red-800' : '');
            break;
        case 'green':
            $classes .= 'bg-green-200 text-black' . ($is_link ? ' hover:bg-green-300' : '');
            break;
        case 'gray':
            default:
                $classes .= 'bg-gray-200 text-black' . ($is_link ? ' hover:bg-gray-300' : '');
                break;
    }

    $classes .= $compact ? ' px-3 py-1 text-xs' : ' px-5 py-1.5';
    $classes .= $uppercase ? ' uppercase' : '';
@endphp

@if($is_link)
    <a {{ $attributes->merge(['class' => 'focus:shadow-outline transition-colors duration-150 ' . $classes]) }}>
        {{ $slot }}
    </a>
@else
    <span  {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </span>
@endif
