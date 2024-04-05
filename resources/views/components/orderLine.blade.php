@props(['orderLine']);

@php
@endphp

<div class="rounded-md w-4/5 bg-gray-200 h-[50vh] lg:h-[25vh] flex flex-col lg:flex-row items-center justify-center p-[1%]">
    <div class="lg:w-1/6 w-5/6 lg:h-full flex items-center justify-center">
        <img src="{{ asset($orderLine->product->image_path) }}" class="object-scale-down h-full w-full">       
    </div>
    <div class="lg:w-5/6">
        <div class="m-4 flex flex-col lg:flex-row justify-between items-center">
            <p class="text-xl ">
                {{$orderLine->product->name}}
            </p>
            <p class="text-xl">
                Maat {{$orderLine->product_size}}
            </p>
            <p class="text-xl">
                Prijs {{$orderLine->product_price}}
            </p>
            <p class="text-xl">
                Aantal {{$orderLine->amount}}
            </p>
            <p class="text-xl">
                Sub totaal: {{$orderLine->product_price * $orderLine->amount}}
            </p>
        </div>
    </div>
</div>