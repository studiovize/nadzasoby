<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Nadzásoby - V nadzásobách vám leží peníze. Nadzásoby za super peníze.'))</title>

    <meta property="og:title" content="@yield('title', config('app.name', 'Nadzásoby - V nadzásobách vám leží peníze. Nadzásoby za super peníze.'))"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:image" content="{{ env('OG_IMAGE') }}"/>
    <meta property="og:description" content="@yield('description', env('OG_DESCRIPTION'))"/>

    <meta name="description" content="@yield('description', env('OG_DESCRIPTION'))">
    <meta name="author" content="Redihend, s.r.o.">

    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('safari-pinned-tab.svg') }}" color="#ef4444">
    <meta name="apple-mobile-web-app-title" content="Nadzásoby">
    <meta name="application-name" content="Nadzásoby">
    <meta name="msapplication-TileColor" content="#fff">
    <meta name="theme-color" content="#fff">

    {{-- Todo: load local font --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <link rel="canonical" href="{{ canonical_url() }}">

    @stack('styles')

    @if(env('APP_ENV') === 'production')
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('consent', 'default', {
                required: 'granted',
                ad_storage: '{{ getCookieSettings('ad_storage') }}',
                analytics_storage: '{{ getCookieSettings('analytics_storage') }}',
            });

            (function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-ND99HL9');</script>
    @endif
</head>
<body class="font-sans antialiased">
@if(env('APP_ENV') === 'production')
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-ND99HL9"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
@endif

<div class="min-h-screen bg-gray-100 flex flex-col">
    @include('layouts.navigation')

    @isset($header)
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    @isset($banner)
        <aside class="bg-red-600 text-white uppercase font-extrabold tracking-wide text-center text-md">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $banner }}
            </div>
        </aside>
    @endisset

    <main class="flex-grow py-4 md:py-8 lg:py-12 ">
        {{ $slot }}
    </main>

    @include('layouts.footer')

    @include('contact.float')


    @if(Route::currentRouteName() !== 'cookies.settings' && !didSetCookies())
        @include('cookies.bar')
    @endif
</div>

<script src="{{ mix('js/app.js') }}" defer></script>
@stack('scripts')
</body>
</html>
