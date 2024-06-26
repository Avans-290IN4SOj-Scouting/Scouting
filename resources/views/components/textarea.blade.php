<label for="{{ $name }}" class="block text-gray-700 font-semibold">{{ $label }}</label>
<div>
    <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}"
        class="w-full px-4 py-2 rounded-md shadow-md focus:outline-none focus:ring focus:border-blue-500 transition duration-300"
        placeholder="{{ $placeholder }}"></textarea>
    <x-error :error="$errors->first($name)" :id="$name" />
</div>
