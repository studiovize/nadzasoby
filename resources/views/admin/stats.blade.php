@section('title', title('Statistiky'))
<x-app-layout>
    <x-slot name="header">
        <div class="md:flex-grow flex items-center justify-start">
            <x-title>Statistiky</x-title>
        </div>
    </x-slot>

    <x-container class="flex flex-col gap-6">
        @foreach($data as $group)
            <x-inner-container class="flex flex-col gap-2">
                <header>
                    <h2 class="font-bold text-lg">{{ $group['title'] }}</h2>
                </header>
                <div class="flex items-start">
                    @if(isset($group['cols']))
                        <div class="flex-1 grid grid-cols-1 sm:grid-cols-{{ count($group['cols']) }}">
                            @foreach($group['cols'] as $col)
                                <aside class="flex flex-col gap-1">
                                    <h3 class="text-sm">{{ $col['label'] }}</h3>
                                    <p class="font-semibold">{{ $col['value'] }}</p>
                                </aside>
                            @endforeach
                        </div>
                    @endif

                    @if($group['title'] === 'Nabídky')
                        <aside class="flex-12 flex flex-col gap-1">
                            <h3 class="text-sm">Nejpopulárnější nabídky</h3>
                            <ul class="font-semibold flex flex-col">
                                @foreach($popular_listings as $item)
                                    <li class="inline-flex items-center gap-1">
                                        - <a href="{{ route('listings.show', $item->slug) }}" class="hover:underline">
                                            {{ $item->title }}
                                        </a>
                                        <span class="text-gray-400">({{ $item->views }}x)</span>
                                    </li>
                                @endforeach
                            </ul>
                        </aside>
                    @endif
                </div>
            </x-inner-container>
        @endforeach
    </x-container>

</x-app-layout>
