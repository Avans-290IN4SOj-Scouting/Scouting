@extends('layouts.base')

@section('title', 'Your Page Title')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/orders/order.css') }}">
@endpush

@section('content')
@include('orders.delete_this')

<main>
    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
        {{ __('orders.order') }}
    </h1>

    <form method="POST">
        <div class="idk">
            <div>
                <div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
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
                                <label for="af-account-email"
                                    class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                    {{ __('orders.email') }}
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <input id="af-account-email" type="email" placeholder="{{ __('orders.email') }}"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            </div>
                            <!-- Email -->

                            <!-- Lid Naam -->
                            <div class="sm:col-span-3">
                                <div class="inline-block">
                                    <label for="af-account-phone"
                                        class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                        {{ __('orders.lid-name') }}
                                    </label>
                                </div>
                            </div>
                            <div class="sm:col-span-9">
                                <div class="sm:flex">
                                    <input id="af-account-phone" type="text" placeholder="{{ __('orders.lid-name') }}"
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
                            <div class="sm:col-span-3">
                                <label for="af-account-email"
                                    class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                    {{ __('orders.billing-address') }}
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <input id="af-account-email" type="email" placeholder="{{ __('orders.email') }}"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="af-account-email"
                                    class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                    {{ __('orders.email') }}
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <input id="af-account-email" type="email" placeholder="{{ __('orders.email') }}"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="af-account-email"
                                    class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                    {{ __('orders.email') }}
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <input id="af-account-email" type="email" placeholder="{{ __('orders.email') }}"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            </div>
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
                    <p class="dark:text-white">
                        {{ __('orders.order-products') }}: (<span id="productCount">{{ 1 }}</span>)
                    </p>

                    <div class="order-total">
                        <div>
                            <p class="dark:text-white">{{ __('orders.order-total') }}:</p>
                            <p class="dark:text-white">
                                {{ __('orders.currency-symbol') }}<span id="shoppingCartTotal">{{ 1 }}</span>
                            </p>
                        </div>
                        <div>
                            <p class="dark:text-white">{{ __('orders.order-sale') }}:</p>
                            <p class="dark:text-white">
                                {{ __('orders.currency-symbol') }}<span id="shoppingCartSale">{{ 1 }}</span>
                            </p>
                        </div>
                    </div>

                    <hr class="border-gray-800 dark:border-white"></hr>

                    <a {{-- href="{{ route('orders.order') }}" --}}>
                        <button type="submit"
                            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            {{ __('orders.order-to-order') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </form>
</main>

@endsection