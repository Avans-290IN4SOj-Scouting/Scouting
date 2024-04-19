@extends('layouts.base')
@section('title', 'Product Toevoegen')
@section('content')

    <body class="bg-gray-100">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-gray-700 font-semibold mb-4">Toevoegen product</h1>
            <!-- Product Form and Image Section -->
            <form action="{{ route('manage.products.create.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Product Form -->
                    <div class="space-y-4">
                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="bg-red-500 text-white px-4 py-2 rounded-md">
                                <ul>
                                    @foreach ($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- Product Name Field -->
                        @include('partials._input', [
                            'label' => 'Product Naam',
                            'id' => 'product-name',
                            'type' => 'text',
                            'placeholder' => 'Product Naam',
                            'name' => 'name',
                        ])
                        <!-- Product Price Field -->
                        @include('partials._price-input', [
                            'label' => 'Product Prijs',
                            'id' => 'product-price',
                            'placeholder' => 'Prijs',
                            'name' => 'priceForSize[Default]',
                        ])
                        <!-- Product Size and Price Field -->
                        <label for="product-size-price" class="block text-gray-700 font-semibold">Maten en Prijzen</label>
                        <div>
                            <div id="size-price-options" class="space-y-4">
                                <div class="flex items-center space-x-4">
                                    <input type="checkbox" id="same-price-all" class="form-checkbox text-blue-500 h-5 w-5">
                                    <label for="same-price-all" class="ml-2 text-gray-700">Verschillende prijzen voor de
                                        maten</label>
                                </div>
                                <div id="size-price-inputs" class="hidden">
                                    <!-- Prijs voor alle maten -->
                                    <!-- Extra invoervelden voor specifieke maten -->
                                    <div id="specific-size-prices">
                                        <label class="block text-gray-700 font-semibold">Specifieke Maten</label>
                                        @foreach ($baseProductSizes as $productSize)
                                            @include('partials._price-input', [
                                                'label' => $productSize->size,
                                                'id' => 'product-size-price',
                                                'placeholder' => 'Prijs voor maat ' . $productSize->size,
                                                'name' => 'priceForSize[' . $productSize->size . ']',
                                            ])
                                        @endforeach
                                        <!-- Nieuwe invoervelden voor aangepaste maten -->
                                        <div id="custom-size-inputs">
                                            <!-- Dit is waar de nieuwe invoervelden worden toegevoegd -->
                                        </div>
                                        <!-- Knop om een nieuwe maat toe te voegen -->
                                        <button onclick="addCustomSizeInput()" type="button"
                                            class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md">Voeg maat toe
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Select -->
                        @include('partials._select', [
                            'label' => 'Scouting groepen',
                            'placeholder' => 'Select scouting groepen',
                            'options' => $baseGroups->pluck('name'),
                            'name' => 'groups',
                        ])
                        @include('partials._single-select', [
                            'label' => 'Scouting categorie',
                            'placeholder' => 'Select scouting categorie',
                            'options' => $baseCategories->pluck('type'),
                            'name' => 'category',
                            'value' => $baseChosenCategorie->type ?? null,
                        ])

                        <!-- Product Description Field -->
                        <label for="product-description" class="block text-gray-700 font-semibold">Product
                            Beschrijving</label>
                        <div>
                            <textarea id="product-description" name="description" rows="4"
                                class="w-full px-4 py-2 rounded-md shadow-md focus:outline-none focus:ring focus:border-blue-500 transition duration-300">{{ request('description') }}</textarea>
                        </div>
                        <!-- Add Product Button -->
                        <div>
                            <button id="big-screen" type="submit"
                                class="bg-blue-500 text-white px-4 py-2 big-screen rounded-md shadow-md hover:bg-blue-600 transition duration-300">
                                Product Toevoegen
                            </button>
                        </div>
                    </div>

                    <div class="container mx-auto">
                        <!-- Upload Form -->
                        <div id="file-upload-form" class="relative overflow-hidden bg-white rounded-lg shadow-md">
                            <input id="file-upload" type="file" name="picture" accept=".image/*" class="hidden" />
                            <!-- File Drop Area -->
                            <label for="af-submit-app-upload-images" id="drop-area"
                                class="group p-6 sm:p-7 block cursor-pointer text-center border-2 border-dashed border-gray-200 rounded-lg focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 dark:border-gray-700">
                                <input id="af-submit-app-upload-images" name="af-submit-app-upload-images" type="file"
                                    class="sr-only">
                                <div class="flex justify-center items-center containerMaxH">
                                    <!-- Set max-height as required -->
                                    <img id="file-image" src="#" alt="Preview" class="hidden containerMaxH">
                                </div>
                                <svg class="size-10 mx-auto text-gray-400 dark:text-gray-600"
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z" />
                                    <path
                                        d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                                </svg>
                                <span class="mt-2 block text-sm text-gray-800 dark:text-gray-200">Selecteer of sleep een
                                    plaatje voor het product</span>
                                <button id="remove-image"
                                    class="hidden mt-2 bg-red-500 text-white px-4 py-2 rounded-md">Delete Image
                                </button>
                            </label>
                        </div>
                    </div>

                    <button id="small-screen" type="submit"
                        class="bg-blue-500 text-white px-4 py-2   rounded-md shadow-md hover:bg-blue-600 transition duration-300">
                        Product Toevoegen
                    </button>
                </div>
            </form>
        </div>
    </body>
@endsection
