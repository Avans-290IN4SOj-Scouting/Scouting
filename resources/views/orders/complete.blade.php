@extends('layouts.base')

@php
    $title = __('orders/orders.completed-success');
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/orders/main.css') }}">
@endpush

@section('content')

    <div id="wrapper">
        <div id="header">
            <h1
                class="mb-4 text-4xl font-extrabold text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                {{ __('orders/orders.completed-success') }}
            </h1>

        </div>
        <div id="main">
            <p>
                <a class="text-blue-600 underline underline-offset-1 decoration-blue-600 hover:opacity-80" href="{{ route('home') }}">
                    {{ __('orders/orders.back-to-home-page') }}
                </a>
            </p>
        </div>
    </div>

@endsection
