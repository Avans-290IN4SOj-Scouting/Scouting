@props(['orderLine'])


<div class="rounded-md w-4/5 bg-gray-200 h-[75vh] lg:h-[25vh] flex flex-col lg:flex-row items-center justify-center p-[2%] space-y-2">
    <div class="lg:w-1/4 w-full h-2/3 lg:h-full flex items-center justify-center">
        <img src="{{ asset($orderLine->product->image_path) }}" alt="{{$orderLine->product->name}}" class="object-contain h-full w-full">       
    </div>
    <div class="lg:w-3/4 w-1/2 lg:h-full h-1/3 flex justify-center items-center">
        <div class="m-4 w-full h-full flex flex-col lg:flex-row flex-row justify-center items-center">
            <x-textTag :division="4">
                {{$orderLine->product->name}}
            </x-textTag>
            <x-textTag :division="4">
                {{__('order_tracking.size')}} {{$orderLine->product_size}}
            </x-textTag>
            <x-textTag :division="4">
                <x-displayCurrency :price="$orderLine->product_price"> </x-displayCurrency>
            </x-textTag>
            <x-textTag :division="4">
                {{__('order_tracking.amount')}} {{$orderLine->amount}}
            </x-textTag>
        </div>
    </div>
</div>