@extends('layouts.base')

@php
    $title = __('orders.product');
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orders/product-page.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('js/orders/shopping-cart.js') }}"></script>
@endpush

@section('content')

    <div id="wrapper">
        <div id="main">
            <div class="single-product-view">
                <div class="image">
                    <img class="product-image" src="{{ $product->image_path }}" alt="{{$product->name}}">
                </div>
                <div class="info">
                    <div>
                        <h2 class="text-4xl font-extrabold dark:text-white">{{ $product->name }}</h2>
                        @if ($product->discount == 0)
                            <p class="dark:text-white">
                                <span
                                    class="dark:text-white">{{ __('orders.currency-symbol') }}{{ $product->price }}</span>
                            </p>
                        @else
                            <p class="dark:text-white">
                                <span
                                    class="pre-discount-price dark:text-white">{{ __('orders.currency-symbol') }}{{ $product->price }}</span>
                                <span>{{ __('orders.currency-symbol') }}{{ ($product->price * (1 - $product->discount)) }}</span>
                            </p>
                        @endif
                    </div>
                    <div class="actions">
                        <div class="hs-dropdown relative inline-flex">
                            <button id="hs-dropdown-default" type="button"
                                    class="hs-dropdown-toggle py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                {{ $sizeSelected }}
                                <svg class="hs-dropdown-open:rotate-180 size-4" xmlns="http://www.w3.org/2000/svg"
                                     width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </button>

                            <div
                                class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg p-2 mt-2 dark:bg-gray-800 dark:border dark:border-gray-700 dark:divide-gray-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full"
                                aria-labelledby="hs-dropdown-default">
                                @foreach ($sizes as $size)
                                    <a id="{{ $size->id }}"
                                       href="{{ route('orders.product', [ 'id' => $product->product_id, 'size' => $size->size]) }}"
                                       class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:bg-gray-700"
                                       href="#">
                                        {{ $size->size }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit"
                                onclick="addProductToShoppingCart('{{ $product->product_id }}', '{{ $product->size }}', 1)"
                                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            {{ __('orders.add-to-shoppingcart') }}
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
