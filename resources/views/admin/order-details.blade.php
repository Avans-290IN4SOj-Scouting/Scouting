@extends('layouts.base')

@php
    $title = __('manage-orders/orders.page_title');
    $admin = auth()->user()->hasRole('admin');
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
                            <label for="group-name"
                                   class="block text-sm font-medium mb-2 dark:text-white">{{ __('manage-orders/orders.group_name') }}</label>
                            <input type="text" id="group-name"
                                   value="{{ $order->group->name }}"
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
                                "toggleClasses": "hs-select-disabled:pointer-events-none relative py-3 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400",
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
                                @if($admin)
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-slate-500">
                                        {{--                                        {{ __('manage-orders/order.action') }}--}}
                                    </th>
                                @endif
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @forelse($order->orderLines as $orderLine)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $orderLine->product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $orderLine->product_size }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                        @if($admin)
                                            <div>
                                                <div class="flex rounded-lg ">
                                                    <span
                                                        class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500 dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400">
                                                        {{ __('common.currency_symbol') }}
                                                    </span>
                                                    <label for="product-price"
                                                           class="sr-only">{{ __('manage-orders/order.price-per') }}</label>
                                                    <input type="number" id="product-price" step="0.01"
                                                           value="{{ number_format($orderLine->product_price, 2)  }}"
                                                           class="py-3 px-4 block w-min border-gray-200 shadow-sm rounded-e-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                                </div>
                                            </div>
                                        @else
                                            {{ __('common.currency_symbol') }} {{ number_format($orderLine->product_price, 2, __('common.seperator'), '.') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $orderLine->amount }}</td>
                                    @if($admin)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                            <form
                                                action="{{ route('manage.orders.delete.orderline', ['id' => $orderLine->id ]) }}"
                                                method="POST">
                                                @csrf
                                                <label for="trash"
                                                       class="sr-only">{{ __('manage-orders/order.delete') }}</label>
                                                <button type="submit" id="trash"
                                                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-slate-200 text-red-500 hover:border-slate-100 hover:text-red-400 disabled:opacity-50 disabled:pointer-events-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 italic py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"
                                        colspan="5">{{ __('manage-orders/order.no_products') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($admin)
                        <x-modal :button-text="__('manage-orders/order.add_product')"
                                 :title="__('manage-orders/order.add_product')"
                                 :modal-button="__('manage-orders/order.add_product')"
                                 modal-text=" "
                                 :route="route('manage.orders.add.product', ['id' => $order->id])"
                                 color="blue">
                            <label for="product-select"
                                   class="sr-only">{{ __('manage-orders/order.add_product_modal_text') }}</label>
                            <select id="product-select" name="product-select"
                                    class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                <option disabled
                                        selected="">{{ __('manage-orders/order.add_product_modal_text') }}</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->row_number }}">{{ $product->name }}
                                        , {{ $product->type }}, {{ $product->size }},
                                        {{ __('common.currency_symbol') }} {{ number_format($product->price, 2, __('common.seperator'), '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </x-modal>
                    @endif
                </div>
                <!-- /Producten -->
            </div>
        </div>
    </div>
@endsection
