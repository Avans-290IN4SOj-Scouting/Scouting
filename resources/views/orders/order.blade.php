@extends('layouts.base')

@section('title', 'Bestelling afronden')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/orders/order.css') }}">
@endpush

@section('content')

<div id="wrapper">
    <div id="header">
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
            {{ __('orders.order') }}
        </h1>
    </div>

    <div id="main">
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', (event) => {
                    createToast("{{ __('orders.incorrect-form-data') }}", 'error');
                });
            </script>
        @endif
        <form name="completeOrder" method="POST" action="{{ route('orders.complete-order') }}">
            @csrf
            <div class="idk">
                <div>
                    <div class="max-w-4xl px-4 sm:px-6 mx-auto">
                        <!-- Card -->
                        <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                            <div class="mb-8">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                    {{ __('orders.temp-title')}}
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('orders.fill-information')}}
                                </p>
                            </div>

                            <!-- Grid -->
                            <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                                <!-- Email -->
                                <div class="sm:col-span-3">
                                    <label for="email"
                                        class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                        {{ __('orders.email') }}
                                    </label>
                                </div>
                                <div class="sm:col-span-9">
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="{{ __('orders.email') }}"
                                        class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                </div>
                                <!-- Email -->

                                <!-- Lid Naam -->
                                <div class="sm:col-span-3">
                                    <div class="inline-block">
                                        <label for="lid-name"
                                            class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                            {{ __('orders.lid-name') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="sm:col-span-9">
                                    <div class="sm:flex">
                                        <input id="lid-name" name="lid-name" type="text" value="{{ old('lid-name') }}" placeholder="{{ __('orders.lid-name') }}"
                                            class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                        <select class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">

                                            <option selected>{{ __('orders.groups') }}</option>
                                            @foreach ($groups as $group)
                                                <option>{{ $group }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Lid Naam -->

                                <div class="sm:col-span-12">
                                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                        {{ __('orders.billing-address')}}
                                    </h2>
                                    <hr class="border-gray-800 dark:border-white" style="margin-top: 0.5rem;"></hr>
                                </div>

                                <!-- Address -->
                                <!-- Postcode + Huisnummer -->
                                <div class="sm:col-span-3">
                                    <label
                                        class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                        {{ __('orders.postal-code') }} en {{ __('orders.housenumber') }}
                                    </label>
                                </div>
                                <div class="sm:col-span-5">
                                    <input id="postalCode" name="postalCode" type="text" value="{{ old('postalCode') }}" placeholder="{{ __('orders.postal-code') }}"
                                        class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                </div>

                                <div class="sm:col-span-2">
                                    <input id="houseNumber" name="houseNumber" type="text" value="{{ old('houseNumber') }}" placeholder="{{ __('orders.housenumber') }}"
                                        class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                </div>

                                <div class="sm:col-span-2">
                                    <input id="houseNumberAddition" name="houseNumberAddition" value="{{ old('houseNumberAddition') }}" type="text" placeholder="{{ __('orders.housenumber-addition') }}"
                                        class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                </div>
                                <!-- /Postcode + Huisnummer -->

                                <!-- Straatnaam en Plaatsnaam -->
                                <div class="sm:col-span-3">
                                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                        {{-- {{ __('orders.email') }} --}}
                                        {{ __('orders.streetname') }} en {{ __('orders.cityName') }}
                                    </label>
                                </div>

                                <div class="sm:col-span-4">
                                    <input id="streetname" name="streetname" type="text" value="{{ old('streetname') }}" placeholder="{{ __('orders.streetname') }}"
                                        class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                </div>
                                <div class="sm:col-span-5">
                                    <input id="cityName" name="cityName" type="text" value="{{ old('cityName') }}" placeholder="{{ __('orders.cityName') }}"
                                        class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                </div>
                                <!-- Straatnaam en Plaatsnaam -->
                                <!-- Address -->
                            </div>
                            <!-- End Grid -->
                        </div>
                        <!-- End Card -->
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="order-data">
                        <h2 class="text-4xl font-extrabold dark:text-white">{{ __('orders.shoppingcart-order') }}</h2>
                        <p class="dark:text-white">{{ __('orders.order-products') }}: (<span
                            id="productCount">{{ $prices->amount }}</span>)
                        </p>

                        <ul>
                            @foreach ($products as $product)
                            <li class="dark:text-white">
                                {{ $product->amount }}x {{ $product->name }}, {{ __('orders.size') }} {{ $product->size }},
                                @if ($product->discount == 0)
                                    <span class="dark:text-white">{{ __('orders.currency-symbol') }}{{ $product->price }}</span>
                                @else
                                    <span class="pre-discount-price dark:text-white">{{ __('orders.currency-symbol') }}{{ $product->price }}</span>
                                    <span>{{ __('orders.currency-symbol') }}{{ ($product->price * (1 - $product->discount)) }}</span>
                                 @endif
                            </li>
                            @endforeach
                        </ul>


                        <hr class="border-gray-800 dark:border-white">
                        </hr>

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

                        <button type="submit"
                                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                {{ __('orders.complete-order') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
