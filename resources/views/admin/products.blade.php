@extends('layouts.base')
@section('title', 'Producten')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-gray-700">{{ __('manage-products/products.index_page_title') }}</h1>
            <a class="add-product-button" href="{{ route('manage.products.create.index') }}">
                <span class="inline-flex justify-center items-center size-[37px] rounded-full bg-blue-600 text-white dark:bg-blue-500">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12H19" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 5V19" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </a>
        </div>
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="border rounded-lg shadow overflow-hidden dark:border-gray-700 dark:shadow-gray-900">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                {{__('manage-products/products.name_label')}}
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                {{__('manage-products/products.heading_custom_sizes')}}
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                {{__('manage-products/products.groups_heading')}}
                            </th>
                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                {{__('manage-products/products.actions_heading')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                    {{ $product['name'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                    @foreach ($product['sizesWithPrices'] as $sizeWithPrice)
                                        <div>{{ $sizeWithPrice['size'] }} - €{{ number_format($sizeWithPrice['price'], 2, ',', '.') }}</div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                    @foreach ($product['groups'] as $group)
                                        <div>{{ $group }}</div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <button type="button" onclick="window.location.href='{{ route('manage.products.edit.index', ['id' => $product['id']]) }}'"
                                            dusk="{{__('manage-products/products.action_edit_class')}}"
                                    class=" inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:bg-blue-500 dark:hover:bg-blue-600">
                                    {{ __('manage-products/products.action_edit_label') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
