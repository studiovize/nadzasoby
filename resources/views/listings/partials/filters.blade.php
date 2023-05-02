<form action="{{ route('listings.search') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4"
      id="filters-form">
    <input type="hidden" value="{{ $_GET['pagination'] ?? 6 }}" id="pagination" name="pagination">

    <x-filter-box label="Klíčové slovo" name="s">
        <x-input class="block mt-1 w-full" type="text" :value="request()->get('s')" name="s" id="s"/>
    </x-filter-box>

    <x-filter-box label="Typ inzerátu" name="type">
        <x-select name="type" id="type">
            <option value="sell" @if(request()->get('type') === 'sell') selected @endif>
                Nabídka
            </option>
            <option value="buy" @if(request()->get('type') === 'buy') selected @endif>
                Poptávka
            </option>
        </x-select>
    </x-filter-box>

    <x-filter-box label="Lokalita" name="area">
        <x-select name="area" id="area">
            <option value="">Všechny kraje a okresy</option>
            @foreach($areas as $area)
                <option value="{{ $area->id }}"
                        @if((int) request()->get('area') === $area->id) selected @endif>{{ $area->name }}</option>

                @foreach($area->subareas as $subarea)
                    <option value="{{ $subarea->id }}"
                            @if((int) request()->get('area') === $subarea->id) selected @endif>
                        &nbsp;&nbsp;- {{ $subarea->name }}</option>
                @endforeach
            @endforeach
        </x-select>
    </x-filter-box>

    <x-filter-box label="Stáří inzerátu" name="date">
        <x-select name="date" id="date">
            <option value="">Bez časového omezení</option>
            <option value="day" @if(request()->get('date') === 'day') selected @endif>
                Posledních 24 hodin
            </option>
            <option value="week" @if(request()->get('date') === 'week') selected @endif>
                Poslední týden
            </option>
            <option value="month" @if(request()->get('date') === 'month') selected @endif>
                Poslední měsíc
            </option>
        </x-select>
    </x-filter-box>

    <x-filter-box label="Kategorie" name="category">
        <x-select name="category" id="category">
            <option value="">Všechny kategorie</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                        @if((int) request()->get('category') === $category->id) selected @endif
                >
                    {{ $category->name }}
                </option>
            @endforeach

        </x-select>
    </x-filter-box>


    <x-filter-box label="Stav zboží" name="condition">
        <x-select name="condition" id="condition">
            <option value="">Jakýkoliv</option>
            @foreach($conditions as $condition)
                <option value="{{ $condition->id }}"
                        @if((int) request()->get('condition') === $condition->id) selected @endif
                >
                    {{ $condition->name }}
                </option>
            @endforeach

        </x-select>
    </x-filter-box>

    <x-filter-box class="flex items-center">
        <x-button class="w-full">Hledat</x-button>
    </x-filter-box>
</form>
