@extends('layouts.base')

@php
    $title = __('orders/orders.order-details');
@endphp

@section('content')

    <!-- TODO: replace hardcoded string w/ attributes -->

    <div class="text-sm">
        <a href="#" class="flex flex-row items-center hover:text-blue-600 dark:text-white dark:fill-white">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div>{{ __('orders/orders.back-to-orders') }}</div>
        </a>
    </div>

    <div class="shadow p-4 rounded-xl">
        <div class="m-4">
            <div class="flex flex-col gap-4 justify-between md:flex-row w-full dark:text-white">
                <div class="flex flex-row md:flex-col justify-between md:justify-normal items-center md:items-baseline mb-2 sm:mb-0">
                    <div class="text-4xl">{{ __('orders/orders.order') }} 123234</div>
                    <div class="md:mt-4">
                        <button
                            class="bg-red-600 text-white rounded p-2 hover:bg-red-900">{{ __('orders/orders.cancel-order') }}</button>
                    </div>
                </div>
                <div class="flex md:flex-row justify-between gap-10 lg:w-3/5">
                    <div class="flex flex-col md:flex-row justify-center gap-2 items-baseline">
                        <div>{{ __('orders/orders.order-date') }}</div>
                        <div class="p-2 rounded shadow h-11 dark:border dark:border-gray-700">01-04-2024</div>
                    </div>
                    <div class="flex flex-col md:flex-row justify-center gap-2 items-baseline">
                        <div>{{ __('orders/orders.total-price') }}</div>
                        <div class="p-2 rounded shadow h-11 dark:border dark:border-gray-700">€60,00</div>
                    </div>
                    <!-- Added to test colors, currently hardcoded -->
                    <div class="mt-2.5">
                        <p class="{{ \App\Enum\DeliveryStatus::delocalised('Geannuleerd') }}">
                            Geannuleerd
                        </p>
                    </div>
                </div>
            </div>
        </div>


        @for($i = 0; $i < 3; $i++)

            <div class="m-4">
                <div
                    class="flex flex-col gap-1 sm:gap-0 pb-1 sm:pb-0 sm:flex-row justify-between items-center sm:pr-6 rounded-xl border dark:text-white dark:border-gray-700">
                    <img src="https://placehold.co/200" alt="product image"
                         class="rounded-t-xl sm:rounded-tr-none sm:rounded-l-xl w-full sm:w-fit h-auto">
                    <div class="">
                        <a href="#" class="font-bold">
                            Product titel
                        </a>
                    </div>
                    <div>M</div>
                    <div>€10,00</div>
                    <div>2 {{ __('orders/orders.amount-items') }}</div>
                </div>
            </div>

        @endfor
    </div>

@endsection
