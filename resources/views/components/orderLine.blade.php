@props(['orderLine'])

<div class="m-4">
    <div class="flex flex-col gap-1 test:gap-0 pb-1 test:pb-0 test:flex-row justify-between items-center test:pr-6 rounded-xl border dark:text-white dark:border-gray-700">
        <img src={{ asset($orderLine->product->image_path) }} alt="{{$orderLine->product->name}}" class="rounded-t-xl test:rounded-tr-none test:rounded-l-xl w-fit h-auto">
        <div class="">
            <a href="#" class="font-bold">
                {{$orderLine->product->name}}
            </a>
        </div>
        <div>{{__('order_tracking.size')}} {{$orderLine->product_size}}</div>
        <div> <x-displayCurrency :price="$orderLine->product_price"> </x-displayCurrency></div>
        <div> {{__('order_tracking.amount')}} {{$orderLine->amount}}</div>
    </div>
</div>