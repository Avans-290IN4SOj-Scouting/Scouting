@extends('layouts.base')

@php
    $title = __('groups/groups.page_title');
@endphp

@section('content')

<div class="flex flex-col gap-1.5">
    <h1 class="text-4xl dark:text-white">{{__('groups/groups.page_title')}}</h1>

    <div>
        <div class="hs-accordion-group">
            @foreach ($groups as $group)
            <div class="hs-accordion bg-white border -mt-px first:rounded-t-lg last:rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700" id="hs-bordered-heading-two">
                <button dusk="group_name" class="hs-accordion-toggle hs-accordion-active:text-blue-600 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 py-4 px-5 hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400" aria-controls="hs-basic-bordered-collapse-two">
                <svg class="hs-accordion-active:hidden block size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                    <path d="M12 5v14"></path>
                </svg>
                <svg class="hs-accordion-active:block hidden size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                </svg>
                {{ $group->name }}
                </button>

                <div id="hs-basic-bordered-collapse-two" class="hs-accordion-content hidden overflow-hidden w-half transition-[height] duration-300" aria-labelledby="hs-bordered-heading-two">
                    <div class="pb-4 px-5 overflow-x-auto">

                        <div class="p-1.5 min-w-full inline-block align-middle border rounded-lg dark:border-neutral-700 overflow-x-auto">
                            <table class="divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th scope="col" class="w-1/5 px-6 py-3 text-start text-xs font-medium text-black uppercase dark:text-white">
                                            {{ __('groups/groups.sub_group') }}
                                        </th>
                                        <th scope="col" class="w-1/5 px-6 py-3 text-start text-xs font-medium text-black uppercase dark:text-white">
                                            {{ __('groups/groups.group_leaders') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($group->roles as $subgroup)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                            {{ $subgroup->display_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                            @forelse (\App\Models\User::with('roles')->get()->filter(
                                                fn ($user) => $user->roles->where('name', $subgroup->name)->toArray()
                                            ) as $subGroupLeader)
                                                <p>{{ $subGroupLeader->email }}</p>
                                            @empty
                                                <p>{{ __('groups/groups.empty_groups') }}</p>
                                            @endforelse
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"
                                            colspan="2">
                                            {{ __('groups/groups.empty_table') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


@endsection
