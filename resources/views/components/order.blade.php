@props(['order' , 'product'])

<div class="rounded-md w-4/5 bg-gray-200 lg:h-[20vh] h-[75vh] flex lg:flex-row flex-col justify-center items-center p-[3%] lg:p-[1%]">
    <div class="lg:w-1/6 w-5/6 h-2/3 lg:h-full flex justify-center items-center">
        <img src="{{ asset($product->image_path) }}" alt="{{$product->name}}" class="object-contain h-full w-full">       
    </div>
    <div class="lg:w-5/6 w-5/6 h-1/3 lg:h-full mt-4 lg:mt-0 flex lg:flex-row flex-col items-center justify-between space-y-2">
        <div class="flex flex-col h-2/3 lg:h-auto items-center lg:items-left lg:pl-[2%] lg:pr-[10%]">
            <p class="text-5xl lg:text-xl h-1/2 lg:h-auto">
                <time> {{substr($order->order_date, 0, 11)}} </time> | {{$order->id}}
            </p>
            @if($order->orderStatus->id == 1)
            <p class="text-5xl lg:text-xl  text-red-500 h-1/2 lg:h-auto">
                {{$order->orderStatus->status}}
            </p>
            @else
                <p class="text-5xl lg:text-xl text-emerald-500 h-1/2 lg:h-auto">
                    {{$order->orderStatus->status}}
                </p>
            @endif        
        </div>
        <div class="h-1/3 lg:h-auto flex items-center justify-center">
            <a href="{{__('route.track_orders')}}/{{$order->id}}" aria-label="__('order_tracking.aria_label_order_details')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-right-circle-fill w-20 h-20 rotate-90 lg:rotate-0" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z"/>
                </svg>
            </a>
            
        </div>
    </div>
    
</div>