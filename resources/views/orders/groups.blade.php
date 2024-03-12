@extends('layouts.base')

@section('title', 'TODO')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/orders/groups.css') }}">
@endpush

@section('content')

<div id="wrapper">
    <div id="header">
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
            {{ __('orders.store') }}
        </h1>
    </div>

    <div id="main">
        <div class="group-container">
            @foreach ($groups as $group)
            <a href="{{ route('orders.overview', ['category' => $group->name]) }}">
                <div class="group-item">
                    <div class="image">
                        <img src="{{ $group->image_url }}">
                    </div>

                    <p class="group-name">{{ $group->name }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

@endsection
