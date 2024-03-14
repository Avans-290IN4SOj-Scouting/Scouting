<label for="{{ $id }}" class="block text-gray-700 font-semibold">{{ $label }}</label>
<div class="relative">
    <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-gray-600">€</span>
    <input id="{{ $id }}" type="number" placeholder="{{ $placeholder }}" name = "{{ $name }}"
        class="block w-full pl-8 pr-4 py-2 border border-gray-300 rounded-md">
</div>
