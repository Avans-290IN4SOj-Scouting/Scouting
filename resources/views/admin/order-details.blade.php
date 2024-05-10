@extends('layouts.base')

@php
    $title = __('manage-orders/orders.page_title');
@endphp

@push('scripts')
    <script type="module" src="{{ asset('js/manage-orders/updatestatus.js') }}" defer></script>
@endpush

@section('content')

    <p><a class="text-blue-600 underline decoration-blue-600 hover:opacity-80"
          href="{{ route('manage.orders.index')}}">{{ __('manage-orders/order.back') }}</a></p>

    <div class="flex justify-around">
        <div class="flex flex-col w-max">
            <div class="flex flex-col sm:flex-row sm:items-center items-left justify-between">
                <h1 class="text-4xl font-bold dark:text-white mb-4 lg:mb-0">{{ __('manage-orders/order.page_title') }} {{ $order->id }}</h1>

                @if ($order->status == App\Enum\DeliveryStatus::AwaitingPayment->value)
                    <x-modal :button-text="__('orders/order_details.cancel_order')"
                             :title="__('orders/order_details.cancel_order') . ' ' . $order->id"
                             :modal-button="__('orders/order_details.cancel_order_confirm')"
                             :modal-text="__('orders/order_details.cancel_order_text')"
                             :route="route('manage.orders.cancel-order', ['id' => $order->id])" color="red"/>
                @endif
            </div>
            <br>

            <div class="flex items-start gap-3 justify-start sm:justify-center sm:items-top sm:gap-10 flex-wrap">
                <!-- Gegevens -->
                <div
                    class="flex flex-col gap-4 bg-white border rounded-xl p-4 md:p-5 dark:bg-slate-900 dark:border-slate-700">
                    <h2 class="text-3xl dark:text-white">{{ __('manage-orders/order.order-data') }}</h2>

                    <div class="flex gap-4 flex-col">
                        <div class="max-w-sm">
                            <label for="email"
                                   class="block text-sm font-medium mb-2 dark:text-white">{{ __('manage-orders/order.customer') }}</label>
                            <input type="text" id="email" value="{{ $order->user->email }}"
                                   class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm border focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:placeholder-slate-500 dark:focus:ring-slate-600" @readonly(true)>
                        </div>

                        <div class="max-w-sm">
                            <label for="datum"
                                   class="block text-sm font-medium mb-2 dark:text-white">{{ __('manage-orders/orders.date') }}</label>
                            <input type="text" id="datum"
                                   value="{{ Carbon\Carbon::parse($order->order_date)->format(__('common.date_time')) }}"
                                   class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm border focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:placeholder-slate-500 dark:focus:ring-slate-600" @readonly(true)>
                        </div>

                        <div class="max-w-sm">
                            <label for="total-price"
                                   class="block text-sm font-medium mb-2 dark:text-white">{{ __('manage-orders/order.total-price') }}</label>
                            <input type="text" id="total-price"
                                   value="{{ __('common.currency_symbol') }} {{ number_format(collect($order->orderLines)->map(fn($line) => $line->amount * $line->product_price)->sum(), 2, __('common.seperator'), '.') }}"
                                   class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm border focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:placeholder-slate-500 dark:focus:ring-slate-600" @readonly(true)>
                        </div>

                        <div class="max-w-sm">
                            <form id="statusform"
                                  action="{{ route('manage.orders.update-status', ['id' => $order->id]) }}"
                                  method="post">
                                @csrf

                                <label for="status"
                                       class="block text-sm font-medium mb-2 dark:text-white">{{ __('manage-orders/orders.status') }}</label>
                                <div id="status-select">
                                    <select id="status" data-hs-select='{
                                "placeholder": "Select option...",
                                "toggleTag": "<button type=\"button\"></button>",
                                "toggleClasses": "hs-select-disabled:pointer-events-none relative py-3 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400",
                                "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-slate-900 dark:border-gray-700",
                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:hover:bg-slate-800 dark:text-neutral-200 dark:focus:bg-slate-800",
                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"flex-shrink-0 size-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"flex-shrink-0 size-3.5 text-gray-500 dark:text-neutral-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                }'
                                            class="hidden" {{ $order->status === \App\Enum\DeliveryStatus::Cancelled->value ? 'disabled' : '' }}>
                                        @if ($order->status !== \App\Enum\DeliveryStatus::Cancelled->value)
                                            @foreach(\App\Enum\DeliveryStatus::cases() as $case)
                                                @if($case->value !== \App\Enum\DeliveryStatus::Cancelled->value)
                                                    <option {{ $order->status === $case->value ? 'selected' : '' }}>
                                                        {{ \App\Enum\DeliveryStatus::localisedValue($case->value) }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option selected>
                                                {{ \App\Enum\DeliveryStatus::localisedValue($order->status) }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!-- /Gegevens -->

                    <!-- Producten -->
                    <div
                        class="flex flex-col max-w-300 sm:max-w-none gap-4 bg-white border rounded-xl p-4 md:p-5 dark:bg-slate-900 dark:border-slate-700">
                        <h2 class="text-3xl dark:text-white">{{ __('manage-orders/order.products') }}</h2>

                        <div class="p-1.5 min-w-full inline-block align-middle overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                                <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-slate-500">
                                        {{ __('manage-orders/order.name') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-slate-500">
                                        {{ __('manage-orders/order.size') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-slate-500">
                                        {{ __('manage-orders/order.price-per') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-slate-500">
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
