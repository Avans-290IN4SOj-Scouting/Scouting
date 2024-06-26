@extends('layouts.base')

@php
    $title = __('manage-accounts/accounts.page_title');
@endphp

@push('scripts')
    <script src="{{ asset('js/manage-accounts/saveroles.js') }}" defer></script>
    <script src="{{ asset('js/manage-accounts/filter.js') }}" defer></script>
    <script src="{{ asset('js/manage-accounts/addrolebutton.js') }}" defer></script>
    <script src="{{ asset('js/manage-accounts/adddropdown.js') }}" defer></script>
@endpush

@section('content')
    <h1 class="text-4xl m-8 dark:text-white">{{ __('manage-accounts/accounts.page_title') }}</h1>

    <div class="flex flex-col">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <form action="{{ route('manage.accounts.filter') }}" method="GET">
                <div class="lg:flex lg:flex-row lg:justify-between">
                    <div
                        class="flex space-y-2 items-start pb-4 flex-col sm:flex-row sm:items-center sm:space-x-4 sm:space-y-0">
                        <x-search-bar search="{{ $search }}"
                                      placeholder="{{ __('manage-accounts/accounts.search_placeholder') }}"/>

                        <x-filter placeholder="{{ __('manage-accounts/accounts.filter_placeholder') }}"
                                  :options="$allroles" label="{{ __('manage-accounts/accounts.filter_placeholder') }}"
                                  name="filter" selected="{{ $selected }}"/>

                        <a href="{{ route('manage.accounts.index') }}"
                           class="text-blue-600 hover:underline hover:decoration-blue-600">
                            {{__('manage-accounts/accounts.remove_filters_button')}}
                        </a>
                    </div>
                    <button id="resetButton" type="button" onclick="resetLocalStorage(); return false;"
                            class="py-3 px-4 mb-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-red-500 hover:bg-red-100 hover:text-red-800 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-red-800/30 dark:hover:text-red-400">
                        {{ __('manage-accounts/accounts.reset_changes') }}
                    </button>
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
                            class="w-1/5 px-6 py-3 text-xs font-medium text-gray-500 uppercase text-end">
                            {{ __('manage-accounts/accounts.role') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($accounts as $account)
                        <tr class="h-[87px]" data-email="{{ $account['email'] }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{ $account['email'] }}
                            </td>
                            <td id="roleContainer{{ $account->id }}"
                                class="h-[87px] flex items-center gap-2 justify-end px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                <div id="selectRoleContainer" class="flex flex-row gap-2 hidden items-center">
                                    <div id="selectRole-wrapper" class="relative w-[250px]"
                                         data-old-roles="{{ json_encode($account->roles->pluck('name')) }}">
                                        <label for="selectRole{{ $account->id }}"
                                               hidden>{{ __('manage-accounts/accounts.role')  }}</label>
                                        <select id="selectRole{{ $account->id }}" name="selectRole"
                                                class="h-[54px] py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                            <option value="" disabled selected>Kies rol</option>
                                            @foreach($roles as $id => $role)
                                                <option
                                                    value="{{ $role }}" data-group-id="{{ $id }}">
                                                    {{ $role }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="cancelButton" class="text-red-600 h-[35px]">
                                        <button class="items-center h-[35px]">
                                            <svg class="svg-icon" width="35px" height="35px" viewBox="0 0 1024 1024"
                                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M810.66 170.66q18.33 0 30.49 12.17t12.17 30.49q0 18-12.33 30.33L572.34 512l268.81 268.34q12.33 12.33 12.33 30.33 0 18.33-12.17 30.49t-30.49 12.17q-18 0-30.33-12.33L512 572.34 243.66 841.15q-12.33 12.33-30.33 12.33-18.33 0-30.49-12.17t-12.17-30.49q0-18 12.33-30.33L451.66 512 182.99 243.66q-12.33-12.33-12.33-30.33 0-18.33 12.17-30.49t30.49-12.17q18 0 30.33 12.33L512 451.66 780.34 182.99q12.33-12.33 30.33-12.33z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div id="addRoleButton" class="text-blue-600 h-[35px]">
                                    <div class="hs-tooltip inline-block h-[35px]">
                                        <button type="button" class="hs-tooltip-toggle items-center">
                                            <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M12 2C12.5523 2 13 2.44772 13 3V11H21C21.5523 11 22 11.4477 22 12C22 12.5523 21.5523 13 21 13H13V21C13 21.5523 12.5523 22 12 22C11.4477 22 11 21.5523 11 21V13H3C2.44772 13 2 12.5523 2 12C2 11.4477 2.44772 11 3 11H11V3C11 2.44772 11.4477 2 12 2Z"
                                                      fill="currentColor"/>
                                            </svg>
                                            <span
                                                class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm dark:bg-neutral-700"
                                                role="tooltip">{{ __('manage-accounts/accounts.add-role') }}</span>
                                        </button>
                                    </div>
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
