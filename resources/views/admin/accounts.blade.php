@extends('layouts.base')

@section('title', 'TODO: put title here')

@section('content')

<div class="mx-auto text-center">
    <h1 class="text-4xl m-8">Account management</h1>

    <div class="w-1/2 mx-auto overflow-hidden border rounded-lg">
        <table class="w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Role</th>
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
                                <option value="gebruiker">Gebruiker</option>
                                <option value="teamleider">Teamleider</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="fixed bottom-0 right-0 m-4">
        <button id="saveBtn" name="saveBtn" class="bg-blue-500 text-white px-8 py-4 rounded">Opslaan</button>
    </div>
</div>

<script>
    const saveBtn = document.getElementById("saveBtn");

    saveBtn.addEventListener("click", function () {
        // TODO: summon modal
    });
</script>

@endsection