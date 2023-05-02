@section('title', title('Nastavení cookies'))
@php
    $cookie_groups = [
        [
            'title' => 'Nezbytné cookies',
            'name' => 'required',
            'required' => true,
            'list' => [
                'Tyto cookies jsou nezbytné pro fungování webových stránek a používání jejich funkcí.'
            ]
        ],
        [
            'title' => 'Analytické cookies',
            'name' => 'analytics_storage',
            'required' => false,
            'list' => [
                'Tyto soubory cookies obecně shromažďují informace o tom, jak uživatelé používají webové stránky. Tyto soubory nám tak umožňují sledovat relace, počet navštěvujících uživatelů. Mohou to být také soubory cookies třetích stran z analytických služeb třetích stran.',
                'Jedná se např. o Google Analytics, Google Tag Manager.'
            ]
        ],
        [
            'title' => 'Marketingové cookies',
            'name' => 'ad_storage',
            'required' => false,
            'list' => [
                'Tyto cookies nám umožňují poskytovat relevantní reklamu a lépe cílit naše marketingové kampaně.'
            ]
        ]
    ];
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-title>Nastavení cookies</x-title>
    </x-slot>

    <x-container>
        {{--        <x-inner-container>--}}
        <form action="{{ route('cookies.store') }}" method="post" class="flex flex-col items-center gap-6 max-w-xl mx-auto">
            @csrf
            <input type="hidden" name="return_url" value="{{ url()->previous() }}">
            @foreach($cookie_groups as $group)
                <x-cookie-box
                    :name="$group['name']"
                    :title="$group['title']"
                    :list="$group['list']"
                    :required="$group['required']"
                    :checked="(didSetCookies() && grantedCookieSettings($group['name']))"
                />
            @endforeach

            <div>
                <x-button>Uložit nastavení</x-button>
            </div>
        </form>
        {{--        </x-inner-container>--}}
    </x-container>
</x-app-layout>
