@props(['order' , 'product'])

<div class="m-4">
    <div class="flex flex-col gap-1 test:gap-0 pb-1 test:pb-0 test:flex-row justify-left items-center test:pr-6 rounded-xl border dark:text-white dark:border-gray-700">
        <img  src="{{ asset($product->image_path) }}" alt="{{$product->name}}" class="rounded-t-xl test:rounded-tr-none test:rounded-l-xl sm:w-fit w-full  h-auto">
        <div class="flex flex-col test:ml-8 justify-center test:jusify-left items-center test:items-start">
            <div>
                <time> {{substr($order->order_date, 0, 11)}} </time> | {{$order->id}}
            </div>
            <div> 
                {{$order->orderStatus->status}}
            </div>
        </div>
       
        <div class="grow flex justify-end items-center"> 
            <a href="{{__('route.track_orders')}}/{{$order->id}}" aria-label="__('order_tracking.aria_label_order_details')" class="justify-self-end">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-right-circle-fill w-20 h-20 rotate-90 test:rotate-0" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z"/>
                </svg>
            </a>
        </div>
    </div>
</div>