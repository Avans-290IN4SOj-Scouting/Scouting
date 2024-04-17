@extends('layouts.base')

@php
    $title = __('manage-orders/orders.page_title');
@endphp

@push('scripts')
    {{-- <script src="{{ asset('js/manage-accounts/accounts.js') }}" defer></script> --}}
    <script src="{{ asset('js/manage-accounts/filter.js') }}" defer></script>
    <script src="{{ asset('js/table/clickabletable.js') }}" defer></script>
@endpush

@section('content')
    <h1 class="text-4xl dark:text-white">{{__('manage-orders/orders.page_title')}}</h1>

    <div class="flex flex-col">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <form action="{{ route('manage.orders.filter') }}" method="GET">
                <div class="flex flex-row gap-4">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-row gap-4">
                            <x-search-bar search="{{ $search }}" placeholder="{{ __('manage-orders/orders.search_placeholder') }}" class="flex-grow"/>

                            <select id="filter" name="filter"
                                class="py-3 px-4 pe-9 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:placeholder-slate-500 dark:focus:ring-slate-600">
                                <option value="0">Filter op status</option>
                                @foreach ($allstatusses as $status)
                                <option value="{{ $status->id }}" @if($selected && $status->id === $selected->id) selected @endif>{{ __('orders/orderstatus.'.$status->status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-row gap-4">
                            <x-date-filter name="date-from-filter" defaultValue="{{ $dateFrom }}" class="flex-grow" />
                            <x-date-filter name="date-till-filter" defaultValue="{{ $dateTill }}" class="flex-grow" />
                        </div>
                    </div>

                    <div class="flex flex-col justify-end">
                        <a href="{{ route('manage.orders.index') }}" class="text-red-500 underline decoration-red-500 hover:opacity-80">
                            {{__('manage-orders/orders.remove_filters_button')}}
                        </a>
                        <a href="{{ route('manage.orders.index') }}" class="text-blue-600 hover:underline hover:decoration-blue-600">
                            {{__('manage-orders/orders.apply_filters')}}
                        </a>
                    </div>
                </div>

                <!-- Add these hidden fields to remember the sort direction and column -->
                <input type="hidden" name="sort" value="{{ Request::get('sort') }}">
                <input type="hidden" name="direction" value="{{ Request::get('direction') }}">
            </form>

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                <tr>
                    <th scope="col"
                        class="w-1/5 px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase flex items-left gap-0.5">
                        @sortablelink('user.email', __('manage-orders/orders.email'))
                        @if (Request::get('sort') == 'email')
                            @if (Request::get('direction') == 'desc')
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                    </svg>
                                </span>
                            @else
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m4.5 15.75 7.5-7.5 7.5 7.5"/>
                                    </svg>
                                </span>
                            @endif
                        @else
                            <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"/>
                            </svg>
                        </span>
                        @endif
                    </th>
                    <th scope="col"
                        class="w-1/5 px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                        @sortablelink('id', __('manage-orders/orders.order-number'))
                        @if (Request::get('sort') == 'id')
                            @if (Request::get('direction') == 'desc')
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                    </svg>
                                </span>
                            @else
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m4.5 15.75 7.5-7.5 7.5 7.5"/>
                                    </svg>
                                </span>
                            @endif
                        @else
                            <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"/>
                            </svg>
                        </span>
                        @endif
                    </th>
                    <th scope="col"
                        class="w-1/5 px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                        {{ __('manage-orders/orders.products') }}
                    </th>
                    <th scope="col"
                        class="w-1/5 px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                        {{ __('manage-orders/orders.date') }}
                    </th>
                    <th scope="col"
                        class="w-1/5 px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                        {{ __('manage-orders/orders.status') }}
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($orders as $order)
                    <tr href="{{ route('manage.orders.order', ['id' => $order->id]) }}" class="clickable hover:bg-gray-100 dark:hover:bg-slate-800">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ $order->user['email'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ $order['id'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            @foreach ($order->orderLines as $orderLine)
                                {{ $orderLine->product['name'] }}; {{ $orderLine['product_size'] }}; {{ $orderLine['amount'] }}x<br>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ $order['order_date'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                            {{ __('orders/orderstatus.'.$order->orderStatus['status']) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"
                            colspan="2">
                            {{ __('manage-accounts/accounts.empty_table') }}
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- {{ $accounts->appends(\Request::except('page'))->links('components.pagination') }} --}}

    {{-- <div class="fixed bottom-0 right-0 m-4">
        <button id="saveBtn" name="saveBtn" type="button"
                class="saveBtn pointer-events-auto z-10 p-4 sm:p-5 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
            {{__('manage-accounts/accounts.save_button')}}
        </button>
    </div>

    <div id="confirmModal" name="confirmModal"
         class="confirmModal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-4 rounded shadow-lg dark:bg-gray-800">
            <h3 class="font-bold text-2xl text-gray-800 border-b mb-4 pb-2 dark:text-white dark:border-gray-600">{{__('manage-accounts/accounts.modal_warning_title')}}
            </h3>
            <div id="changedAccountsInfo" name="changedAccountsInfo"
                 class="text-gray-800 mb-4 dark:text-gray-400"></div>
            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-gray-600">
                <button id="closeModalBtn" name="closeModalBtn"
                        class="mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">{{__('manage-accounts/accounts.close_button')}}</button>
                <form id="updateRoleForm" action="{{ route('manage.accounts.update.roles') }}" method="post">
                    @csrf
                    <input type="hidden" id="userRoles" name="userRoles" value="">
                    <button type="button" id="confirmModalBtn" name="confirmModalBtn"
                            class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        {{__('manage-accounts/accounts.confirm_button')}}
                    </button>
                </form>
            </div>
        </div>
    </div> --}}
@endsection
