@extends('layouts.base')
@section('title', 'Producten')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-700 font-semibold mb-4">Producten</h1>
        <div class="mb-4">
            <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nieuw Product Toevoegen
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ $product->name }}</h2>
                    <p class="text-gray-600 mb-4">Prijs: €{{ $product->price }}</p>
                    <p class="text-gray-600 mb-4">Beschrijving: {{ $product->description }}</p>
                    <p class="text-gray-600 mb-4">Maten:</p>
                    <ul class="list-disc pl-5">
                        @foreach ($product->sizes as $size)
                            <li>{{ $size->name }} - €{{ $size->price }}</li>
                        @endforeach
                    </ul>
                    <div class="mt-4">
                        <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500 hover:underline">Bewerken</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Verwijderen</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
