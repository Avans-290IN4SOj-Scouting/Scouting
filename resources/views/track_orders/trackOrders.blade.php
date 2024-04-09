@extends('layouts.base')
@props(['orders', 'mostExpensiveProductsByOrder'])

@section('content')
    <main class="flex flex-col w-full items-center space-y-5">
        @foreach ($orders as $order)
            <x-order 
            :order="$order"
            :product="$mostExpensiveProductsByOrder[$order->id]"
            />
        @endforeach
    </main>
@endsection
