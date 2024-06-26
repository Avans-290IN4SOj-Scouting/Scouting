<!DOCTYPE html>

<html lang="{{ config('app.locale') }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>
        @isset($title)
            {{ $title }} |
        @endisset

        {{ config('app.name') }}
    </title>

    @vite('resources/css/app.css')
    @stack('styles')

    @vite('resources/js/app.js')
    <script src="{{ asset('js/toast.js') }}"></script>
    @stack('scripts')
</head>


<body class="bg-white dark:bg-slate-900">
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
