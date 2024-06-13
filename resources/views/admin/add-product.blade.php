@extends('layouts.base')
@push('scripts')
    <script src="{{ asset('js/manage-products/product.js') }}" defer></script>
@endpush

@section('content')
    <x-breadcrumbs :names="[__('manage-products/products.index_page_title'), __('manage-products/products.create_page_title')]" :routes="[route('manage.products.index'), route('manage.products.create.index')]" />

    <body class="bg-gray-100">
        <div class="container mx-auto px-4 py-8">
            <h1 id="add-product-heading" class="text-3xl font-bold text-gray-700 mb-4">
                {{ __('manage-products/products.create_page_title') }}</h1>

            <!-- Product Form and Image Section -->
            <form action="{{ route('manage.products.create.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Product Form -->
                    <div class="space-y-4">
                        <!-- Product Name Field -->
                        <x-input :label="__('manage-products/products.name_label')" id="product-name" type="text" :placeholder="__('manage-products/products.name_placeholder')" name="name"
                            :disabled="false" :error="$errors->first('name')" />

                        <!-- Sizes & Prices -->
                        <div>
                            <p class="block text-gray-700 font-semibold">Prijzen</p>
                            <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <div id="size-price-options" class="space-y-4">
                                    <div id="size-price-inputs-jeroen" class="flex flex-col gap-4">
                                        <div id="price-size-inputs" class="flex flex-col gap-4">
                                            <x-product-price-size-entry :sizes="$sizes" />
                                        </div>

                                        <button dusk="addPriceSize" type="button" onclick="addPriceSizeInput()"
                                            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                            {{ __('manage-products/products.add_size') }}
                                        </button>
                                    </div>
                                </div>

                                @if (session('error_same_product_size'))
                                <p class="text-xs text-red-600 mt-2" id="error_same_product_size-error">
                                    {{ session('error_same_product_size') }}
                                </p>
                                @endif
                                <x-error :error="$errors->first('price_input.0')" :id="'price_input.0'" />
                            </div>
                        </div>
                        <!-- /Sizes & Prices -->

                    <!-- Select Groups Field -->
                    <x-multiselect :label="__('manage-products/products.groups_multi_select_label')" :placeholder="__('manage-products/products.groups_multi_select_placeholder')" :options="$baseGroups->pluck('name')"
                        name="products-group-multiselect" class="manage-products/products.groups-multiselect" />

                    <!-- Product Category Field -->
                    <x-singleselect :label="__('manage-products/products.category_input_label')" :placeholder="__('manage-products/products.category_input_placeholder')" :options="$baseCategories->pluck('type')" id="product-category"
                        name="products-category-select" class="manage-products/products.category-select" />

                    <!-- Product Variety Field -->
                    <x-singleselect :label="__('manage-products/products.variety_input_label')" :placeholder="__('manage-products/products.variety_input_placeholder')" :options="$baseVarieties->pluck('variety')" id="product-variety"
                        name="products-variety-select" class="manage-products/products.variety-select" />

                    <!-- Add Product Button -->
                    <button type="submit" id="add-product-button"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        {{ __('manage-products/products.product_add_button') }}
                    </button>
                </div>

                <div class="container mx-auto">
                    <!-- Upload image -->
                    <div id="file-upload-form" class="relative overflow-hidden bg-white rounded-lg shadow-md">
                        <input id="file-upload" type="file" name="picture" accept="image/*" class="hidden" />
                        <label for="af-submit-app-upload-images" id="drop-area"
                            class="group p-6 sm:p-7 block cursor-pointer text-center border-2 border-dashed border-gray-200 rounded-lg focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 dark:border-gray-700">
                            <input id="af-submit-app-upload-images" name="af-submit-app-upload-images" type="file"
                                class="sr-only">
                            <div class="flex justify-center items-center containerMaxH">
                                <img id="file-image" src="#" alt="Preview" class="hidden containerMaxH">
                            </div>
                            <svg id="not-image" class="size-10 mx-auto text-gray-400 dark:text-gray-600"
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z" />
                                <path
                                    d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                            </svg>
                            <span
                                class="mt-2 block text-sm text-gray-800 dark:text-gray-200">{{ __('manage-products/products.product_image_span') }}</span>
                        </label>
                    </div>
                    <x-error :error="$errors->first('af-submit-app-upload-images')" id="af-submit-app-upload-images" />
                </div>
            </div>
        </form>
    </div>
</body>

<template id="price-size-template">
    <x-product-price-size-entry :sizes="$sizes" />
</template>

@endsection
