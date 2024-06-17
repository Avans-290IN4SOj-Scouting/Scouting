@extends('layouts.base')

@php
    $title = __('orders/orders.product');
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/orders/main.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/orders/product-page.css') }}">
@endpush
@push('scripts')
    <script src="{{ secure_asset('js/orders/shopping-cart.js') }}" defer></script>
    <script src="{{ secure_asset('js/orders/shopping-cart-dom.js') }}" defer></script>
@endpush

@section('content')

    <x-breadcrumbs :names="[$group->name, $product->name]"
                   :routes="[route('orders.overview', ['category' => $group->name]), '']"/>

    <div id="wrapper">
        <div id="main">
            <div class="single-product-view">
                <div class="image">
                    <img src="{{ secure_asset($product->image_path) }}" alt="{{ $product->name }}">
                </div>
                <div class="info">
                    <div>
                        <h1 class="text-4xl font-extrabold dark:text-white">{{ $product->name }}</h1>
                        <p class="dark:text-white">
                            <span>{{ __('common.currency_symbol') }}</span>
                            <span id="product-price">
                                {{ number_format($productSizes->first()->pivot->price, 2, __('common.seperator'), '.') }}
                            </span>
                        </p>
                        @if (count($productSizes) === 1)
                            <p class="dark:text-white">{{ __('orders/orders.size') }}
                                - {{ $productSizes->first()->size }}</p>
                        @endif
                    </div>
                    <div class="actions">
                        @if (count($productSizes) > 1)
                            <div class="relative">
                                <label for="product-sizes"
                                       class="hidden">{{ __('orders/orders.product') }} {{ __('orders/orders.size') }}</label>
                                <select id="product-sizes" name="product-sizes" class="peer p-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600
                        focus:pt-6
                        focus:pb-2
                        [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2
                        autofill:pt-6
                        autofill:pb-2">
                                    @foreach ($productSizes as $productSize)
                                        <option data-price="{{ $productSize->pivot->price }}"
                                                id="{{ $productSize->id }}" @selected($productSizes->first() == $productSize)>
                                            {{ $productSize->size }}
                                        </option>
                                    @endforeach
                                </select>

                                <p for="product-sizes"
                                   class="absolute top-0 start-0 p-4 h-full truncate pointer-events-none transition ease-in-out duration-100 border border-transparent dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
                        peer-focus:text-xs
                        peer-focus:-translate-y-1.5
                        peer-focus:text-gray-500
                        peer-[:not(:placeholder-shown)]:text-xs
                        peer-[:not(:placeholder-shown)]:-translate-y-1.5
                        peer-[:not(:placeholder-shown)]:text-gray-500">{{ __('orders/orders.size') }}</p>
                            </div>
                        @endif

                        <button type="submit" onclick="DOM_addProductFromProductPage('{{ $product->id }}')"
                                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            {{ __('orders/orders.add-to-shoppingcart') }}
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8 22C8.55228 22 9 21.5523 9 21C9 20.4477 8.55228 20 8 20C7.44772 20 7 20.4477 7 21C7 21.5523 7.44772 22 8 22Z"
                                    stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                <path
                                    d="M19 22C19.5523 22 20 21.5523 20 21C20 20.4477 19.5523 20 19 20C18.4477 20 18 20.4477 18 21C18 21.5523 18.4477 22 19 22Z"
                                    stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                <path
                                    d="M2.05005 2.05005H4.05005L6.71005 14.47C6.80763 14.9249 7.06072 15.3315 7.42576 15.6199C7.7908 15.9083 8.24495 16.0604 8.71005 16.05H18.49C18.9452 16.0493 19.3865 15.8933 19.7411 15.6079C20.0956 15.3224 20.3422 14.9246 20.4401 14.48L22.09 7.05005H5.12005"
                                    stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
