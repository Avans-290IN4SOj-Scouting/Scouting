@props(['order']);

<div class="rounded-md w-4/5 bg-gray-200 min-h-40 flex flex-row items-center justify-center">
    <div class="basis-1/4 ">
        <img src="{{ asset('images/polo-kabouter.jpg') }}" class="p-[10%]">       
    </div>
    <div class="basis-1/2">
        <div class="flex flex-col items-left p-[10%]">
            <p class="text-xl">
                <time> {{$order->order_date}} </time> | {{$order->id}}
            </p>
            <p class="text-xl text-emerald-500">
                {{-- {{$order->orderStatus}} --}}
            </p>
        </div>
    </div>
    <div class="basis-1/4 flex items-center justify-center">
        <a href="{{__('route.track_orders')}}/{{$order->id}}">
            <i class="bi bi-arrow-right-circle-fill"></i>
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-right-circle-fill w-20 h-20" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z"/>
            </svg>
        </a>
    </div>
</div>