<!DOCTYPE html>

<head>
    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/product.js')
    @stack('styles')

    @stack('scripts')
</head>

<body>
    @yield('content')
</body>

</html>
