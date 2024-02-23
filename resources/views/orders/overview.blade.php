@extends('layouts.base')

@section('title', 'Your Page Title')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
@endpush

@section('content')
    <h1>{{ $productCategory }} - Producten</h1>

    <div class="hs-dropdown relative inline-flex">
        <button id="hs-dropdown-default" type="button" class="hs-dropdown-toggle py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
            Selecteer maat
            <svg class="hs-dropdown-open:rotate-180 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
        </button>

        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg p-2 mt-2 dark:bg-gray-800 dark:border dark:border-gray-700 dark:divide-gray-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full" aria-labelledby="hs-dropdown-default">
            @foreach ($sizes as $size)
                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:bg-gray-700" href="#">
                    {{ $size }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="products-container">
        @foreach ($products as $product)
            <div class="product">
                <a href="#">
                    <div class="flex flex-col bg-white rounded-xl dark:bg-slate-900">
                        <img class="rounded-t-xl" src="https://placehold.co/200x200" alt="Image Description">
                        <div class="p-2 ">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-white">
                            {{ $product }}
                        </h4>
                        <p>
                            <span class="pre-discount-price dark:text-white">€12,34</span>
                            <span class="dark:text-white">€12,34</span>
                        </p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
