@extends('layouts.base')

@php
    $title = __('orders.completed-success');
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
@endpush

@section('content')

    <div id="wrapper">
        <div id="header">
            <h1
                class="mb-4 text-4xl font-extrabold text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                {{ __('orders.completed-success') }}
            </h1>

        </div>

        <div id="main">
            <a href="{{ route('orders.overview') }}">Terug naar de home pagina</a>
        </div>
    </div>

@endsection
