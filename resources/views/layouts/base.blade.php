<!DOCTYPE html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    @stack('styles')

    @vite('resources/js/app.js')
    @stack('scripts')
</head>

<body class="bg-white dark:bg-slate-900">
<x-navbar></x-navbar>

<div style="padding-top: 70px">
    @yield('content')
</div>
</body>

</html>
