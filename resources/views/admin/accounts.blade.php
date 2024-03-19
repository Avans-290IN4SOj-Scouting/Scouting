@extends('layouts.base')

@php
    $title = __('accounts.page_title');
@endphp

@section('content')

    <div class="w-1/2 mx-auto text-center">
        <h1 class="text-4xl m-8 dark:text-white">{{__('accounts.page_title')}}</h1>

        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <table id="usersTable" name="usersTable"
                               class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                    {{__('accounts.email')}}</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">
                                    {{__('accounts.role')}}</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                            @foreach ($accounts as $account)
                                <tr>
                                    <td class="text-left px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                        {{$account['email']}}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-800">
                                        <div class="relative inline-block text-left">

                                            @php
                                                $oldRole = $account->roles->first() ? $account->roles->first()->name : null;
                                                $translatedOldRole = $oldRole ? __('roles.' . $oldRole) : null;
                                            @endphp

                                            <label for="selectRole" hidden>{{ __('accounts.role')  }}</label>
                                            <select id="selectRole" data-account-email="{{ $account->email }}"
                                                    data-old-role="{{ $account->roles->first()->name }}"
                                                    class="block appearance-none w-full border border-gray-300 py-2 px-4 pr-8 rounded leading tight focus:outline-none focus:border-blue-500 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700">

                                                @foreach (trans('roles') as $role => $translatedRole)
                                                    <option
                                                        value="{{ $role }}" {{ $translatedOldRole === $translatedRole ? "selected" : "" }}>
                                                        {{ __('roles.' . $role) }}
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
            <button id="saveBtn" name="saveBtn"
                    class="saveBtn bg-blue-500 text-white px-8 py-4 rounded hover:bg-blue-600">{{__('accounts.save_button')}}</button>
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
    </div>

@endsection
