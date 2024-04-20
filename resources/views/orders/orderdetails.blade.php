@extends('layouts.base')

@php
    $title = __('orders/orders.order-details');
@endphp

@section('content')

    <!-- TODO: replace hardcoded string w/ attributes and localization -->

    <div class="text-sm">
        <a href="#" class="flex flex-row items-center hover:text-blue-600 dark:text-white dark:fill-white">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div>Terug naar bestellingen</div>
        </a>
    </div>

    <div class="m-4">
        <div class="flex flex-row justify-between items-center w-full dark:text-white">
            <div>
                <div class="text-4xl">Bestelling 123234</div>
            </div>
            <div class="flex flex-row justify-center gap-4 items-center">
                <div>Besteldatum</div>
                <div class="p-2 border rounded dark:border-gray-700">01-01-0001</div>
            </div>
            <div class="flex flex-row justify-center gap-4 items-center">
                <div>Totaalbedrag</div>
                <div class="p-2 border rounded dark:border-gray-700">€99,99</div>
            </div>
            <div>Geannuleerd</div>
        </div>
    </div>

    <div class="m-4">
        <button class="bg-red-600 text-white rounded p-2 hover:bg-red-900">Annuleer bestelling</button>
    </div>

    @for($i = 0; $i < 3; $i++)

        <div class="m-4">
            <div class="flex flex-row justify-between items-center w-full p-6 rounded-xl border dark:text-white dark:border-gray-700">
                <div>
                    <img src="https://placehold.co/200" alt="product image">
                </div>
                <div>
                    <a href="#" class="font-bold">
                        Product titel
                    </a>
                </div>
                <div>M</div>
                <div>€10,00</div>
                <div>2 stuks</div>
            </div>
        </div>

    @endfor

@endsection
