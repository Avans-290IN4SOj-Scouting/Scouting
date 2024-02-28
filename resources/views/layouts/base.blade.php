<!DOCTYPE html>

<head>
    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    @stack('styles')

    @vite('resources/js/app.js')
    @stack('scripts')
</head>

<body>
    @yield('content')
</body>

</html>
