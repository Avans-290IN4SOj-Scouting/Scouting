<!DOCTYPE html>

<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>@yield('title')</title>
    @stack('styles')
</head>

<body class="dark:bg-slate-900">
    @yield('content')
</body>

</html>
