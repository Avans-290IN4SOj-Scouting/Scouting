<!DOCTYPE html>

<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>@yield('title')</title>
</head>

<body>
    @yield('content')
</body>

</html>
