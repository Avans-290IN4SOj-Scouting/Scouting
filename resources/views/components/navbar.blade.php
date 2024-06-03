<header
    class="flex flex-wrap sm:justify-start sm:flex-nowrap z-50 w-full bg-white border-b border-gray-200 text-sm py-3 sm:py-0 dark:bg-gray-800 dark:border-gray-700">
    <nav class="relative max-w-7xl w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8"
        aria-label="Global">
        <div class="flex items-center justify-between">
            <a class="flex-none text-xl font-semibold dark:text-white" href="{{ route('home') }}"
                aria-label="Brand">{{ __('navbar.company') }}</a>
            <div class="sm:hidden">
                <button type="button"
                    class="hs-collapse-toggle size-9 flex justify-center items-center text-sm font-semibold rounded-lg border border-gray-200 text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                    data-hs-collapse="#navbar-collapse-with-animation" aria-controls="navbar-collapse-with-animation"
                    aria-label="Toggle navigation">
                    <svg class="hs-collapse-open:hidden size-4" width="16" height="16" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                    </svg>
                    <svg class="hs-collapse-open:block flex-shrink-0 hidden size-4" width="16" height="16"
                        fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </button>
            </div>
        </div>
        <div id="navbar-collapse-with-animation"
            class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow sm:block">
            <div
                class="flex flex-col gap-y-4 gap-x-0 mt-5 sm:flex-row sm:items-center sm:justify-end sm:gap-y-0 sm:gap-x-7 sm:mt-0 sm:ps-7">
                {{-- This are all links --}}
                <a class="{{ request()->routeIs('home') ? 'active-nav-link' : 'inactive-nav-link' }}"
                    href="{{ route('home') }}">{{ __('navbar.home') }}</a>
                <a class="{{ request()->routeIs('orders.shoppingcart.index') ? 'active-nav-link' : 'inactive-nav-link' }}"
                    href="{{ route('orders.shoppingcart.index') }}">{{ __('navbar.cart') }}</a>
                <a class="{{ request()->routeIs('orders.checkout.order') ? 'active-nav-link' : 'inactive-nav-link' }}"
                    href="{{ route('orders.checkout.order') }}">{{ __('navbar.checkout') }}</a>

                {{--This is the dropdown for Admin--}}
                @if (Auth::user() && (Auth::user()->hasAnyRole(['admin', 'teamleader'])))
                    <div
                        class="hs-dropdown [--strategy:static] sm:[--strategy:fixed] [--adaptive:none] sm:[--trigger:hover] sm:py-4">
                        <button type="button"
                            class="{{ request()->routeIs('manage.products.index') ||
                            request()->routeIs('manage.accounts.index') ||
                            request()->routeIs('manage.orders.index') ||
                            request()->routeIs('manage.orders.order') ||
                            request()->routeIs('manage.accounts.filter')
                                ? 'active-nav-link'
                                : 'inactive-nav-link' }} flex items-center w-full sm:py-0">
                            {{ __('navbar.manage') }}
                            <svg class="ms-2 size-2.5 text-gray-600" width="16" height="16" viewBox="0 0 16 16"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                            </svg>
                        </button>

                        <div
                            class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] sm:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 sm:w-48 hidden z-10 bg-white sm:shadow-md rounded-lg p-2 dark:bg-gray-800 sm:dark:border dark:border-gray-700 dark:divide-gray-700 before:absolute top-full sm:border before:-top-5 before:start-0 before:w-full before:h-5">
                            @if (Auth::user()->hasRole('admin'))
                                <a class="{{ request()->routeIs('manage.accounts.index', 'manage.accounts.filter') ? 'active-nav-link flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm' : 'inactive-nav-link flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm' }}"
                                   href="{{route('manage.accounts.index')}}">
                                    {{__('navbar.manage_accounts')}}
                                </a>
                                <a class="{{ request()->routeIs('stocks.index') ? 'active-nav-link flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm' : 'inactive-nav-link flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm' }}"
                                   href="{{route('manage.stocks.index')}}">
                                    {{__('navbar.manage_stocks')}}
                                </a>
                            @endif
                            @if (Auth::user()->hasRole('admin'))
                                <a class="{{ request()->routeIs('manage.products.index') ? 'active-nav-link flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm' : 'inactive-nav-link flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm' }}"
                                    href="{{ route('manage.products.index') }}">
                                    {{ __('navbar.manage_products') }}
                                </a>
                            @endif
                            @if (Auth::user()->hasAnyRole(['admin', 'teamleader']))
                                <a class="{{ request()->routeIs('manage.orders.index', 'manage.orders.filter') ? 'active-nav-link flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm' : 'inactive-nav-link flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm' }}"
                                   href="{{route('manage.orders.index')}}">
                                    {{__('navbar.manage_orders')}}
                                </a>
                            @endif
                            @if (Auth::user()->hasRole('admin'))
                                <hr class="border-gray-300 dark:border-gray-100">
                                <a class="inactive-nav-link flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm"
                                   href="{{ route('manage.backorders.download') }}">
                                    {{__('navbar.download_backorders')}}
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                @if (Auth::guest())
                    <a class="flex items-center gap-x-2 {{ request()->routeIs('login') ? 'active-nav-link' : 'inactive-nav-link' }}"
                        href="{{ route('login') }}">
                        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16"
                            height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                        </svg>
                        {{-- This is the Login link --}}
                        {{ __('navbar.login') }}
                    </a>
                @else
                    {{-- This is the other link for when user is logged in --}}
                    <a class="flex items-center gap-x-2 {{ request()->routeIs('profile.index') ? 'active-nav-link' : 'inactive-nav-link' }}"
                        href="{{ route('profile.update') }}">
                        {{ __('navbar.account') }}
                    </a>
                @endif
            </div>
        </div>
    </nav>
</header>
