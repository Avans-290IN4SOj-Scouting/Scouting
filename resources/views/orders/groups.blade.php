@extends('layouts.base')

@php
    $title = __('orders/orders.store');
@endphp

@push('styles')
<link rel="stylesheet" href="{{ secure_asset('css/orders/main.css') }}">
<link rel="stylesheet" href="{{ secure_asset('css/orders/groups.css') }}">
@endpush

@section('content')

<div id="wrapper">
    <div id="header">
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-5xl dark:text-white">{{ __('orders/orders.store') }}</h1>
    </div>

    <div id="main">
        <div class="group-container">
            @foreach ($groups as $group)
            <a dusk="{{ $group->name }}" class="group-item" href="{{ route('orders.overview', ['category' => $group->name]) }}">
                <div class="image">
                    <img src="{{ secure_asset($group->image_url) }}" alt="{{ __('orders/orders.accessibility-group-image') }} {{ $group->name }} {{ __('orders/orders.group') }}">
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

@endsection
