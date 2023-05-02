@props([
'link' => true,
'text' => true
])
@if($link)
    <a href="{{ route('listings.index') }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-3 text-inherit']) }}>
        @endif
        <x-application-logo class="block w-10 h-10"/>
        @if($text)
            <span class="font-bold tracking-[1px] text-md uppercase">Nadzásoby</span>
        @endif
        @if($link)
    </a>
@endif
