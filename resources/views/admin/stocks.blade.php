@extends('layouts.base')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/accordion/accordion.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('js/accordion/accordion.js') }}" defer></script>
@endpush

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-4xl m-8 dark:text-white">{{ __('manage-stocks/stocks.page_title') }}</h1>
        <form method="POST" action="{{ route('manage.delete') }}">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="me-6 py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 disabled:opacity-50 disabled:pointer-events-none">
                {{ __('manage-stocks/stocks.empty_inventory') }}
            </button>
        </form>
    </div>

    <div class="accordion-group bg-white border rounded-xl dark:bg-slate-900 dark:border-slate-700 border-gray-500">
        @foreach($products as $product)
            <div id="accordion-item-{{$loop->index + 1}}"
                 class="accordion-item @if(!$loop->last) border-b dark:border-slate-700 border-gray-500 @endif">
                <div class="accordion-header p-1.5 py-3">
                    <svg class="size-3.5 inactive dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24"
                         height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M5 12h14"></path>
                        <path d="M12 5v14"></path>
                    </svg>
                    <svg class="size-3.5 active dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24"
                         height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M5 12h14"></path>
                    </svg>
                    <p class="font-semibold text-lg dark:text-white">
                        {{ $product->name }}
                    </p>
                </div>
                {{--                @foreach ($product->productTypes as $type)--}}
                <div class="accordion-content">
                    <form method="POST" action="{{ route('manage.update', $product->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="accordion-group bg-white dark:bg-slate-900 dark:border-slate-700 border-gray-500">
                            <div id="accordion-item-{{$loop->index + 1}}-{{$loop->index + 1}}"
                                 class="accordion-item @if(!$loop->last) border-b dark:border-slate-700 border-gray-500 @endif">
                                <div class="accordion-header ps-6 py-3">
                                    <svg class="size-3.5 inactive dark:text-white" xmlns="http://www.w3.org/2000/svg"
                                         width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg>
                                    <svg class="size-3.5 active dark:text-white" xmlns="http://www.w3.org/2000/svg"
                                         width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                    </svg>
                                    <p class="font-semibold text-base dark:text-white">
                                        {{ $product->productType->type }}
                                    </p>
                                </div>
                                <div class="accordion-content ps-6 py-2.5 space-x-1">
                                    @foreach ($product->productSizes as $size)
                                        <div
                                            class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                            <label
                                                for="size-{{strtolower($size->size)}}-{{$loop->parent->index + 1}}-{{$loop->index + 1}}"
                                                class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                {{ $size->size }}
                                            </label>
                                            <div
                                                class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                            <input
                                                name="size-{{strtolower($size->size)}}-{{$loop->parent->index + 1}}-{{$loop->index + 1}}"
                                                id="size-{{strtolower($size->size)}}-{{$loop->parent->index + 1}}-{{$loop->index + 1}}"
                                                class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white focus:border-white focus:ring-1 focus:ring-white focus:rounded-l-none focus:rounded-r-lg"
                                                type="text"
                                                value="{{ $product->stocks->firstWhere('product_size_id', $size->id)->amount ?? 0 }}">
                                        </div>
                                    @endforeach
                                    <button type="submit"
                                            class="ms-auto py-1 px-2.5 inline-flex items-center text-sm rounded-lg border border-transparent bg-blue-500 text-white hover:bg-blue-600 disabled:opacity-50 disabled:pointer-events-none">
                                        {{ __('manage-stocks/stocks.save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                {{--                @endforeach--}}
            </div>
        @endforeach
    </div>
@endsection
