@extends('layouts.base')

@php
    $title = __('manage-accounts/accounts.page_title');
@endphp

@push('scripts')
    <script src="{{ secure_asset('js/manage-accounts/accounts.js') }}" defer></script>
    <script src="{{ secure_asset('js/manage-accounts/filter.js') }}" defer></script>
@endpush

@section('content')
    <h1 class="text-4xl m-8 dark:text-white">{{ __('manage-accounts/accounts.page_title') }}</h1>

    <div class="flex flex-col">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <form action="{{ route('manage.accounts.filter') }}" method="GET">
                <div class="flex space-y-2 items-start pb-4 flex-col  sm:flex-row sm:items-center sm:space-x-4 sm:space-y-0">
                    <x-search-bar search="{{ $search }}"
                        placeholder="{{ __('manage-accounts/accounts.search_placeholder') }}" />

                    <x-filter placeholder="{{ __('manage-accounts/accounts.filter_placeholder') }}" :options="$allroles"
                        label="{{ __('manage-accounts/accounts.filter_placeholder') }}" name="filter"
                        selected="{{ $selected }}" />

                    <a href="{{ route('manage.accounts.index') }}"
                        class="text-blue-600 hover:underline hover:decoration-blue-600">
                        {{ __('manage-accounts/accounts.remove_filters_button') }}
                    </a>
                </div>

                <!-- Add these hidden fields to remember the sort direction and column -->
                <input type="hidden" name="sort" value="{{ Request::get('sort') }}">
                <input type="hidden" name="direction" value="{{ Request::get('direction') }}">
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                    <tr>
                        <th scope="col"
                            class="w-4/5 px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase flex items-left gap-0.5">
                            @sortablelink('email', __('manage-accounts/accounts.email'))
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
                            {{ __('manage-accounts/accounts.role') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($accounts as $account)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{ $account['email'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                <div id="selectRole-div" class="relative"
                                    data-account-email="{{ $account->email }}"
                                    data-old-roles="{{ json_encode($account->roles->pluck('name')) }}"
                                    style="width: 250px;">
                                    <label for="selectRole" hidden>{{ __('manage-accounts/accounts.role')  }}</label>
                                    <select id="selectRole" multiple
                                            data-hs-select='{
                                                    "placeholder": "{{ __('manage-accounts/accounts.multiple_select_placeholder') }}",
                                                    "toggleTag": "<button type=\"button\"></button>",
                                                    "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative z-0 py-3 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600",
                                                    "dropdownClasses": "z-50 mt-2 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-slate-900 dark:border-gray-700",
                                                    "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-slate-900 dark:hover:bg-slate-800 dark:text-gray-200 dark:focus:bg-slate-800",
                                                    "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"flex-shrink-0 size-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                                                    }' class="hidden">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}"
                                                    data-translated-name="{{ __('manage-accounts/roles.' . $role->name) }}" {{ in_array($role->name, $account->roles->pluck('name')->toArray()) ? 'selected' : '' }}>
                                                {{ __('manage-accounts/roles.' . $role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
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
    </div>

    {{ $accounts->appends(\Request::except('page'))->links('components.pagination') }}

    <div class="fixed bottom-0 right-0 m-4">
        <button id="saveBtn" name="saveBtn" type="button"
            class="saveBtn pointer-events-auto z-10 p-4 sm:p-5 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
            {{ __('manage-accounts/accounts.save_button') }}
        </button>
    </div>

    <div id="confirmModal" name="confirmModal"
        class="confirmModal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-4 rounded shadow-lg dark:bg-gray-800">
            <h3 class="font-bold text-2xl text-gray-800 border-b mb-4 pb-2 dark:text-white dark:border-gray-600">
                {{ __('manage-accounts/accounts.modal_warning_title') }}
            </h3>
            <div id="changedAccountsInfo" name="changedAccountsInfo" class="text-gray-800 mb-4 dark:text-gray-400"></div>
            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-gray-600">
                <button id="closeModalBtn" name="closeModalBtn"
                    class="mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">{{ __('manage-accounts/accounts.close_button') }}</button>
                <form id="updateRoleForm" action="{{ route('manage.accounts.update.roles') }}" method="post">
                    @csrf
                    <input type="hidden" id="userRoles" name="userRoles" value="">
                    <button type="button" id="confirmModalBtn" name="confirmModalBtn"
                        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        {{ __('manage-accounts/accounts.confirm_button') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
