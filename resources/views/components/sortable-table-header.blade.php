<th scope="col" class="w-1/5 px-6 py-3 text-start text-xs font-medium text-black uppercase dark:text-white">
    <div class="flex gap-1">
        <div>
            @sortablelink($sortOn, __($textKey))
        </div>

        <div>
            @if (Request::get('sort') == $sortOn)
            @if (Request::get('direction') == 'desc')
            <span>
                <!-- Desc -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
                <!-- /Desc -->
            </span>
            @else
            <span>
                <!-- Asc -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                </svg>
                <!-- /Asc -->
            </span>
            @endif
            @else
            <span>
                <!-- No filter -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                </svg>
                <!-- /No filter -->
            </span>
            @endif
        </div>
    </div>
</th>
