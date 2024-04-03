<div id="dismiss-toast"
     class="z-50 absolute bottom-0 end-0 m-6 hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-gray-800 dark:border-gray-700"
     role="alert">
    <div id="toast" class="toast-{{ $type }} flex p-4">
        <span class="font-bold">
            {{ __('toast/toast_types.' . $type) }} -
        </span>
        <p class="text-sm text-gray-700 dark:text-gray-400">
            &nbsp;{{ $message }}
        </p>

        <div class="ms-auto">
            <button type="button"
                    class="inline-flex flex-shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 dark:text-white"
                    data-hs-remove-element="#dismiss-toast">
                <span class="sr-only">Close</span>
                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M18 6 6 18"/>
                    <path d="m6 6 12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
