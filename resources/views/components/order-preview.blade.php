<div
    class="bg-white border rounded-xl shadow-sm sm:flex dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
    <div
        class="flex-shrink-0 relative w-full rounded-t-xl overflow-hidden pt-[40%] sm:rounded-s-xl sm:max-w-60 md:rounded-se-none md:max-w-xs">
        <img class="size-full absolute top-0 start-0 object-cover"
             src="{{ $order->orderLines->first()->product_image_path }}" alt="Image Description">
    </div>
    <div class="flex flex-wrap">
        <div class="p-4 flex flex-col h-full sm:p-7">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                {{ $order->order_date->format('M d, Y') }}
            </h3>
            <p class="mt-1 text-gray-500 dark:text-neutral-400">
                {{ $order->status }}
            </p>
        </div>
    </div>
</div>
