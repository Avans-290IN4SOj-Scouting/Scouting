@extends('layouts.base')

@php
$title = __('manage-orders/orders.page_title');
@endphp

@push('scripts')
{{-- <script src="{{ asset('js/manage-accounts/accounts.js') }}" defer></script> --}}
<script src="{{ asset('js/manage-accounts/filter.js') }}" defer></script>
<script src="{{ asset('js/manage-orders/filter.js') }}" defer></script>
<script src="{{ asset('js/table/clickabletable.js') }}" defer></script>
@endpush

@section('content')
<h1 class="text-4xl dark:text-white">{{__('manage-orders/orders.page_title')}}</h1>

<div class="flex flex-col">
    <div class="p-1.5 min-w-full inline-block align-middle">
        <form action="{{ route('manage.orders.filter') }}" method="GET">
            <!-- Filters -->
            <div class="flex flex-row gap-4">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-row gap-4">
                        <x-search-bar search="{{ $search }}"
                            placeholder="{{ __('manage-orders/orders.search_placeholder') }}" />

                        <select id="filter" name="filter"
                            class="py-3 px-4 pe-9 block border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:placeholder-slate-500 dark:focus:ring-slate-600">
                            <option value="0">Filter op status</option>
                            @foreach ($allstatusses as $status)
                            <option value="{{ $status->id }}" @if($selected && $status->id === $selected->id) selected
                                @endif>{{ __('orders/orderstatus.'.$status->status) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-row gap-4">
                        <x-date-filter name="date-from-filter" label="{{ __('manage-orders/orders.filter-from') }}" defaultValue="{{ $dateFrom }}" />
                        <x-date-filter name="date-till-filter" label="{{ __('manage-orders/orders.filter-till') }}" defaultValue="{{ $dateTill }}" />
                    </div>
                </div>

                <div class="flex flex-col justify-end">
                    <a href="{{ route('manage.orders.index') }}"
                        class="text-red-600 underline decoration-red-500 hover:opacity-80 dark:text-red-500">
                        {{__('manage-orders/orders.remove_filters_button')}}
                    </a>
                </div>
            </div>
            <!-- /Filters -->

            <!-- Add these hidden fields to remember the sort direction and column -->
            <input type="hidden" name="sort" value="{{ Request::get('sort') }}">
            <input type="hidden" name="direction" value="{{ Request::get('direction') }}">
        </form>

        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr>
                    <x-sortable-table-header sortOn="user.email" textKey="manage-orders/orders.email" />
                    <x-sortable-table-header sortOn="id" textKey="manage-orders/orders.order-number" />

                    <th scope="col" class="w-1/5 px-6 py-3 text-start text-xs font-medium text-black uppercase dark:text-white">
                        {{ __('manage-orders/orders.products') }}
                    </th>
                    <th scope="col" class="w-1/5 px-6 py-3 text-start text-xs font-medium text-black uppercase dark:text-white">
                        {{ __('manage-orders/orders.date') }}
                    </th>
                    <th scope="col" class="w-1/5 px-6 py-3 text-start text-xs font-medium text-black uppercase dark:text-white">
                        {{ __('manage-orders/orders.status') }}
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($orders as $order)
                <tr href="{{ route('manage.orders.order', ['id' => $order->id]) }}"
                    class="clickable hover:bg-gray-100 dark:hover:bg-slate-800">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                        {{ $order->user['email'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                        {{ $order['id'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                        @foreach ($order->orderLines as $orderLine)
                        {{ $orderLine->product['name'] }}; {{ $orderLine['product_size'] }};
                        {{ $orderLine['amount'] }}x<br>
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
@endsection
