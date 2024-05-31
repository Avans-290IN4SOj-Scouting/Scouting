<div class="flex flex-row gap-2 w-full justify-between price-size-entry">
    <div class="max-w-sm space-y-3 w-full">
        <select id="size_input" name="size_input[]" dusk="size-input"
            class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
            @foreach ($sizes as $size)
                <option @selected(($sizeValue ?? '') === $size->id) value="{{ $size->id }}" >{{ $size->size }}</option>
            @endforeach
        </select>
    </div>

    <div class="max-w-sm space-y-3 w-full">
        <input type="number" step=".01" id="price_input" name="price_input[]" value="{{ $priceValue ?? '' }}" dusk="price-input"
            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
            placeholder="{{ __('manage-products/products.price_placeholder') }}">
    </div>

    <button type="button" onclick="removePriceSize(event)" dusk="removePriceSize"
        class="px-2.5 flex justify-center items-center text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M3 6H21" stroke="black" stroke-linecap="round"
                stroke-linejoin="round" />
            <path d="M19 6V20C19 21 18 22 17 22H7C6 22 5 21 5 20V6" stroke="black"
                stroke-linecap="round" stroke-linejoin="round" />
            <path d="M8 6V4C8 3 9 2 10 2H14C15 2 16 3 16 4V6" stroke="black"
                stroke-linecap="round" stroke-linejoin="round" />
            <path d="M10 11V17" stroke="black" stroke-linecap="round"
                stroke-linejoin="round" />
            <path d="M14 11V17" stroke="black" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </button>
</div>
