<div {{ $attributes->merge(['class' => 'flex flex-col md:flex-row items-start md:items-center py-2 border-b last:border-none']) }}>
    <div class="flex-1">
        <span class="text-sm">{{ $left }}</span>
    </div>

    <div class="flex-1">
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            {{ $right }}
        @endif
    </div>
</div>
