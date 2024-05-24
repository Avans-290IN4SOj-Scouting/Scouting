@extends('layouts.base')

@php
    $title = __('orders/orders.products');
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orders/overview.css') }}">
@endpush

@section('content')
    <x-breadcrumbs :names="[$group->name]" :routes="[route('orders.overview', ['category' => $group->name])]" />

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
