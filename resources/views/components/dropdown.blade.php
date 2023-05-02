<div class="relative">
    <div data-dropdown-trigger>
        {{ $trigger }}
    </div>

    <div class="absolute z-50 mt-2 w-48 min-w-max shadow-md origin-top-right right-0"
         style="display: none;"
         data-dropdown-elem>
        <div class="ring-1 ring-black ring-opacity-5 py-1 bg-white">
            {{ $content }}
        </div>
    </div>
</div>
