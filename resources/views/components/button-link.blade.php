@props([
'theme' => 'primary',
'size' => 'big'
])

@php
    if($theme === 'primary'){
        $color_classes = 'bg-red-500 border-red-500 hover:bg-red-600 hover:border-red-600 text-white active:bg-red-900 ring-red-300';
    }
    else if($theme === 'success'){
        $color_classes = 'bg-green-500 border-green-500 hover:bg-green-700 hover:border-green-700 text-white active:bg-green-900 focus:border-green-900 ring-green-300';
    }
    else if($theme === 'error'){
        $color_classes = 'bg-red-700 border-red-700 hover:bg-red-800 hover:border-red-800 text-white active:bg-yellow-900 focus:border-yellow-900 ring-yellow-300';
    }
    else if($theme === 'outline'){
        $color_classes = 'bg-transparent hover:bg-gray-100 text-red-500 border-red-500 active:bg-gray-300 focus:border-gray-300 ring-gray-300';
    }
    else if($theme === 'outline-white'){
        $color_classes = 'bg-white hover:bg-gray-100 text-red-500 border-white active:bg-gray-300 focus:border-gray-300 ring-gray-300';
    }
    else if($theme === 'ghost') {
        $color_classes = 'bg-transparent hover:bg-gray-100 text-black border-transparent active:bg-gray-300 focus:bg-gray-300 ring-gray-300';
    }
    else {
        $color_classes = 'bg-transparent hover:bg-gray-100 text-black border-transparent active:bg-gray-300 focus:bg-gray-300 ring-gray-300';
    }


    if($size === 'big'){
        $size_classes = 'py-3 px-5';
    }
    else{
        $size_classes = 'py-1 px-3';
    }
@endphp
<a {{ $attributes->merge(['class' => 'border-2 rounded inline-flex items-center font-bold justify-center focus:outline-none focus:ring disabled:opacity-25 transition ease-in-out duration-150 ' . $color_classes . ' ' . $size_classes]) }}>
    {{ $slot }}
</a>
