@extends('layouts.base')

@section('title', __('orders.products'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orders/overview.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('js/orders/shopping-cart.js') }}"></script>
@endpush

@section('content')

<div id="wrapper">
    <div id="header">
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-5xl dark:text-white">{{ $group->name }} - {{ __('orders.products') }}</h1>
    </div>

    <div id="main">
        <div class="content-devider bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="products-container">
                @foreach ($products as $product)
                    <div class="product">
                            <div class="flex flex-col bg-white border rounded-xl dark:bg-slate-900">
                                <a href="{{ route('orders.product', [ 'name' => $product->name, 'groupName' => $group->name]) }}">
                                    <img class="rounded-t-xl" src="{{ $product->image_path }}" alt="{{ $product->name }}">
                                </a>

                                <div class="p-2">
                                    <div class="product-info-container">
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-800 dark:text-white">
                                                {{ $product->name }}
                                            </h4>
                                            <p class="dark:text-white">
                                                <span class="dark:text-white">{{ __('currency.symbol') }}
                                                    {{ number_format($product->price, 2, __('currency.seperator'), '.') }}
                                                </span>
                                            </p>
                                        </div>
                                        <div>
                                            <button class="add-product" onclick="addProductToShoppingCart('{{ $product->product_id }}', '{{ $group->size_id }}', 1)">
                                                <div class="product-shopping-cart">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M8 22C8.55228 22 9 21.5523 9 21C9 20.4477 8.55228 20 8 20C7.44772 20 7 20.4477 7 21C7 21.5523 7.44772 22 8 22Z"
                                                            stroke="#2563eb" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M19 22C19.5523 22 20 21.5523 20 21C20 20.4477 19.5523 20 19 20C18.4477 20 18 20.4477 18 21C18 21.5523 18.4477 22 19 22Z"
                                                            stroke="#2563eb" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M2.05005 2.05005H4.05005L6.71005 14.47C6.80763 14.9249 7.06072 15.3315 7.42576 15.6199C7.7908 15.9083 8.24495 16.0604 8.71005 16.05H18.49C18.9452 16.0493 19.3865 15.8933 19.7411 15.6079C20.0956 15.3224 20.3422 14.9246 20.4401 14.48L22.09 7.05005H5.12005"
                                                            stroke="#2563eb" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                @endforeach
                @if (count($products) == 0)
                    <h2 class="text-4xl font-extrabold dark:text-white">{{ __('orders.no-products-to-show') }}</h2>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
