@props(['name'])

<div class="mb-4 sm:mb-8 flex flex-col lg:flex-row gap-3 lg:items-bottom">
    <label for="{{ $name }}" class="text-sm font-medium dark:text-white">{{ $name }}</label>
    <input type="text" id="{{ $name }}"
        class="px-4 w-full border-red-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-100 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
        placeholder="{{ $name }}">
</div>
