@extends('layouts.base')

@php
    $title = __('accounts.page_title');
@endphp

@section('content')
    <h1 class="text-4xl m-8 dark:text-white">{{__('accounts.page_title')}}</h1>

    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                        <tr>
                            <th scope="col"
                                class="w-4/5 px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                {{ __('accounts.email') }}
                            </th>
                            <th scope="col"
                                class="w-1/5 px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                {{ __('accounts.role') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($accounts as $account)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                    {{ $account['email'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                    <div id="selectRole-div" class="relative" data-account-email="{{ $account->email }}" data-old-roles="{{ json_encode($account->roles->pluck('name')) }}" style="width: 250px;">
                                        <label for="selectRole" hidden>{{ __('accounts.role')  }}</label>
                                        <select id="selectRole" multiple
                                                data-hs-select='{
                                                  "placeholder": "{{ __('accounts.multiple_select_placeholder') }}",
                                                  "toggleTag": "<button type=\"button\"></button>",
                                                  "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600",
                                                  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-slate-900 dark:border-gray-700",
                                                  "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-slate-900 dark:hover:bg-slate-800 dark:text-gray-200 dark:focus:bg-slate-800",
                                                  "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"flex-shrink-0 size-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                                                }' class="hidden">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}" data-translated-name="{{ __('roles.' . $role->name) }}" {{ in_array($role->name, $account->roles->pluck('name')->toArray()) ? 'selected' : '' }}>
                                                    {{ __('roles.' . $role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <nav class="flex justify-center items-center gap-x-1">
        <button type="button"
                class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
            <svg aria-hidden="true" class="hidden flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg"
                 width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            <span>Previous</span>
        </button>
        <div class="flex items-center gap-x-1">
            <button type="button"
                    class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10"
                    aria-current="page">1
            </button>
            <button type="button"
                    class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                2
            </button>
            <button type="button"
                    class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                3
            </button>
        </div>
        <button type="button"
                class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
            <span>Next</span>
            <svg aria-hidden="true" class="hidden flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg"
                 width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6"/>
            </svg>
        </button>
    </nav>

    <div class="fixed bottom-0 right-0 m-4">
        <button id="saveBtn" name="saveBtn" type="button"
                class="saveBtn p-4 sm:p-5 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
            {{__('accounts.save_button')}}
        </button>
    </div>

    <div id="confirmModal" name="confirmModal"
         class="confirmModal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-4 rounded shadow-lg dark:bg-gray-800">
            <h3 class="font-bold text-2xl text-gray-800 border-b mb-4 pb-2 dark:text-white dark:border-gray-600">{{__('accounts.modal_warning_title')}}
            </h3>
            <div id="changedAccountsInfo" name="changedAccountsInfo"
                 class="text-gray-800 mb-4 dark:text-gray-400"></div>
            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-gray-600">
                <button id="closeModalBtn" name="closeModalBtn"
                        class="mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">{{__('accounts.close_button')}}</button>
                <form id="updateRoleForm" action="{{ route('manage-accounts.updateRoles') }}" method="post">
                    @csrf
                    <input type="hidden" id="userRoles" name="userRoles" value="">
                    <button type="button" id="confirmModalBtn" name="confirmModalBtn"
                            class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        {{__('accounts.confirm_button')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
