@extends('layouts.base')

@php
    $title = __('navbar.account');
@endphp

@section('content')
    <div class="w-full max-w-md mx-auto p-6 items-center" style="inline-size: fit-content;">
        <form action="{{route('logoutpost')}}" method="POST">
            @csrf
            <button type="submit"
                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-100 text-gray-500 hover:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-white/10 dark:hover:bg-white/20 dark:text-gray-400 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                {{__('auth.logout')}} {{ Auth::user()->getEmail() }}
            </button>
        </form>
    </div>
@endsection
