@extends('layouts.base')

@php
    $title = __('manage-orders/orders.page_title');
@endphp

@section('content')

<p><a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="{{ route('manage.orders.index')}}">{{ __('manage-orders/order.back') }}</a></p>

<div class="flex justify-around">
    <div class="flex flex-col w-max">
        <div class="flex flex-row justify-between items-center">
            <h1 class="text-4xl font-bold dark:text-white mb-4 lg:mb-0">{{ __('manage-orders/order.page_title') }} {{ $order->id }}</h1>

            @if ($order->orderStatus->status != 'cancelled')
            <form name="cancelOrderForm" method="POST" action="{{ route('manage.orders.cancel-order', ['id' => $order->id]) }}">
                @csrf
                <input type="submit" value="{{ __('manage-orders/order.cancel-order') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 dark:bg-red-500 text-white hover:bg-red-600 disabled:opacity-50 disabled:pointer-events-none">
            </form>
            @endif
        </div>
        <br>

        <div class="flex justify-center items-top gap-10 flex-wrap">
            <!-- Gegevens -->
            <div class="flex flex-col gap-4 bg-white border rounded-xl p-4 md:p-5 dark:bg-slate-900 dark:border-slate-700">
                <h2 class="text-3xl dark:text-white">{{ __('manage-orders/order.order-data') }}</h2>

                <div class="flex gap-4 flex-col">
                    <div class="max-w-sm">
                        <label for="email" class="block text-sm font-medium mb-2 dark:text-white">{{ __('manage-orders/order.customer') }}</label>
                        <input type="text" id="email" value="{{ $order->user->email }}" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm border focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:placeholder-slate-500 dark:focus:ring-slate-600" @readonly(true)>
                    </div>

                    <div class="max-w-sm">
                        <label for="datum" class="block text-sm font-medium mb-2 dark:text-white">{{ __('manage-orders/orders.date') }}</label>
                        <input type="text" id="datum" value="{{ $order->order_date }}" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm border focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:placeholder-slate-500 dark:focus:ring-slate-600" @readonly(true)>
                    </div>

                    <div class="max-w-sm">
                        <label for="total-price" class="block text-sm font-medium mb-2 dark:text-white">{{ __('manage-orders/order.total-price') }}</label>
                        <input type="text" id="total-price" value="{{ __('common.currency_symbol') }} {{ number_format(collect($order->orderLines)->map(fn($line) => $line->amount * $line->product_price)->sum(), 2, __('common.seperator'), '.') }}" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm border focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:placeholder-slate-500 dark:focus:ring-slate-600" @readonly(true)>
                    </div>

                    <div class="max-w-sm">
                        <label for="status" class="block text-sm font-medium mb-2 dark:text-white">{{ __('manage-orders/orders.status') }}</label>
                        <input type="text" id="status" value="{{ __('delivery_status.'.$order->orderStatus->status) }}" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm border focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:placeholder-slate-500 dark:focus:ring-slate-600" @readonly(true)>
                    </div>
                </div>
            </div>
            <!-- /Gegevens -->

            <!-- Producten -->
            <div class="flex flex-col gap-4 bg-white border rounded-xl p-4 md:p-5 dark:bg-slate-900 dark:border-slate-700">
                <h2 class="text-3xl dark:text-white">{{ __('manage-orders/order.products') }}</h2>

                <div class="p-1.5 min-w-full inline-block align-middle overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-slate-500">
                                    {{ __('manage-orders/order.name') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-slate-500">
                                    {{ __('manage-orders/order.size') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-slate-500">
                                    {{ __('manage-orders/order.price-per') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-slate-500">
                                    {{ __('manage-orders/order.amount') }}
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @foreach ($order->orderLines as $orderLine)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $orderLine->product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $orderLine->product_size }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ __('common.currency_symbol') }} {{ number_format($orderLine->product_price, 2, __('common.seperator'), '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $orderLine->amount }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Producten -->
        </div>
    </div>
</div>
@endsection
