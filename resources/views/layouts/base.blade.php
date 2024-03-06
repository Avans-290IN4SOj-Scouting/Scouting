<!DOCTYPE html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/product.js')
    @stack('styles')

    @stack('scripts')
</head>

<body class="bg-white dark:bg-black antialiased">
<x-navbar/>

<div class="m-6" style="padding-top: 70px;">
    @if(session('toast-message'))
        <x-toast type="{{ session('toast-type') }}"
                 message="{{ session('toast-message') }}"
        />
    @endif

    <main>
        @yield('content')
    </main>
</div>
<body class="bg-white dark:bg-slate-900">
<x-navbar></x-navbar>

<div style="padding-top: 70px">
    @yield('content')
</div>
</body>

</html>
