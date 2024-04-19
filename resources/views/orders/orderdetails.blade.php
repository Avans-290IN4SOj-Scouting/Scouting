@extends('layouts.base')

@php
    $title = __('orders/orders.order-details');
@endphp

@section('content')

    <!-- TODO: replace hardcoded string w/ attributes and localization -->

    <div class="m-4">
        <div class="flex flex-row justify-between w-full bg-white p-6 rounded-xl">
            <div>Bestelling 1234</div>
            <div>Besteldatum: 0001-01-01</div>
            <div>Geannuleerd</div>
        </div>
    </div>

    @for($i = 0; $i < 4; $i++)

        <div class="m-4">
            <div class="flex flex-row justify-between items-center w-full bg-white p-6 rounded-xl">
                <div>
                    <img src="https://placehold.co/200" alt="product image">
                </div>
                <div>Product titel</div>
                <div>M</div>
                <div>€10,00</div>
                <div>2 stuks</div>
            </div>
        </div>

    @endfor

    <div class="m-4">
        <div class="flex flex-row justify-center w-full bg-white p-6 rounded-xl">
            <div>Totaal: €99,99</div>
        </div>
    </div>

@endsection
