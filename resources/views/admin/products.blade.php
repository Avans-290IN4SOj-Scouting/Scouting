@extends('layouts.base')

@php
    $title = __('manage-products/products.page_title');
@endphp

@push('scripts')
    <script src="{{ asset('js/manage-products/products.js') }}" defer></script>
@endpush

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-4xl m-8 dark:text-white">{{ __('manage-products/products.page_title') }}</h1>
        <button type="button"
                class="me-6 py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 disabled:opacity-50 disabled:pointer-events-none">
            {{ __('manage-products/products.empty_inventory') }}
        </button>
    </div>

    <div class="flex flex-col rounded-lg border-gray-200 border">
        <div class="min-w-full inline-block align-middle">
            <div class="hs-accordion-group">
                @for($i = 0; $i < $total; $i++)
                    <div class="hs-accordion" id="hs-basic-nested-heading-one">
                        <div>
                            <button
                                class="p-1.5 hs-accordion-toggle py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none focus:text-blue-500"
                                aria-controls="hs-basic-nested-collapse-one"
                                onclick="toggleAccordion(this)"
                                data-open="false">

                                <svg class="block size-3.5" xmlns="http://www.w3.org/2000/svg"
                                     width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                    <path d="M12 5v14"></path>
                                </svg>
                                <svg class="hidden block size-3.5" xmlns="http://www.w3.org/2000/svg"
                                     width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                </svg>
                                Product {{ $i + 1 }}
                            </button>
                            {{--                    Will replace this based on product count when doing the backend--}}
                            @if($i < $total)
                                <hr class="border-gray-200 hidden">
                            @endif
                        </div>
                        <div id="hs-basic-nested-collapse-one"
                             class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                             aria-labelledby="hs-basic-nested-heading-one">
                            <div class="hs-accordion-group">
                                <div class="hs-accordion ps-6" id="hs-basic-nested-sub-heading-one">
                                    <button
                                        class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-500 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none focus:text-blue-500"
                                        aria-controls="hs-basic-nested-sub-collapse-one">
                                        <svg class="hs-accordion-active:hidden block size-3" width="16" height="16"
                                             viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.62421 7.86L13.6242 7.85999" stroke="currentColor"
                                                  stroke-width="2" stroke-linecap="round"></path>
                                            <path d="M8.12421 13.36V2.35999" stroke="currentColor" stroke-width="2"
                                                  stroke-linecap="round"></path>
                                        </svg>
                                        <svg class="hs-accordion-active:block hidden size-3" width="16" height="16"
                                             viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.62421 7.86L13.6242 7.85999" stroke="currentColor"
                                                  stroke-width="2" stroke-linecap="round"></path>
                                        </svg>
                                        Groen
                                    </button>
                                    <div id="hs-basic-nested-sub-collapse-one"
                                         class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                         aria-labelledby="hs-basic-nested-sub-heading-one">
                                        <div class="py-2.5 space-x-1">
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="size_xs"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    S
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input id="size_xs"
                                                       class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white focus:rounded-l-none focus:rounded-r-lg"
                                                       type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="size_xs"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    M
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input id="size_xs"
                                                       class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white focus:rounded-l-none focus:rounded-r-lg"
                                                       type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="size_xs"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    L
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input id="size_xs"
                                                       class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white focus:rounded-l-none focus:rounded-r-lg"
                                                       type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="size_xs"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    XL
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input id="size_xs"
                                                       class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white focus:rounded-l-none focus:rounded-r-lg"
                                                       type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="size_xs"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    XXL
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input id="size_xs"
                                                       class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white focus:rounded-l-none focus:rounded-r-lg"
                                                       type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <button type="button"
                                                    class="ms-auto py-1 px-2.5 inline-flex items-center text-sm rounded-lg border border-transparent bg-blue-500 text-white hover:bg-blue-600 disabled:opacity-50 disabled:pointer-events-none">
                                                Opslaan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-gray-200">
                                <div class="hs-accordion ps-6" id="hs-basic-nested-sub-heading-two">
                                    <button
                                        class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-500 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none focus:text-blue-500"
                                        aria-controls="hs-basic-nested-sub-collapse-two">
                                        <svg class="hs-accordion-active:hidden block size-3" width="16" height="16"
                                             viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.62421 7.86L13.6242 7.85999" stroke="currentColor"
                                                  stroke-width="2" stroke-linecap="round"></path>
                                            <path d="M8.12421 13.36V2.35999" stroke="currentColor" stroke-width="2"
                                                  stroke-linecap="round"></path>
                                        </svg>
                                        <svg class="hs-accordion-active:block hidden size-3" width="16" height="16"
                                             viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.62421 7.86L13.6242 7.85999" stroke="currentColor"
                                                  stroke-width="2" stroke-linecap="round"></path>
                                        </svg>
                                        Blauw
                                    </button>
                                    <div id="hs-basic-nested-sub-collapse-two"
                                         class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                                         aria-labelledby="hs-basic-nested-sub-heading-two">
                                        <div class="py-2.5 space-x-1">
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="product_name"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    XS
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input
                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white"
                                                    type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="product_name"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    S
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input
                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white"
                                                    type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="product_name"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    M
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input
                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white"
                                                    type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="product_name"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    L
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input
                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white"
                                                    type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="product_name"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    XL
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input
                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white"
                                                    type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <button type="button"
                                                    class="ms-auto py-1 px-2.5 inline-flex items-center text-sm rounded-lg border border-transparent bg-blue-500 text-white hover:bg-blue-600 disabled:opacity-50 disabled:pointer-events-none">
                                                Opslaan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-gray-200">
                                <div class="hs-accordion ps-6" id="hs-basic-nested-sub-heading-three">
                                    <button
                                        class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-500 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none focus:text-blue-500"
                                        aria-controls="hs-basic-nested-sub-collapse-three">
                                        <svg class="hs-accordion-active:hidden block size-3" width="16" height="16"
                                             viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.62421 7.86L13.6242 7.85999" stroke="currentColor"
                                                  stroke-width="2" stroke-linecap="round"></path>
                                            <path d="M8.12421 13.36V2.35999" stroke="currentColor" stroke-width="2"
                                                  stroke-linecap="round"></path>
                                        </svg>
                                        <svg class="hs-accordion-active:block hidden size-3" width="16" height="16"
                                             viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.62421 7.86L13.6242 7.85999" stroke="currentColor"
                                                  stroke-width="2" stroke-linecap="round"></path>
                                        </svg>
                                        Grijs
                                    </button>
                                    <div id="hs-basic-nested-sub-collapse-three"
                                         class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                                         aria-labelledby="hs-basic-nested-sub-heading-three">
                                        <div class="py-2.5 space-x-1">
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="product_name"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    XS
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input
                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white"
                                                    type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="product_name"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    S
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input
                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white"
                                                    type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="product_name"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    M
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input
                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white"
                                                    type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="product_name"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    L
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input
                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white"
                                                    type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <div
                                                class="inline-flex text-neutral-200 rounded-lg border-gray-200 border overflow-hidden">
                                                <label for="product_name"
                                                       class="text-gray-800 px-1.5 dark:text-neutral-200 bg-gray-100 dark:bg-slate-800">
                                                    XL
                                                </label>
                                                <div
                                                    class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>
                                                <input
                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center dark:text-white"
                                                    type="text" value="0" data-hs-input-number-input="">
                                            </div>
                                            <button type="button"
                                                    class="ms-auto py-1 px-2.5 inline-flex items-center text-sm rounded-lg border border-transparent bg-blue-500 text-white hover:bg-blue-600 disabled:opacity-50 disabled:pointer-events-none">
                                                Opslaan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--                    Will replace this based on product count when doing the backend--}}
                    @if($i < $total - 1)
                        <hr class="border-gray-200">
                    @endif
                @endfor
            </div>
        </div>
    </div>
@endsection
