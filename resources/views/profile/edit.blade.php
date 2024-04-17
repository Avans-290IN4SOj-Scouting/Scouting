@extends('layouts.base')

@php
    $title = __('navbar.account');
@endphp

@push('scripts')
    <script src="{{ @asset('js/auth/profile.js') }}" defer></script>
@endpush

@section('content')
    <div class="grid gap-4">
        <div class="flex flex-row justify-between items-center">
            <h1 class="text-4xl dark:text-white">Welkom!</h1>
            <div>
                <form action="{{ route('logoutpost') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-red-900 dark:text-red-500 dark:hover:text-red-400">
                        {{ __('auth/auth.logout') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="flex flex-col space-y-2 sm:flex-row sm:justify-start sm:items-start sm:space-y-0 sm:space-x-10">
            <div class="grid gap-4 w-full sm:w-1/3">
                <div>
                    <label for="email"
                           class="block text-sm mb-2 dark:text-white">{{__('auth/auth.email')}}</label>
                    <div class="max-w space-y-3">
                        <input type="text"
                               class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                               placeholder="{{ $user->email }}" readonly="">
                    </div>
                </div>
                <button type="button" id="edit-password-button"
                        class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    {{ __('auth/profile.edit_password') }}
                </button>

                <form action="#" method="post">
                    @csrf

                    <div id="password-fields" class="hidden grid gap-2">
                        <div>
                            <label for="old-password" class="block text-sm mb-2 dark:text-white">
                                {{ __('auth/profile.current_password') }}
                            </label>
                            <input type="password" id="old-password"
                                   class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>
                        <div>
                            <label for="new-password" class="block text-sm mb-2 dark:text-white">
                                {{ __('auth/profile.new_password') }}
                            </label>
                            <input type="password" id="new-password"
                                   class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>
                        <div>
                            <label for="repeat-password"
                                   class="block text-sm mb-2 dark:text-white">
                                {{ __('auth/profile.repeat_password') }}
                            </label>
                            <input type="password" id="repeat-password"
                                   class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>
                        <button type="submit"
                                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            {{ __('auth/profile.edit_password') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="w-full sm:w-2/3">
                <p class="dark:text-white">
                    <strong>{{ __('auth/profile.recent_orders') }}</strong>
                </p>
                <p class="dark:text-white">
                    {{ __('auth/profile.all_orders') }}
                    <a href="#"
                       class="text-blue-600 hover:underline dark:text-blue-400 dark:hover:text-blue-300">
                        {{ __('auth/profile.here') }}
                    </a>
                </p>

                @forelse($orders as $order)
                    <x-order-preview :order="$order"/>
                @empty
                    <p class="dark:text-white">
                        {{ __('auth/profile.no_orders') }}
                    </p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
