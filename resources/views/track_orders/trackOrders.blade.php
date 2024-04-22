@extends('layouts.base')
@props(['orders', 'mostExpensiveProductsByOrder'])

@php
    $title = __('order_tracking.order_tracking_title');
@endphp

@section('content')
    <div class="shadow p-4 m-4 rounded-xl">
        @foreach ($orders as $order)
            <x-order 
            :order="$order"
            :product="$mostExpensiveProductsByOrder[$order->id]"
            />
        @endforeach
    </div>
@endsection
