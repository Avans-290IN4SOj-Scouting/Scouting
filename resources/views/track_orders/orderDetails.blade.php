@extends('layouts.base')
@props(['order', 'total'])

@php
    $title = __('order_tracking.order_details_title');
@endphp

@section('content')

<div class="breadcrumbs-container">
    <ol class="flex items-center whitespace-nowrap" aria-label="Breadcrumb">
        <li class="inline-flex items-center">
            <a href="{{ route('home') }}" class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500">
                <svg class="flex-shrink-0 me-3 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                {{ __('navbar.home') }}
            </a>
            <svg class="flex-shrink-0 mx-2 overflow-visible size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </li>
        <li class="inline-flex items-center">
            <a  href="{{ route('orders.overview', ['category' => $group->name]) }}" class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500">
                {{ $group->name }}
            </a>
            <svg class="flex-shrink-0 mx-2 overflow-visible size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </li>
        <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate dark:text-gray-200" aria-current="page">
            {{ $product->name }}
        </li>
    </ol>
</div>

    <main class="flex flex-col w-full items-center space-y-5">
        <div class="rounded-md bg-gray-200  lg:h-[10vh] h-[20vh] w-4/5 flex flex-row justify-center align-center">
            <div class="flex flex-col lg:flex-row m-4 lg:m-0 items-center justify-between w-4/5 text-xl">
                <div class="h-1/4 lg:h-auto">
                    <a href="{{__('route.track_orders')}}" class="" aria-label="__('order_tracking.aria_label_order_details_return')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-backspace w-16 h-3/4 rotate-90 lg:rotate-0" viewBox="0 0 16 16">
                            <path d="M5.83 5.146a.5.5 0 0 0 0 .708L7.975 8l-2.147 2.146a.5.5 0 0 0 .707.708l2.147-2.147 2.146 2.147a.5.5 0 0 0 .707-.708L9.39 8l2.146-2.146a.5.5 0 0 0-.707-.708L8.683 7.293 6.536 5.146a.5.5 0 0 0-.707 0z"/>
                            <path d="M13.683 1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-7.08a2 2 0 0 1-1.519-.698L.241 8.65a1 1 0 0 1 0-1.302L5.084 1.7A2 2 0 0 1 6.603 1zm-7.08 1a1 1 0 0 0-.76.35L1 8l4.844 5.65a1 1 0 0 0 .759.35h7.08a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z"/>
                          </svg>
                    </a>
                </div>
                <p class="h-1/4 lg:h-auto">
                    {{__('order_tracking.order') . ' ' . $order->id}}
                </p>
                <p class="h-1/4 lg:h-auto">
                    {{__('order_tracking.order_date') . ' ' . substr($order->order_date, 0, 11)}}
                </p>
                @if($order->orderStatus->id == 1)
                <p class="text-red-500 h-1/4 lg:h-auto">
                    {{$order->orderStatus->status}}
                </p>
                @else
                    <p class="text-emerald-500 h-1/4 lg:h-auto">
                        {{$order->orderStatus->status}}
                    </p>
                @endif     
            </div>
           
        </div>
        @foreach ($order->orderLine as $orderLine)
            <x-orderLine :orderLine="$orderLine"/>
        @endforeach
        <div class="rounded-md bg-gray-200  lg:h-[10vh] h-[15vh] w-4/5 flex flex-row justify-center align-center">
            <div class="flex flex-col lg:flex-row m-4 items-center justify-center w-4/5 text-xl">    
                <p class="">
                  {{__('order_tracking.total_amount')}}  <x-displayCurrency :price="$total"></x-displayCurrency>
                </p>
            </div>
        </div>
    </main>
@endsection
