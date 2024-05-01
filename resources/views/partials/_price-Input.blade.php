<label for="{{ $name }}" class="block text-gray-700 font-semibold">{{ $label }}</label>
<div class="relative">
    <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-gray-600">€</span>
    <input id="{{ $name }}" type="number" step="0.01" min="0" placeholder="{{ $placeholder }}"
        name = "{{ $name }}" class="block w-full pl-8 pr-4 py-2 border border-gray-300 rounded-md"
        value="{{ old($name) ?? ($value ?? (request()->has($name) ? request($name) : '')) }}">
</div>
