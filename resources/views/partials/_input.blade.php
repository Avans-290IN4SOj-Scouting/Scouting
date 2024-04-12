<label class="block text-gray-700 font-semibold">{{ $label }}</label>
<div>
    <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $id ?? $name }}"
        class="w-full px-4 py-2 rounded-md shadow-md focus:outline-none focus:ring focus:border-blue-500 transition duration-300"
        placeholder="{{ $placeholder }}"
        value="{{ isset($value) ? $value : (request()->has($name) ? request($name) : '') }}">
</div>
