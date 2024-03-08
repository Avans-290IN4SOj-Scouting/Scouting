<!DOCTYPE html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    @stack('styles')

    @vite('resources/js/app.js')
    @stack('scripts')


    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
    <script src="{{ asset('js/toast.js') }}" defer></script>
</head>

<body class="bg-white dark:bg-slate-900">
<x-navbar></x-navbar>

<div style="padding-top: 70px">
    @yield('content')
    <div class="norefresh-toast-container">
    </div>
</div>
</body>

</html>
