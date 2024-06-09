<button type="button"
        class="py-3 px-4 items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-{{ $color }}-600 text-white hover:bg-{{ $color }}-700 disabled:opacity-50 disabled:pointer-events-none"
        data-hs-overlay="#{{ $id }}">
    {{ $buttonText }}
</button>
<div id="{{ $id }}"
     class="hs-overlay hs-overlay-open:opacity-100 hs-overlay-open:duration-500 hidden size-full fixed top-0 start-0 z-[80] opacity-0 overflow-x-hidden transition-all overflow-y-auto pointer-events-none">
    <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto">
        <div
            class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <form action="{{ $route }}" method="POST">
                @csrf
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                    <h3 class="font-bold text-gray-800 dark:text-white">
                        {{ $title }}
                    </h3>
                    <button type="button"
                            class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700"
                            data-hs-overlay="#{{ $id }}">
                        <span class="sr-only">Sluit modal</span>
                        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-4 overflow-y-auto">
                    <p class="mt-1 text-gray-800 dark:text-neutral-400">
                        {{ $modalText }}
                        {{ $slot }}
                    </p>
                </div>
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700">
                    <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800"
                            data-hs-overlay="#{{ $id }}">
                        {{ __('common.close') }}
                    </button>
                    <button type="submit"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-{{ $color }}-600 text-white hover:bg-{{ $color }}-700 disabled:opacity-50 disabled:pointer-events-none">
                        {{ $modalButton }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
