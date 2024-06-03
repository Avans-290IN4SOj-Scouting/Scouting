@extends('layouts.base')

@php
    $title = __('orders/orders.completed-success');
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
@endpush

@section('content')

    <p>Je MOET deze gebruiken (staan in code)</p>
    <h1 class="text-4xl dark:text-white">h1. Preline heading</h1>
    <h2 class="text-3xl dark:text-white">h2. Preline heading</h2>
    <h3 class="text-2xl dark:text-white">h3. Preline heading</h3>
    <h4 class="text-xl dark:text-white">h4. Preline heading</h4>
    <h5 class="text-lg dark:text-white">h5. Preline heading</h5>
    <h6 class="text-base dark:text-white">h6. Preline heading</h6>

    <a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="#">Link</a>

    <div>
        <ol class="list-decimal list-inside text-gray-800 dark:text-white">
            <li>Item</li>
        </ol>
    </div>

    <p>==================================</p>

    <h1 class="text-4xl dark:text-white">1. Product bestellen</h1>
    <h2 class="text-3xl dark:text-white">1.1 Product in winkelwagen zetten</h2>
    <div>
        <ol class="list-decimal list-inside text-gray-800 dark:text-white">
            <li>Ga naar <a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="#">de home pagina</a>.</li>
            <li>Kies de groep waar u of uw kind bij hoort.</li>
            <li>Selecteer een product.</li>
            <li>Selecteer indien nodig een andere size.</li>
            <li>Voeg het product toe aan uw winkelwagen.</li>
        </ol>
    </div>
    <br>

    <h2 class="text-3xl dark:text-white">1.2 Winkelwagen controleren</h2>
    <div>
        <ol class="list-decimal list-inside text-gray-800 dark:text-white">
            <li>Ga via de navigatiebalk bovenin naar <a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="#">de winkelwagen pagina</a>.</li>
            <li>Pas indien nodig het aantal van het product aan via de "+" of "-" knop.</li>
            <li>Verwijder indien nodig het product door rechtsboven in het product op de prullenbak te klikken.</li>
        </ol>
    </div>
    <br>

    <h2 class="text-3xl dark:text-white">1.3 Bestelling plaatsen</h2>
    <div>
        <ol class="list-decimal list-inside text-gray-800 dark:text-white">
            <li>Klik in <a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="#">de winkelwagen pagina</a> op de knop "Naar bestellen".</li>
            <li>Vul het naam in van het lid voor wie de bestelling is.</li>
            <li>Kies de groep van het lid in de dropdown.</li>
            <li>Klik op de "Bestelling afronden" knop.</li>
        </ol>
    </div>
    <br>

@endsection
