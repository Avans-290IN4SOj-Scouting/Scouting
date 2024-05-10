@extends('layouts.base');

@props(['feedbacktypes'])

@php
    $title = __('feedback/feedback.title');
    use app\Enum\FeedbackType;
@endphp

@push('scripts')
    <script src='https://www.hCaptcha.com/1/api.js' async defer></script>
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
@endpush

@section('content')
    <!-- Comment Form -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="mx-auto max-w-2xl">
            <div class="text-center">
                <h2 class="text-3xl text-gray-800 font-bold dark:text-white">
                    {{ __('feedback/feedback.title') }}
                </h2>
            </div>

            <!-- Card -->
            <div
                class="mt-5 p-4 relative z-10 bg-white border rounded-xl sm:mt-10 md:p-10 dark:bg-neutral-900 dark:border-neutral-700">
                <form action="{{ route('feedback.store') }}" method="POST">
                    @csrf
                    <x-feedback.field>
                        <x-feedback.label label="email"> </x-feedback.label>
                        <input type="text" id="email " name="email"
                            class="px-4 w-full border-red-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-100 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="{{ __('feedback/feedback.email') }}" value="{{ old('email') }}">
                        <x-feedback.feedback-error error="email"></x-feedback.feedback-error>
                    </x-feedback.field>
                    <x-feedback.field class="form-group">
                        <x-feedback.label label="type"></x-feedback.label>
                        <select
                            class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            name="type" value="{{ old('type') }}">>
                            @foreach ($feedbacktypes as $feedback)
                                <option value="{{ $feedback }}">{{ $feedback }}</option>
                            @endforeach
                        </select>
                        <x-feedback.feedback-error error="type"></x-feedback.feedback-error>
                    </x-feedback.field>
                    <x-feedback.field>
                        <x-feedback.label label="message"></x-feedback.label>
                        <textarea
                            class="px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            rows="3" name="message" placeholder="{{ __('feedback/feedback.placeholder') }}"
                            value="{{ old('message') }}"></textarea>
                        <x-feedback.feedback-error error="message"></x-feedback.feedback-error>
                    </x-feedback.field>
                    <x-feedback.field class="lg:justify-center">
                        <div class="h-captcha flex flex-col items-center"
                            data-sitekey="50831444-e5fe-4809-adf6-15fbe0195749"></div>
                        <x-feedback.feedback-error error="hCaptchaError"></x-feedback.feedback-error>
                    </x-feedback.field>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mt-6 grid">
                        <button type="submit"
                            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">{{ __('feedback/feedback.submit') }}</button>
                    </div>
                </form>
            </div>
            <!-- End Card -->
        </div>
    </div>
    <!-- End Comment Form -->
@endsection
