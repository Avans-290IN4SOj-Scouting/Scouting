<!DOCTYPE html>

<head>
    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    @stack('styles')

    @vite('resources/js/app.js')
    @stack('scripts')
</head>

<body class="bg-white dark:bg-black antialiased">
<x-navbar></x-navbar>

@yield('content')
</body>

</html>
