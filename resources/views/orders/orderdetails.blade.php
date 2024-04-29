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
                <div class="flex flex-col justify-normal mb-2 sm:mb-0">
                    <div class="text-4xl">{{ __('orders/orders.order') }} {{ $order->id }}</div>
                    <div class="mt-4">
                        <button
                            class="bg-red-600 text-white rounded p-2 hover:bg-red-900">{{ __('orders/orders.cancel-order') }}</button>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row justify-between gap-10 lg:w-3/5">
                    <div class="flex flex-row gap-2 items-baseline">
                        <div>{{ __('orders/orders.order-date') }}</div>
                        <div class="p-2 rounded shadow h-11 dark:border dark:border-gray-700">{{ App\Helpers\DateFormatter::format($order->order_date) }}</div>
                    </div>
                    <div class="flex flex-row gap-2 items-baseline">
                        <div>{{ __('orders/orders.total-price') }}</div>
                        <div class="p-2 rounded shadow h-11 dark:border dark:border-gray-700">{{ $totalPrice }}</div>
                    </div>
                    <div class="sm:mt-2.5">
                        <p class="{{ \App\Enum\DeliveryStatus::delocalised($order->status) }}">
                            {{ $order->status }}
                        </p>
                    </div>
                </div>
            </div>
        </div>


        @foreach($orderLines as $orderLine)

            <div class="m-4">
                <div
                    class="flex flex-col gap-1 sm:gap-0 pb-1 sm:pb-0 sm:flex-row justify-between items-center sm:pr-6 rounded-xl border dark:text-white dark:border-gray-700">
                    <img src="{{ $orderLine->product_image_path }}" alt="Image of {{ $orderLine->product->name }}"
                         class="rounded-t-xl sm:rounded-tr-none sm:rounded-l-xl w-full sm:w-48 h-auto">
                    <div class="w-28 text-center">
                        <a href="#" class="font-bold">
                            {{ $orderLine->product->name }}
                        </a>
                    </div>
                    <div class="w-28 text-center">{{ $orderLine->product_size }}</div>
                    <div class="w-28 text-center">{{ $orderLine->product_price }}</div>
                    <div>{{ $orderLine->amount }} {{ __('orders/orders.amount-items') }}</div>
                </div>
            </div>

        @endforeach
    </div>

@endsection
