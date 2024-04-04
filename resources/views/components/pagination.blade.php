@if($paginator->hasPages())
    <nav class="flex justify-center items-center mt-5 gap-x-1">
        <a @if(!$paginator->onFirstPage()) href="{{ $paginator->previousPageUrl() }}" @endif>
            <button type="button"
                    class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10"
                    @if($paginator->onFirstPage()) disabled @endif>
                <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                <span>
                    {{ __('common.previous') }}
                </span>
            </button>
        </a>
        <div class="flex items-center gap-x-1">
            @php
                // Calculate the start and end of the range (5) of pages to show.
                $start = max($paginator->currentPage() - 2, 1);
                $end = min($start + 4, $paginator->lastPage());
                $start = max($end - 4, 1);
            @endphp
            @foreach(range($start, $end) as $i)
                @if ($i == $paginator->currentPage())
                    <a href="{{ $paginator->url($i) }}">
                        <button
                            class="min-h-[38px] min-w-[38px] flex justify-center items-center bg-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-600 dark:text-white dark:focus:bg-gray-500"
                            aria-current="page" disabled>{{ $i }}</button>
                    </a>
                @else
                    <a href="{{ $paginator->url($i) }}">
                        <button
                            class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">{{ $i }}</button>
                    </a>
                @endif
            @endforeach
        </div>
        <a @if(!$paginator->onLastPage()) href="{{ $paginator->nextPageUrl() }}" @endif>
            <button type="button"
                    class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10"
                    @if($paginator->onLastPage()) disabled @endif>
                <span>
                    {{ __('common.next') }}
                </span>
                <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"/>
                </svg>
            </button>
        </a>
    </nav>
@endif
