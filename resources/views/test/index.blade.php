@extends('layouts.base')

@php
    $title = 'Testing View';
@endphp

@section('content')

<a href="{{ route('test.authenticate') }}"class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
    Authenticate GMAIL API (test.authenticate)
</a>
<a href="{{ route('test.gmail-auth-callback') }}"class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
    Authenticate GMAIL API (test.gmail-auth-callback)
</a>

<form name="testForm" method="POST" action="{{ route('test.send-test-mail') }}">
    @csrf

    <div>
        <label for="email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
            Send mail to Email:
        </label>
        <input id="email" name="email" type="text" value="{{ old('email') }}" placeholder="{{ __('orders.email') }}" class="{{ $errors->has('email') ? 'form-error-input' : '' }} py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px rounded-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
        <button type="submit" class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
            Send mail
        </button>
    </div>
</form>

@endsection
