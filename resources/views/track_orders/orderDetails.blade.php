@extends('layouts.base')
@props(['order', 'total'])

@php
    $title = __('order_tracking.order_details_title');
@endphp

@section('content')
    <div class="text-sm">
        <a href="/{{__('route.track_orders')}}" class="flex flex-row items-center hover:text-blue-600 dark:text-white dark:fill-white">
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
                    <div class="text-4xl">{{ __('orders/orders.order') }} {{$order->id}}</div>
                </div>
                <div class="flex flex-col sm:flex-row justify-center gap-4 items-center">
                    <div>{{ __('orders/orders.order-date') }}</div>
                    <div class="p-2 rounded shadow dark:border dark:border-gray-700">{{substr($order->order_date, 0, 11)}}</div>
                </div>
                <div class="flex flex-col sm:flex-row justify-center gap-4 items-center">
                    <div>{{ __('orders/orders.total-price') }}</div>
                    <div class="p-2 rounded shadow dark:border dark:border-gray-700"><x-displayCurrency :price="$total"></x-displayCurrency></div>
                </div>
                <div> {{$order->orderStatus->status}} </div>
            </div>
        </div>

        <div class="m-4 flex flex-row justify-center lg:justify-normal items-center">
            <button
                class="bg-red-600 text-white rounded p-2 hover:bg-red-900">{{ __('orders/orders.cancel-order') }}</button>
        </div>

        @foreach ($order->orderLine as $orderLine)
            <x-orderLine :orderLine="$orderLine"/>
        @endforeach      
    </div>

@endsection
