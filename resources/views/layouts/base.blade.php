<!DOCTYPE html>

<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
    @stack('scripts')
</head>

<body class="dark:bg-slate-900">
    @yield('content')
</body>

</html>
