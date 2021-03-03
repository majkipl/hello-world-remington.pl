<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charSet="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @isset($metaTitle)
        <title>{{$metaTitle}}</title>
    @else
        <title>{{ config('app.name', 'Laravel') }}</title>
    @endisset

    @isset($metaDescription)
        <meta name="description" content="{{ $metaDescription }}"/>
    @else
        <meta name="description" content="{{ config('app.name', 'Laravel') }}"/>
    @endisset

    <meta name="keywords" content="{{ config('app.name', 'Laravel') }}"/>

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.typekit.net/vni7duj.css" />
    <link href="{{ asset('css/front.css') }}" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
</head>

<body>
    <div id="app">
        @include('common.menu')

        @yield('content')

        @include('common.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/front.js') }}" defer></script>
</body>
</html>
