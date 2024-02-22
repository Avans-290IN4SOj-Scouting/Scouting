<!DOCTYPE html>

<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>@yield('title')</title>
</head>

<body class="bg-white dark:bg-black antialiased">
<x-navbar></x-navbar>

@yield('content')
</body>

</html>
