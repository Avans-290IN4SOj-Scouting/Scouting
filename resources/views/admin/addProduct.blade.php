@extends('layouts.base')
@section('title', 'Product Toevoegen')
@section('content')

    <body class="bg-gray-100">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-gray-700 font-semibold mb-4">Toevoegen product</h1>
            <!-- Product Form and Image Section -->
            <form action="{{ route('product.createProduct') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Product Form -->
                    <div class="space-y-4">
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
                                        <div class="flex items-center space-x-4">
                                            <span class="text-gray-600">Small (S): €</span>
                                            <input type="number" placeholder="Prijs"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md specific-size-price"
                                                name="priceForSize[Small]">
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <span class="text-gray-600">Medium (M): €</span>
                                            <input type="number" placeholder="Prijs"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md specific-size-price"
                                                name="priceForSize[Medium]">
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <span class="text-gray-600">Large (L): €</span>
                                            <input type="number" placeholder="Prijs"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md specific-size-price"
                                                name="priceForSize[Large]">
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <span class="text-gray-600">Extra Large (XL): €</span>
                                            <input type="number" placeholder="Prijs"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md specific-size-price"
                                                name="priceForSize[Extra Large]">
                                        </div>
                                        <!-- Nieuwe invoervelden voor aangepaste maten -->
                                        <div id="custom-size-inputs">
                                            <!-- Dit is waar de nieuwe invoervelden worden toegevoegd -->
                                        </div>
                                        <!-- Knop om een nieuwe maat toe te voegen -->
                                        <button onclick="addCustomSizeInput()"
                                            class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md">Voeg maat toe</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Select -->
                        <!-- Select -->
                        @include('partials._select', [
                            'label' => 'Scouting groepen',
                            'placeholder' => 'Select scouting groepen',
                            'options' => [
                                'Bevers',
                                'Gidsen',
                                'Kabouters',
                                'Leiders',
                                'Verkenners',
                                'Waterwerk',
                                'Welpen',
                            ],
                            'name' => 'groups',
                        ])

                        <!-- Product Description Field -->
                        <label for="product-description" class="block text-gray-700 font-semibold">Product
                            Beschrijving</label>
                        <div>
                            <textarea id="product-description" name="description" rows="4"
                                class="w-full px-4 py-2 rounded-md shadow-md focus:outline-none focus:ring focus:border-blue-500 transition duration-300"></textarea>
                        </div>

                        <!-- Add Product Button -->
                        <div>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-600 transition duration-300">
                                Product Toevoegen
                            </button>
                        </div>
                    </div>
                    <!-- Product Image and Upload Form -->
                    <div class="container mx-auto py-5">
                        <!-- Upload Form -->
                        <div id="file-upload-form" class="relative overflow-hidden bg-white rounded-lg shadow-md">
                            <input id="file-upload" type="file" name="picture" accept="image/*" class="hidden" />
                            <!-- File Drop Area -->
                            <label for="file-upload" id="file-drag"
                                class="cursor-pointer block p-8 rounded-md shadow-md  hover:border-blue-500 transition duration-300">
                                <div class="flex flex-col items-center space-y-4">
                                    <img id="file-image" src="#" alt="Preview" class="hidden" />
                                    <div id="start" class="text-center">
                                        <i class="fa fa-download text-4xl mb-2"></i>
                                        <div class="mb-2.5">Selecteer of sleep een plaatje voor het product</div>
                                        <div id="notimage" class="hidden">Klik hier</div>
                                        <!-- Clicking this label will trigger file input -->
                                        <label for="file-upload"
                                            class="btn bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 mt-2">Klik
                                            hier om je bestanden te openen</label>
                                    </div>
                                </div>
                            </label>
                            <!-- Upload Progress and Messages -->
                            <div id="response" class="hidden">
                                <div id="messages" class="mb-2"></div>
                                <progress class="progress w-full bg-gray-300" id="file-progress" value="0"></progress>
                            </div>
                            <!-- Remove Image Button -->
                            <button id="remove-image"
                                class="absolute top-0 right-0 mt-2 mr-2 bg-gray-300 text-white px-2 py-1 rounded-full hidden"
                                onclick="removeImage()">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M6 18 18 6m0 12L6 6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script>
            function addCustomSizeInput() {
                // Maak een nieuw div-element aan
                var newDiv = document.createElement('div');
                newDiv.classList.add('flex', 'items-center', 'space-x-4');

                // Voeg invoerveld toe voor maat
                var sizeInput = document.createElement('input');
                sizeInput.type = 'text';
                sizeInput.name = 'custom_sizes[]'; // Set name attribute for form submission
                sizeInput.placeholder = 'Maat';
                sizeInput.classList.add('w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-md',
                    'specific-size-price');

                // Voeg invoerveld toe voor prijs
                var priceInput = document.createElement('input');
                priceInput.type = 'number';
                priceInput.name = 'custom_prices[]'; // Set name attribute for form submission
                priceInput.placeholder = 'Prijs';
                priceInput.classList.add('w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-md',
                    'specific-size-price');

                // Voeg de elementen toe aan de nieuwe div
                newDiv.appendChild(sizeInput);
                newDiv.appendChild(priceInput);

                // Voeg de nieuwe div toe aan #custom-size-inputs
                document.getElementById('custom-size-inputs').appendChild(newDiv);
            }
        </script>
    </body>
@endsection
