@extends('layouts.base')

@php
    $title = __('orders/orders.products');
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orders/overview.css') }}">
@endpush
{{-- @push('scripts')
    <script src="{{ asset('js/orders/shopping-cart.js') }}"></script>
@endpush --}}

@section('content')

<div class="breadcrumbs-container">
    <ol class="flex items-center whitespace-nowrap" aria-label="Breadcrumb">
        <li class="inline-flex items-center">
            <a  href="{{ route('home') }}" class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500">
                <svg class="flex-shrink-0 me-3 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                {{ __('navbar.home') }}
            </a>
            <svg class="flex-shrink-0 mx-2 overflow-visible size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </li>
        <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate dark:text-gray-200" aria-current="page">
            {{ $group->name }}
        </li>
    </ol>
</div>

<div id="wrapper">

    <div id="header">
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-5xl dark:text-white">{{ $group->name }} - {{ __('orders/orders.products') }}</h1>
    </div>

    <div id="main">
        <div class="content-devider bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="products-container">
                @foreach ($products as $product)
                <a dusk="{{ $product->name }}" href="{{ route('orders.product', [ 'name' => $product->name, 'groupName' => $group->name]) }}">
                    <div class="product">
                        <div class="flex flex-col bg-white border rounded-xl dark:bg-slate-900">
                            <img class="rounded-t-xl" src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
                        <div class="p-2">
                            <div class="product-info-container">
                                <div>
                                    <p class="text-lg font-bold text-gray-800 dark:text-white">
                                        {{ $product->name }}
                                    </p>
                                    <p class="dark:text-white">
                                        <span class="dark:text-white">
                                            {{ __('common.currency_symbol') }} {{ number_format($product->productSizes->pluck('pivot.price')->min(), 2, __('common.seperator'), '.') }}
                                            @if (count($product->productSizes) > 1)
                                            {{ __('orders/orders.till') }}
                                            {{ __('common.currency_symbol') }} {{ number_format($product->productSizes->pluck('pivot.price')->max(), 2, __('common.seperator'), '.') }}
                                            @endif
                                        </span>
                                    </p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
                @if (count($products) == 0)
                    <h2 class="text-4xl font-extrabold dark:text-white">{{ __('orders/orders.no-products-to-show') }}</h2>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
