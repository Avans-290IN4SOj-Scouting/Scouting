@extends('layouts.base')
@props(['orders'])

@php
    $title = __('orders/orders.overview_user_title');
@endphp

@section('content')
    <div class="breadcrumbs-container">
        <ol class="flex items-center whitespace-nowrap" aria-label="Breadcrumb">
            <li class="inline-flex items-center">
                <a href="{{ route('profile.index') }}"
                   class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500">
                    {{ ucfirst(__('orders/orders.profile')) }}
                </a>
                <svg class="flex-shrink-0 mx-2 overflow-visible size-4 text-gray-400 dark:text-neutral-600"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"/>
                </svg>
            </li>
            <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate dark:text-gray-200"
                aria-current="page">
                {{ ucfirst(__('orders/orders.overview_orders')) }}
            </li>
        </ol>
    </div>

    <div class="shadow p-4 m-4 rounded-xl flex flex-col gap-4">
        @foreach ($orders as $order)
            <a href="{{ route('orders.detail', ['id' => $order->id]) }}">
                <x-order-preview :order="$order"/>
            </a>
        @endforeach
    </div>
@endsection
