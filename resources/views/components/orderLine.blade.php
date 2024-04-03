@props(['orderLine']);

@php
    $product = App\Models\Product::where('id', $orderLine->product_id);
@endphp

<div class="rounded-md w-4/5 bg-gray-200 min-h-40 flex flex-row items-center justify-center">
    <div class="basis-1/4 ">
        {{-- <img src="{{ asset('images/'.$product->image_path) }}" class="p-[10%]">        --}}
    </div>
    <div class="basis-3/4">
        <div class="flex flex-row items-between p-[10%]">
            <p class="text-xl">
                {{-- {{$product->name}} --}}
            </p>
            <p class="text-xl">
                Size: {{$orderLine->product_size}}
            </p>
            <p class="text-xl">
                Price: {{$orderLine->product_price}}
            </p>
            <p class="text-xl">
                Amount: {{$orderLine->product_amount}}
            </p>
            <p class="text-xl">
                SubTotal:{{$orderLine->product_price * $orderLine->product_amount}}
            </p>
        </div>
    </div>
</div>