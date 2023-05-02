<div {{ $attributes->merge(['class' => 'w-full h-64 flex bg-gray-100 text-gray-300']) }}>
    <div class="m-auto inline-flex flex-col gap-2">
        <div class="w-32 h-32 m-auto">
            {!! svg('icons/no-thumb.svg') !!}
        </div>
        <p class="text-xl font-semibold tracking-wide">
            Inzerát nemá fotku.
        </p>
    </div>
</div>

