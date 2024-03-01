@extends('layouts.base')

@section('title', 'Your Page Title')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders/shoppingcart.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('js/orders/shopping-cart-dom.js') }}"></script>
<script src="{{ asset('js/orders/shopping-cart.js') }}"></script>
@endpush

@section('content')
@include('orders.delete_this')

<main>
    <div class="shopingcart-view">
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
            {{ __('orders.shoppingcart') }}
        </h1>

        <div class="idk ">
            <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                <div class="shoppingcart-products-container">
                    @foreach ($products as $product)
                    <div class="shoppingcart-product" id="product-{{ $product->id }}">
                        <div class="split">
                            <div class="image">
                                <img class="product-image" src="{{ $product->imageUri }}" alt="{{$product}}">
                            </div>
                            <div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-800 dark:text-white">
                                        {{ $product->name }}
                                    </h4>
                                    <p class="dark:text-white">
                                        <span
                                            class="pre-discount-price dark:text-white">{{ __('orders.currency-symbol') }}{{ $product->price }}</span>
                                        <span>{{ __('orders.currency-symbol') }}{{ $product->salePrice }}</span>
                                    </p>
                                </div>
                                <div class="py-2 px-3 inline-block bg-white border border-gray-200 rounded-lg dark:bg-slate-900 dark:border-gray-700"
                                    data-hs-input-number>
                                    <div class="flex items-center gap-x-1.5">
                                        <button type="button"
                                            onclick="DOM_shoppingCartProductAdd({{ $product->id }}, -1)"
                                            class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                            <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M5 12h14" /></svg>
                                        </button>

                                        <input id="input-{{ $product->id }}"
                                            class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center focus:ring-0 dark:text-white"
                                            onchange="DOM_shoppingCartProductAmountChange({{ $product->id }})"
                                            type="text" value="{{ $product->amount }}">

                                        <button type="button"
                                            onclick="DOM_shoppingCartProductAdd({{ $product->id }}, 1)"
                                            class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                            <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M5 12h14" />
                                                <path d="M12 5v14" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-shoppingcart-delete">
                            <button type="submit" onclick="DOM_removeShoppingCartProduct({{ $product->id }})">
                                <div class="icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 6H21" stroke="red" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19 6V20C19 21 18 22 17 22H7C6 22 5 21 5 20V6" stroke="red"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8 6V4C8 3 9 2 10 2H14C15 2 16 3 16 4V6" stroke="red"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M10 11V17" stroke="red" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M14 11V17" stroke="red" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                <div class="order-data">
                    <h2 class="text-4xl font-extrabold dark:text-white">{{ __('orders.shoppingcart-order') }}</h2>
                    <p class="dark:text-white">{{ __('orders.order-products') }}: (<span
                            id="productCount">{{ $prices->amount }}</span>)</p>

                    <div class="order-total">
                        <div>
                            <p class="dark:text-white">{{ __('orders.order-total') }}:</p>
                            <p class="dark:text-white">{{ __('orders.currency-symbol') }}<span
                                    id="shoppingCartTotal">{{ $prices->total }}</span></p>
                        </div>
                        <div>
                            <p class="dark:text-white">{{ __('orders.order-sale') }}:</p>
                            <p class="dark:text-white">{{ __('orders.currency-symbol') }}<span
                                    id="shoppingCartSale">{{ $prices->sale }}</span></p>
                        </div>
                    </div>

                    <hr class="border-gray-800 dark:border-white">
                    </hr>

                    <a href="{{ route('orders.order') }}">
                        <button type="submit"
                            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            {{ __('orders.order-to-order') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="shoppingcartUpdate" value="{{ route('shoppingcart.update') }}">
</main>
@endsection
