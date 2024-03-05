@extends('layouts.base')
@section('title', 'Product Bewerken')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-700 font-semibold mb-4">Product Bewerken</h1>
        <!-- Product Form and Image Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Form -->
            <div class="space-y-4">
                <!-- Product Name Field -->
                @include('partials._input', ['value' => $product->name, 'label' => 'Product Naam', 'id' => 'product-name', 'type' => 'text', 'placeholder' => 'Product Naam'])
                <!-- Product Price Field -->
                @include('partials._price-input', ['value' => $product->price, 'label' => 'Product Prijs', 'id' => 'product-price', 'placeholder' => 'Prijs'])
                <!-- Product Size and Price Field -->
                <label for="product-size-price" class="block text-gray-700 font-semibold">Maten en Prijzen</label>
                <div>
                    <div id="size-price-options" class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" id="same-price-all" class="form-checkbox text-blue-500 h-5 w-5">
                            <label for="same-price-all" class="ml-2 text-gray-700">Verschillende prijzen voor de maten</label>
                        </div>
                        <div id="size-price-inputs" class="hidden">
                            <!-- Prijs voor alle maten -->
                            <!-- Extra invoervelden voor specifieke maten -->
                            <div id="specific-size-prices">
                                <label class="block text-gray-700 font-semibold">Specifieke Maten</label>
                                @foreach ($product->sizes as $size)
                                    <div class="flex items-center space-x-4">
                                        <span class="text-gray-600">{{ $size->name }}:</span>
                                        <input type="number" placeholder="Prijs" class="w-full px-4 py-2 border border-gray-300 rounded-md specific-size-price" value="{{ $size->price }}">
                                    </div>
                                @endforeach
                                <!-- Nieuwe invoervelden voor aangepaste maten -->
                                <div id="custom-size-inputs">
                                    <!-- Dit is waar de nieuwe invoervelden worden toegevoegd -->
                                </div>
                                <!-- Knop om een nieuwe maat toe te voegen -->
                                <button onclick="addCustomSizeInput()" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md">Voeg maat toe</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Select -->
                <!-- Select -->
                @include('partials._select', ['label' => 'Scouting groepen', 'placeholder' => 'Select scouting groepen', 'options' => ['Bevers', 'Gidsen', 'Kabouters', 'Leiders', 'Verkenners', 'Waterwerk', 'Welpen']])

                <!-- Product Description Field -->
                <label for="product-description" class="block text-gray-700 font-semibold">Product Beschrijving</label>
                <div>
                    <textarea id="product-description" rows="4" class="w-full px-4 py-2 rounded-md shadow-md focus:outline-none focus:ring focus:border-blue-500 transition duration-300">{{ $product->description }}</textarea>
                </div>

                <!-- Add Product Button -->
                <div>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-600 transition duration-300">
                        Product Bewerken
                    </button>
                </div>
            </div>
            <!-- Product Image and Upload Form -->
            <div class="container mx-auto py-5">
                <!-- Upload Form -->
                <form id="file-upload-form" class="relative overflow-hidden bg-white rounded-lg shadow-md">
                    <input id="file-upload" type="file" name="fileUpload" accept="image/*" class="hidden"/>
                    <!-- File Drop Area -->
                    <label for="file-upload" id="file-drag" class="cursor-pointer block p-8 rounded-md shadow-md  hover:border-blue-500 transition duration-300">
                        <div class="flex flex-col items-center space-y-4">
                            <img id="file-image" src="#" alt="Preview" class="hidden"/>
                            <div id="start" class="text-center">
                                <i class="fa fa-download text-4xl mb-2"></i>
                                <div class="mb-2.5">please select a file or drag it here</div>
                                <div id="notimage" class="hidden">Please select an image</div>
                                <!-- Clicking this label will trigger file input -->
                                <label for="file-upload" class="btn bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 mt-2">Select a file</label>
                            </div>
                        </div>
                    </label>
                    <!-- Upload Progress and Messages -->
                    <div id="response" class="hidden">
                        <div id="messages" class="mb-2"></div>
                        <progress class="progress w-full bg-gray-300" id="file-progress" value="0"></progress>
                    </div>
                    <!-- Remove Image Button -->
                    <button id="remove-image" class="absolute top-0 right-0 mt-2 mr-2 bg-gray-300 text-white px-2 py-1 rounded-full hidden" onclick="removeImage()">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6m0 12L6 6"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
