@extends('layouts.base')
@props(['orders'])

@php
    
@endphp

@section('content')
    <main class="flex flex-col w-full items-center space-y-5">
        @foreach ($orders as $order)
            <x-order :order="$order"/>
        @endforeach
    </main>
@endsection
