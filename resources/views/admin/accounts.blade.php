@extends('layouts.base')

@section('title', __('accounts.title'))

@section('content')
{{--TODO: Add navbar --}}

<head>
    @vite(['resources/js/app.js'])
</head>

<body>
    <div class="mx-auto text-center">
        <h1 class="text-4xl m-8">{{__('accounts.page_title')}}</h1>

        <div class="w-1/2 mx-auto overflow-hidden border rounded-lg">
            <table class="w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            {{__('accounts.email')}}</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            {{__('accounts.role')}}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    {{--TODO: Iterate through accounts; use example below for each iteration --}}
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-800">test@test.com
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-800">
                            <div class="relative inline-block text-left">
                                <select id="dropdownRoles" name="dropdownRoles"
                                    class="block appearance-none w-full border border-gray-300 py-2 px-4 pr-8 rounded leading tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="gebruiker">{{__('accounts.user')}}</option>
                                    <option value="teamleider">{{__('accounts.team_leader')}}</option>
                                    <option value="admin">{{__('accounts.admin')}}</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="fixed bottom-0 right-0 m-4">
            <button id="saveBtn" name="saveBtn"
                class="bg-blue-500 text-white px-8 py-4 rounded">{{__('accounts.save_button')}}</button>
        </div>

        <div id="confirmModal" name="confirmModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-4 rounded shadow-lg">
                <h3 class="font-bold text-2xl text-gray-800 border-b mb-4 pb-2">{{__('accounts.modal_warning_title')}}</h3>
                <p class="text-gray-800 mb-4">{{__('accounts.modal_warning_message')}}</p>
                {{-- TODO: Iterate through each account that is edited, see below --}}
                <p class="text-gray-800 mb-4">test@test.com -> teamleider</p>
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
                    <button id="closeModalBtn" name="closeModalBtn"
                        class="mt-4 bg-gray-500 text-white px-4 py-2 rounded">{{__('accounts.close_button')}}</button>
                    <button id="confirmModalBtn" name="confirmModalBtn"
                        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
                        {{__('accounts.confirm_button')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection