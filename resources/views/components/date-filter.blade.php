<div class="max-w-sm space-y-3 w-full">
    <label for="{{ $name }}" class="block text-sm font-medium mb-2 dark:text-white">{{ $label }}</label>
    <input type="date" name="{{ $name }}" id="{{ $name }}" value="{{ $defaultValue }}"
    class="date-filter py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
</div>
