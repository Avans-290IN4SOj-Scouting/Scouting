<!DOCTYPE html>

<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>@yield('title')</title>
    @stack('styles')
</head>

<body>
    @yield('content')
</body>

</html>
