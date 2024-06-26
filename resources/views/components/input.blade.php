<label for="{{ $id }}" class="block text-gray-700 font-semibold">{{ $label }}</label>
<div class="relative">
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
        class="block w-full pr-4 py-2 border border-gray-300 rounded-md {{ $disabled ? 'bg-gray-200 cursor-not-allowed' : '' }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name) ?? ($value ?? (request()->has($name) ? request($name) : '')) }}"
        @if ($disabled) disabled @endif>
    @if ($disabled)
        <span class="text-sm text-gray-500">{{ __('manage-products/products.cannot-edit-due-order') }}</span>
    @endif
</div>
<x-error :error="$errors->first($name)" :id="$name" />
