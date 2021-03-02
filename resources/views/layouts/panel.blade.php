<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
</head>
<body class="panel">
<div id="app">
    @include('panel.common.navbar')
    @include('panel.common.token')

    <main class="padding-top-4 padding-bottom-4">
        @yield('content')
    </main>
</div>

<script src="https://unpkg.com/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
<script src="https://unpkg.com/tableexport.jquery.plugin@1.27.0/tableExport.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.4/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script
    src="https://unpkg.com/bootstrap-table@1.21.4/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
<script src="https://unpkg.com/moment@2.29.4/min/moment.min.js"></script>
<script src="https://unpkg.com/axios@0.16.2/dist/axios.min.js"></script>
<script src="https://unpkg.com/js-cookie@2.2.1/src/js.cookie.js"></script>


<script src="{{ asset('js/backend.js') }}" defer></script>
</body>
</html>
