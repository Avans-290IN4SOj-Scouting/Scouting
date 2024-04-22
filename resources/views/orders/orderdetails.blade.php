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

    <div class="shadow p-4 m-4 rounded-xl">
        <div class="m-4">
            <div class="flex flex-col gap-4 lg:flex-row justify-between items-center w-full dark:text-white">
                <div class="mb-2 sm:mb-0">
                    <div class="text-4xl">{{ __('orders/orders.order') }} 123234</div>
                </div>
                <div class="flex flex-col sm:flex-row justify-center gap-4 items-center">
                    <div>{{ __('orders/orders.order-date') }}</div>
                    <div class="p-2 rounded shadow dark:border dark:border-gray-700">01-04-2024</div>
                </div>
                <div class="flex flex-col sm:flex-row justify-center gap-4 items-center">
                    <div>{{ __('orders/orders.total-price') }}</div>
                    <div class="p-2 rounded shadow dark:border dark:border-gray-700">€60,00</div>
                </div>
                <div>Geannuleerd</div>
            </div>
        </div>

        <div class="m-4 flex flex-row justify-center lg:justify-normal items-center">
            <button
                class="bg-red-600 text-white rounded p-2 hover:bg-red-900">{{ __('orders/orders.cancel-order') }}</button>
        </div>

        @for($i = 0; $i < 3; $i++)

            <div class="m-4">
                <div class="flex flex-col gap-1 sm:gap-0 pb-1 sm:pb-0 sm:flex-row justify-between items-center sm:pr-6 rounded-xl border dark:text-white dark:border-gray-700">
                    <img src="https://placehold.co/200" alt="product image" class="rounded-t-xl sm:rounded-tr-none sm:rounded-l-xl w-full sm:w-fit h-auto">
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