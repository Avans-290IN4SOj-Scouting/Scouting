<!DOCTYPE html>

<head>
    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/product.js')
    @stack('styles')

    @stack('scripts')
</head>

<body class="bg-white dark:bg-black antialiased">
<x-navbar></x-navbar>

@yield('content')
</body>

</html>
