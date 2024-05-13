@extends('layouts.base')
@push('scripts')
    <script src="{{ asset('js/manage-products/product.js') }}"></script>
    <script src="{{ asset('js/manage-products/product initialise.js') }}" defer></script>
@endpush

@section('content')

    <body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 id="#edit-product-heading" class="text-3xl font-bold text-gray-700 mb-4">
            {{ __('manage-products/products.edit_page_title') }}</h1>
        <form action="{{ route('manage.products.edit.store', ['id' => $product->id]) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Product Form -->
                <div class="space-y-4">
                    <!-- Product Name Field -->
                    @include('partials._input', [
                        'label' => __('manage-products/products.name_label'),
                        'id' => 'product-name',
                        'type' => 'text',
                        'placeholder' => __('manage-products/products.name_placeholder'),
                        'name' => 'name',
                        'value' => $product->name,
                        'disabled' => $nameDisabled,
                    ])

                        @if ($nameDisabled)
                            <input type="hidden" name="name" value="{{ $product->name }}">
                        @endif

                        <!-- Product Size and Price Fields -->
                        @include('partials._price-input', [
                            'label' => __('manage-products/products.price_label'),
                            'id' => 'product-price',
                            'placeholder' => __('manage-products/products.price_placeholder'),
                            'name' => 'priceForSize[Default]',
                            'value' => old('priceForSize.Default', $defaultSizeWithPrice['price']),
                        ])

                        <div>
                            <div id="size-price-options" class="space-y-4">
                                <div class="flex items-center space-x-4">
                                    <input type="checkbox" id="same-price-all" class="form-checkbox text-blue-500 h-5 w-5"
                                        {{ $defaultSizeWithPrice['price'] == null ? 'checked' : '' }}>
                                    <label for="same-price-all"
                                        class="ml-2 text-gray-700">{{ __('manage-products/products.custom_sizes_prices_label') }}</label>
                                </div>
                                <div id="size-price-inputs" class="hidden">
                                    <div id="specific-size-prices">
                                        <label
                                            class="block text-gray-700 font-semibold">{{ __('manage-products/products.custom_sizes_label') }}</label>
                                        @foreach ($sizesWithPrices as $sizeWithPrice)
                                            @include('partials._price-input', [
                                                'label' => $sizeWithPrice['size'],
                                                'id' => 'product-size-price-' . $loop->index,
                                                'placeholder' =>
                                                    __('manage-products/products.custom_size_placeholder') .
                                                    ' ' .
                                                    $sizeWithPrice['size'],
                                                'name' => 'priceForSize[' . $sizeWithPrice['size'] . ']',
                                            
                                                'value' => old(
                                                    'priceForSize.' . $sizeWithPrice['size'],
                                                    $sizeWithPrice['price']),
                                                'class' => 'existing-custom-price ',
                                            ])
                                        @endforeach
                                        <div id="custom-size-inputs">
                                            <!-- Dit is waar de nieuwe invoervelden worden toegevoegd -->
                                            @php
                                                $oldCustomSizes = old('custom_sizes') ?? [];
                                                $oldCustomPrices = old('custom_prices') ?? [];
                                            @endphp
                                            @if (count($oldCustomSizes) > 0 && count($oldCustomPrices) > 0)
                                                @for ($i = 0; $i < count($oldCustomSizes); $i++)
                                                    <script>
                                                        addCustomSizeInput('{{ $oldCustomSizes[$i] }}', '{{ $oldCustomPrices[$i] }}');
                                                    </script>
                                                @endfor
                                            @else
                                                <script>
                                                    addCustomSizeInput();
                                                </script>
                                            @endif
                                        </div>
                                        <button onclick="addCustomSizeInput()" type="button"
                                            class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('manage-products/products.custom_size_button') }}</button>
                                    </div>
                                </div>
                            </div>
                            @php
                                $price_sizeErrorTypes = [
                                    'priceForSize',
                                    'priceForSize.*',
                                    'custom_prices',
                                    'custom_prices.*',
                                    'custom_sizes',
                                    'custom_sizes.*',
                                ];
                            @endphp
                            @foreach ($price_sizeErrorTypes as $errorType)
                                @if ($errors->has($errorType))
                                    <x-error :error="$errors->first($errorType)" :id="$errorType" />
                                @break
                            @endif
                        @endforeach
                    </div>
                    <!-- Select Groups Field -->
                    @include('partials._select', [
                        'label' => __('manage-products/products.groups_multi_select_label'),
                        'placeholder' => __('manage-products/products.groups_multi_select_placeholder'),
                        'options' => $baseGroups->pluck('name'),
                        'selected' => $chosenGroups->pluck('name'),
                        'name' => 'products-group-multiselect',
                        'selectedGroups' => $chosenGroups->pluck('name'),
                        'class' => 'manage-products/products.groups-multiselect',
                    ])
                    
                    <!-- Product Category Field -->
                    @include('partials._input', [
                        'label' => __('manage-products/products.category_input_label'),
                        'placeholder' => __('manage-products/products.category_input_placeholder'),
                        'id' => 'product-category',
                        'type' => 'text',
                        'name' => 'category',
                        'value' => $baseChosenCategorie->type,
                        'disabled' => false,
                    ])

                    <!-- Disable Product Checkbox -->
                    <div class="flex">
                        <input name="inactive-checkbox" type="checkbox"
                               class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                               id="hs-default-checkbox" {{ $product->inactive ? 'checked' : '' }}>
                        <label for="hs-default-checkbox"
                               class="text-sm text-gray-500 ms-3 dark:text-gray-400">
                            {{ $product->inactive ? __('manage-products/products.active-product') : __('manage-products/products.inactive-product') }}
                        </label>
                    </div>

                    <!-- Add Product Button -->
                    <div>
                        <button id="big-screen" type="submit"
                            class="bg-blue-500 text-white px-4 py-2 big-screen rounded-md shadow-md hover:bg-blue-600 transition duration-300">
                            {{ __('manage-products/products.product_edit_button') }}
                        </button>
                    </div>
                </div>
                <div class="container mx-auto">
                    <!-- Upload Image -->
                    <div id="file-upload-form" class="relative overflow-hidden bg-white rounded-lg shadow-md">
                        <input id="file-upload" type="file" name="picture" accept="image/*" class="hidden" />
                        <label for="af-submit-app-upload-images" id="drop-area"
                            class="group p-6 sm:p-7 block cursor-pointer text-center border-2 border-dashed border-gray-200 rounded-lg focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 dark:border-gray-700">
                            <input id="af-submit-app-upload-images" name="af-submit-app-upload-images" type="file"
                                class="sr-only">
                            <div class="flex justify-center items-center containerMaxH">
                                @if($product->image_path)
                                    <img id="file-image" src="{{ asset($product->image_path) }}" alt="Preview" class="hidden containerMaxH">
                                @endif
                            </div>
                            <svg id="notimage" class="size-10 mx-auto text-gray-400 dark:text-gray-600"
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z" />
                                <path
                                    d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                            </svg>
                            <span
                                class="mt-2 block text-sm text-gray-800 dark:text-gray-200">{{ __('manage-products/products.product_image_span') }}</span>
                            <button id="remove-image"
                                class="hidden mt-2 bg-red-500 text-white px-4 py-2 rounded-md">{{ __('manage-products/products.product_image_delete_button') }}</button>
                        </label>
                    </div>
                    <x-error :error="$errors->first('af-submit-app-upload-images')" id="af-submit-app-upload-images" />
                </div>

                <button id="small-screen" type="submit"
                    class="bg-blue-500 text-white px-4 py-2   rounded-md shadow-md hover:bg-blue-600 transition duration-300">
                    {{ __('manage-products/products.product_edit_button') }}
                </button>
            </div>
        </form>
    </div>
</body>
@endsection