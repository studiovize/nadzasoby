@props(['theme' => 'primary', 'tooltip' => null])

@php
    if($theme === 'primary'){
        $color_classes = 'bg-red-500 border-red-500 hover:bg-red-700 hover:border-red-700 text-white active:bg-red-900 focus:border-red-900 ring-red-300';
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
    else if($theme === 'gray') {
        $color_classes = 'bg-transparent hover:bg-gray-100 text-gray-400 hover:text-gray-600 active:text-gray-600 focus:text-gray-600 border-transparent active:bg-gray-300 focus:bg-gray-300 ring-gray-300';
    }
    else {
        $color_classes = 'bg-transparent hover:bg-gray-100 text-black border-transparent active:bg-gray-300 focus:bg-gray-300 ring-gray-300';
    }
@endphp
<a {{ $attributes->merge(['class' => 'relative group w-12 h-12 rounded border-2 text-0 inline-flex items-center p-3 justify-center focus:outline-none focus:ring disabled:opacity-25 transition ease-in-out duration-150 ' . $color_classes]) }}>
    {{ $slot }}
    @if(!is_null($tooltip))
        <div
            class="opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 absolute top-full left-1/2 -translate-x-1/2 bg-black text-white uppercase tracking-[0.5px] leading-none p-1 rounded font-bold text-xs pointer-events-none transition-all duration-100">
            {{ $tooltip }}
            <div
                class="absolute bottom-full left-1/2 -translate-x-1/2 h-0 w-0 border-x-8 border-x-transparent border-b-8 border-b-black"></div>
        </div>
    @endif
</a>
