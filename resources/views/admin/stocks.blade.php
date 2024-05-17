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
        <form method="POST" action="{{ route('manage.stocks.destroy') }}">
            @csrf
            @method('DELETE')
            <div class="m-8">
                <x-modal :button-text="__('manage-stocks/stocks.empty_inventory')"
                         :title="__('manage-stocks/stocks.empty_inventory')"
                         :modal-button="__('manage-stocks/stocks.empty_inventory_confirm')"
                         :modal-text="__('manage-stocks/stocks.empty_inventory_text')"
                         :route="route('manage.stocks.destroy')"
                         color="red"/>
            </div>
        </form>
    </div>

    <div class="accordion-group bg-transparent border rounded-xl dark:border-gray-700 border-gray-300">
        @foreach($products as $product)
            <div id="accordion-item-{{$loop->index + 1}}"
                 class="accordion-item @if(!$loop->last) border-b dark:border-gray-700 border-gray-300 @endif">
                <div class="accordion-header p-1.5 py-3">
                    <svg class="size-3.5 inactive dark:text-white mx-1.5" xmlns="http://www.w3.org/2000/svg" width="24"
                         height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M5 12h14"></path>
                        <path d="M12 5v14"></path>
                    </svg>
                    <svg class="size-3.5 active dark:text-white mx-1.5" xmlns="http://www.w3.org/2000/svg" width="24"
                         height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M5 12h14"></path>
                    </svg>
                    <p class="font-semibold text-lg dark:text-white">
                        {{$product->name}}
                    </p>
                </div>
                <div class="accordion-content">
                    @foreach($product->productTypes as $productType)
                        <form method="POST" action="{{ route('manage.stocks.update', ['product' => $product->id, 'type' => $productType->id]) }}">
                            @csrf
                            @method('PUT')
                            <div
                                class="accordion-group bg-transparent dark:border-gray-700 border-gray-300">
                                <div id="accordion-item-{{$loop->index + 1}}-{{$loop->index + 1}}"
                                     class="accordion-item @if(!$loop->last) border-b dark:border-gray-700 border-gray-300 @endif">
                                    <div class="accordion-header ps-6 py-3">
                                        <svg class="size-3.5 inactive dark:text-white mx-1.5"
                                             xmlns="http://www.w3.org/2000/svg"
                                             width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5v14"></path>
                                        </svg>
                                        <svg class="size-3.5 active dark:text-white mx-1.5" xmlns="http://www.w3.org/2000/svg"
                                             width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                        </svg>
                                        <p class="font-semibold text-base dark:text-white">
                                            {{ $productType->type }}
                                        </p>
                                    </div>
                                    <div class="accordion-content ps-6 py-2.5 space-x-1">
                                        @foreach ($product->productSizes as $productSize)
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-300 dark:border-gray-700 border overflow-hidden shadow-md">
                                                <label
                                                    for="size-{{strtolower($productSize->size)}}-{{$loop->parent->parent->index + 1}}-{{$loop->index + 1}}"
                                                    class="text-black font-semibold px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    {{ $productSize->size }}
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-300 dark:border-gray-700"></div>
                                                <input
                                                    name="size-{{strtolower($productSize->size)}}-{{$loop->parent->parent->index + 1}}-{{$loop->index + 1}}"
                                                    id="size-{{strtolower($productSize->size)}}-{{$loop->parent->parent->index + 1}}-{{$loop->index + 1}}"
                                                    class="p-0 w-6 font-semibold bg-transparent border-0 text-black text-center dark:text-white focus:border-gray-300 dark:focus:border-gray-700 focus:ring-1 focus:ring-gray-300 dark:focus:ring-gray-700 focus:rounded-l-none focus:rounded-r-lg"
                                                    type="text"
                                                    value="{{ $product->stocks->where('product_size_id', $productSize->id)->where('product_type_id', $productType->id)->first()->amount ?? 0 }}">
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
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
