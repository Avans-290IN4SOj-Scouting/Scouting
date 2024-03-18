@extends('layouts.base')

@section('title', __('orders.complete-order'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/orders/order.css') }}">
@endpush

@section('content')

<div id="wrapper">
    <div id="header">
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-5xl dark:text-white">
            {{ __('orders.order') }}
        </h1>
    </div>

    <div id="main">
        @if (auth()->check() && count($products) > 0)
            <form name="completeOrder" method="POST" action="{{ route('orders.complete-order') }}">
        @endif

            @csrf
            <div class="order-container">
                <div>
                    <div class="max-w-4xl px-4 sm:px-6 mx-auto">
                        <!-- Card -->
                        <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                            <div class="mb-8">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                    {{ __('orders.order-data')}}
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('orders.fill-information')}}
                                </p>
                            </div>

                            <!-- Grid -->
                            <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                                <div class="sm:col-span-3">
                                    <div class="inline-block">
                                        <label for="lid-name"
                                            class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                            {{ __('orders.lid-name') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="sm:col-span-9">
                                    <div class=sm:flex>
                                        <div>
                                            <input id="lid-name" name="lid-name" type="text" value="{{ old('lid-name') }}" placeholder="{{ __('orders.lid-name') }}"
                                                class="{{ $errors->has('lid-name') ? 'form-error-input' : '' }} py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px rounded-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                        </div>
                                        @error('lid-name')
                                            <p class="form-error-text">{{ __('orders.form-lid-name-error') }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <div class="inline-block">
                                        <label for="scouting-group"
                                            class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                            {{ __('orders.group') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="sm:col-span-9">
                                    <div class="relative">
                                        <select id="scouting-group" name="scouting-group" class="peer p-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600
                                        focus:pt-6
                                        focus:pb-2
                                        [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2
                                        autofill:pt-6
                                        autofill:pb-2">
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                            @endforeach
                                        </select>

                                        <label class="absolute top-0 start-0 p-4 h-full truncate pointer-events-none transition ease-in-out duration-100 border border-transparent dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
                                        peer-focus:text-xs
                                        peer-focus:-translate-y-1.5
                                        peer-focus:text-gray-500
                                        peer-[:not(:placeholder-shown)]:text-xs
                                        peer-[:not(:placeholder-shown)]:-translate-y-1.5
                                        peer-[:not(:placeholder-shown)]:text-gray-500">{{ __('orders.group') }}</label>
                                    </div>
                                </div>
                                @error('scouting-group')
                                    <p class="form-error-text">{{ __('orders.form-group-error') }}</p>
                                @enderror
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
                                <span class="dark:text-white">{{ __('currency.symbol') }}
                                    {{ number_format($product->price, 2, __('currency.seperator'), '.') }}
                                </span>
                            </li>
                            @endforeach
                        </ul>


                        <hr class="border-gray-800 dark:border-white">
                        </hr>

                        <div class="order-total">
                            <div>
                                <p class="dark:text-white">{{ __('orders.order-total') }}:</p>
                                <p class="dark:text-white">{{ __('currency.symbol') }}<span
                                        id="shoppingCartTotal">
                                        {{ number_format($prices->total, 2, __('currency.seperator'), '.') }}
                                    </span></p>
                            </div>
                        </div>


                        <hr class="border-gray-800 dark:border-white">
                        </hr>

                        @if (auth()->check() && count($products) > 0)
                            <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                {{ __('orders.complete-order') }}
                              </button>
                        @elseif (count($products) == 0)
                            <p>{{ __('orders.empty-shoppingcart') }}</p>
                        @else
                            <a href="{{ route('login') }}"
                            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                <p>{{ __('orders.log-in') }}</p>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @if (auth()->check() && count($products) > 0)
            </form>
        @endif
    </div>
</div>

@endsection
