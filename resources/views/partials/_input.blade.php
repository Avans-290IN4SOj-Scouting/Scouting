<label for="{{ $name }}" class="block text-gray-700 font-semibold">{{ $label }}</label>
<div class="relative">
    <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $name }}"
        class="block w-full pr-4 py-2 border border-gray-300 rounded-md" placeholder="{{ $placeholder }}"
        value="{{ old($name) ?? ($value ?? (request()->has($name) ? request($name) : '')) }}"
        @if ($disabled) disabled @endif> <!-- Apply disabled attribute based on $disabled -->
    @if ($disabled)
        <div class="absolute inset-y-0 right-0 flex items-center pr-4">
            <span class="text-sm text-gray-500">Aanpassen niet mogelijk (er is een bestelling voor dit product)</span>
        </div>
    @endif
</div>
<x-error :error="$errors->first($name)" :id="$name" />
