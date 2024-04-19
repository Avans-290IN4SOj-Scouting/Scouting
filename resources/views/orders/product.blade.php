@extends('layouts.base')

@php
    $title = __('orders/orders.product');
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orders/product-page.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('js/orders/shopping-cart.js') }}" defer></script>
    <script src="{{ asset('js/orders/shopping-cart-dom.js') }}" defer></script>
@endpush

@section('content')

<div class="breadcrumbs-container">
    <ol class="flex items-center whitespace-nowrap" aria-label="Breadcrumb">
        <li class="inline-flex items-center">
            <a href="{{ route('home') }}" class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500">
                <svg class="flex-shrink-0 me-3 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                {{ __('navbar.home') }}
            </a>
            <svg class="flex-shrink-0 mx-2 overflow-visible size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </li>
        <li class="inline-flex items-center">
            <a  href="{{ route('orders.overview', ['category' => $group->name]) }}" class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500">
                {{ $group->name }}
            </a>
            <svg class="flex-shrink-0 mx-2 overflow-visible size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </li>
        <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate dark:text-gray-200" aria-current="page">
            {{ $product->name }}
        </li>
    </ol>
</div>

<div id="wrapper">
    <div id="main">
        <div class="single-product-view">
            <div class="image">
                <img class="product-image" src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
            </div>
            <div class="info">
                <div>
                    <h1 class="text-4xl font-extrabold dark:text-white">{{ $product->name }} - {{ $group->name }}</h1>
                    <p class="dark:text-white">
                        <span>{{ __('common.currency_symbol') }}</span>
                        <span id="product-price">
                            {{ number_format($product->productSizes->first()->pivot->price, 2, __('currency.seperator'), '.') }}
                        </span>
                    </p>
                    @if (count($productSizes) === 1)
                    <p>{{ __('orders.size') }} - {{ $product->productSizes->first()->size }}</p>
                    @endif
                </div>
                <div class="actions">
                    @if (count($productSizes) > 1)
                    <div class="relative">
                        <select id="product-sizes" class="peer p-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600
                        focus:pt-6
                        focus:pb-2
                        [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2
                        autofill:pt-6
                        autofill:pb-2">
                            @foreach ($productSizes as $productSize)
                                <option id="{{ $productSize->id }}" @selected($group->size_id == $productSize->id)>
                                    {{ $productSize->size }} - {{ __('common.currency_symbol') }} {{ number_format($productSize->pivot->price, 2, __('common.seperator'), '.') }}
                                </option>
                            @endforeach
                        </select>

                        <label class="absolute top-0 start-0 p-4 h-full truncate pointer-events-none transition ease-in-out duration-100 border border-transparent dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
                        peer-focus:text-xs
                        peer-focus:-translate-y-1.5
                        peer-focus:text-gray-500
                        peer-[:not(:placeholder-shown)]:text-xs
                        peer-[:not(:placeholder-shown)]:-translate-y-1.5
                        peer-[:not(:placeholder-shown)]:text-gray-500">{{ __('orders/orders.size') }}</label>
                    </div>
                    @endif

                    <button type="submit" onclick="DOM_addProductFromProductPage('{{ $product->id }}')" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                        {{ __('orders/orders.add-to-shoppingcart') }}
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 22C8.55228 22 9 21.5523 9 21C9 20.4477 8.55228 20 8 20C7.44772 20 7 20.4477 7 21C7 21.5523 7.44772 22 8 22Z"
                                stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M19 22C19.5523 22 20 21.5523 20 21C20 20.4477 19.5523 20 19 20C18.4477 20 18 20.4477 18 21C18 21.5523 18.4477 22 19 22Z"
                                stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2.05005 2.05005H4.05005L6.71005 14.47C6.80763 14.9249 7.06072 15.3315 7.42576 15.6199C7.7908 15.9083 8.24495 16.0604 8.71005 16.05H18.49C18.9452 16.0493 19.3865 15.8933 19.7411 15.6079C20.0956 15.3224 20.3422 14.9246 20.4401 14.48L22.09 7.05005H5.12005"
                                stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
