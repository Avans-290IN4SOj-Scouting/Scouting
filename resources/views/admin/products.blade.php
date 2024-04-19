@extends('layouts.base')

@php
    $title = 'TODO: put title here';
@endphp

@section('content')
    <h1 class="text-4xl m-8 dark:text-white">Hardcoded header</h1>

    <div class="flex flex-col rounded-lg border-gray-500 border">
        <div class="min-w-full inline-block align-middle">
            <div class="hs-accordion-group">
                <div class="hs-accordion" id="hs-basic-nested-heading-one">
                    <div class="p-1.5">
                        <button
                            class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400"
                            aria-controls="hs-basic-nested-collapse-one">
                            <svg class="hs-accordion-active:hidden block size-3.5" xmlns="http://www.w3.org/2000/svg"
                                 width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5v14"></path>
                            </svg>
                            <svg class="hs-accordion-active:block hidden size-3.5" xmlns="http://www.w3.org/2000/svg"
                                 width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                            </svg>
                            Accordion #1
                        </button>
                    </div>
                    <hr class="border-gray-500">
                    <div id="hs-basic-nested-collapse-one"
                         class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                         aria-labelledby="hs-basic-nested-heading-one">
                        <div class="hs-accordion-group">
                            <div class="hs-accordion active ps-6" id="hs-basic-nested-sub-heading-one">
                                <button
                                    class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400"
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
                                    Sub accordion #1
                                </button>
                                <div id="hs-basic-nested-sub-collapse-one"
                                     class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                     aria-labelledby="hs-basic-nested-sub-heading-one">
                                    <p class="text-gray-800 dark:text-neutral-200 pb-2.5">
                                        <em>This is the third item's accordion body.</em> It is hidden by default,
                                        until the collapse plugin adds the appropriate classes that we use to style
                                        each element. These classes control the overall appearance, as well as the
                                        showing and hiding via CSS transitions.
                                    </p>
                                </div>
                            </div>
                            <hr class="border-gray-500">
                            <div class="hs-accordion ps-6" id="hs-basic-nested-sub-heading-two">
                                <button
                                    class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400"
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
                                    Sub accordion #2
                                </button>
                                <div id="hs-basic-nested-sub-collapse-two"
                                     class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                                     aria-labelledby="hs-basic-nested-sub-heading-two">
                                    <p class="text-gray-800 dark:text-neutral-200 pb-2.5">
                                        <em>This is the second item's accordion body.</em> It is hidden by default,
                                        until the collapse plugin adds the appropriate classes that we use to style
                                        each element. These classes control the overall appearance, as well as the
                                        showing and hiding via CSS transitions.
                                    </p>
                                </div>
                            </div>
                            <hr class="border-gray-500">
                            <div class="hs-accordion ps-6" id="hs-basic-nested-sub-heading-three">
                                <button
                                    class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400"
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
                                    Sub accordion #3
                                </button>
                                <div id="hs-basic-nested-sub-collapse-three"
                                     class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                                     aria-labelledby="hs-basic-nested-sub-heading-three">
                                    <p class="text-gray-800 dark:text-neutral-200 pb-2.5">
                                        <em>This is the first item's accordion body.</em> It is hidden by default,
                                        until the collapse plugin adds the appropriate classes that we use to style
                                        each element. These classes control the overall appearance, as well as the
                                        showing and hiding via CSS transitions.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="border-gray-500">
                <div class="hs-accordion" id="hs-basic-nested-heading-two">
                    <div class="p-1.5">
                        <button
                            class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400"
                            aria-controls="hs-basic-nested-collapse-one">
                            <svg class="hs-accordion-active:hidden block size-3.5" xmlns="http://www.w3.org/2000/svg"
                                 width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5v14"></path>
                            </svg>
                            <svg class="hs-accordion-active:block hidden size-3.5" xmlns="http://www.w3.org/2000/svg"
                                 width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                            </svg>
                            Accordion #2
                        </button>
                    </div>
                    <hr class="border-gray-500">
                    <div id="hs-basic-nested-collapse-one"
                         class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                         aria-labelledby="hs-basic-nested-heading-one">
                        <div class="hs-accordion-group">
                            <div class="hs-accordion active ps-6" id="hs-basic-nested-sub-heading-one">
                                <button
                                    class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400"
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
                                    Sub accordion #1
                                </button>
                                <div id="hs-basic-nested-sub-collapse-one"
                                     class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                     aria-labelledby="hs-basic-nested-sub-heading-one">
                                    <p class="text-gray-800 dark:text-neutral-200 pb-2.5">
                                        <em>This is the third item's accordion body.</em> It is hidden by default,
                                        until the collapse plugin adds the appropriate classes that we use to style
                                        each element. These classes control the overall appearance, as well as the
                                        showing and hiding via CSS transitions.
                                    </p>
                                </div>
                            </div>
                            <hr class="border-gray-500">
                            <div class="hs-accordion ps-6" id="hs-basic-nested-sub-heading-two">
                                <button
                                    class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400"
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
                                    Sub accordion #2
                                </button>
                                <div id="hs-basic-nested-sub-collapse-two"
                                     class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                                     aria-labelledby="hs-basic-nested-sub-heading-two">
                                    <p class="text-gray-800 dark:text-neutral-200 pb-2.5">
                                        <em>This is the second item's accordion body.</em> It is hidden by default,
                                        until the collapse plugin adds the appropriate classes that we use to style
                                        each element. These classes control the overall appearance, as well as the
                                        showing and hiding via CSS transitions.
                                    </p>
                                </div>
                            </div>
                            <hr class="border-gray-500">
                            <div class="hs-accordion ps-6" id="hs-basic-nested-sub-heading-three">
                                <button
                                    class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400"
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
                                    Sub accordion #3
                                </button>
                                <div id="hs-basic-nested-sub-collapse-three"
                                     class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                                     aria-labelledby="hs-basic-nested-sub-heading-three">
                                    <p class="text-gray-800 dark:text-neutral-200 pb-2.5">
                                        <em>This is the first item's accordion body.</em> It is hidden by default,
                                        until the collapse plugin adds the appropriate classes that we use to style
                                        each element. These classes control the overall appearance, as well as the
                                        showing and hiding via CSS transitions.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="border-gray-500">
                <div class="hs-accordion" id="hs-basic-nested-heading-three">
                    <div class="p-1.5">
                        <button
                            class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400"
                            aria-controls="hs-basic-nested-collapse-one">
                            <svg class="hs-accordion-active:hidden block size-3.5" xmlns="http://www.w3.org/2000/svg"
                                 width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5v14"></path>
                            </svg>
                            <svg class="hs-accordion-active:block hidden size-3.5" xmlns="http://www.w3.org/2000/svg"
                                 width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                            </svg>
                            Accordion #3
                        </button>
                    </div>

                    <div id="hs-basic-nested-collapse-one"
                         class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                         aria-labelledby="hs-basic-nested-heading-one">
                        <hr class="border-gray-500">
                        <div class="hs-accordion-group">
                            <div class="hs-accordion active ps-6" id="hs-basic-nested-sub-heading-one">
                                <button
                                    class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400"
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
                                    Sub accordion #1
                                </button>
                                <div id="hs-basic-nested-sub-collapse-one"
                                     class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                     aria-labelledby="hs-basic-nested-sub-heading-one">
                                    <p class="text-gray-800 dark:text-neutral-200 pb-2.5">
                                        <em>This is the third item's accordion body.</em> It is hidden by default,
                                        until the collapse plugin adds the appropriate classes that we use to style
                                        each element. These classes control the overall appearance, as well as the
                                        showing and hiding via CSS transitions.
                                    </p>
                                </div>
                            </div>
                            <hr class="border-gray-500">
                            <div class="hs-accordion ps-6" id="hs-basic-nested-sub-heading-two">
                                <button
                                    class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400"
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
                                    Sub accordion #2
                                </button>
                                <div id="hs-basic-nested-sub-collapse-two"
                                     class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                                     aria-labelledby="hs-basic-nested-sub-heading-two">
                                    <p class="text-gray-800 dark:text-neutral-200 pb-2.5">
                                        <em>This is the second item's accordion body.</em> It is hidden by default,
                                        until the collapse plugin adds the appropriate classes that we use to style
                                        each element. These classes control the overall appearance, as well as the
                                        showing and hiding via CSS transitions.
                                    </p>
                                </div>
                            </div>
                            <hr class="border-gray-500">
                            <div class="hs-accordion ps-6" id="hs-basic-nested-sub-heading-three">
                                <button
                                    class="hs-accordion-toggle hs-accordion-active:text-blue-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400"
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
                                    Sub accordion #3
                                </button>
                                <div id="hs-basic-nested-sub-collapse-three"
                                     class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                                     aria-labelledby="hs-basic-nested-sub-heading-three">
                                    <p class="text-gray-800 dark:text-neutral-200 pb-2.5">
                                        <em>This is the first item's accordion body.</em> It is hidden by default,
                                        until the collapse plugin adds the appropriate classes that we use to style
                                        each element. These classes control the overall appearance, as well as the
                                        showing and hiding via CSS transitions.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
