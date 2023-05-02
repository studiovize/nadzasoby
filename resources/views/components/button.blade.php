@props([
'theme' => 'primary',
'size' => 'big'
])

@php
    if($theme === 'primary'){
        $color_classes = 'bg-red-500 border-red-500 hover:bg-red-600 hover:border-red-600 text-white active:bg-red-900 ring-red-300';
    }
    else{
    $color_classes = 'bg-gray-200 border-gray-200 hover:bg-gray-300 hover:border-gray-300 text-red-500 active:bg-gray-300 focus:border-gray-300 ring-gray-300';
    }

    if($size === 'big'){
        $size_classes = 'py-3 px-5';
    }
    else{
        $size_classes = 'py-1 px-3';
    }
@endphp


<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex rounded items-center font-bold justify-center border-2 focus:outline-none focus:ring disabled:opacity-25 transition ease-in-out duration-150 ' . $color_classes . ' ' . $size_classes]) }}>
    {{ $slot }}
</button>

