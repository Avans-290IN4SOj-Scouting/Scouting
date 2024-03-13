@extends('layouts.base')

@section('title', 'Producten')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-700 font-semibold mb-4">Producten</h1>
        <div class="mb-4">
            <a class="{{ request()->routeIs('manage-addProduct') ? 'active-nav-link flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm' : 'inactive-nav-link flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm' }}"
               href="{{route('manage-addProduct')}}">
            <span class="inline-flex justify-center items-center size-[55px] rounded-full bg-blue-600 text-white dark:bg-blue-500">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 12H19" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 5V19" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            </span>
            </a>
        </div>
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg shadow overflow-hidden dark:border-gray-700 dark:shadow-gray-900">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Name</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Maten en Prijzen</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Voor groepen</th>
                                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                            @foreach ($products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{ $product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                        @foreach ($product->sizesWithPrices as $sizeWithPrice)
                                            <div>{{ $sizeWithPrice['size'] }} - €{{ number_format($sizeWithPrice['price'], 2) }}</div>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                        @foreach ($product->groups as $group)
                                            @if (is_object($group))
                                                <div>{{ $group->name }}</div>
                                            @else
                                                <div>{{ $group }}</div>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $product->category }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Delete</button>
                                        <td>
                                    </td>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        </div>
    </div>
@endsection
