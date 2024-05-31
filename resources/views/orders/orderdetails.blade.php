@extends('layouts.base')

@php
    $title = __('orders/orders.order-details');
@endphp

@section('content')

    <div class="text-sm">
        <a href="{{ route('orders.overview.user') }}" class="flex flex-row items-center hover:text-blue-600 dark:text-white dark:fill-white">
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
                    <div class="text-4xl">{{ __('orders/orders.order') . ' ' . $order->id }}</div>

                    @if($isCancellable)
                        <div class="mt-4">
                            <x-modal :button-text="__('orders/order_details.cancel_order')" :title="__('orders/order_details.cancel_order') . ' ' . $order->id"
                                     :modal-button="__('orders/order_details.cancel_order_confirm')" :modal-text="__('orders/order_details.cancel_order_text')"
                                     :route="route('orders.detail', ['id' => $order->id])" color="red" />
                        </div>
                    @endif

                </div>
                <div class="flex flex-col sm:flex-row justify-between gap-10 lg:w-3/5">
                    <div class="flex flex-row gap-2 items-baseline">
                        <p>{{ __('orders/orders.order-date') }}</p>
                        <p class="p-2 rounded shadow h-auto dark:border dark:border-gray-700 whitespace-wrap">{{ App\Helpers\DateFormatter::format($order->order_date) }}</p>
                    </div>
                    <div class="flex flex-row gap-2 items-baseline">
                        <div>{{ __('orders/orders.total-price') }}</div>
                        <div class="p-2 rounded shadow h-11 dark:border dark:border-gray-700">{{ __('common.currency_symbol') . number_format($totalPrice, 2, __('common.seperator'), '.') }}</div>
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
                    <img src="{{ asset($orderLine->product_image_path) }}" alt="{{ __('common.image_of') . $orderLine->product->name }}"
                         class="rounded-t-xl sm:rounded-tr-none sm:rounded-l-xl w-full sm:w-48 h-auto">
                    <div class="w-28 text-center">
                        <a href="{{ route('orders.product', [ 'name' => $orderLine->product->name, 'groupName' => $orderLine->product->group_name]) }}"
                           class="font-bold">
                            {{ $orderLine->product->name }}
                        </a>
                    </div>
                    <div class="w-28 text-center">{{ __('orders/orders.size') . ' ' . $orderLine->product_size }}</div>
                    <div class="w-28 text-center">{{ __('common.currency_symbol') . number_format($orderLine->product_price, 2, __('common.seperator'), '.')  }}</div>
                    <div>{{ $orderLine->amount }} {{ __('orders/orders.amount-items') }}</div>
                </div>
            </div>

        @endforeach
    </div>

@endsection
