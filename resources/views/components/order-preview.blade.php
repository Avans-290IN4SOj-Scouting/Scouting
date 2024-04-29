<div class="w-full sm:flex sm:max-w-none border border-gray-300 dark:border-gray-700 rounded-xl overflow-hidden">
    <div
        class="h-48 sm:h-auto sm:w-48 flex-none bg-cover text-center overflow-hidden"
        style="background-image: url({{ $order->orderLines->first()->product_image_path }})" title="{{--TODO!--}}">
    </div>
    <div
        class="w-full p-10 flex sm:flex-row justify-between leading-normal dark:text-white">
        <div class="flex flex-col text-base align-middle">
            <p>{{ App\Helpers\DateFormatter::format($order->order_date) }}</p>
            <p class="{{ \App\Enum\DeliveryStatus::delocalised($order->status) }}">
                {{ $order->status }}
            </p>
        </div>
        <div class="dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                 stroke="currentColor" class="w-14 h-14">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m12.75 15 3-3m0 0-3-3m3 3h-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </div>
    </div>
</div>
