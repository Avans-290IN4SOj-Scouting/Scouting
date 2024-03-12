@extends('layouts.base')

@section('title', __('complete-order'))

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
        @if (auth()->check())
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
                                            class="{{ $errors->has('lid-name') ? 'form-error-input' : '' }} py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                        <select name="group"
                                            class="{{ $errors->has('group') ? 'form-error-input' : '' }} py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('lid-name')
                                        <p class="form-error-text">{{ __('orders.form-lid-name-error') }}</p>
                                    @enderror
                                    @error('group')
                                        <p class="form-error-text">{{ __('orders.form-group-error') }}</p>
                                    @enderror
                                </div>
                                <!-- Lid Naam -->
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

                        @if (auth()->check())
                            <button type="submit"
                                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                    {{ __('orders.complete-order') }}
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                <p>{{ __('orders.log-in') }}</p>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @if (auth()->check())
            </form>
        @endif
    </div>
</div>

@endsection
