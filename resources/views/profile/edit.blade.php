@extends('layouts.base')

@php
    $title = __('navbar.account');
@endphp

@section('content')
<div class="breadcrumbs-container">
    <ol class="flex items-center whitespace-nowrap" aria-label="Breadcrumb">
        <li class="inline-flex items-center">
            <a href="{{ route('home') }}"
                class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500">
                <svg class="flex-shrink-0 me-3 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                {{ __('navbar.home') }}
            </a>
            <svg class="flex-shrink-0 mx-2 overflow-visible size-4 text-gray-400 dark:text-neutral-600"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6" />
            </svg>
        </li>
        <li class="inline-flex items-center text-sm font-semibold text-gray-800 truncate dark:text-gray-200"
            aria-current="page">
            {{ __('auth/profile.overview_orders') }}
        </li>
    </ol>
</div>

    <div class="grid gap-4">
        <div class="flex flex-row justify-between items-center">
            <h1 class="text-4xl dark:text-white">
                {{ __('auth/profile.welcome') }}!
            </h1>
            <div>
                <form action="{{ route('logoutpost') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-red-900 dark:text-red-300 dark:hover:bg-red-950 dark:hover:text-red-400">
                        {{ __('auth/auth.logout') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="flex flex-col space-y-2 md:flex-row md:justify-start md:items-start md:space-y-0 md:space-x-10">
            <div class="grid gap-4 w-full md:w-1/3">
                <div>
                    <label for="email"
                           class="block text-sm mb-2 dark:text-white">{{__('auth/auth.email')}}</label>
                    <div class="max-w space-y-3">
                        <input type="text" id="email"
                               class="py-3 px-4 block w-full border-gray-200 rounded-lg placeholder-black text-black text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-50 dark:placeholder-neutral-50 dark:focus:ring-neutral-600"
                               placeholder="{{ $user->email }}" readonly="">
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="post">
                    @csrf

                    <div id="password-fields" class="grid gap-2">
                        <div>
                            <label for="old-password" class="block text-sm mb-2 dark:text-white">
                                {{ __('auth/profile.current_password') }}
                            </label>
                            <input type="password" id="old-password" value="{{ old('old-password') }}"
                                   name="old-password"
                                   class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            <x-error id="old-password" :error="$errors->first('old-password')"/>
                        </div>
                        <div>
                            <label for="new-password" class="block text-sm mb-2 dark:text-white">
                                {{ __('auth/profile.new_password') }}
                            </label>
                            <input type="password" id="new-password" value="{{ old('new-password') }}"
                                   name="new-password"
                                   class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            <x-error id="new-password" :error="$errors->first('new-password')"/>
                        </div>
                        <div>
                            <label for="repeat-password"
                                   class="block text-sm mb-2 dark:text-white">
                                {{ __('auth/profile.repeat_password') }}
                            </label>
                            <input type="password" id="repeat-password" value="{{ old('repeat-password') }}"
                                   name="repeat-password"
                                   class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            <x-error id="repeat-password" :error="$errors->first('repeat-password')"/>
                        </div>
                        <button type="submit"
                                class="w-full mt-3 py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            {{ __('auth/profile.edit_password') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="w-full md:w-2/3">
                <p class="dark:text-white">
                    <strong>{{ __('auth/profile.recent_orders') }}</strong>
                </p>
                <a href="{{ route('profile.overview')}}">
                    <div class="dark:text-white flex flex-row">
                        {{ __('auth/profile.all_orders') }}&nbsp;
                        <div class="text-blue-600 hover:underline dark:text-blue-400 dark:hover:text-blue-300">
                            {{ __('auth/profile.here') }}
                        </div>
                    </div>
                </a>

                <div class="flex flex-col pt-4 gap-4">
                    @forelse($orders as $order)
                        <a href="#">
                            <x-order-preview :order="$order"/>
                        </a>
                    @empty
                        <p class="italic dark:text-white">
                            {{ __('auth/profile.no_orders') }}
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
