<div class="relative w-fit border border-gray-200 rounded-lg">
    <label for="search" class="sr-only">{{ $placeholder }}</label>
    <input
        class="py-3 ps-4 pe-10 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600 placeholder-black"
        id="search" name="q" type="text" placeholder="{{ $placeholder }}" value="{{ $search }}">
    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none z-20 pe-3.5">
        <svg class="flex-shrink-0 size-4 text-gray-400 dark:text-white/60" xmlns="http://www.w3.org/2000/svg"
             width="24"
             height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
        </svg>
    </div>
</div>
