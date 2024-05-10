@props(['label'])

<label for="{{ $label }}"
    class="w-auto lg:w-14 text-sm font-medium dark:text-white">{{ __("feedback/feedback.$label") }}
</label>
