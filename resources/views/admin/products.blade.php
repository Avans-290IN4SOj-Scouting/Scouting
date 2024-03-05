@extends('layouts.base')

@section('title', 'Producten')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-700 font-semibold mb-4">Producten</h1>
        <div class="mb-4">
            {{--    <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Nieuw Product Toevoegen
                </a>--}}
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <div class="border border-gray-200 p-4 rounded">
                    <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                    <p class="text-gray-600">{{ $product->category }}</p>
                    {{-- Access other properties of the ProductViewModel here --}}
                </div>
            @endforeach
        </div>
    </div>
@endsection

<script>
    // Make an Ajax request to the productOverview endpoint
    $.ajax({
        url: '/productOverview',
        type: 'GET',
        success: function(response) {
            console.log(response);
        },
        error: function(xhr, status, error) {
            // Log the error response in the console
            console.error(xhr.responseJSON);
        }
    });
</script>

