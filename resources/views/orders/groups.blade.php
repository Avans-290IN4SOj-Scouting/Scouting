@extends('layouts.base')

@section('title', __('orders.store'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/orders/groups.css') }}">
@endpush

@section('content')

<div id="wrapper">
    <div id="header">
        <h1 class="mb-4 font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-5xl dark:text-white">
            {{ __('orders.store') }}
        </h1>
    </div>

    <div id="main">
        <div class="group-container">
            @foreach ($groups as $group)
                <div class="group-item">
                    <a href="{{ route('orders.overview', ['category' => $group->name]) }}">
                    <div class="image">
                        <img src="{{ $group->image_url }}">
                    </div>

                    <p class="group-name">{{ $group->name }}</p>
                </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
