<label for="{{ $id }}" class="block text-gray-700 font-semibold">{{ $label }}</label>
<div class="relative">
    <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $id }}"
        class="w-full px-4 py-2 rounded-md shadow-md focus:outline-none focus:ring focus:border-blue-500 transition duration-300"
        placeholder="{{ $placeholder }}"
        value="{{ isset($value) ? $value : (request()->has($name) ? request($name) : '') }}"
        @if ($disabled) disabled @endif> <!-- Apply disabled attribute based on $disabled -->
    @if ($disabled)
        <div class="absolute inset-y-0 right-0 flex items-center pr-4">
            <span class="text-sm text-gray-500">Aanpassen niet mogelijk (er is een bestelling voor dit product)</span>
        </div>
    @endif
</div>
