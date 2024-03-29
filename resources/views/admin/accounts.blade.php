@extends('layouts.base')

@php
    $title = __('accounts.page_title');
@endphp

@section('content')

    <div class="mx-auto text-center">
        <h1 class="text-4xl m-8 dark:text-white">{{__('accounts.page_title')}}</h1>

        <div class="w-1/2 mx-auto overflow-hidden border rounded-lg mb-4 dark:border-gray-700">
            <table id="usersTable" name="usersTable" class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                        {{__('accounts.email')}}</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                        {{__('accounts.role')}}</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">

                @foreach ($accounts as $account)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-900">
                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">
                            {{$account['email']}}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-800">
                            <div class="relative inline-block text-left">

                                @php
                                    $oldRole = $account->roles->first() ? $account->roles->first()->name : null;
                                    $translatedOldRole = $oldRole ? __('roles.' . $oldRole) : null;
                                @endphp

                                <label hidden>{{ __('accounts.role')  }}</label>
                                <select data-account-email="{{ $account->email }}"
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
