<!DOCTYPE html>

<head>
    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    @stack('styles')

    @vite('resources/js/app.js')
    @stack('scripts')
</head>

<body class="bg-white dark:bg-black antialiased">
<x-navbar/>

<div class="m-6" style="padding-top: 70px;">
    @if(session('toast-type'))
        <x-toast type="{{ session('toast-type') }}"
                 message="{{ session('toast-message') }}"
        />
    @endif

    <main>
        @yield('content')
    </main>
</div>

</body>

</html>
