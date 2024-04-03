@extends('layouts.base')
@props(['order'])

@php
    
@endphp

@section('content')
    <main class="flex flex-col w-full justify-center align-center">
        <div class="rounded-md w-4/5 bg-gray-200 min-h-40 flex flex-row items-center justify-between">
           <p>
                Bestelling {{$order->id}}
           </p>
           <p>
                Besteldatum {{$order->order_date}}
           </p>
        </div>
        @foreach ($order->orderLines as $orderLine)
            <x-orderLine :orderLine="$order"/>
        @endforeach
    </main>
@endsection
